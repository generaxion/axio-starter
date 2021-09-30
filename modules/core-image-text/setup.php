<?php
/**
 * Setup: core/media-text block
 *
 * @package axio
 */

/**
 * Allow block
 */
add_filter('allowed_block_types_all', function($blocks, $post) {

  $blocks[] = 'core/media-text';
  return $blocks;

}, 11, 2);
