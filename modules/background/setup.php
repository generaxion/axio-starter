<?php
/**
 * Cover: Data structures
 *
 * @package aucor_starter
 */

/**
 * Register block
 */
add_action('acf/init', function () {

  if (function_exists('acf_register_block_type')) {
    acf_register_block_type([
      'name'              => 'background',
      'title'             => 'Background',
      'render_template'   => dirname(__FILE__) . '/block.php',
      'multiple'          => true,
      'keywords'          => ['header', 'background', 'cover', 'video', 'color', 'bg'],
      'post_types'        => ['page', 'post'],
      'category'          => 'design',
      'icon'              => '<svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><path d="M4 4h7V2H4c-1.1 0-2 .9-2 2v7h2V4zm6 9l-4 5h12l-3-4-2.03 2.71L10 13zm7-4.5c0-.83-.67-1.5-1.5-1.5S14 7.67 14 8.5s.67 1.5 1.5 1.5S17 9.33 17 8.5zM20 2h-7v2h7v7h2V4c0-1.1-.9-2-2-2zm0 18h-7v2h7c1.1 0 2-.9 2-2v-7h-2v7zM4 13H2v7c0 1.1.9 2 2 2h7v-2H4v-7z"></path></svg>',
      'mode'              => 'preview',
      'align'             => 'full',
      'supports'          => [
        'align'  => ['full', 'wide'],
        'mode'   => false,
        'jsx'    => true,
      ],
    ]);
  }

});

/**
 * Register image sizes
 */
add_action('after_setup_theme', function() {

  add_image_size('background_l',  2000, 1250, true);   // 16:10
  add_image_size('background_m',  1600, 1000, true);   // 16:10
  add_image_size('background_s',   900,  900, true);   // 1:1
  add_image_size('background_xs',  600,  600, true);   // 1:1

});

/**
 * Image sizing
 */
add_filter('theme_image_sizing', function($sizes) {

  $sizes['background'] = [
    'primary'    => 'background_m',
    'supporting' => ['background_l', 'background_m', 'background_s'],
    'sizes'      => '(min-width: 720px) 100vw, 110vw' // compensates for horizontal-ish image
  ];
  return $sizes;

});

/**
 * Allow block
 */
add_filter('allowed_block_types', function($blocks, $post) {

  $blocks[] = 'acf/background';
  return $blocks;

}, 11, 2);

/**
 * Load ACF fields
 */
add_filter('acf/settings/load_json', function ($paths) {

  $paths[] = dirname(__FILE__) . '/acf-json';
  return $paths;

});
