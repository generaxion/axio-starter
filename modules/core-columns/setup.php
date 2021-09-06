<?php
/**
 * Setup: core/columns block
 *
 * @package axio
 */

/**
 * Allow block
 */
add_filter('allowed_block_types_all', function($blocks, $post) {

  $blocks[] = 'core/columns';
  return $blocks;

}, 11, 2);
