<?php
/**
 * Setup: core/heading block
 *
 * @package axio
 */

/**
 * New styles
 */
add_action( 'init', function() {
	register_block_style( 'core/heading', [
		'name'  => 'subheading',
		'label' => 'Subheading',
	] );
} );

/**
 * Allow block
 */
add_filter('allowed_block_types', function($blocks, $post) {

  $blocks[] = 'core/heading';
  return $blocks;

}, 11, 2);
