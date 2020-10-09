<?php
/**
 * Setup: core/quote block
 *
 * @package aucor_starter
 */

/**
 * Allow block
 */
add_filter('allowed_block_types', function($blocks, $post) {

  $blocks[] = 'core/quote';
  return $blocks;

}, 11, 2);
