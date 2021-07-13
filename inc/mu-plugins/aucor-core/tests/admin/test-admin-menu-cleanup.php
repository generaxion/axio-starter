<?php
/**
 * Class AdminMenuCleanupTest
 *
 * @package Aucor_Core
 */

class AdminMenuCleanupTest extends WP_UnitTestCase {

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

  public function test_admin_menu_cleanup() {
    $class = $this->admin->get_sub_features()['aucor_core_admin_menu_cleanup'];
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
      9999, has_action('admin_menu', array($class, 'aucor_core_cleanup_admin_menu'))
    );

    // AUCOR_CORE_CLEANUP_ADMIN_MENU()

    global $menu, $submenu;

    // create an admin user and set it as the current user
    $user_admin = $this->factory->user->create(array('role' => 'administrator'));
    wp_set_current_user($user_admin);

    // mock menu and submenu pages
    add_menu_page('Appearance', 'Appearance', 'switch_themes', 'themes.php');
    add_submenu_page('themes.php', 'Themes', 'Themes', 'switch_themes', 'themes.php');
    add_submenu_page('themes.php', 'Customize', 'Customize', 'customize', 'customize.php');

    // run the callback function
    $class->aucor_core_cleanup_admin_menu();

    // check that the subpages are present
    $this->assertTrue(
      in_array('Themes', $submenu['themes.php'][0])
    );

    $this->assertTrue(
      in_array('Customize', $submenu['themes.php'][1])
    );

    // create a user with insufficient capabilities and set it as the current user
    $user_sub = $this->factory->user->create(array('role' => 'subscriber'));
    wp_set_current_user($user_sub);

    // run the callback function
    $class->aucor_core_cleanup_admin_menu();

    // check that the subpages have been removed
    $this->assertSame(
      array(), $submenu['themes.php']
    );
  }

}
