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

  // Check function exists.
  if (function_exists('acf_register_block_type')) {
    acf_register_block_type([
      'name'              => 'button',
      'title'             => 'Button',
      'render_template'   => 'drop-ins/button/block.php',
      'keywords'          => ['button', 'buttons', 'cta'],
      'post_types'        => ['page', 'post'],
      'category'          => 'common',
      'icon'              => 'share-alt2',
      'mode'              => 'auto',
      'align'             => 'center',
      'supports'          => [
        'align'               => array('left', 'right', 'center'),
        'multiple'            => true,
        'customClassName'     => false,
      ],
    ]);
  }

});

/**
 * Allow button block
 */
add_filter('allowed_block_types', function($blocks, $post) {
  $blocks[] = 'acf/button';
  return $blocks;
}, 11, 2);
