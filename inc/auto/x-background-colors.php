<?php
// Created via `gulp vars`. Defined in theme's manifest.js
add_filter( 'x_background_colors', function( $colors = [] ) {
	return array_merge( $colors, [ 
	'primary' => [
		'label'   => __( 'Primary' ),
		'color'   => '#fe0700',
		'is_dark' => true,
	],
	'primary-dark' => [
		'label'   => __( 'Primary-dark' ),
		'color'   => '#a00700',
		'is_dark' => true,
	],
	'secondary' => [
		'label'   => __( 'Secondary' ),
		'color'   => '#d08a4e',
		'is_dark' => false,
	],
	'black' => [
		'label'   => __( 'Black' ),
		'color'   => '#000',
		'is_dark' => true,
	],
	'grey-dark' => [
		'label'   => __( 'Grey-dark' ),
		'color'   => '#333',
		'is_dark' => true,
	],
	'grey' => [
		'label'   => __( 'Grey' ),
		'color'   => '#777',
		'is_dark' => true,
	],
	'grey-light' => [
		'label'   => __( 'Grey-light' ),
		'color'   => '#bbb',
		'is_dark' => false,
	],
	'grey-extra-light' => [
		'label'   => __( 'Grey-extra-light' ),
		'color'   => '#eee',
		'is_dark' => false,
	],
	'white' => [
		'label'   => __( 'White' ),
		'color'   => '#fff',
		'is_dark' => false,
	], ] );
} );

