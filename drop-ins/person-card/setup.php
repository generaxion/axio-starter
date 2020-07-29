<?php
/**
 * Setup: Person Card
 *
 * @package aucor_starter
 */

/**
 * Localization
 */
add_filter('aucor_core_pll_register_strings', function($strings) {

  return array_merge($strings, [

    'Person Card: Title'        => 'Yhteystiedot',

  ]);

}, 10, 1);

/**
 * Register block
 */
add_action('acf/init', function () {

  // Check function exists.
  if (function_exists('acf_register_block_type')) {
    acf_register_block_type([
      'name'              => 'staff-list',
      'title'             => 'Staff List',
      'render_template'   => 'drop-ins/person-card/block.php',
      'keywords'          => ['person', 'card', 'staff', 'list', 'contacts'],
      'post_types'        => ['page', 'post'],
      'category'          => 'common',
      'icon'              => 'id-alt',
      'mode'              => 'auto',
      'align'             => 'left',
      'supports'          => [
        'align'               => false,
        'multiple'            => true,
        'customClassName'     => false,
      ],
    ]);
  }

});

/**
 * Allow staff list block
 */
add_filter('allowed_block_types', function($blocks, $post) {
  $blocks[] = 'acf/staff-list';
  return $blocks;
}, 11, 2);
