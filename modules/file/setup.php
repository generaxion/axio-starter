<?php
/**
 * Module: File
 *
 * @package axio
 */

/**
 * Register block
 */
add_action('acf/init', function () {

  if (function_exists('acf_register_block_type')) {
    acf_register_block_type([
      'name'              => 'file',
      'title'             => _x('File', 'TinyMCE menu'),
      'render_template'   => dirname(__FILE__) . '/block.php',
      'keywords'          => ['file', 'pdf', 'download', 'document', 'link'],
      'category'          => 'media',
      'icon'              => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><rect x="0" fill="none" width="20" height="20"/><g><style>.st0{fill-rule:evenodd;clip-rule:evenodd;}</style><path d="M5.8 14H5v1h.8c.3 0 .5-.2.5-.5s-.2-.5-.5-.5zM11 2H3v16h13V7l-5-5zM7.2 14.6c0 .8-.6 1.4-1.4 1.4H5v1H4v-4h1.8c.8 0 1.4.6 1.4 1.4v.2zm4.1.5c0 1-.8 1.9-1.9 1.9H8v-4h1.4c1 0 1.9.8 1.9 1.9v.2zM15 14h-2v1h1.5v1H13v1h-1v-4h3v1zm0-2H4V3h7v4h4v5zm-5.6 2H9v2h.4c.6 0 1-.4 1-1s-.5-1-1-1z"/></g></svg>',
      'mode'              => 'auto',
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
 * Localization
 */
add_filter('axio_core_pll_register_strings', function($strings) {

  return array_merge($strings, [
    'Files: Accessability download'     => 'Downloadable file',
    'Files: New block instructions'     => 'Click to add files...',
  ]);

}, 10, 1);

/**
 * Manipulate ACF values and localize
 */
add_filter('acf/load_field', function ($field) {

  // files
  if ($field['key'] == 'field_5f8465786f745') {
    $field['button_label'] = '+ ' . _x('Add New', 'link');
  }

  // title
  if ($field['key'] == 'field_5f8465b36f747') {
    $field['label'] = __('Title');
  }

  return $field;

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
add_filter('allowed_block_types_all', function($blocks, $block_editor_context) {

  $blocks[] = 'acf/file';
  return $blocks;

}, 11, 2);
