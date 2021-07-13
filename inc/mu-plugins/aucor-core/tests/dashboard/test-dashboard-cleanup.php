<?php
/**
 * Class DashboardCleanupTest
 *
 * @package Aucor_Core
 */

class DashboardCleanupTest extends WP_UnitTestCase {

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

  public function test_dashboard_cleanup() {
    $class = $this->dash->get_sub_features()['aucor_core_dashboard_cleanup'];
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
      99, has_action('wp_dashboard_setup', array($class, 'aucor_core_admin_dashboard'))
    );

    // AUCOR_CORE_ADMIN_DASHBOARD()

    global $wp_meta_boxes;

    // mock metaboxes
    $args = array(
      array('dashboard_right_now', 'normal'),
      array('dashboard_recent_comments', 'normal'),
      array('dashboard_incoming_links', 'normal'),
      array('dashboard_activity', 'normal'),
      array('dashboard_plugins', 'normal'),
      array('wpseo-dashboard-overview', 'normal'),
      array('dashboard_quick_press', 'side'),
      array('dashboard_recent_drafts', 'side'),
      array('dashboard_primary', 'side'),
      array('dashboard_secondary', 'side')
    );

    foreach ($args as $arg) {
      add_meta_box(
          $arg[0],
          'Test',
          'test_callback',
          'dashboard',
          $arg[1]
      );
    }

    // check that the boxes are present
    $this->assertNotEmpty(
      $wp_meta_boxes
    );

    // run callback function
    $class->aucor_core_admin_dashboard();

    // check that the boxes' callbacks have been removed (which means they won't appear)
    // nested for loops are not ideal, but with such a limited amount of inputs it's still manageable

    // main context
    foreach ($wp_meta_boxes['dashboard']['normal'] as $priority => $list) {
      foreach ($list as $key => $value) {
        $this->assertEmpty(
          $value
        );
      }
    }

    // side context
    foreach ($wp_meta_boxes['dashboard']['side'] as $priority => $list) {
      foreach ($list as $key => $value) {
        $this->assertEmpty(
          $value
        );
      }
    }
  }

}
