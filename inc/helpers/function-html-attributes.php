<?php
/**
 * Function for image attributes
 *
 * @package aucor_starter
 */

/**
 * Build html attributes from key-value array
 *
 * @param array $attr key-value array of attribute names and values
 *
 * @return string attributes for html element
 */
function aucor_starter_build_attributes($attr) {

  $attr_str = '';
  foreach ($attr as $key => $value) {
    if (!empty($value) || is_numeric($value)) {
      $attr_str .= ' ' . esc_attr($key) . '="' . esc_attr($value) . '"';
    } else {
      $attr_str .= ' ' . esc_attr($key);
    }
  }
  return $attr_str;

}
