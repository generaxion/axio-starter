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
