<?php
/**
 * Module: File
 *
 * @package aucor_starter
 */

/**
 * Register block
 */
add_action('acf/init', function () {

  if (function_exists('acf_register_block_type')) {
    acf_register_block_type([
      'name'              => 'file',
      'title'             => 'File',
      'render_template'   => 'modules/file/block.php',
      'keywords'          => ['file', 'pdf', 'download'],
      'post_types'        => ['page', 'post'],
      'category'          => 'common',
      'icon'              => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><rect x="0" fill="none" width="20" height="20"/><g><path d="M14.01 4v6h2V2H4v8h2.01V4h8zm-2 2v6h3l-5 6-5-6h3V6h4z"/></g></svg>',
      'mode'              => 'preview',
      'align'             => '',
      'supports'          => [
        'align'               => false,
        'multiple'            => true,
        'customClassName'     => false,
      ],
    ]);
  }

});

/**
 * Load ACF fields
 */
add_filter('acf/settings/load_json', function ($paths) {

  $paths[] = dirname(__FILE__) . '/acf-json';
  return $paths;

});


/**
 * Allow button block
 */
add_filter('allowed_block_types', function($blocks, $post) {

  $blocks[] = 'acf/file';
  return $blocks;

}, 11, 2);

/**
 * Localization
 */
add_filter('aucor_core_pll_register_strings', function($strings) {

  return array_merge($strings, [
    'Files: Accessability download'     => 'Downloadable file',
    'Files: New block instructions'     => 'Click to add files...',
  ]);

}, 10, 1);
