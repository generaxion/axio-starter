<?php
/**
 * Setup: Posts navigation numeric
 *
 * @package axio
 */

/**
 * Localization
 */
add_filter('axio_core_pll_register_strings', function($strings) {

  return array_merge($strings, [

    'Navigation: Numeric pagination'     => 'Show more',
    'Navigation: Go to page x'           => 'Go to page %s',
    'Navigation: Current page x'         => 'Current page, page %s',
    'Navigation: Previous'               => 'Previous page',
    'Navigation: Next'                   => 'Next page',

  ]);

}, 10, 1);
