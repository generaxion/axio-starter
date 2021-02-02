<?php
/**
 * Setup: Share buttons
 *
 * @package aucor_starter
 */

/**
 * Place share buttons
 */
add_action('theme_entry_footer', function ($post_obj) {

  Aucor_Share_Buttons::render();

}, 100, 1);

/**
 * Localization
 */
add_filter('aucor_core_pll_register_strings', function($strings) {

  return array_merge($strings, [

    'Social share: Title'       => 'Share on social media',
    'Social share: Facebook'    => 'Share on Facebook',
    'Social share: Twitter'     => 'Share on Twitter',
    'Social share: LinkedIn'    => 'Share on LinkedIn',
    'Social share: WhatsApp'    => 'Share on WhatsApp',

  ]);

}, 10, 1);
