<?php
/**
 * Setup: core/list block
 *
 * @package aucor_starter
 */

/**
 * Allow block
 */
add_filter('allowed_block_types', function($blocks, $post) {

  $blocks[] = 'core/list';
  return $blocks;

}, 11, 2);
