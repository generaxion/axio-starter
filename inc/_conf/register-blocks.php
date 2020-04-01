<?php
/**
 * Register: Blocks
 *
 * @package aucor_starter
 */

/**
 * Set explicitly allowed blocks (all others are disallowed)
 *
 * Notice that you need to manually add any custom block or plugins'
 * blocks here to appear on Gutenberg. This is to keep the control on what
 * is or is not allowed.
 *
 * @param bool|array $allowed_block_types list of block names or true for all
 * @param WP_Post $post the current post object
 *
 * @return array $allowed_block_types list of block names
 */
function aucor_starter_gutenberg_allowed_blocks($allowed_block_types, $post) {

  $blocks = [];

  /**
   * Common blocks
   */
  $blocks[] = 'core/paragraph';
  $blocks[] = 'core/image';
  $blocks[] = 'core/heading';
  $blocks[] = 'core/gallery';
  $blocks[] = 'core/list';
  $blocks[] = 'core/quote';
  $blocks[] = 'core/file';

  /**
   * Formatting
   */
  $blocks[] = 'core/table';
  $blocks[] = 'core/freeform'; // classic editor

  /**
   * Layout
   */
  $blocks[] = 'core/button';
  $blocks[] = 'core/buttons';
  $blocks[] = 'core/media-text';
  $blocks[] = 'core/columns';
  $blocks[] = 'core/group';
  $blocks[] = 'core/separator';

  /**
   * Widgets
   */
  $blocks[] = 'core/shortcode';

  /**
   * Embeds
   */
  $blocks[] = 'core/embed';
  $blocks[] = 'core-embed/twitter';
  $blocks[] = 'core-embed/youtube';
  $blocks[] = 'core-embed/facebook';
  $blocks[] = 'core-embed/instagram';
  $blocks[] = 'core-embed/soundcloud';
  $blocks[] = 'core-embed/spotify';
  $blocks[] = 'core-embed/flickr';
  $blocks[] = 'core-embed/vimeo';
  $blocks[] = 'core-embed/issuu';
  $blocks[] = 'core-embed/slideshare';

  /**
   * Reusable blocks
   */
  $blocks[] = 'core/block';

  /**
   * Plugins
   */

  /**
   * Custom
   */

  return $blocks;

}
add_filter('allowed_block_types', 'aucor_starter_gutenberg_allowed_blocks', 10, 2);
