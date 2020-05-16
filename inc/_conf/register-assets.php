<?php
/**
 * Register: Assets
 *
 * Enqueue scripts and stylesheets for theme.
 * Append content into <head> or footer.
 * Include favicons.
 *
 * @package aucor_starter
 */

/**
 * Enqueue scripts and styles
 */
add_action('wp_enqueue_scripts', function() {

  // main css
  wp_enqueue_style(
    'aucor_starter-style',
    get_template_directory_uri() . '/dist/styles/main.css',
    [],
    aucor_starter_last_edited('css')
  );

  // critical js
  wp_enqueue_script(
    'aucor_starter-critical-js',
    get_template_directory_uri() . '/dist/scripts/critical.js#async',
    [],
    aucor_starter_last_edited('js'),
    false
  );

  // main js
  wp_enqueue_script(
    'aucor_starter-js',
    get_template_directory_uri() . '/dist/scripts/main.js#defer',
    [],
    aucor_starter_last_edited('js'),
    true
  );

  // localize scripts
  $strings = [
    // Tobi.js
    'prev'    => ask__('Tobi: Prev'),
    'next'    => ask__('Tobi: Next'),
    'close'   => ask__('Tobi: Close'),
    'loading' => ask__('Tobi: Loading'),
  ];
  wp_localize_script('aucor_starter-js', 'theme_strings', $strings);

  // comments
  if (is_singular() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }

  // wp-embed
  wp_deregister_script('wp-embed');

});

/**
 * Enqueue styles for Gutenberg Editor
 */
add_action('enqueue_block_editor_assets', function() {

  // editor styles
  wp_enqueue_style(
    'aucor_starter-editor-gutenberg-style',
    get_stylesheet_directory_uri() . '/dist/styles/editor-gutenberg.css',
    [],
    aucor_starter_last_edited('css')
  );

  // editor scripts
  wp_enqueue_script(
    'aucor_starter-editor-gutenberg-scripts',
    get_stylesheet_directory_uri() . '/dist/scripts/editor-gutenberg.js',
    ['wp-i18n', 'wp-blocks', 'wp-dom-ready'],
    aucor_starter_last_edited('js'),
    true
  );

}, 10);

/**
 * Enqueue scripts and styles for admin
 */
add_action('admin_enqueue_scripts', function() {

  // admin.css
  wp_enqueue_style(
    'aucor_starter-admin-css',
    get_template_directory_uri() . '/dist/styles/admin.css',
    [],
    aucor_starter_last_edited('css')
  );

});

/**
 * Enqueue styles for Classic Editor
 */
add_action('admin_init', function() {

  add_editor_style('dist/styles/editor-classic.css');

});

/**
 * Append to <head>
 */
add_action('wp_head', function() {

  // replace class no-js with js in html tag
  echo "<script>(function(d){d.className = d.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";

});

/**
 * Append to footer
 */
add_action('wp_footer', function() {

});

/**
 * Favicons
 *
 * Add favicons' <link> and <meta> tags here
 */
function aucor_starter_favicons() {

}
add_action('wp_head',    'aucor_starter_favicons');
add_action('admin_head', 'aucor_starter_favicons');
add_action('login_head', 'aucor_starter_favicons');

/**
 * Async assets via #async in url
 *
 * @see https://stackoverflow.com/a/18945175
 */
add_filter('clean_url', function ($url) {

  if (strpos($url, '#async') !== false && !is_admin()) {
    $url = str_replace('#async', '', $url) . "' async='async";
  }
  if (strpos($url, '#defer') !== false && !is_admin()) {
    $url = str_replace('#defer', '', $url) . "' defer='defer";
  }
  return $url;

}, 11, 1);
