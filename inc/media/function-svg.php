<?php
/**
 * Function for fetching SVGs
 *
 * @package aucor_starter
 */

/**
 * Get SVG
 *
 * Return x:linked markup of SVG from the big SVG sprite.
 *
 * @example aucor_starter_get_svg('plus')
 * @example aucor_starter_get_svg('plus', ['class' => 'icon-more'])
 *
 * @param string $icon the filename without .svg
 * @param array  $args list of options
 *
 * @return string SVG markup
 */
function aucor_starter_get_svg($icon, $args = array()) {

  // @TODO: disable wrapper by default

  // set defaults
  $defaults = array(
    'wrap'        => true, // wrap in <span>
    'class'       => '',
    'title'       => '',
    'desc'        => '',
    'aria_hidden' => true, // hide from screen readers
  );

  // set SVG variable
  $svg = '';

  // parse args
  $args = wp_parse_args($args, $defaults);

  // add extra space before classes
  $args['class'] = $args['class'] ? ' ' . $args['class'] : '';

  // set aria hidden
  $aria_hidden = ($args['aria_hidden'] === true) ? ' aria-hidden="true"' : '';

  // set ARIA
  $aria_labelledby = ($args['title'] && $args['desc']) ? ' aria-labelledby="title desc"' : '';

  // start wrap
  if ($args['wrap'] === true) {
    $svg .= '<span class="icon-wrap">';
  }

  // begin SVG markup
  $svg .= '<svg class="icon icon-' . esc_html($icon) . esc_html($args['class']) . '"' . $aria_hidden . $aria_labelledby . ' role="img">';

  // if there is a title, display it
  if ($args['title']) {
    $svg .= '<title>' . esc_html($args['title']) . '</title>';
  }

  // if there is a description, display it
  if ($args['desc']) {
    $svg .= '<desc>' . esc_html($args['desc']) . '</desc>';
  }

  // include icon
  $svg .= '<use xlink:href="' . get_template_directory_uri() . '/dist/sprite/sprite.svg?ver=' . aucor_starter_last_edited('svg') . '#icon-' . esc_html($icon) . '"></use>';

  // end SVG markup
  $svg .= '</svg>';

  // end wrap
  if ($args['wrap'] === true) {
    $svg .= '</span>';
  }

  return $svg;

}
