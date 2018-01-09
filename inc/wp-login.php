<?php
/**
 * Customize wp-login.php
 *
 * @package aucor_starter
 */

/**
 * Assets for login screen
 */
function aucor_starter_login_screen_assets() {

  wp_enqueue_style('aucor_starter-login-styles', get_stylesheet_directory_uri() . '/dist/styles/wp-login.css');

}
add_action('login_enqueue_scripts', 'aucor_starter_login_screen_assets');

/**
 * Logo title
 *
 * @param string $title login header title
 *
 * @return string site name
 */
function aucor_starter_login_logo_url_title($title) {

  return get_bloginfo('name');

}
add_filter('login_headertitle', 'aucor_starter_login_logo_url_title');


/**
 * Logo link
 *
 * @param string $url the url for logo link
 *
 * @return string site url
 */
function aucor_starter_login_logo_url($url) {

  return get_site_url();

}
add_filter('login_headerurl', 'aucor_starter_login_logo_url');
