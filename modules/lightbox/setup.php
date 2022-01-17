<?php
/**
 * Setup: Lightbox
 *
 * @package axio
 */

/**
 * Localization
 */
add_filter('axio_core_pll_register_strings', function($strings) {

  return array_merge($strings, [
    'Lightbox: Prev'          => 'Previous',
    'Lightbox: Next'          => 'Next',
    'Lightbox: Close'         => 'Close',
    'Lightbox: Loading'       => 'Loading',
  ]);

}, 10, 1);

/**
 * Enqueue scripts and styles
 */
add_action('wp_enqueue_scripts', function() {

  wp_localize_script('x-js', 'theme_strings_lightbox', [
    'prev'    => ask__('Lightbox: Prev'),
    'next'    => ask__('Lightbox: Next'),
    'close'   => ask__('Lightbox: Close'),
    'loading' => ask__('Lightbox: Loading'),
  ]);

});
