<?php
/**
 * Hero: Data structures
 *
 * @package axio
 */

/**
 * Register block
 */
add_action('acf/init', function () {

  if (function_exists('acf_register_block_type')) {
    acf_register_block_type([
      'name'              => 'media-text',
      'title'             => __('Media & Text'),
      'render_template'   => dirname(__FILE__) . '/block.php',
      'multiple'          => false,
      'keywords'          => ['media-text', 'text-media', '50/50', 'columns', 'video'],
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
 * Manipulate values and localize
 */
add_filter('acf/load_field', function ($f) {

  // background
  if ($f['key'] == 'field_60a5120a578e6') {
    $f['default_value'] = 'default';
    $f['choices'] = [];
    $colors = apply_filters('x_background_colors', []);
    if (!empty($colors)) {
      foreach ($colors as $name => $arr) {
        $f['choices'][$name] = $arr['label'];
      }
    } else {
      $f['disabled'] = true;
    }
    $f['label'] = __('Background');
  }

  // type
  if ($f['key'] == 'field_5f46770e84e39') {
    $f['label'] = __('Type');
    if (isset($f['choices']) && is_array($f['choices'])) {
      foreach ($f['choices'] as $name => $label) {
        switch ($name) {
          case 'image': $f['choices'][$name] = __('Image'); break;
          case 'video': $f['choices'][$name] = __('Video'); break;
        }
      }
    }
  }

  // type
  if ($f['key'] == 'field_5f46770e84f85') {
    $f['label'] = __('Image');
  }

  // alignment
  if ($f['key'] == 'field_5f477f642dbc6') {
    $f['label'] = __('Alignment');
  }

  // position
  if ($f['key'] == 'field_5f467c4edbabc') {
    $f['label'] = __('Order');
  }

  // vertical align
  if ($f['key'] == 'field_5f477e312dbc4') {
    $f['label'] = _x('V Align', 'vertical table cell alignment');
  }

  return $f;

});

/**
 * Allow block
 */
add_filter('allowed_block_types_all', function($blocks, $block_editor_context) {

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
add_filter('axio_core_pll_register_strings', function($strings) {

  return array_merge($strings, []);

}, 10, 1);
