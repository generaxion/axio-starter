<?php
/**
 * Register: translatable strings
 *
 * @package axio
 */

/**
 * Register string to translate
 *
 * Module specific strings should be registeder from the module.
 *
 * @uses Aucor Core filter: aucor_core_pll_register_strings
 *
 * @return array list of translatabel strings
 */
add_filter('aucor_core_pll_register_strings', function($strings) {

  return array_merge($strings, [

    // 404
    '404: Page not found description'   => 'Page might have been deleted or moved. Try the search below.',

    // search
    'Search: Title'                      => 'Search:',
    'Search: Nothing found'              => 'No results',
    'Search: Nothing found description'  => 'No results found. Try different words.',

    // accessibility
    'Accessibility: Skip to content'     => 'Skip to content',

  ]);

});
