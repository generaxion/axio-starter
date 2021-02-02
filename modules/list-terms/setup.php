<?php
/**
 * Setup: List Terms
 *
 * @package aucor_starter
 */

/**
 * Append lists to entry footer
 */
add_action('theme_entry_footer', function() {

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
    'Taxonomies: Categories'        => 'Categories',
    'Taxonomies: Post tags'         => 'Tags',
  ]);

}, 10, 1);
