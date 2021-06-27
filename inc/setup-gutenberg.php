<?php
/**
 * Setup Gutenberg
 *
 * @package axio
 */

/**
 * Gutenberg setup
 */
add_action('after_setup_theme', function() {

  // support wide width
  add_theme_support('align-wide');

  // disable custom color picker
	//add_theme_support( 'disable-custom-colors' );

  // disable font size selection
	// add_theme_support('disable-custom-font-sizes');

  // disable default patterns
	// remove_theme_support('core-block-patterns');

  // disable gradients
	// add_theme_support('__experimental-editor-gradient-presets', []);
	// add_theme_support('__experimental-disable-custom-gradients', true);
	// add_theme_support('editor-gradient-presets', []);
	// add_theme_support('disable-custom-gradients', true);

  // remove font size options
	// add_theme_support('editor-font-sizes', []);

  /**
   * Remove colors and prefer using colors through custom styles
   * as long as Gutenberg won't support scoping specific colors
   * to specific blocks. As for now, the same color options will
   * show up to every block that supports colors and fot both
   * text color and background color options.
	 *
	 * Add from x_background_colors filter
   */
	add_theme_support( 'editor-color-palette', getColors() );
} );

function getColors() {

	$return = [];
	$colors = apply_filters( 'x_background_colors', [] );
	foreach ( $colors as $name => $arr ) {
		if ( isset( $arr['color'] ) && ! empty( $arr['color'] ) ) {
			$return[] = [
				'name'  => esc_attr( $arr['label'] ),
				'slug'  => esc_attr( $name ),
				'color' => esc_attr( $arr['color'] ),
			];
		}
	}

	return $return;
}


/**
 * Clean up content markup
 *
 * @param string $content the html markup of content
 *
 * @return string $content the html markup of content
 */
add_filter('the_content', function ($content) {

  $content = str_replace('<p></p>', '', $content);
	// $content = str_replace('<p class="wp-block-paragraph"></p>', '', $content);
  $content = str_replace('<p>&nbsp;</p>', '', $content);
  $content = str_replace('<li></li>', '', $content);
  return $content;

}, 100);
