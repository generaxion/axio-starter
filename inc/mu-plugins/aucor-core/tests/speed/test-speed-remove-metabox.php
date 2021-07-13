<?php
/**
 * Class SpeedRemoveMetaboxTest
 *
 * @package Aucor_Core
 */

class SpeedRemoveMetaboxTest extends WP_UnitTestCase {

  private $speed;

  public function setUp() {
    parent::setUp();
    $this->speed = new Aucor_Core_Speed;
  }

  public function tearDown() {
    unset($this->speed);
    parent::tearDown();
  }

  // test speed sub feature

  public function test_speed_remove_metabox() {
    $class = $this->speed->get_sub_features()['aucor_core_speed_remove_metabox'];
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
      10, has_action('add_meta_boxes', array($class, 'aucor_core_remove_post_meta_metabox'))
    );

    // AUCOR_CORE_REMOVE_POST_META_METABOX()

    global $wp_meta_boxes;

    // mock metabox
    add_meta_box(
      'postcustom',
      'Test',
      'test_callback',
      'post',
      'normal',
      'core'
    );

    // check that the box is present
    $this->assertArrayHasKey(
      'postcustom', $wp_meta_boxes['post']['normal']['core']
    );

    // run callback function
    $class->aucor_core_remove_post_meta_metabox();

    // check that the meta box has been removed
    $this->assertEmpty(
      $wp_meta_boxes['post']['normal']['core']['postcustom']
    );
  }

}
