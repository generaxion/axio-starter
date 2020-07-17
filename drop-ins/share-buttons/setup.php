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

    'Social share: Title'       => 'Jaa sosiaalisessa mediassa',
    'Social share: Facebook'    => 'Jaa Facebookissa',
    'Social share: Twitter'     => 'Jaa Twitterissä',
    'Social share: LinkedIn'    => 'Jaa LinkedInissä',
    'Social share: WhatsApp'    => 'Jaa WhatsAppissa',

  ]);

}, 10, 1);
