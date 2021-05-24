<?php
/**
 * Register: Image sizes
 *
 * @package axio
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
      'w'    => 400,
      'h'    => 700,
    ],
    [
      'name' => 'large',
      'w'    => 800,
      'h'    => 1400,
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
  add_image_size('wide_m',  1216, 2128, false); // gutenberg wide, relational to large
  add_image_size('wide_l',  1824, 3192, false); // gutenberg wide, relational to large

  // enable support for post thumbnails
  add_theme_support('post-thumbnails');

});

/**
 * Add sizing info to image function to responsive image logic
 *
 * Module specific sizings should be registeder from the module.
 *
 * @param array $sizes
 *
 * @return array $sizes
 */
add_filter('theme_image_sizing', function($sizes) {

  $sizes['large'] = [
    'primary'    => 'large',
    'supporting' => ['full', 'large', 'medium'],
    'sizes'      => '(min-width: 800px) 800px, 100vw'
  ];

  $sizes['medium'] = [
    'primary'    => 'medium',
    'supporting' => ['full', 'large', 'medium'],
    'sizes'      => '(min-width: 400px) 400px, 100vw'
  ];

  $sizes['thumbnail'] = [
    'primary'    => 'thumbnail',
    'supporting' => ['thumbnail'],
    'sizes'      => '100px'
  ];

  return $sizes;

});

/**
 * Set the content width in pixels, based on the theme's design and stylesheet
 *
 * @global int $content_width the max width of content in pixels
 */
add_action('after_setup_theme', function() {

  $GLOBALS['content_width'] = 800;

}, 0);
