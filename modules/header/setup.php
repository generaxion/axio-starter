<?php
/**
 * Setup: Header
 *
 * @package axio
 */

/**
 * Place header before page
 */
add_action('theme_before_page', function () {

  X_Mobile_Menu::render();

}, 100, 1);

/**
 * Place header
 */
add_action('theme_header', function () {

  X_Header::render();

}, 100, 1);

/**
 * Localization
 */
add_filter('axio_core_pll_register_strings', function($strings) {

  return array_merge($strings, [
    'Menu: Primary Menu'        => 'Primary Menu',
    'Menu: Additional Menu'     => 'Additional Menu',
    'Menu: Button label'        => 'Menu',
    'Menu: Open'                => 'Open menu',
    'Menu: Close'               => 'Close menu',
    'Menu: Open Sub-menu'       => 'Open sub-menu',
    'Menu: Close Sub-menu'      => 'Close sub-menu',
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
 * @param string    $item_output the menu item output
 * @param WP_Post   $item menu item object
 * @param int       $depth depth of the menu
 * @param stdObject $args wp_nav_menu() arguments
 *
 * @return string menu item with possible description
 */
add_filter('walker_nav_menu_start_el', function ($item_output, $item, $depth, $args) {

  if ($args->theme_location == 'primary') {
    foreach ($item->classes as $value) {
      if ($value == 'menu-item-has-children') {
        // add caret button. not focusable as tab navigation is handeled without this button
        $item_output .= '<button class="menu-item__caret js-menu-caret">' .
          X_SVG::get(['name' => 'chevron-down', 'attr' => ['class' => ['menu-item__caret__icon', 'menu-item__caret__icon--desktop', 'menu-item__caret__icon--arrow']]]) .
          X_SVG::get(['name' => 'plus',         'attr' => ['class' => ['menu-item__caret__icon', 'menu-item__caret__icon--mobile', 'menu-item__caret__icon--open']]]) .
          X_SVG::get(['name' => 'minus',        'attr' => ['class' => ['menu-item__caret__icon', 'menu-item__caret__icon--mobile', 'menu-item__caret__icon--close']]]) .
          '<span class="menu-item__caret__text-open">' . ask__('Menu: Open Sub-menu') . '</span>' .
          '<span class="menu-item__caret__text-close">' . ask__('Menu: Close Sub-menu') . '</span>' .
        '</button>';
      }
    }
  }
  return '<span class="menu-item__link">' . $item_output . '</span>';

}, 10, 4);

/**
 * Include icon by class name
 *
 * Example: `icon-arrow` includes svg `arrow` from SVG sprite.
 *
 * @param string    $title the title of menu item
 * @param WP_Post   $item menu item object
 * @param stdObject $args wp_nav_menu() arguments
 * @param int       $depth depth of the menu
 *
 * @return string menu item with possible description
 */
add_filter('nav_menu_item_title', function ($title, $item, $args, $depth) {

  foreach ($item->classes as $value) {
    if (strpos($value, 'icon-') === 0) {
      $svg = X_SVG::get(['name' => str_replace('icon-', '', $value), 'attr' => ['class' => ['icon-from-class']]]);
      if (in_array('after-icon', $item->classes)) {
        $title = trim($title) . $svg;
      } else {
        $title =  $svg . trim($title);
      }
    }
  }
  return $title;

}, 10, 4);
