<?php
/**
 * Setup: List Terms
 *
 * @package aucor_starter
 */

add_action('theme_after_post', function() {
  Aucor_List_Terms::render([
    'title'     => ask__('Taxonomies: Categories'),
    'taxonomy'  => 'category'
  ]);
  Aucor_List_Terms::render([
    'title'     => ask__('Taxonomies: Post tags'),
    'taxonomy'  => 'post_tag'
  ]);
}, 100, 1);

/**
 * Localization
 */
add_filter('aucor_core_pll_register_strings', function($strings) {

  return array_merge($strings, [
    'Taxonomies: Categories'        => 'Kategoriat',
    'Taxonomies: Post tags'         => 'Avainsanat',
  ]);

}, 10, 1);
