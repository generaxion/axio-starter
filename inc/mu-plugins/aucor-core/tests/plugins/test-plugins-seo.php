<?php
/**
 * Class PluginsSeoTest
 *
 * @package Aucor_Core
 */

class PluginsSeoTest extends WP_UnitTestCase {

  private $plugins;

  public function setUp() {
    parent::setUp();
    $this->plugins = new Aucor_Core_Plugins;
  }

  public function tearDown() {
    unset($this->plugins);
    parent::tearDown();
  }

  // test plugins sub feature

  public function test_plugins_seo() {
    $class = $this->plugins->get_sub_features()['aucor_core_plugins_seo'];
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
      10, has_action('wp_before_admin_bar_render', array($class, 'aucor_core_yoast_admin_bar_render'))
    );

    // AUCOR_CORE_YOAST_ADMIN_BAR_RENDER()

    global $wp_admin_bar;

    // mock empty WP_Admin_Bar
    $wp_admin_bar = new WP_Admin_Bar;
    $wp_admin_bar->add_node(array(
        'id'    => 'wpseo-menu',
      )
    );

    // add extra item so the admin bar isn't empty when checking after removal
    $wp_admin_bar->add_node(array(
        'id'    => 'test',
      )
    );

    // run callback function
    $class->aucor_core_yoast_admin_bar_render();

    // check that the node has been removed
    $this->assertArrayNotHasKey(
      'wpseo-menu', $wp_admin_bar->get_nodes()
    );
  }

}
