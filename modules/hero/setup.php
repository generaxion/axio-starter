<?php
/**
 * Hero: Data structures
 *
 * @package aucor_starter
 */

/**
 * Register image sizes
 */
add_action('after_setup_theme', function() {

  add_image_size('hero_l', 2000, 750, true);  // hero @1,33x 3:1
  add_image_size('hero_m', 1500, 500, true);  // hero @1x 3:1
  add_image_size('hero_s',  800, 500, true);  // hero mobile 8:5

});

/**
 * Image sizing
 */
add_filter('theme_image_sizing', function($sizes) {

  $sizes['hero'] = [
    'primary'    => 'hero_m',
    'supporting' => ['hero_l', 'hero_m', 'hero_s'],
    'sizes'      => '100vw'
  ];

  return $sizes;

});

/**
 * Localization
 */
add_filter('aucor_core_pll_register_strings', function($strings) {

  return array_merge($strings, [
    'Title: Home'                       => 'Blog',
    'Title: Archives'                   => 'Archives',
    'Title: Search'                     => 'Search',
    'Title: 404'                        => 'Page not found',
  ]);

}, 10, 1);

/**
 * Display hero
 */
add_action('theme_hero', function() {

  Aucor_Hero::render();

}, 100, 1);
