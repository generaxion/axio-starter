<?php
/**
 * Cache hooks and functions
 *
 * @package axio
 */

/**
 * Get last-edited timestamp
 *
 * @global array $x_timestamps cached timestamp values
 *
 * @param string $asset ID of asset type
 *
 * @return int UNIX timestamp
 */
function x_last_edited($asset = 'css') {

  global $x_timestamps;

  // save timestamps to cache in global variable for this request
  if (empty($x_timestamps)) {

    $filepath = get_template_directory() . '/assets/last-edited.json';

    if (file_exists($filepath)) {
      $json = file_get_contents($filepath);
      $x_timestamps = json_decode($json, true);
    }

  }

  // use cached value from global variable
  if (isset($x_timestamps[$asset])) {
    return absint($x_timestamps[$asset]);
  }

  return 0;

}
