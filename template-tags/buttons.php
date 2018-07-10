<?php
/**
 * Functions for buttons
 *
 * @package aucor_starter
 */

/**
 * Social share buttons
 *
 * Display share links to social media platforms.
 *
 * @example aucor_starter_social_share_buttons()
 */
function aucor_starter_social_share_buttons() {

  $url = (!is_tax()) ? get_permalink() : get_term_link(get_queried_object()->term_id);
  $title = get_the_title();

  ?>
  <div class="social-share">

    <span class="social-share__title h3"><?php ask_e('Social share: Title'); ?></span>

    <a href="<?php echo esc_url("https://www.facebook.com/sharer/sharer.php?u=$url"); ?>" target="_blank" class="social-share__link social-share__link--facebook">
      <?php echo aucor_starter_get_svg('facebook'); ?>
      <span class="social-share__link__label"><?php ask_e('Social share: Facebook'); ?></span>
    </a>

    <a href="<?php echo esc_url("https://twitter.com/share?url=$url"); ?>" target="_blank" class="social-share__link social-share__link--twitter">
      <?php echo aucor_starter_get_svg('twitter'); ?>
      <span class="social-share__link__label"><?php ask_e('Social share: Twitter'); ?></span>
    </a>

    <a href="<?php echo esc_url("https://www.linkedin.com/shareArticle?mini=true&title=$title&url=$url"); ?>" target="_blank" class="social-share__link social-share__link--linkedin">
      <?php echo aucor_starter_get_svg('linkedin'); ?>
      <span class="social-share__link__label"><?php ask_e('Social share: LinkedIn'); ?></span>
    </a>

  </div>
  <?php

}

/**
 * Menu toggle button
 *
 * Button with hamburger menu.
 *
 * @example aucor_starter_menu_toggle_btn('menu-toggle')
 * @example aucor_starter_menu_toggle_btn('menu-toggle', ['label' => 'Menu'])
 *
 * @param string $id HTML id for button element
 * @param array  $args list of arguments
 */
function aucor_starter_menu_toggle_btn($id, $args = array()) {

  // set defaults
  $defaults = array(
    'class'              => '',
    'label'              => '',
    'screen-reader-text' => ask__('Menu: Button label'),
  );

  // parse args
  $args = wp_parse_args($args, $defaults);

  // setup class
  $class = 'menu-toggle';
  if (!empty($args['class'])) {
    $class .= ' ' . trim($args['class']);
  }

  ?>
  <button id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($class); ?>" aria-expanded="false">
    <span class="screen-reader-text"><?php echo esc_html($args['screen-reader-text']); ?></span>
    <svg class="menu-toggle__svg icon" aria-hidden="true" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100">
      <g class="menu-toggle__svg__g">
        <path class="menu-toggle__svg__line menu-toggle__svg__line--1" d="M5 13h90v14H5z"/>
        <path class="menu-toggle__svg__line menu-toggle__svg__line--2" d="M5 43h90v14H5z"/>
        <path class="menu-toggle__svg__line menu-toggle__svg__line--3" d="M5 73h90v14H5z"/>
        <path class="menu-toggle__svg__close-line menu-toggle__svg__close-line--1" d="M5 43h90v14H5z"/>
        <path class="menu-toggle__svg__close-line menu-toggle__svg__close-line--2" d="M5 43h90v14H5z"/>
      </g>
    </svg>
    <?php if (!empty($args['label'])) : ?>
      <span class="menu-toggle__label"><?php echo esc_html($args['label']); ?></span>
    <?php endif; ?>
  </button>
  <?php

}
