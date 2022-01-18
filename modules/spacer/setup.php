<?php
/**
 * Spacer
 *
 * @package axio
 */

/**
 * Spacer sizes
 */
add_filter('acf/load_field/name=spacer_size', function ($field) {

  $field['default_value'] = 'm';
  $field['choices'] = [
    's'   => 'S',
    'm'   => 'M',
    'l'   => 'L',
  ];
  return $field;

});

/**
 * Register block
 */
add_action('acf/init', function () {

  if (function_exists('acf_register_block_type')) {
    acf_register_block_type([
      'name'              => 'spacer',
      'title'             => __('Spacer'),
      'render_template'   => dirname(__FILE__) . '/block.php',
      'keywords'          => ['spacer', 'break', 'empty', 'margin'],
      'category'          => 'design',
      'icon'              => 'image-flip-vertical',
      'mode'              => 'preview',
      'supports'          => [
        'mode'                => false,
        'align'               => false,
        'multiple'            => true,
        'customClassName'     => false,
      ],
    ]);
  }

});

/**
 * Allow block
 */
add_filter('allowed_block_types_all', function($blocks, $block_editor_context) {

  $blocks[] = 'acf/spacer';
  return $blocks;

}, 11, 2);

/**
 * Load ACF fields
 */
add_filter('acf/settings/load_json', function ($paths) {

  $paths[] = dirname(__FILE__) . '/acf-json/';
  return $paths;

});
