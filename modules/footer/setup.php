<?php
/**
 * Setup: Footer
 *
 * @package aucor_starter
 */

/**
 * Place footer
 */
add_action('theme_footer', function() {

  Aucor_Footer::render();

}, 100, 0);

