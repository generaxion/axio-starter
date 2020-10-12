<?php
/**
 * Setup: Posts navigation numeric
 *
 * @package aucor_starter
 */


/**
 * Localization
 */
add_filter('aucor_core_pll_register_strings', function($strings) {

  return array_merge($strings, [

    'Navigation: Numeric pagination'     => 'Näytä lisää',
    'Navigation: Go to page x'           => 'Siirry sivulle %s',
    'Navigation: Current page x'         => 'Nykyinen sivu, sivu %s',
    'Navigation: Previous'               => 'Edellinen sivu',
    'Navigation: Next'                   => 'Seuraava sivu',

  ]);

}, 10, 1);
