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
      'render_template'   => 'drop-ins/button/block.php',
      'keywords'          => ['button', 'buttons', 'cta'],
      'post_types'        => ['page', 'post'],
      'category'          => 'common',
      'icon'              => 'dashicons-admin-links',
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

  $paths[] = dirname(__FILE__) . '/assets/fields';
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
