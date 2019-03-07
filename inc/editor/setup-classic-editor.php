<?php
/**
 * Editor configuration
 *
 * @package aucor_starter
 */

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
 * Set the content width in pixels, based on the theme's design and stylesheet
 *
 * @global int $content_width the max width of content in pixels
 */
function aucor_starter_content_width() {

  $GLOBALS['content_width'] = 720;

}
add_action('after_setup_theme', 'aucor_starter_content_width', 0);
