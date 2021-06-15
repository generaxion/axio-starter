<?php
/**
 * Setup: Footer
 *
 * @package hw
 */

/**
 * Place footer
 */
add_action('theme_footer', function() {

  X_Footer_Widgets::render();

}, 90, 0);

/**
 * Sidebars widget areas
 */
add_action('widgets_init', function() {
  $args = [
    'description'   => 'Add widgets here.',
    'before_widget' => '<section id="%1$s" class="widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
  ];

  $args['name'] = 'Footer';
  $args['id']   = 'footer';
  register_sidebar($args);

});

