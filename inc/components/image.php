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

    <img <?php parent::render_attributes($data['attr']); ?> />

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
      'loading'     => 'lazy',

    ];
    $args = wp_parse_args($args, $placeholders);

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

    // alt
    if (!isset($args['attr']['alt'])) {
      $args['attr']['alt'] = $args['alt'];
    }

    // loading
    if (!isset($args['attr']['loading'])) {
      $args['attr']['loading'] = $args['loading'];
    }

    // srcset
    $srcset = array();
    foreach ($possible_sizes['supporting'] as $key => $possible_size) {
      $srcset[] = self::get_image_url($args['id'], $possible_size) . ' ' . $generated_sizes[$possible_size]['width'] . 'w';
    }
    if (!empty($srcset)) {
      $args['attr']['srcset'] = implode(', ', $srcset);
      $args['attr']['sizes'] = $desired_sizes['sizes'];
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
