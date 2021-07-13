<?php
/**
 * Class SecurityHideUsersTest
 *
 * @package Aucor_Core
 */

class SecurityHideUsersTest extends WP_UnitTestCase {

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

  public function test_security_hide_users() {
    $class = $this->security->get_sub_features()['aucor_core_security_hide_users'];
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
      100, has_filter('the_author', array($class, 'aucor_core_rename_authors'))
    );
    $this->assertSame(
      100, has_filter('the_modified_author', array($class, 'aucor_core_rename_authors'))
    );
    $this->assertSame(
      100, has_filter('get_the_author_link', array($class, 'aucor_core_author_link_to_front_page'))
    );
    $this->assertSame(
      1000, has_filter('rest_endpoints', array($class,'aucor_core_disable_user_endpoints'))
    );

    // AUCOR_CORE_RENAME_AUTHORS()

    // mock args
    $name = 'Test';

    // check that the callback function returns the correct value
    $this->assertSame(
      get_bloginfo('name'), $class->aucor_core_rename_authors($name)
    );

    // set current screen to admin screen
    set_current_screen('index.php');

    // check that the callback function returns the correct value
    $this->assertSame(
      'Test', $class->aucor_core_rename_authors($name)
    );

    // AUCOR_CORE_AUTHOR_LINK_TO_FRONT_PAGE()

    // mock args
    $url = 'Test';

    // check that the callback function returns the correct value
    $this->assertSame(
      get_site_url(), $class->aucor_core_author_link_to_front_page($url)
    );

    // AUCOR_CORE_DISABLE_USER_ENDPOINTS()

    // mock args
    // include a second item so that the array isn't empty when the first item is removed
    // a "random" item also makes it possible to cover the path when !is_set('/wp/v2/users') instead of using the second looked for key
    $endpoints = array('/wp/v2/users' => '', 'Test' => '');

    // create a user and log them in
    $user = $this->factory->user->create();
    wp_set_current_user($user);
    wp_signon();

    // check that the callback function returns the correct value
    $this->assertArrayHasKey(
      '/wp/v2/users', $class->aucor_core_disable_user_endpoints($endpoints)
    );

    // log user out
    wp_logout();
    wp_set_current_user(0);

    // check that the callback function returns the correct value
    $this->assertArrayNotHasKey(
      '/wp/v2/users', $class->aucor_core_disable_user_endpoints($endpoints)
    );

    $endpoints['/wp/v2/users/(?P<id>[\d]+)'] = '';

    // check that the callback function returns the correct value
    $this->assertArrayNotHasKey(
      '/wp/v2/users', $class->aucor_core_disable_user_endpoints($endpoints)
    );
  }

}
