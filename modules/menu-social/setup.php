<?php
/**
 * Setup: Menu Social
 *
 * @package axio
 */

/**
 * Localization
 */
add_filter('axio_core_pll_register_strings', function($strings) {

  return array_merge($strings, [
    'Menu: Social Menu' => 'Social media channels',
  ]);

}, 10, 1);

/**
 * Register menu position
 */

add_action('after_setup_theme', function() {

  register_nav_menus(['social' => ask__('Menu: Social Menu')]);

});

/**
 * SVG icons for social menu
 *
 * @param string    $title the title of menu item
 * @param WP_Post   $item menu item object
 * @param stdClass  $args wp_nav_menu() arguments
 * @param int       $depth depth of the menu
 *
 * @return string menu item with possible description
 */
add_filter('nav_menu_item_title', function ($title, $item, $args, $depth) {

  if ($args->theme_location == 'social') {

    // supported social icons
    $social_icons = [
      'facebook.com'   => 'facebook',
      'instagram.com'  => 'instagram',
      'linkedin.com'   => 'linkedin',
      'mailto:'        => 'mail',
      'twitter.com'    => 'twitter',
      'youtube.com'    => 'youtube',
      'github.com'     => 'github',
    ];

    // fallback icon
    $svg = 'external';

    // find matching icon
    foreach ($social_icons as $domain => $value) {
      if (strstr($item->url, $domain)) {
        $svg = $value;
      }
    }

    // replace title with svg and <span> wrapped title
    $title = X_SVG::get(['name' => $svg]) . '<span class="social-navigation__item__label">' . $title . '</span>';

    return $title;

  }

  return $title;

}, 10, 4);
