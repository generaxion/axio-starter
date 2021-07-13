<?php
/**
 * Class LocalizationTest
 *
 * @package Aucor_Core
 */

class LocalizationTest extends WP_UnitTestCase {

  private $local;

  public function setUp() {
    parent::setUp();
    $this->local = new Aucor_Core_Localization;
  }

  public function tearDown() {
    unset($this->local);
    parent::tearDown();
  }

  // test localization feature

  public function test_localization() {
    $class = $this->local;
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
