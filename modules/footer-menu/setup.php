<?php

/**
 * Setup: Footer
 *
 * @package axio
 */

/**
 * Place footer
 */
add_action('theme_footer', function() {

  X_Footer_Menus::render();

}, 90, 0);



/**
 * Register Footer menu positions
 */

add_action('after_setup_theme', function() {

  register_nav_menus([
    'footer' => 'Footer Menu',
  ]);

});