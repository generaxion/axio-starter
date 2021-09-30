<?php

/**
 * Setup: core/block-cover block
 *
 * @package axio
 */

/**
 * Allow block
 */
add_filter('allowed_block_types_all', function ($blocks, $post) {

	$blocks[] = 'core/block-cover';
	return $blocks;
}, 11, 2);
