<?php
/**
 * Button: Data structures
 *
 * @package axio
 */

/**
 * Register block
 */
add_action('acf/init', function () {

  if (function_exists('acf_register_block_type')) {
    acf_register_block_type([
      'name'              => 'buttons',
      'title'             => __('Buttons'),
      'render_template'   => dirname(__FILE__) . '/block.php',
      'keywords'          => ['button', 'buttons', 'cta', 'link', 'url', 'href'],
      'category'          => 'common',
      'icon'              => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><rect x="0" fill="none" width="20" height="20"/><g><path d="M17 5H3c-1.1 0-2 .9-2 2v6c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm1 7c0 .6-.4 1-1 1H3c-.6 0-1-.4-1-1V7c0-.6.4-1 1-1h14c.6 0 1 .4 1 1v5z"/></g></svg>',
      'mode'              => 'auto',
      'align'             => '',
      'supports'          => [
        'align'               => false,
        'multiple'            => true,
        'customClassName'     => true,
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
 * Manipulate ACF values and localize
 */
add_filter('acf/load_field', function ($field) {

  // button_type
  if ($field['key'] == 'field_5f1a6f6233b00') {
    $field['default_value'] = 'default';
    $field['choices'] = [
      'default'   => __('Default'),
      'solid'     => ask__('Button: Type Solid'),
      'outline'   => ask__('Button: Type Outline'),
      'text'      => __('Text'),
    ];
    $field['label'] = __('Type');
  }

  // button_link
  if ($field['key'] == 'field_5f1a6e4533aff') {
    $field['label'] = __('Link');
  }

  // buttons
  if ($field['key'] == 'field_602566880098f') {
    $field['button_label'] = '+ ' . _x('Add New', 'link');
  }

  // style
  if ($field['key'] == 'field_60a4f5119721d') {
    $field['label'] = __('Alignment');
  }

  // buttons_alignment
  if ($field['key'] == 'field_6025679600991') {
    $field['label'] = __('Align');
  }

  // buttons_layout
  if ($field['key'] == 'field_60a4ef1f77c95') {
    $field['label'] = __('Order');
  }

  return $field;

});

/**
 * Allow button block
 */
add_filter('allowed_block_types_all', function($blocks, $block_editor_context) {

  $blocks[] = 'acf/buttons';
  return $blocks;

}, 11, 2);

/**
 * Localization
 */
add_filter('axio_core_pll_register_strings', function($strings) {

  return array_merge($strings, [
    'Button: Type Solid'              => 'Solid',
    'Button: Type Outline'            => 'Outline',
  ]);

}, 10, 1);
