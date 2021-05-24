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

}, 100, 0);

