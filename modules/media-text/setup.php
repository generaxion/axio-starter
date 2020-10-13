<?php
/**
 * Hero: Data structures
 *
 * @package aucor_starter
 */

/**
 * Register block
 */
add_action('acf/init', function () {

  if (function_exists('acf_register_block_type')) {
    acf_register_block_type([
      'name'              => 'media-text',
      'title'             => 'Media & Text',
      'render_template'   => dirname(__FILE__) . '/block.php',
      'multiple'          => false,
      'keywords'          => ['media-text', 'text-media', '50/50'],
      'category'          => 'design',
      'icon'              => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><rect x="0" fill="none" width="20" height="20"/><g><path d="M9 16V4H3v12h6zm2-7h6V7h-6v2zm0 4h6v-2h-6v2z"/></g></svg>',
      'mode'              => 'preview',
      'align'             => 'wide',
      'supports'          => [
        'align' => ['wide', 'full'],
        'mode'  => false,
        'jsx'   => true,
      ],
    ]);
  }

});

/**
 * Image sizing
 */
add_filter('theme_image_sizing', function($sizes) {

  $sizes['media_text_wide'] = [
    'primary'    => 'large',
    'supporting' => ['wide_l', 'wide_m', 'large', 'medium'],
    'sizes'      => '(min-width: 920px) 720px, 100vw'
  ];

  $sizes['media_text_full'] = [
    'primary'    => 'large',
    'supporting' => ['wide_l', 'wide_m', 'large', 'medium'],
    'sizes'      => '(min-width: 720px) 50vw, 100vw'
  ];

  return $sizes;

});

/**
 * Allow block
 */
add_filter('allowed_block_types', function($blocks, $post) {

  $blocks[] = 'acf/media-text';
  return $blocks;

}, 11, 2);

/**
 * Load ACF fields
 */
add_filter('acf/settings/load_json', function ($paths) {

  $paths[] = dirname(__FILE__) . '/acf-json';
  return $paths;

});

/**
 * Localization
 */
add_filter('aucor_core_pll_register_strings', function($strings) {

  return array_merge($strings, [

  ]);

}, 10, 1);
