<?php
/**
 * Setup: core/image block
 *
 * @package axio
 */

/**
 * Allow block
 */
add_filter('allowed_block_types_all', function($blocks, $block_editor_context) {

  $blocks[] = 'core/image';
  return $blocks;

}, 11, 2);

/**
 * Set wide image sizes attribute
 *
 * Gutenberg has at the moment a bit lacking logic for sizes attributes.
 * This fixes some issues where big images appear low-res.
 *
 * @see https://github.com/WordPress/gutenberg/issues/6131
 *
 * @param string $html the rendered markup
 * @param array  $args the options
 *
 * @return string $html
 */
add_filter('render_block', function ($html, $args) {

  if ($args['blockName'] === 'core/image' && isset($args['attrs']['align'])) {

    if ($args['attrs']['align'] === 'full') {

      $html = str_replace('<img ', '<img sizes="100vw" ', $html);

    } elseif ($args['attrs']['align'] === 'wide') {

      $base_width = (isset($GLOBALS['content_width'])) ? absint($GLOBALS['content_width']) : 800;
      $wide_width = absint(1.5 * $base_width);
      $html = str_replace('<img ', '<img sizes="(min-width: ' . $wide_width . 'px) ' . $wide_width . 'px, 100vw" ', $html);

    }

  }
  return $html;

}, 10, 2);
