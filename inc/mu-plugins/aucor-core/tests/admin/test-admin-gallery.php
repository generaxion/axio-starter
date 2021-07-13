<?php
/**
 * Class AdminGalleryTest
 *
 * @package Aucor_Core
 */

class AdminGalleryTest extends WP_UnitTestCase {

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

	public function test_admin_gallery() {
    $class = $this->admin->get_sub_features()['aucor_core_admin_gallery'];
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
      10, has_filter('media_view_settings', array($class, 'aucor_core_gallery_defaults'))
    );

    // AUCOR_CORE_GALLERY_DEFAULTS()

    // mock correct args
    $args = array(
      'galleryDefaults' => array(
        'link'    => 'file',
        'size'    => 'medium',
        'columns' => '2',
      )
    );
    // check that the callback function returns those args
    $this->assertEquals(
      $args, $class->aucor_core_gallery_defaults(array())
    );
  }

}
