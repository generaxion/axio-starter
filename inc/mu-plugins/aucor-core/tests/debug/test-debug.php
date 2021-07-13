<?php
/**
 * Class DebugTest
 *
 * @package Aucor_Core
 */

class DebugTest extends WP_UnitTestCase {

  private $debug;

  public function setUp() {
    parent::setUp();
    $this->debug = new Aucor_Core_Debug;
  }

  public function tearDown() {
    unset($this->debug);
    parent::tearDown();
  }

  // test debug feature

  public function test_debug() {
    $class = $this->debug;
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

    // sub feature init
    $this->assertNotEmpty(
      $class->get_sub_features()
    );
  }

}
