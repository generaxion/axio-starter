<?php
/**
 * Component: Image
 *
 * @example
 * Aucor_Image::render([
 *  'id'   => get_post_thumbnail_id(),
 *  'size' => 'hero',
 * ]);
 */

class Aucor_Image extends Aucor_Component {

  /**
   * Image markup
   */
  public static function frontend($data) {
    ?>

    <?php if ($data['lazyload']) : ?>
      <noscript><img <?php parent::render_attributes($data['attr-nojs']); ?> /></noscript>
    <?php endif; ?>

    <img <?php parent::render_attributes($data['attr']); ?> />

    <?php if ($data['lazyload'] === 'animated') : ?>
      <img <?php parent::render_attributes($data['attr-preload']); ?> />
    <?php endif; ?>

    <?php
  }

  /**
   * Fetch and setup image data
   *
   * @param array $args
   */
  public static function backend($args = []) {

    $placeholders = [

      // required
      'id'           => null,
      'size'         => 'large',

      // optional
      'attr'         => array(),
      'alt'          => '',
      'lazyload'     => 'fast',   // 'fast', 'animated', false

      // internal
      'attr-nojs'    => array(),
      'attr-preload' => array(),

    ];
    $args = wp_parse_args($args, $placeholders);

    // diable lazyload in admin
    if (is_admin()) {
      $args['lazyload'] = false;
    }

    if (empty($args['id'])) {
      return parent::error('Missing attachment_id ($args[\'id\'])');
    }

    // fetch attachment metadata from database
    $image = wp_get_attachment_metadata($args['id']);

    // bail if image is invalid
    if (empty($image) || is_wp_error($image)) {
      return parent::error('Invalid attachment for Aucor_Image');
    }

    // load alt text if deosn't exist
    if (empty($args['alt'])) {
      $args['alt'] = get_post_meta($args['id'], '_wp_attachment_image_alt', true);
    }

    // get WP generated image sizes
    $generated_sizes = $image['sizes'];
    $generated_sizes['full'] = array(
      'width'  => $image['width'],
      'height' => $image['height'],
    );

    // get desired sizes for image
    $desired_sizes = aucor_starter_human_image_size_to_wp_sizes($args['size']);

    // figure out which desired sizes are possible
    $possible_sizes = self::get_possible_image_sizes($desired_sizes, $generated_sizes);

    if (empty($possible_sizes)) {
      return parent::error('No possible sizes');
    }

    // src
    $args['attr']['src'] = self::get_image_url($args['id'], $possible_sizes['primary']);

    // width
    $args['attr']['width'] = $generated_sizes[$possible_sizes['primary']]['width'];

    // height
    $args['attr']['height'] = $generated_sizes[$possible_sizes['primary']]['height'];

    // srcset
    $srcset = array();
    foreach ($possible_sizes['supporting'] as $key => $possible_size) {
      $srcset[] = self::get_image_url($args['id'], $possible_size) . ' ' . $generated_sizes[$possible_size]['width'] . 'w';
    }
    if (!empty($srcset)) {
      $args['attr']['srcset'] = implode(', ', $srcset);
      $args['attr']['sizes'] = $desired_sizes['sizes'];
    }

    if ($args['lazyload']) {

        // set aspect ratio
      if (isset($args['attr']['width']) && isset($args['attr']['height'])) {
        $args['attr']['data-aspectratio'] = $args['attr']['width'] . '/' . $args['attr']['height'];
      }

      // duplicate attributes to no js before adding lazyload values
      $args['attr-nojs'] = $args['attr'];

      // add lazyload class
      if (!isset($args['attr']['class'])) {
        $args['attr']['class'] = [];
      }
      $args['attr']['class'][] = 'lazyload';

      if ($args['lazyload'] === 'fast') {
        $args['attr']['class'][] = 'lazyload--fast';
      } elseif ($args['lazyload'] === 'animated') {
        $args['attr']['class'][] = 'lazyload--animated';
      }

      // prefix src attributes
      $lazy_attributes = ['src', 'srcset', 'sizes'];
      foreach ($lazy_attributes as $lazy_attribute) {
        if (isset($args['attr'][$lazy_attribute])) {
          $args['attr']['data-' . $lazy_attribute] = $args['attr'][$lazy_attribute];
          /**
           * Show primary image for browsers that can't handle srcsets
           *
           * @see https://github.com/aFarkas/lazysizes#modern-transparent-srcset-pattern
           */
          if ($lazy_attribute !== 'src') {
            unset($args['attr'][$lazy_attribute]);
          }
        }
      }

      // transparent base image
      $args['attr']['srcset'] = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';

    }

    // blurry preload image
    if ($args['lazyload'] == 'animated') {

      // add blurry preload image inlined
      $base64 = '';
      $image_preload = wp_get_attachment_image_src($args['id'], 'lazyload');

      // make sure preload image exists and is reasonable size (WP fallbacks to full size if not found)
      if (is_array($image_preload) && $image_preload[1] < 50 && $image_preload[2] < 50) {

        // make preload path from full size path as there is no function to get preload image size path
        $image_full_size_path = get_attached_file($args['id']);
        $image_preload_path = str_replace(basename($image_full_size_path), basename($image_preload[0]), $image_full_size_path);

        if (file_exists($image_preload_path)) {
          $image_base64_content = base64_encode(file_get_contents($image_preload_path));
          $extension = substr(strrchr($image_preload_path, '.'), 1);
          if (!empty($image_base64_content)) {
            $base64 = 'data:image/' . $extension . ';base64,' . $image_base64_content;
          }
        }
      }
      if (empty($base64)) {
        $base64 = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';
      }

      if (!isset($args['attr']['class'])) {
        $preload_class = [];
      } else {
        $preload_class = $args['attr']['class'];
      }
      $preload_class[] = 'lazyload-preload';

      $args['attr-preload'] = [
        'alt'   => null,
        'class' => $preload_class,
        'src'   => $base64
      ];
    }

    return $args;

  }

  /**
   * Get desired image sizes from generated sizes
   *
   * @param array $desired_sizes list of image sizes wanted
   * @param array $generated_sizes list of all image sizes WP has generated for image
   *
   * @return array list of possible image sizes from desired sizes
   */
  public static function get_possible_image_sizes($desired_sizes, $generated_sizes) {

    $real_sizes = array();

    // get primary size
    if (isset($generated_sizes[$desired_sizes['primary']])) {
      // desired primary size found
      $real_sizes['primary'] = $desired_sizes['primary'];
    } else {
      // use first supporting size found as primary
      foreach ($desired_sizes['supporting'] as $key => $desired_size) {
        if (isset($generated_sizes[$desired_size])) {
          $real_sizes['primary'] = $desired_size;
          break;
        }
      }
    }

    // if selected image has none of desired sizes, use full size
    if (empty($real_sizes)) {
      $real_sizes['primary'] = 'full';
    }

    // collect possible supporting sizes
    $real_sizes['supporting'] = array();
    foreach ($desired_sizes['supporting'] as $key => $desired_size) {
      if (isset($generated_sizes[$desired_size])) {
        $real_sizes['supporting'][] = $desired_size;
      }
    }

    if (empty($real_sizes['supporting'])) {
      $real_sizes['supporting'][] = 'full';
    }

    return $real_sizes;

  }

  /**
   * Get URL for WP image
   *
   * @param int    $attachment_id the ID of image
   * @param string $size the WP image size
   *
   * @return string URL
   */
  public static function get_image_url($attachment_id, $size) {

    $image_url = '';
    $image_src = wp_get_attachment_image_src($attachment_id, $size);
    if (!empty($image_src) && !is_wp_error($image_src)) {
      $image_url = $image_src[0];
    }
    return $image_url;

  }

}
