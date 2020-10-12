<?php
/**
 * Setup: Search form
 *
 * @package aucor_starter
 */

/**
 * Localization
 */
add_filter('aucor_core_pll_register_strings', function($strings) {

  return array_merge($strings, [

    'Search form: Placeholder'                => 'Etsi sivustolta...',
    'Search form: Screen reader label'        => 'Etsi sivustolta',
    'Search form: Submit'                     => 'Hae',

  ]);

}, 10, 1);
