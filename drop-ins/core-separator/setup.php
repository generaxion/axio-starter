<?php
/**
 * Setup: core/separator block
 *
 * @package aucor_starter
 */

/**
 * Allow block
 */
add_filter('allowed_block_types', function($blocks, $post) {

  $blocks[] = 'core/separator';
  return $blocks;

}, 11, 2);
