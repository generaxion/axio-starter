<?php
/**
 * Register: Colors
 *
 * @package aucor_starter
 */

/**
 * Setup colos that can be used in Gutenberg
 */
add_action('after_setup_theme', function() {

  add_theme_support('editor-color-palette', array(
    array(
      'name'  => ask__('Color: White'),
      'slug'  => 'white',
      'color' => '#fff',
    ),
    array(
      'name'  => ask__('Color: Black'),
      'slug'  => 'black',
      'color' => '#333', // base font color
    ),
    array(
      'name'  => ask__('Color: Primary'),
      'slug'  => 'primary',
      'color' => '#42a0d9', // base font color
    ),
  ));

});
