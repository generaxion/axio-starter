<?php
/**
 * Setup: Gravity Forms plugin compatibility
 *
 * @package aucor_starter
 */

/**
 * Allow block
 */
add_filter('allowed_block_types', function($blocks, $post) {

  $blocks[] = 'gravityforms/form';
  return $blocks;

}, 11, 2);
