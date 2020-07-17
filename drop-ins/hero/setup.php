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

  // Check function exists.
  if (function_exists('acf_register_block_type')) {
    acf_register_block_type([
      'name'              => 'hero',
      'title'             => 'Hero',
      'render_template'   => 'drop-ins/hero/block.php',
      'multiple'          => false,
      'keywords'          => ['header', 'title', 'cover'],
      'post_types'        => ['page'],
      'category'          => 'general',
      'icon'              => 'slides',
      'mode'              => 'preview',
      'supports'          => [
        'align'               => false,
        'mode'                => false,
        '__experimental_jsx'  => true,
      ],
    ]);
  }

});

/**
 * Allow hero block
 */
add_filter('allowed_block_types', function($blocks, $post) {

  $blocks[] = 'acf/hero';
  return $blocks;

}, 11, 2);


/**
 * Auto append hero block
 */
add_action('init', function () {

  $post_type_object = get_post_type_object('page');
  $post_type_object->template = [
    ['acf/hero'],
    ['core/paragraph'],
  ];

});
