<?php
/**
 * Class ClassicEditorTest
 *
 * @package Aucor_Core
 */

class ClassicEditorTest extends WP_UnitTestCase {

  private $ce;

  public function setUp() {
    parent::setUp();
    $this->ce = new Aucor_Core_Classic_Editor;
  }

  public function tearDown() {
    unset($this->ce);
    parent::tearDown();
  }

  // test CE feature

  public function test_ce() {
    $class = $this->ce;
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
