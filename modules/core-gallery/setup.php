<?php
/**
 * Setup: core/gallery block
 *
 * @package axio
 */

/**
 * Allow block
 */
add_filter('allowed_block_types_all', function($blocks, $post) {

  $blocks[] = 'core/gallery';
  return $blocks;

}, 11, 2);
