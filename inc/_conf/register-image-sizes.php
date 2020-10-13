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
  add_image_size('wide_m',  1216, 2432, false); // gutenberg wide, relational to large
  add_image_size('wide_l',  1824, 3648, false); // gutenberg wide, relational to large

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
    'sizes'      => '(min-width: 720px) 720px, 100vw'
  ];

  $sizes['medium'] = [
    'primary'    => 'medium',
    'supporting' => ['full', 'large', 'medium'],
    'sizes'      => '(min-width: 360px) 360px, 100vw'
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

  $GLOBALS['content_width'] = 720;

}, 0);

/**
 * Set wide image sizes attribute
 *
 * Gutenberg has at the moment a bit lacking logic for sizes attributes.
 * This fixes some issues where big images appear low-res.
 *
 * @see https://github.com/WordPress/gutenberg/issues/6131
 *
 * @param string $html the rendered markup
 * @param array  $args the options
 *
 * @return string $html
 */
add_filter('render_block', function ($html, $args) {

  if (isset($args['attrs']['align'])) {

    $base_width = (isset($GLOBALS['content_width'])) ? absint($GLOBALS['content_width']) : 720;

    if ($args['blockName'] === 'core/image' && $args['attrs']['align'] === 'full') {

      $html = str_replace('<img ', '<img sizes="100vw"', $html);

    }
    if ($args['blockName'] === 'core/image' && $args['attrs']['align'] === 'wide') {

      $wide_width = absint(1.5 * $base_width);
      $html = str_replace('<img ', '<img sizes="(min-width: ' . $wide_width . 'px) ' . $wide_width . 'px, 100vw"', $html);

    } elseif ($args['blockName'] === 'core/media-text' && $args['attrs']['align'] === 'full') {

      $html = str_replace('<img ', '<img sizes="(min-width: ' . $base_width . 'px) 50vw, 100vw"', $html);

    }

  }
  return $html;

}, 10, 2);
