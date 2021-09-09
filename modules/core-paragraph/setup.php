<?php
/**
 * Setup: core/paragraph block
 *
 * @package axio
 */

/**
 * Allow block
 */
add_filter('allowed_block_types_all', function($blocks, $post) {

  $blocks[] = 'core/paragraph';
  return $blocks;

}, 11, 2);
