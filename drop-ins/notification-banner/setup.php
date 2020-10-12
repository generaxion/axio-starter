<?php
/**
 * Setup: Notification Banner
 *
 * @package aucor_starter
 */

/**
 * Place share buttons
 */
add_action('theme_header', function ($post_obj) {

  Aucor_Notification_Banner::render();

}, 100, 1);

/**
 * Localization
 */
add_filter('aucor_core_pll_register_strings', function($strings) {

  return array_merge($strings, [

  ]);

}, 10, 1);
