<?php
/**
 * Customize wp-login.php
 */

// Assets for login screen

function aucor_starter_login_screen_assets() {
  wp_enqueue_style( 'aucor_starter-login-styles', get_stylesheet_directory_uri() . '/dist/styles/wp-login.css' );
}
add_action( 'login_enqueue_scripts', 'aucor_starter_login_screen_assets' );

// Logo title

function aucor_starter_login_logo_url_title() {
  return get_bloginfo('name'); // Site name
}
add_filter( 'login_headertitle', 'aucor_starter_login_logo_url_title' );

// Logo link

function aucor_starter_login_logo_url() {
  return get_site_url(); // Site URL
}
add_filter( 'login_headerurl', 'aucor_starter_login_logo_url' );
