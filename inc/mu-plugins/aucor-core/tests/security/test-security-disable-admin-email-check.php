<?php
/**
 * Class SecurityDisableAdminEmailCheckTest
 *
 * @package Aucor_Core
 */

class SecurityDisableAdminEmailCheckTest extends WP_UnitTestCase {

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

  public function test_security_disable_admin_email_check() {
    $class = $this->security->get_sub_features()['aucor_core_security_disable_admin_email_check'];
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

    // check filter hook
    $this->assertSame(
      10, has_filter('admin_email_check_interval', '__return_false')
    );
  }

}
