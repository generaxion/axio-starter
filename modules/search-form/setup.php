<?php
/**
 * Setup: Search form
 *
 * @package axio
 */

/**
 * Localization
 */
add_filter('axio_core_pll_register_strings', function($strings) {

  return array_merge($strings, [

    'Search form: Placeholder'                => 'Search from website...',
    'Search form: Screen reader label'        => 'Search from website',
    'Search form: Submit'                     => 'Search',

  ]);

}, 10, 1);
