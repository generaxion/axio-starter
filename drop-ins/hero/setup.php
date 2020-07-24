<?php
/**
 * Hero: Data structures
 *
 * @package aucor_starter
 */

/**
 * theme_hero action
 */
add_action('theme_hero', function () {
  Aucor_Hero::render();
}, 100, 1);

/**
 * Localization
 */
add_filter('aucor_core_pll_register_strings', function($strings) {

  return array_merge($strings, [
    'Title: Home'                       => 'Blogi',
    'Title: Archives'                   => 'Arkisto',
    'Title: Search'                     => 'Haku',
    'Title: 404'                        => 'Hakemaasi sivua ei löytynyt',
  ]);

}, 10, 1);
