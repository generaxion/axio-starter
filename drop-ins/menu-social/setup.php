<?php
/**
 * Setup: Menu Social
 *
 * @package aucor_starter
 */

/**
 * Localization
 */
add_filter('aucor_core_pll_register_strings', function($strings) {

  return array_merge($strings, [
    'Menu: Social Menu' => 'Sosiaalisen median kanavat',
  ]);

}, 10, 1);

/**
 * Register menu position
 *
 * @package aucor_starter
 */

add_action('after_setup_theme', function() {
  register_nav_menus(['social'     => ask__('Menu: Social Menu')]);
});

/**
 * SVG icons for social menu
 *
 * @param string  $title the title of menu item
 * @param WP_Post $item menu item object
 * @param array   $args wp_nav_menu() arguments
 * @param int     $depth depth of the menu
 *
 * @return string menu item with possible description
 */
function aucor_starter_social_menu_icons($title, $item, $args, $depth) {

  if ($args->theme_location == 'social') {

    // supported social icons
    $social_icons = array(
      'facebook.com'   => 'facebook',
      'instagram.com'  => 'instagram',
      'linkedin.com'   => 'linkedin',
      'mailto:'        => 'mail',
      'twitter.com'    => 'twitter',
      'youtube.com'    => 'youtube',
    );

    // fallback icon
    $svg = 'external';

    // find matching icon
    foreach ($social_icons as $domain => $value) {
      if (strstr($item->url, $domain)) {
        $svg = $value;
      }
    }

    // replace title with svg and <span> wrapped title
    $title = Aucor_SVG::get(['name' => $svg]) . '<span class="social-navigation__item__label">' . $title . '</span>';

    return $title;

  }

  return $title;

}
add_filter('nav_menu_item_title', 'aucor_starter_social_menu_icons', 10, 4);


