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

  X_Footer::render();

}, 100);

/**
 * Localization
 */
add_filter('axio_core_pll_register_strings', function($strings) {

  return array_merge($strings, [
    'Menu: Legal Menu'        => 'Legal Menu',
  ]);

}, 10, 1);

/**
 * Register menu positions
 */
add_action('after_setup_theme', function() {

  register_nav_menus([
    'legal'    => ask__('Menu: Legal Menu'),
  ]);

});
