<?php
/**
 * Setup: core/list block
 *
 * @package axio
 */

/**
 * Allow block
 */
add_filter('allowed_block_types_all', function($blocks, $post) {

  $blocks[] = 'core/list';
  return $blocks;

}, 11, 2);
