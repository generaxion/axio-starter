<?php
/**
 * Register menu positions
 *
 * @package aucor_starter
 */

add_action('after_setup_theme', function() {

  register_nav_menus([
    'primary'    => ask__('Menu: Primary Menu'),
    'additional' => ask__('Menu: Additional Menu'),
  ]);

});
