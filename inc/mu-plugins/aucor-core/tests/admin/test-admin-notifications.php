<?php
/**
 * Class AdminNotificationsTest
 *
 * @package Aucor_Core
 */

class AdminNotificationsTest extends WP_UnitTestCase {

  private $admin;

  public function setUp() {
    parent::setUp();
    $this->admin = new Aucor_Core_Admin;
  }

  public function tearDown() {
    unset($this->admin);
    parent::tearDown();
  }

  // test admin sub feature

  public function test_admin_notifications() {
    $class = $this->admin->get_sub_features()['aucor_core_admin_notifications'];
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
      1, has_action('admin_head', array($class, 'aucor_core_remove_update_nags_for_non_admins'))
    );

    // AUCOR_CORE_REMOVE_UPDATE_NAGS_FOR_NON_ADMINS()

     // create an admin user and set it as the current user
    $user_admin = $this->factory->user->create(array('role' => 'administrator'));
    wp_set_current_user($user_admin);

    // run the callback function
    $class->aucor_core_remove_update_nags_for_non_admins();

    // check that the callback is present by comparing to the callbacks priority
    $this->assertEquals(
      3, has_action('admin_notices', 'update_nag')
    );

    // create a user with insufficient capabilities and set it as the current user
    $user_sub = $this->factory->user->create(array('role' => 'subscriber'));
    wp_set_current_user($user_sub);

    // run the callback function
    $class->aucor_core_remove_update_nags_for_non_admins();

    // check that the callback has been removed
    $this->assertFalse(
      has_action('admin_notices', 'update_nag')
    );
  }

}
