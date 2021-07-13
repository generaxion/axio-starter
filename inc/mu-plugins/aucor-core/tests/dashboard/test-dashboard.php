<?php
/**
 * Class DashboardTest
 *
 * @package Aucor_Core
 */

class DashboardTest extends WP_UnitTestCase {

  private $dash;

  public function setUp() {
    parent::setUp();
    $this->dash = new Aucor_Core_Dashboard;
  }

  public function tearDown() {
    unset($this->dash);
    parent::tearDown();
  }

  // test dashboard feature

  public function test_dashboard() {
    $class = $this->dash;
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
