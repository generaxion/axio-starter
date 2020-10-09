<?php
/**
 * Setup: core/paragraph block
 *
 * @package aucor_starter
 */

/**
 * Allow block
 */
add_filter('allowed_block_types', function($blocks, $post) {

  $blocks[] = 'core/paragraph';
  return $blocks;

}, 11, 2);
