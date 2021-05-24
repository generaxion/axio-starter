<?php
/**
 * Setup ACF (Advanced Custom Fields Pro plugin)
 *
 * @package axio
 */

/**
 * Save ACF fields as JSON at theme root /acf-json/
 */
add_filter('acf/settings/save_json', function() {

  return get_template_directory() . '/acf-json';

}, 100);

/**
 * Load ACF fields as JSON from theme root /acf-json/
 */
add_filter('acf/settings/load_json', function($paths) {

  $paths[] = get_template_directory() . '/acf-json';
  return $paths;

}, 100);
