<?php
/**
 * Setup: core/table block
 *
 * @package axio
 */

/**
 * Allow block
 */
add_filter('allowed_block_types_all', function($blocks, $post) {

  $blocks[] = 'core/table';
  return $blocks;

}, 11, 2);
