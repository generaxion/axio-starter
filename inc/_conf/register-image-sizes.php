<?php
/**
 * Register: Image sizes
 *
 * @package aucor_starter
 */

/**
 * Setup image sizes
 */
add_action('after_setup_theme', function() {

  // default image sizes
  $default_image_sizes = [
    [
      'name' => 'thumbnail',
      'w'    => 100,
      'h'    => 100,
    ],
    [
      'name' => 'medium',
      'w'    => 360,
      'h'    => 720,
    ],
    [
      'name' => 'large',
      'w'    => 720,
      'h'    => 1440,
    ]
  ];

  foreach ($default_image_sizes as $size) {
    $existing_w = intval(get_option($size['name'] . '_size_w'));
    if ($existing_w !== $size['w']) {
      update_option($size['name'] . '_size_h', $size['h']);
      update_option($size['name'] . '_size_w', $size['w']);
    }
  }

  // custom image sizes
  add_image_size('lazyload',   14,  8,  true); // (default starter) small ~16:9
  add_image_size('hero_xl',  2000, 750, true); // (default starter) hero @1,33x 3:1
  add_image_size('hero_md',  1500, 500, true); // (default starter) hero @1x 3:1
  add_image_size('hero_sm',   800, 500, true); // (default starter) hero mobile 8:5

  // enable support for post thumbnails
  add_theme_support('post-thumbnails');

});


/**
 * Turn human readable image size into responsive sizes
 *
 * @param string $human_size an abstraction of WP image size that consits of multiple sub-sizes
 *
 * @return array of responsive image stuff
 */
function aucor_starter_human_image_size_to_wp_sizes($human_size) {

  switch ($human_size) {

    case 'hero':
      return array(
        'primary'    => 'hero_md',
        'supporting' => ['full', 'hero_xl', 'hero_md', 'hero_sm'],
        'sizes'      => '100vw'
      );

    case 'teaser':
      return array(
        'primary'    => 'thumbnail',
        'supporting' => ['full', 'thumbnail'],
        'sizes'      => '250px'
      );

    case 'large':
      return array(
        'primary'    => 'large',
        'supporting' => ['full', 'large', 'medium'],
        'sizes'      => '(min-width: 720px) 720px, 100vw'
      );

    case 'medium':
      return array(
        'primary'    => 'medium',
        'supporting' => ['full', 'large', 'medium'],
        'sizes'      => '(min-width: 360px) 360px, 100vw'
      );

    case 'thumbnail':
      return array(
        'primary'    => 'thumbnail',
        'supporting' => ['full', 'thumbnail'],
        'sizes'      => '100px'
      );

    default:
      aucor_starter_debug('Image size error - Missing human readable size {' . $human_size . '}', array('aucor_starter_get_image'));

  }

}
