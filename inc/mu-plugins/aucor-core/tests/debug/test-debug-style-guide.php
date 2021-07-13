<?php
/**
 * Class DebugStyleGuideTest
 *
 * @package Aucor_Core
 */

class DebugStyleGuideTest extends WP_UnitTestCase {

  private $debug;

  public function setUp() {
    parent::setUp();
    $this->debug = new Aucor_Core_Debug;
  }

  public function tearDown() {
    unset($this->debug);
    parent::tearDown();
  }

  // test debug sub feature

  public function test_debug_style_guide() {
    $class = $this->debug->get_sub_features()['aucor_core_debug_style_guide'];
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

    // check filter hook
    $this->assertSame(
      10, has_filter('the_content', array($class, 'aucor_core_style_guide_markup'))
    );

    // AUCOR_CORE_STYLE_GUIDE_MARKUP()

    // run callback function
    $content = $class->aucor_core_style_guide_markup('');

    // check that return value is empty
    $this->assertEmpty(
      $content
    );

    // set global $_GET variable
    $_GET['ac-debug'] = 'styleguide';

    // run callback function
    $content = $class->aucor_core_style_guide_markup('');

    // check that return value is not empty
    $this->assertNotEmpty(
      $content
    );

    // add filter to override content
    add_filter('aucor_core_custom_markup', function($arg) {
      $arg = 'Test markup';
      return $arg;
    });

    // run callback function
    $content = $class->aucor_core_style_guide_markup('');

    // check that returned value equals set content
    $this->assertSame(
      'Test markup', $content
    );
  }

}

