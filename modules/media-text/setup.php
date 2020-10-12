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
      'category'          => 'common',
      'icon'              => 'align-pull-left',
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

  $paths[] = dirname(__FILE__) . '/assets/fields';
  return $paths;

});

/**
 * Localization
 */
add_filter('aucor_core_pll_register_strings', function($strings) {

  return array_merge($strings, [

  ]);

}, 10, 1);
