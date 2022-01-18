<?php
/**
 * Setup: core/embed(s) block(s)
 *
 * @package axio
 */

/**
 * Allow block
 */
add_filter('allowed_block_types_all', function($blocks, $block_editor_context) {

  $blocks[] = 'core/embed';
  $blocks[] = 'core-embed/twitter';
  $blocks[] = 'core-embed/youtube';
  $blocks[] = 'core-embed/soundcloud';
  $blocks[] = 'core-embed/spotify';
  $blocks[] = 'core-embed/flickr';
  $blocks[] = 'core-embed/vimeo';
  $blocks[] = 'core-embed/issuu';
  $blocks[] = 'core-embed/slideshare';
  return $blocks;

}, 11, 2);
