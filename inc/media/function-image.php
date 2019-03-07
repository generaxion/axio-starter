<?php
/**
 * Functions for fetching responsive image markup
 *
 * @package aucor_starter
 */

/**
 * Get responsive image markup
 *
 * @example aucor_starter_get_image(123, 'large')
 * @example aucor_starter_get_image(123, 'medium', ['class' => 'teaser-img'])
 * @example aucor_starter_get_image(123, 'medium', ['attr' => ['data-name' => 'data-value']])
 *
 * @param int    $attachment_id ID of image
 * @param string $human_size a easy to understand size of image
 * @param array  $args list of optional options
 *
 * @return html markup for image
 */
function aucor_starter_get_image($attachment_id, $human_size = 'large', $args = array()) {

  // fetch attachment metadata from database
  $image = wp_get_attachment_metadata($attachment_id);

  // bail if image is invalid
  if (empty($image) || is_wp_error($image)) {
    return '';
  }

  // set return html
  $html = '';

  // set defaults
  $defaults = array(
    'alt'         => get_post_meta($attachment_id, '_wp_attachment_image_alt', true),
    'attr'        => array(),
    'class'       => '',
    'lazyload'    => 'fast' // 'fast', 'animated', false
  );

  // parse args
  $args = wp_parse_args($args, $defaults);

  // build html attributes
  $attr = $args['attr'];
  $attr['alt'] = $args['alt'];
  $attr['class'] = $args['class'];

  // get WP generated image sizes
  $generated_sizes = $image['sizes'];
  $generated_sizes['full'] = array(
    'width'  => $image['width'],
    'height' => $image['height'],
  );

  // get desired sizes for image
  $desired_sizes = aucor_starter_human_image_size_to_wp_sizes($human_size);

  // figure out which desired sizes are possible
  $possible_sizes = aucor_starter_get_possible_image_sizes($desired_sizes, $generated_sizes);

  // src
  $attr['src'] = aucor_starter_get_image_url($attachment_id, $possible_sizes['primary']);

  // width
  $attr['width'] = $generated_sizes[$possible_sizes['primary']]['width'];

  // height
  $attr['height'] = $generated_sizes[$possible_sizes['primary']]['height'];

  // srcset
  $srcset = array();
  foreach ($possible_sizes['supporting'] as $key => $possible_size) {
    $srcset[] = aucor_starter_get_image_url($attachment_id, $possible_size) . ' ' . $generated_sizes[$possible_size]['width'] . 'w';
  }
  if (!empty($srcset)) {
    $attr['srcset'] = implode(', ', $srcset);
    $attr['sizes'] = $desired_sizes['sizes'];
  }

  // lazyload images
  if ($args['lazyload']) {

    // <img> tag for <noscript> situation
    $html .= '<noscript><img' . aucor_starter_build_attributes($attr) . ' /></noscript>';

    // add lazyload class
    $attr['class'] .= ' lazyload';

    if ($args['lazyload'] === 'fast') {
      $attr['class'] .= ' lazyload--fast';
    } elseif ($args['lazyload'] === 'animated') {
      $attr['class'] .= ' lazyload--animated';
    }

    // prefix src attributes
    $lazy_attributes = ['src', 'srcset', 'sizes'];
    foreach ($lazy_attributes as $lazy_attribute) {
      if (isset($attr[$lazy_attribute])) {
        $attr['data-' . $lazy_attribute] = $attr[$lazy_attribute];
        // show primary image for browsers that can't handle srcsets (https://github.com/aFarkas/lazysizes#modern-transparent-srcset-pattern)
        if ($lazy_attribute !== 'src') {
          unset($attr[$lazy_attribute]);
        }

      }
    }

    // transparent base image
    $attr['srcset'] = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';

  }

  // <img> tag to be lazyloaded
  $html .= '<img' . aucor_starter_build_attributes($attr) . ' />';

  // <img> tag for blurry preload image
  if ($args['lazyload'] == 'animated') {

    // add blurry preload image inlined
    $base64 = '';
    $image_preload = wp_get_attachment_image_src($attachment_id, 'lazyload');

    // make sure preload image exists and is reasonable size (WP fallbacks to full size if not found)
    if (is_array($image_preload) && $image_preload[1] < 50 && $image_preload[2] < 50) {

      // make preload path from full size path as there is no function to get preload image size path
      $image_full_size_path = get_attached_file($attachment_id);
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

    $html .= '<img class="lazyload-preload ' . $attr['class'] . '" src="' . esc_attr($base64) . '" alt />';

  }

  return $html;

}

/**
 * Get URL for WP image
 *
 * @param int    $attachment_id the ID of image
 * @param string $size the WP image size
 *
 * @return string URL
 */
function aucor_starter_get_image_url($attachment_id, $size) {

  $image_url = '';
  $image_src = wp_get_attachment_image_src($attachment_id, $size);
  if (!empty($image_src) && !is_wp_error($image_src)) {
    $image_url = $image_src[0];
  }
  return $image_url;

}

/**
 * Get desired image sizes from generated sizes
 *
 * @param array $desired_sizes list of image sizes wanted
 * @param array $generated_sizes list of all image sizes WP has generated for image
 *
 * @return array list of possible image sizes from desired sizes
 */
function aucor_starter_get_possible_image_sizes($desired_sizes, $generated_sizes) {

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

