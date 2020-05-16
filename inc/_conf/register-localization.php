<?php
/**
 * Register: translatable strings
 *
 * @package aucor_starter
 */

/**
 * Register string to translate
 *
 * @uses Aucor Core filter: aucor_core_pll_register_strings
 *
 * @return array list of translatabel strings
 */
add_filter('aucor_core_pll_register_strings', function() {

  return [

    // titles
    'Title: Home'                       => 'Blogi',
    'Title: Archives'                   => 'Arkisto',
    'Title: Search'                     => 'Haku',
    'Title: 404'                        => 'Hakemaasi sivua ei löytynyt',

    // menu
    'Menu: Button label'                => 'Menu',
    'Menu: Primary Menu'                => 'Päävalikko',
    'Menu: Upper Menu'                  => 'Lisävalikko',
    'Menu: Social Menu'                 => 'Sosiaalisen median kanavat',
    'Menu: Open'                        => 'Avaa valikko',
    'Menu: Close'                       => 'Sulje valikko',
    'Menu: Open Sub-menu'               => 'Avaa alavalikko',
    'Menu: Close Sub-menu'              => 'Sulje alavalikko',

    // 404
    '404: Page not found description'   => 'Sivu on saatettu poistaa tai siirtää eri osoitteeseen. Käytä alla olevaa hakua löytääksesi etsimäsi.',

    // search
    'Search: Title'                      => 'Haku: ',
    'Search: Nothing found'              => 'Ei hakutuloksia',
    'Search: Nothing found description'  => 'Hakutuloksia ei löytynyt. Kokeile eri hakusanoja.',
    'Search: Placeholder'                => 'Etsi sivustolta...',
    'Search: Screen reader label'        => 'Etsi sivustolta',
    'Search: Submit'                     => 'Hae',

    // accessibility
    'Accessibility: Skip to content'     => 'Siirry sisältöön',

    // navigation
    'Navigation: Numeric pagination'     => 'Näytä lisää',
    'Navigation: Go to page x'           => 'Siirry sivulle %s',
    'Navigation: Current page x'         => 'Nykyinen sivu, sivu %s',
    'Navigation: Previous'               => 'Edellinen sivu',
    'Navigation: Next'                   => 'Seuraava sivu',

    // social
    'Social share: Title'                => 'Jaa sosiaalisessa mediassa',
    'Social share: Facebook'             => 'Jaa Facebookissa',
    'Social share: Twitter'              => 'Jaa Twitterissä',
    'Social share: LinkedIn'             => 'Jaa LinkedInissä',
    'Social share: WhatsApp'             => 'Jaa WhatsAppissa',

    // taxonomies
    'Taxonomies: Keywords'               => 'Avainsanat',
    'Taxonomies: Categories'             => 'Kategoriat',

    // colors
    'Color: White'                       => 'Valkoinen',
    'Color: Black'                       => 'Musta',
    'Color: Primary'                     => 'Pääväri',

    // script localization
    'Tobi: Prev'                        => 'Edellinen',
    'Tobi: Next'                        => 'Seuraava',
    'Tobi: Close'                       => 'Sulje',
    'Tobi: Loading'                     => 'Lataa',

  ];

});
