<?php
/**
 * Theme support registration
 *
 * @package axio
 */

/**
 * Register support for various WordPress features
 */
add_action('after_setup_theme', function() {

  // automatic document title
  add_theme_support('title-tag');

  // use HTML5 markup
  add_theme_support('html5', ['comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script']);

});
