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
        $item_output .= '<button tabindex="-1" class="menu-item__link__caret js-menu-caret">' . aucor_starter_get_svg('caret-down') . '</button>';
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
    $title = aucor_starter_get_svg(esc_attr($svg), array('title' => $title)) . '<span class="social-navigation__item__label">' . $title . '</span>';

    return $title;

  }

  return $title;

}
add_filter('nav_menu_item_title', 'aucor_starter_social_menu_icons', 10, 4);
