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
 * @uses Axio Core filter: axio_core_pll_register_strings
 *
 * @return array list of translatabel strings
 */
add_filter('axio_core_pll_register_strings', function($strings) {

  return array_merge($strings, [

    // titles
    'Title: Home'                       => 'Blog',
    'Title: Archives'                   => 'Archives',
    'Title: Search'                     => 'Search',
    'Title: 404'                        => 'Page not found',

    // 404
    '404: Page not found description'   => 'Page might have been deleted or moved.',

    // search
    'Search: Title'                      => 'Search:',
    'Search: Nothing found'              => 'No results',
    'Search: Nothing found description'  => 'No results found. Try different words.',

    // accessibility
    'Accessibility: Skip to content'     => 'Skip to content',

  ]);

});
