<?php
/**
 * Class AdminRemoveCustomizerTest
 *
 * @package Aucor_Core
 */

class AdminRemoveCustomizerTest extends WP_UnitTestCase {

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

  public function test_admin_remove_customizer() {

    // needed to mock the admin bar
    require_once ABSPATH . WPINC . '/class-wp-admin-bar.php';

    $class = $this->admin->get_sub_features()['aucor_core_admin_remove_customizer'];
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
      999, has_action('admin_bar_menu', array($class, 'aucor_core_remove_customizer_admin_bar'))
    );

    // AUCOR_CORE_REMOVE_CUSTOMIZER_ADMIN_BAR()

    // mock admin bar
    $args = new WP_Admin_Bar;
    $args->add_node(array(
        'id' => 'customize'
      )
    );
    // add extra item so the admin bar isn't empty when checking after removal
    $args->add_node(array(
        'id' => 'test'
      )
    );

    // run callback function
    $class->aucor_core_remove_customizer_admin_bar($args);

    // check that the node has been removed
    $this->assertArrayNotHasKey(
      'customize', $args->get_nodes()
    );
  }

}
