<?php
/**
 * Setup: core/image block
 *
 * @package aucor_starter
 */

/**
 * Allow block
 */
add_filter('allowed_block_types', function($blocks, $post) {

  $blocks[] = 'core/image';
  return $blocks;

}, 11, 2);
