<?php
/**
 * Class Localization_Polyfill
 */
class Aucor_Core_Localization_Polyfill extends Aucor_Core_Sub_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'aucor_core_localization_polyfill');

    // var: name
    $this->set('name', 'Preserve functionality without Polylang plugin');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Run feature
   */
  public function run() {

  }

}

/**
 * This structure of not having the polyfills in the class is so that the functions
 * might be used outside the class (i.e. the theme) without having to declare an instance
 * of the class first. The instance created below is to still maintain the option of diabling
 * the polyfills, if that need ever rises for some reason.
 */

/**
 * Get site locale
 *
 * @return string locale 2 character language code
 */
function aucor_core_get_site_locale() {
  $locale = get_locale();
  if (strlen($locale) >= 2) {
    return substr($locale, 0, 2);
  }

  // invalid locale
  return '';

}

$instance = new Aucor_Core_Localization_Polyfill;

/**
 * Fallback Polylang (preserve functionality without the plugin)
 */
if ($instance->is_active()) :
  if (!function_exists('pll__')) {
    function pll__($s) {
      return $s;
    }
  }
  if (!function_exists('pll_e')) {
    function pll_e($s) {
      echo $s;
    }
  }
  if (!function_exists('pll_esc_html__')) {
    function pll_esc_html__($s) {
      return esc_html($s);
    }
  }
  if (!function_exists('pll_esc_html_e')) {
    function pll_esc_html_e($s) {
      echo esc_html($s);
    }
  }
  if (!function_exists('pll_esc_attr__')) {
    function pll_esc_attr__($s) {
      return esc_attr($s);
    }
  }
  if (!function_exists('pll_esc_attr_e')) {
    function pll_esc_attr_e($s) {
      echo esc_attr($s);
    }
  }
  if (!function_exists('pll_current_language')) {
    function pll_current_language() {
      return aucor_core_get_site_locale();
    }
  }
  if (!function_exists('pll_default_language')) {
    function pll_default_language() {
      return aucor_core_get_site_locale();
    }
  }
  if (!function_exists('pll_get_post_language')) {
    function pll_get_post_language($id) {
      return aucor_core_get_site_locale();
    }
  }
  if (!function_exists('pll_get_post')) {
    function pll_get_post($post_id, $slug = '') {
      return $post_id;
    }
  }
  if (!function_exists('pll_get_term')) {
    function pll_get_term($term_id, $slug = '') {
      return $term_id;
    }
  }
  if (!function_exists('pll_translate_string')) {
    function pll_translate_string($str, $lang = '') {
      return $str;
    }
  }
  if (!function_exists('pll_home_url')) {
    function pll_home_url($slug = '') {
      return get_home_url();
    }
  }
endif;

unset($instance);
