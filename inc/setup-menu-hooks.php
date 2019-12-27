<?php
/**
 * Menus
 *
 * @package aucor_starter
 */

/**
 * Dropdown caret for primary menu
 *
 * @param string  $item_output the menu item output
 * @param WP_Post $item menu item object
 * @param int     $depth depth of the menu
 * @param array   $args wp_nav_menu() arguments
 *
 * @return string menu item with possible description
 */
function aucor_starter_dropdown_icon_to_menu_links($item_output, $item, $depth, $args) {

  if ($args->theme_location == 'primary') {
    foreach ($item->classes as $value) {
      if ($value == 'menu-item-has-children') {
        // add caret button. not focusable as tab navigation is handeled without this button
        $item_output .= '<button class="menu-item__caret js-menu-caret">' .
                          Aucor_SVG::get(['name' => 'caret-down']) .
                          '<span class="menu-item__caret__text-open">' . ask__('Menu: Open Sub-menu') . '</span>' .
                          '<span class="menu-item__caret__text-close">' . ask__('Menu: Close Sub-menu') . '</span>' .
                        '</button>';
      }
    }
  }
  return '<span class="menu-item__link">' . $item_output . '</span>';

}
add_filter('walker_nav_menu_start_el', 'aucor_starter_dropdown_icon_to_menu_links', 10, 4);

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
    $title = Aucor_SVG::get(['name' => $svg, 'title' => $title]) . '<span class="social-navigation__item__label">' . $title . '</span>';

    return $title;

  }

  return $title;

}
add_filter('nav_menu_item_title', 'aucor_starter_social_menu_icons', 10, 4);

/**
 * Include icon by class name
 *
 * Example: `icon-arrow` includes svg `arrow` from SVG sprite.
 *
 * @param string  $title the title of menu item
 * @param WP_Post $item menu item object
 * @param array   $args wp_nav_menu() arguments
 * @param int     $depth depth of the menu
 *
 * @return string menu item with possible description
 */
function aucor_starter_icons_from_classes($title, $item, $args, $depth) {

  foreach ($item->classes as $value) {
    if (strpos($value, 'icon-') === 0) {
      $title = Aucor_SVG::get(['name' => str_replace('icon-', '', $value), 'attr' => ['class' => ['icon-from-class']]]) . trim($title);
    }
  }
  return $title;

}
add_filter('nav_menu_item_title', 'aucor_starter_icons_from_classes', 10, 4);


