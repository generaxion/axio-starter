<?php
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */

function aucor_starter_setup() {

  // Enable support for Post Thumbnails
  add_theme_support( 'post-thumbnails' );

  // Add custom image sizes
  //add_image_size( $name, $width, $height, $crop );

  // Let WordPress manage the document title.
  add_theme_support( 'title-tag' );

  // This theme uses wp_nav_menu() in one location.
  register_nav_menus( array(
    'primary' => ask__('Menu: Primary Menu'),
    'social'  => ask__('Menu: Social Menu'),
  ) );

  // Switch default core markup for search form, comment form, and comments to output valid HTML5.
  add_theme_support( 'html5', array(
    'search-form',
    'comment-form',
    'comment-list',
    'gallery',
    'caption',
  ) );

}
add_action( 'after_setup_theme', 'aucor_starter_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * @global int $content_width
 */

function aucor_starter_content_width() {
  $GLOBALS['content_width'] = apply_filters( 'aucor_starter_content_width', 640 );
}
add_action( 'after_setup_theme', 'aucor_starter_content_width', 0 );

/**
 * Register widget area.
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */

function aucor_starter_widgets_init() {
  /*
  register_sidebar( array(
    'name'          => esc_html__( 'Sidebar', 'aucor_starter' ),
    'id'            => 'sidebar-1',
    'description'   => '',
    'before_widget' => '<section id="%1$s" class="widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
  ) );
  */
}
add_action( 'widgets_init', 'aucor_starter_widgets_init' );

/**
 * Get last-edited timestamp
 */

function aucor_starter_last_edited( $asset = 'css' ) {

  global $aucor_starter_timestamps;

  if(empty($aucor_starter_timestamps)) {
    $filepath = get_template_directory() . '/assets/last-edited.json';
    if(file_exists($filepath)) {
      $json = file_get_contents($filepath);
      $aucor_starter_timestamps = json_decode($json, true);
    }
  }

  if(isset($aucor_starter_timestamps[$asset])) {
    return absint($aucor_starter_timestamps[$asset]);
  }

  return 0;

}

/**
 * TinyMCE formats
 *
 * @link https://codex.wordpress.org/TinyMCE_Custom_Styles
 */

function aucor_starter_tinymce_formats( $init ) {

  // Text formats
  $init['block_formats'] = "Paragraph=p; Alaotsikko 2=h2; Alaotsikko 3=h3; Alaotsikko 4=h4";

  // Cache busting
  $init['cache_suffix'] = aucor_starter_last_edited('css');

  return $init;
}
add_filter( 'tiny_mce_before_init', 'aucor_starter_tinymce_formats' );

/**
 * Move jQuery to footer
 */

function aucor_starter_move_jquery_into_footer( $wp_scripts ) {
  if( !is_admin() ) {
    $wp_scripts->add_data( 'jquery', 'group', 1 );
    $wp_scripts->add_data( 'jquery-core', 'group', 1 );
    $wp_scripts->add_data( 'jquery-migrate', 'group', 1 );
  }
}
add_action( 'wp_default_scripts', 'aucor_starter_move_jquery_into_footer' );

/**
 * Enqueue scripts and styles.
 */

function aucor_starter_scripts() {

  wp_enqueue_style( 'aucor_starter-style', get_template_directory_uri() . '/dist/styles/main.css' , false, aucor_starter_last_edited('css') );
  wp_enqueue_script( 'aucor_starter-js', get_template_directory_uri() . '/dist/scripts/main.js', ['jquery'], aucor_starter_last_edited('js'), true );

  if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
  }
}
add_action( 'wp_enqueue_scripts', 'aucor_starter_scripts' );

/**
 * Enqueue scripts and styles for admin.
 */

function aucor_starter_admin_scripts() {
  wp_enqueue_style( 'aucor_starter_admin_css', get_template_directory_uri() . '/dist/styles/admin.css', false, aucor_starter_last_edited('css') );
}
add_action( 'admin_enqueue_scripts', 'aucor_starter_admin_scripts' );

/**
 * Enqueue scripts and styles for TinyMCE
 */

function aucor_starter_tinymce_styles() {
  add_editor_style( 'dist/styles/editor.css' );
}
add_action( 'admin_init', 'aucor_starter_tinymce_styles' );

/**
 * Append to <head>
 */

function aucor_starter_append_to_head() {
  // Detect JS – replace class no-js with js in html tag
  echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action('wp_head', 'aucor_starter_append_to_head');

/**
 * Append to footer
 */

function aucor_starter_append_to_footer() {

}
add_action('wp_footer', 'aucor_starter_append_to_footer');


/**
 * Include files
 */

require_once 'inc/localization.php';       // Localization strings and functions
require_once 'inc/wp-settings.php';        // WP Settings
require_once 'inc/template-tags.php';      // Template tags
require_once 'inc/menus.php';              // Menus
require_once 'inc/remove-commenting.php';  // Remove commenting
require_once 'inc/hide-users.php';         // Hide users' identities
require_once 'inc/wp-login.php';           // Login screen

