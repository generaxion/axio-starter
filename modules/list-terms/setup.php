<?php
/**
 * Setup: List Terms
 *
 * @package axio
 */

/**
 * Append lists to entry footer
 */
add_action('theme_entry_footer', function() {

  X_List_Terms::render([
    'title'     => ask__('Taxonomies: Categories'),
    'taxonomy'  => 'category'
  ]);

  X_List_Terms::render([
    'title'     => ask__('Taxonomies: Post tags'),
    'taxonomy'  => 'post_tag'
  ]);

}, 100, 1);

/**
 * Localization
 */
add_filter('axio_core_pll_register_strings', function($strings) {

  return array_merge($strings, [
    'Taxonomies: Categories'        => 'Categories',
    'Taxonomies: Post tags'         => 'Tags',
  ]);

}, 10, 1);
