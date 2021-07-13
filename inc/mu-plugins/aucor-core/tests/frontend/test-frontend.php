<?php
/**
 * Class FrontEndTest
 *
 * @package Aucor_Core
 */

class FrontEndTest extends WP_UnitTestCase {

  private $front_end;

  public function setUp() {
    parent::setUp();
    $this->front_end = new Aucor_Core_Front_End;
  }

  public function tearDown() {
    unset($this->front_end);
    parent::tearDown();
  }

  // test front end feature

  public function test_front_end() {
    $class = $this->front_end;
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
