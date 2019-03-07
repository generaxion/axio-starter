<?php
/**
 * Theme support registration
 *
 * @package aucor_starter
 */

/**
 * Register support for various WordPress features
 */
add_action('after_setup_theme', function() {

  // automatic document title
  add_theme_support('title-tag');

  // use HTML5 markup
  add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);

});
