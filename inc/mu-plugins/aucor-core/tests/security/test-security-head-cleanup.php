<?php
/**
 * Class SecurityHeadCleanupTest
 *
 * @package Aucor_Core
 */

class SecurityHeadCleanupTest extends WP_UnitTestCase {

  private $security;

  public function setUp() {
    parent::setUp();
    $this->security = new Aucor_Core_Security;
  }

  public function tearDown() {
    unset($this->security);
    parent::tearDown();
  }

  // test security sub feature

  public function test_security_head_cleanup() {
    $class = $this->security->get_sub_features()['aucor_core_security_head_cleanup'];
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

    // check filter hooks
    $this->assertSame(
      10, has_filter('the_generator', '__return_empty_string')
    );
    $this->assertSame(
      10, has_filter('xmlrpc_enabled', '__return_false')
    );
    $this->assertSame(
      10, has_filter('xmlrpc_enabled', '__return_false')
    );
    $this->assertSame(
      10, has_filter('wp_headers', array($class, 'aucor_core_remove_pingback_header'))
    );
    $this->assertSame(
      10, has_filter('xmlrpc_methods', array($class, 'aucor_core_remove_pingback_functionality'))
    );

    // AUCOR_CORE_REMOVE_PINGBACK_HEADER()

    // mock args
    // include a second item so array isn't empty on deletion
    $headers = array('X-Pingback' => '', 'Test'  => '');

    // check that the callback function has removed the correct value
    $this->assertArrayNotHasKey(
      'X-Pingback', $class->aucor_core_remove_pingback_header($headers)
    );

    // AUCOR_CORE_REMOVE_PINGBACK_FUNCTIONALITY()

    // mock args
    // include a second item so array isn't empty on deletion
    $methods = array('pingback.ping' => '', 'Test' => '');

    // check that the callback function has removed the correct value
    $this->assertArrayNotHasKey(
      'pingback.ping', $class->aucor_core_remove_pingback_functionality($methods)
    );

    // check that the hooks have been removed
    $this->assertFalse(
      has_action('wp_head', 'rsd_link')
    );
    $this->assertFalse(
      has_action('wp_head', 'feed_links')
    );
    $this->assertFalse(
      has_action('wp_head', 'index_rel_link')
    );
    $this->assertFalse(
      has_action('wp_head', 'wlwmanifest_link')
    );
    $this->assertFalse(
      has_action('wp_head', 'feed_links_extra')
    );
    $this->assertFalse(
      has_action('wp_head', 'start_post_rel_link')
    );
    $this->assertFalse(
      has_action('wp_head', 'parent_post_rel_link')
    );
    $this->assertFalse(
      has_action('wp_head', 'adjacent_posts_rel_link')
    );
    $this->assertFalse(
      has_action('wp_head', 'rest_output_link_wp_head')
    );
    $this->assertFalse(
      has_action('wp_head', 'wp_oembed_add_discovery_links')
    );
  }

}
