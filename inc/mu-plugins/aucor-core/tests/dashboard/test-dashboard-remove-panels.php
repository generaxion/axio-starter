<?php
/**
 * Class DashboardRemovePanelsTest
 *
 * @package Aucor_Core
 */

class DashboardRemovePanelsTest extends WP_UnitTestCase {

  private $dash;

  public function setUp() {
    parent::setUp();
    $this->dash = new Aucor_Core_Dashboard;
  }

  public function tearDown() {
    unset($this->dash);
    parent::tearDown();
  }

  // test dashboard sub feature

  public function test_dashboard_remove_panels() {
    $class = $this->dash->get_sub_features()['aucor_core_dashboard_remove_panels'];
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

    // check that the hooks have been removed
    $this->assertFalse(
      has_action('try_gutenberg_panel', 'wp_try_gutenberg_panel')
    );
    $this->assertFalse(
      has_action('welcome_panel', 'wp_welcome_panel')
    );
  }

}
