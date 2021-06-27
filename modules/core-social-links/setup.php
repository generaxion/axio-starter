<?php

/**
 * Setup: core/social-links block
 *
 * @package axio
 */

/**
 * Allow block
 */
add_filter('allowed_block_types', function ($blocks, $post) {

	$blocks[] = 'core/social-links';
	return $blocks;
}, 11, 2);
