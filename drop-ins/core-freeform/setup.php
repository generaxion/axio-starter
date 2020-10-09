<?php
/**
 * Setup: core/freeform block
 *
 * @package aucor_starter
 */

/**
 * Allow block
 */
add_filter('allowed_block_types', function($blocks, $post) {

  $blocks[] = 'core/freeform';
  return $blocks;

}, 11, 2);
