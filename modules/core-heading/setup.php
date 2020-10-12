<?php
/**
 * Setup: core/heading block
 *
 * @package aucor_starter
 */

/**
 * Allow block
 */
add_filter('allowed_block_types', function($blocks, $post) {

  $blocks[] = 'core/heading';
  return $blocks;

}, 11, 2);
