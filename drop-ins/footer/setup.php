<?php
/**
 * Setup: Footer
 *
 * @package aucor_starter
 */

/**
 * Place footer
 */
add_action('theme_footer', function ($post_obj) {

  Aucor_Footer::render();

}, 100, 1);

/**
 * Localization
 */
add_filter('aucor_core_pll_register_strings', function($strings) {

  return array_merge($strings, [



  ]);

}, 10, 1);
