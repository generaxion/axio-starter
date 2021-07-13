<?php
/**
 * Class SecurityDisableUnfilteredHtmlTest
 *
 * @package Aucor_Core
 */

class SecurityDisableUnfilteredHtmlTest extends WP_UnitTestCase {

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

  public function test_security_disable_unfiltered_html() {
    $class = $this->security->get_sub_features()['aucor_core_security_disable_unfiltered_html'];
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

    // check defined constant
    $this->assertTrue(
      DISALLOW_UNFILTERED_HTML
    );
  }

}
