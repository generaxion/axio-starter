<?php
/**
 * Plugin Name:    Site Functionality
 * Description:    Required functions for site
 * Version:        1.0.0
 * Author:         Sunny Morgan
 * Author URI:     https://sunnymorgan.com
 * Text Domain:    X
 */

/** Inlcude all files who's directory names and file names do not start with _ */
foreach ( glob( __DIR__ . "/inc/*.php", GLOB_BRACE ) as $file ) {
	if ( strpos( $file, '/_' ) < 1 ) {
		require $file;
	}
}
