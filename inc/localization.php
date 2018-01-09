<?php
/**
 * Localization
 */

/**
 * Theme strings
 *
 * [0]: Unique id for string (context)
 * [1]: Default string
 *
 * @return array strings
 */

function aucor_starter_strings() {

  return array(

    // Menu
    'Menu: Button label'                => 'Menu',
    'Menu: Primary Menu'                => 'Päävalikko',
    'Menu: Social Menu'                 => 'Sosiaalisen median kanavat',

    // 404
    '404: Page not found'               => 'Hakemaasi sivua ei löytynyt',
    '404: Page not found description'   => 'Sivu on saatettu poistaa tai siirtää eri osoitteeseen. Käytä alla olevaa hakua löytääksesi etsimäsi.',

    // Search
    'Search: Title'                      => 'Haku: ',
    'Search: Nothing found'              => 'Ei hakutuloksia',
    'Search: Nothing found description'  => 'Hakutuloksia ei löytynyt. Kokeile eri hakusanoja.',

    // Accessibility
    'Accessibility: Skip to content'     => 'Siirry sisältöön',

    // Navigation
    'Navigation: Previous'               => 'Edellinen',
    'Navigation: Next'                   => 'Seuraava',

    // Social
    'Social share: Title'                => 'Jaa sosiaalisessa mediassa',
    'Social share: Facebook'             => 'Facebook',
    'Social share: Twitter'              => 'Twitter',
    'Social share: LinkedIn'             => 'LinkedIn',

    // Taxonomies
    'Taxonomies: Keywords'               => 'Avainsanat',
    'Taxonomies: Categories'             => 'Kategoriat',

  );
}

/**
 * String translations
 */

if(function_exists('pll_register_string')) {
  $strings = aucor_starter_strings();
  foreach ($strings as $key => $value) {
    pll_register_string($key, $value, 'Aucor Starter');
  }
}

/**
 * Get localized string by key
 *
 * @example ask__('Social share: Title')
 *
 * @param string $key unique identifier of string
 * @param string $lang 2 character language code (defaults to current language)
 *
 * @return string translated value or key if not registered string
 */

function ask__($key, $lang = null) {

  $strings = aucor_starter_strings();
  if(isset($strings[$key])) {
    if($lang === null) {
      return pll__($strings[$key]);
    } else {
      return pll_translate_string($strings[$key], $lang);
    }
  }

  // debug missing strings
  if(WP_DEBUG === true) {

    // init warning to get source
    $e = new Exception('Localization error - Missing string by key {' . $key . '}');

    // find file and line for problem
    $trace_line ='';
    foreach ($e->getTrace() as $trace) {
      if(in_array($trace['function'], array('ask__', 'ask_e'))) {
        $trace_line = ' in ' . $trace['file'] . ':' . $trace['line'];
      }
    }

    // compose error message
    $error_msg = $e->getMessage() . $trace_line . ' ==> add it to /inc/localization.php';

    // trigger errors
    trigger_error($error_msg , E_USER_WARNING);
    error_log($error_msg);

  }

  return $key;
}

/**
 * Echo localized string by key
 *
 * @param string $key unique identifier of string
 * @param string $lang 2 character language code (defaults to current language)
 */

function ask_e($key, $lang = null) {
  echo ask__($key, $lang);
}

/**
 * Get localized string by value
 *
 * @example asv__('Social share: Title')
 *
 * @param string $key unique identifier of string
 * @param string $lang 2 character language code (defaults to current language)
 *
 * @return string translated value or key if not registered string
 */

function asv__($value, $lang = null) {

  // debug missing strings
  if(WP_DEBUG === true) {
    $strings = aucor_starter_strings();
    if(array_search($value, $strings) === false) {

      // init warning to get source
      $e = new Exception('Localization error - Missing string by value {' . $value . '}');

      // find file and line for problem
      $trace_line ='';
      foreach ($e->getTrace() as $trace) {
        if(in_array($trace['function'], array('asv__', 'asv_e'))) {
          $trace_line = ' in ' . $trace['file'] . ':' . $trace['line'];
        }
      }

      // compose error message
      $error_msg = $e->getMessage() . $trace_line . ' ==> add it to /inc/localization.php';

      // trigger errors
      trigger_error($error_msg , E_USER_WARNING);
      error_log($error_msg);

    }
  }

  if($lang === null) {
    return pll__($value);
  } else {
    return pll_translate_string($value, $lang);
  }

}

/**
 * Echo localized string by value
 *
 * @param string $key unique identifier of string
 * @param string $lang 2 character language code (defaults to current language)
 */

function asv_e($value, $lang = null) {
  echo asv__($value, $lang);
}

/**
 * Fallback Polylang (preserve functionality without the plugin)
 */

if(!function_exists('pll__')) :
  function pll__($s) {
    return $s;
  }
  function pll_e($s) {
    echo $s;
  }
	function pll_esc_html_e($s) {
		esc_html_e($s);
	}
	function pll_esc_html__($s) {
		return esc_html__($s);
	}
	function pll_esc_attr_e($s) {
		esc_attr_e($s);
	}
	function pll_esc_attr__($s) {
		return esc_attr__($s);
	}
  function pll_current_language() {
    return 'fi';
  }
  function pll_get_post_language($id) {
    return 'fi';
  }
  function pll_get_post($post_id, $slug = '') {
    return $post_id;
  }
  function pll_get_term($term_id, $slug = '') {
    return $term_id;
  }
  function pll_translate_string($str, $lang = '') {
    return $str;
  }
  function pll_home_url($slug = '') {
    return get_home_url();
  }
endif;
