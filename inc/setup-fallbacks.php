<?php
/**
 * Fallbacks
 *
 * @package axio
 */

/**
 * Fallbacks for the localization functions (axio-core)
 */
if (!function_exists('ask__')) {
  function ask__($s, $lang = null) {
    return $s;
  }
}
if (!function_exists('ask_e')) {
  function ask_e($s, $lang = null) {
    echo $s;
  }
}
if (!function_exists('asv__')) {
  function asv__($s, $lang = null) {
    return $s;
  }
}
if (!function_exists('asv_e')) {
  function asv_e($s, $lang = null) {
    echo $s;
  }
}
