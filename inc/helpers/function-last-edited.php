<?php
/**
 * Cache hooks and functions
 *
 * @package aucor_starter
 */

/**
 * Get last-edited timestamp
 *
 * @global array $aucor_starter_timestamps cached timestamp values
 *
 * @param string $asset ID of asset type
 *
 * @return int UNIX timestamp
 */
function aucor_starter_last_edited($asset = 'css') {

  global $aucor_starter_timestamps;

  // save timestamps to cache in global variable for this request
  if (empty($aucor_starter_timestamps)) {

    $filepath = get_template_directory() . '/assets/last-edited.json';

    if (file_exists($filepath)) {
      $json = file_get_contents($filepath);
      $aucor_starter_timestamps = json_decode($json, true);
    }

  }

  // use cached value from global variable
  if (isset($aucor_starter_timestamps[$asset])) {
    return absint($aucor_starter_timestamps[$asset]);
  }

  return 0;

}
