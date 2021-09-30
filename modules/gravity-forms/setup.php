<?php
/**
 * Setup: Gravity Forms plugin compatibility
 *
 * @package axio
 */

/**
 * Allow block
 */
add_filter('allowed_block_types_all', function($blocks, $post) {

  $blocks[] = 'gravityforms/form';
  return $blocks;

}, 11, 2);

/**
 * Force anchors
 */
add_filter('gform_confirmation_anchor', '__return_true');
