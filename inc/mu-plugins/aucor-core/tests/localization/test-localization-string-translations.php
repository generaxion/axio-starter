<?php
/**
 * Class LocalizationStringTranslationsTest
 *
 * @package Aucor_Core
 */

class LocalizationStringTranslationsTest extends WP_UnitTestCase {

  private $local;

  public function setUp() {
    parent::setUp();
    $this->local = new Aucor_Core_Localization;
  }

  public function tearDown() {
    unset($this->local);
    parent::tearDown();
  }

  // test localization sub feature

  public function test_localization_string_translations() {
    $class = $this->local->get_sub_features()['aucor_core_localization_string_translations'];
    // key
    $this->assertNotEmpty(
       $class->get_key()
    );
    // name
    $this->assertNotEmpty(
      $class->get_name()
    );
    // status
    $this->assertTrue(
      $class->is_active()
    );

    /**
     * Run
     */

    // check action hook
    $this->assertSame(
      10, has_action('init', array($class, 'aucor_core_string_registration'))
    );

    // AUCOR_CORE_STRING_REGISTRATION()

    // register "translations" with filter for the string translation functions to use
    add_filter('aucor_core_pll_register_strings', function($string_arr){
      $string_arr = array(
        'key 1' => 'value 1',
        'key 2' => 'value 2'
      );
      return $string_arr;
    });

    // run callback function
    $class->aucor_core_string_registration();

    global $pll_strings;
    $blog_info = get_bloginfo();

    // mock args
    $args = array(
      'key 1' => array(
        'value'      => 'value 1',
        'group_name' => $blog_info,
      ),
      'key 2' => array(
        'value'      => 'value 2',
        'group_name' => $blog_info,
      )
    );

    // check that the mock function produces the filtered values in correct format
    $this->assertSame(
      $args, $pll_strings
    );

    // FOR ALL THE STRING TRANSLATION FUNCTIONS

    // check that functions exist and that return correct value
    // for the _e() functions buffer the output
    // the ask__ and asv__ functions will throw an E_USER_WARNING on invalid inputs, so place them last and before running them, handle warning with custom function

    $this->assertTrue(
      function_exists('ask__')
    );
    $this->assertSame(
      'value 1', ask__('key 1')
    );
    $this->assertSame(
      'value 2', ask__('key 2', 'fi')
    );

    $this->assertTrue(
      function_exists('ask_e')
    );
    ob_start();
    ask_e('key 1');
    $output = ob_get_contents();
    ob_clean();
    $this->assertSame(
      'value 1', $output
    );

    $this->assertTrue(
      function_exists('asv__')
    );
    $this->assertSame(
      'value 1', asv__('value 1')
    );
    $this->assertSame(
      'value 2', asv__('value 2', 'fi')
    );

    $this->assertTrue(
      function_exists('asv_e')
    );
    asv_e('value 2');
    $output = ob_get_clean();
    $this->assertSame(
      'value 2', $output
    );

    // testing the invalid inputs that throw a warning

    set_error_handler('handle_debug_msg_user_warning', E_USER_WARNING);

    $this->assertSame(
      'key 3', ask__('key 3')
    );

    $this->assertSame(
      'value 3', asv__('value 3')
    );

    restore_error_handler();
  }

}

// custom error handler
function handle_debug_msg_user_warning($errno, $errstr) {
  $test = new WP_UnitTestCase;
  $test->assertSame(
    E_USER_WARNING, $errno
  );

  $test->assertContains(
    'Localization error - Missing string by', $errstr
  );
}

global $pll_strings;
$pll_strings = array();

// mock pll_register_string function
function pll_register_string($key, $value, $group_name) {
  global $pll_strings;
  $pll_strings[$key] = array('value' => $value, 'group_name' => $group_name);
}
