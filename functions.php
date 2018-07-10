<?php
/**
 * Functions and definitions
 *
 * @package aucor_starter
 */

/**
 * Include features
 */
require_once 'inc/cache.php';                  // cache hooks and functions
require_once 'inc/debug.php';                  // debug functions
require_once 'inc/hide-users.php';             // hide users' identities
require_once 'inc/localization.php';           // localization strings and functions
require_once 'inc/menus.php';                  // menus
require_once 'inc/remove-commenting.php';      // remove commenting
require_once 'inc/wp-login.php';               // login screen
require_once 'inc/wp-settings.php';            // WP settings and optimization

/**
 * Include template functions
 */
require_once 'template-tags/buttons.php';      // buttons & social
require_once 'template-tags/icons.php';        // icons & SVG
require_once 'template-tags/images.php';       // images
require_once 'template-tags/meta.php';         // meta & time
require_once 'template-tags/navigation.php';   // navigation & hierarchial pages
require_once 'template-tags/search.php';       // search
require_once 'template-tags/titles.php';       // titles


/**
 * Set up theme defaults and register support for various WordPress features
 */
function aucor_starter_setup() {

  // default image sizes
  $default_image_sizes = [
    [
      'name' => 'thumbnail',
      'w'    => 250,
      'h'    => 250,
    ],
    [
      'name' => 'medium',
      'w'    => 360,
      'h'    => 720,
    ],
    [
      'name' => 'large',
      'w'    => 720,
      'h'    => 1440,
    ]
  ];

  foreach ($default_image_sizes as $size) {
    $existing_w = intval(get_option($size['name'] . '_size_w'));
    if ($existing_w !== $size['w']) {
      update_option($size['name'] . '_size_h', $size['h']);
      update_option($size['name'] . '_size_w', $size['w']);
    }
  }

  // custom image sizes
  add_image_size('lazyload',   14,  8,  true); // small ~16:9
  add_image_size('hero_xl',  2000, 750, true);  // hero @1,33x 3:1
  add_image_size('hero_md',  1500, 500, true);  // hero @1x 3:1
  add_image_size('hero_sm',   800, 500, true);  // hero mobile 8:5

  // enable support for post thumbnails
  add_theme_support('post-thumbnails');

  // automatic document title
  add_theme_support('title-tag');

  // menu locations
  register_nav_menus(array(
    'primary' => ask__('Menu: Primary Menu'),
    'social'  => ask__('Menu: Social Menu'),
  ));

  // use HTML5 markup
  add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);

}
add_action('after_setup_theme', 'aucor_starter_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet
 *
 * @global int $content_width the max width of content in pixels
 */
function aucor_starter_content_width() {

  $GLOBALS['content_width'] = apply_filters('aucor_starter_content_width', 720);

}
add_action('after_setup_theme', 'aucor_starter_content_width', 0);

/**
 * Register widget area
 */
function aucor_starter_widgets_init() {

  // register_sidebar(array(
  //   'name'          => esc_html__('Sidebar', 'aucor_starter'),
  //   'id'            => 'sidebar-1',
  //   'description'   => '',
  //   'before_widget' => '<section id="%1$s" class="widget %2$s">',
  //   'after_widget'  => '</section>',
  //   'before_title'  => '<h2 class="widget-title">',
  //   'after_title'   => '</h2>',
  // ));

}
add_action('widgets_init', 'aucor_starter_widgets_init');

/**
 * TinyMCE formats
 *
 * @link https://codex.wordpress.org/TinyMCE_Custom_Styles
 *
 * @param array $init TinyMCE settings
 *
 * @return array TinyMCE settings
 */
function aucor_starter_tinymce_formats($init) {

  // text formats
  $init['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4';

  // cache busting
  $init['cache_suffix'] = aucor_starter_last_edited('css');

  return $init;

}
add_filter('tiny_mce_before_init', 'aucor_starter_tinymce_formats');

/**
 * Enqueue scripts and styles
 */
function aucor_starter_scripts() {

  // main css
  wp_enqueue_style('aucor_starter-style', get_template_directory_uri() . '/dist/styles/main.css', false, aucor_starter_last_edited('css'));

  // dependencies for js, if you need jQuery => array('jquery')
  $js_dependencies = array();

  // main js
  wp_enqueue_script('aucor_starter-js', get_template_directory_uri() . '/dist/scripts/main.js', $js_dependencies, aucor_starter_last_edited('js'), true);

  // critical js
  wp_enqueue_script('aucor_starter-critical-js', get_template_directory_uri() . '/dist/scripts/critical.js', array(), aucor_starter_last_edited('js'), false);

  // comments
  if (is_singular() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }

}
add_action('wp_enqueue_scripts', 'aucor_starter_scripts');

/**
 * Enqueue scripts and styles for admin
 */
function aucor_starter_admin_scripts() {

  wp_enqueue_style('aucor_starter_admin_css', get_template_directory_uri() . '/dist/styles/admin.css', false, aucor_starter_last_edited('css'));

}
add_action('admin_enqueue_scripts', 'aucor_starter_admin_scripts');

/**
 * Enqueue scripts and styles for TinyMCE
 */
function aucor_starter_tinymce_styles() {

  add_editor_style('dist/styles/editor.css');

}
add_action('admin_init', 'aucor_starter_tinymce_styles');

/**
 * Append to <head>
 */
function aucor_starter_append_to_head() {

  // replace class no-js with js in html tag
  echo "<script>(function(d){d.className = d.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";

}
add_action('wp_head', 'aucor_starter_append_to_head');

/**
 * Append to footer
 */
function aucor_starter_append_to_footer() {

}
add_action('wp_footer', 'aucor_starter_append_to_footer');

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


