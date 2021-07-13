<?php
/**
 * Class DebugWireframeTest
 *
 * @package Aucor_Core
 */

class DebugWireframeTest extends WP_UnitTestCase {

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

  public function test_debug_wireframe() {
    $class = $this->debug->get_sub_features()['aucor_core_debug_wireframe'];
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
      10, has_action('wp_head', array($class, 'aucor_core_wireframe'))
    );

    // AUCOR_CORE_WIREFRAME()

    // buffer output
    ob_start();

    // run callback function
    $class->aucor_core_wireframe();
    $output = ob_get_contents();
    ob_clean();

    // check that the return value is empty
    $this->assertEmpty(
      $output
    );

    // set the global $_GET variable
    $_GET['ac-debug'] = 'wireframe';

    // run callback function
    $class->aucor_core_wireframe();
    $output = ob_get_clean();

    // check the return value for keywords
    $this->assertContains(
      'outline: 1px solid !important;', $output
    );
    $this->assertContains(
      "links[i].href += '?ac-debug=wireframe';", $output
    );
  }

}

