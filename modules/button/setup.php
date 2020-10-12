<?php
/**
 * Button: Data structures
 *
 * @package aucor_starter
 */

/**
 * Register block
 */
add_action('acf/init', function () {

  if (function_exists('acf_register_block_type')) {
    acf_register_block_type([
      'name'              => 'button',
      'title'             => ask__('Button: Block name'),
      'render_template'   => 'modules/button/block.php',
      'keywords'          => ['button', 'buttons', 'cta'],
      'post_types'        => ['page', 'post'],
      'category'          => 'common',
      'icon'              => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><rect x="0" fill="none" width="20" height="20"/><g><path d="M17 5H3c-1.1 0-2 .9-2 2v6c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm1 7c0 .6-.4 1-1 1H3c-.6 0-1-.4-1-1V7c0-.6.4-1 1-1h14c.6 0 1 .4 1 1v5z"/></g></svg>',
      'mode'              => 'preview',
      'align'             => '',
      'supports'          => [
        'align'               => ['left', 'right', 'center'],
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
 * Button types
 */
add_filter('acf/load_field/name=button_type', function ($field) {

  $field['default_value'] = 'primary';
  $field['choices'] = [
    'primary'   => ask__('Button: Type Primary'),
    // 'secondary' => ask__('Button: Type Secondary'),
  ];
  return $field;

});


/**
 * Allow button block
 */
add_filter('allowed_block_types', function($blocks, $post) {

  $blocks[] = 'acf/button';
  return $blocks;

}, 11, 2);

/**
 * Localization
 */
add_filter('aucor_core_pll_register_strings', function($strings) {

  return array_merge($strings, [
    'Button: Block name'                => 'Button',
    'Button: Type Primary'              => 'Primary',
    'Button: New button instructions'   => 'Click to edit...',
  ]);

}, 10, 1);
