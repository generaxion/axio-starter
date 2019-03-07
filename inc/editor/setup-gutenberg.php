<?php
/**
 * Setup Gutenberg
 *
 * @package aucor_starter
 */

/**
 * Gutenberg setup
 */
add_action('after_setup_theme', function() {

  // support wide width
  add_theme_support('align-wide');

  // support responsive embeds
  add_theme_support('responsive-embeds');

  // disable custom color picker
  add_theme_support('disable-custom-colors');

  // disable font size selection
  add_theme_support('disable-custom-font-sizes');

  // remove font size options
  // @TODO: fix when disablind supported: https://github.com/WordPress/gutenberg/issues/11628
  add_theme_support('editor-font-sizes', array(
    array(
      'name'        => 'Normal',
      'shortName'   => 'N',
      'size'        => 16,
      'slug'        => 'normal'
    ),
  ));

});
