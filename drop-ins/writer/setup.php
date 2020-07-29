<?php
/**
 * Setup: Writer
 *
 * @package aucor_starter
 */

/**
 * Place Writer
 */
add_action('theme_entry_footer', function ($post_obj) {

  Aucor_Writer::render();

}, 90, 1);

/**
 * Localization
 */
add_filter('aucor_core_pll_register_strings', function($strings) {

  return array_merge($strings, [

    'Writer: Title'               => 'Kirjoittaja: ',
    'Writer: Writer\'s articles'  => 'Kirjoittajan muut kirjoitukset',

  ]);

}, 10, 1);
