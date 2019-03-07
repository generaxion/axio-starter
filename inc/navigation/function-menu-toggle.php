<?php
/**
 * Function for hamburger menu button
 *
 * @package aucor_starter
 */

/**
 * Menu toggle button
 *
 * Button with hamburger menu.
 *
 * @example aucor_starter_menu_toggle_btn('menu-toggle')
 * @example aucor_starter_menu_toggle_btn('menu-toggle', ['label' => 'Menu'])
 *
 * @param string $id HTML id for button element
 * @param array  $args list of arguments
 */
function aucor_starter_menu_toggle_btn($id, $args = array()) {

  // set defaults
  $defaults = array(
    'class'              => '',
    'label'              => '',
    'screen-reader-text' => ask__('Menu: Button label'),
  );

  // parse args
  $args = wp_parse_args($args, $defaults);

  // setup class
  $class = 'menu-toggle';
  if (!empty($args['class'])) {
    $class .= ' ' . trim($args['class']);
  }

  ?>
  <button id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($class); ?>" aria-expanded="false">
    <span class="screen-reader-text"><?php echo esc_html($args['screen-reader-text']); ?></span>
    <svg class="menu-toggle__svg icon" aria-hidden="true" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100">
      <g class="menu-toggle__svg__g">
        <path class="menu-toggle__svg__line menu-toggle__svg__line--1" d="M5 13h90v14H5z"/>
        <path class="menu-toggle__svg__line menu-toggle__svg__line--2" d="M5 43h90v14H5z"/>
        <path class="menu-toggle__svg__line menu-toggle__svg__line--3" d="M5 73h90v14H5z"/>
        <path class="menu-toggle__svg__close-line menu-toggle__svg__close-line--1" d="M5 43h90v14H5z"/>
        <path class="menu-toggle__svg__close-line menu-toggle__svg__close-line--2" d="M5 43h90v14H5z"/>
      </g>
    </svg>
    <?php if (!empty($args['label'])) : ?>
      <span class="menu-toggle__label"><?php echo esc_html($args['label']); ?></span>
    <?php endif; ?>
  </button>
  <?php

}
