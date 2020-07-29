<?php
/**
 * Setup: Header
 *
 * @package aucor_starter
 */

/**
 * Place header before page
 */
add_action('theme_before_page', function () {

  Aucor_Mobile_Menu::render();

}, 100, 1);

/**
 * Place header
 */
add_action('theme_header', function () {

  Aucor_Header::render();

}, 100, 1);

/**
 * Localization
 */
add_filter('aucor_core_pll_register_strings', function($strings) {

  return array_merge($strings, [

    'Menu: Primary Menu'        => 'Päävalikko',
    'Menu: Additional Menu'     => 'Lisävalikko',
    'Menu: Button label'        => 'Menu',
    'Menu: Open'                => 'Avaa valikko',
    'Menu: Close'               => 'Sulje valikko',
    'Menu: Open Sub-menu'       => 'Avaa alavalikko',
    'Menu: Close Sub-menu'      => 'Sulje alavalikko',

  ]);

}, 10, 1);

/**
 * Register menu positions
 */

add_action('after_setup_theme', function() {

  register_nav_menus([
    'primary'    => ask__('Menu: Primary Menu'),
    'additional' => ask__('Menu: Additional Menu'),
  ]);

});

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
                          Aucor_SVG::get(['name' => 'chevron-down']) .
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
