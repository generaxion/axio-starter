<?php

/**
 * Setup: core/heading block
 *
 * @package axio
 */

/**
 * Allow block
 */
add_filter('allowed_block_types_all', function ($blocks, $post) {

	$blocks[] = 'core/buttons';
	return $blocks;
}, 11, 2);
