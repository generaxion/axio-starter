<?php
/**
 * Class FrontEndExcerptTest
 *
 * @package Aucor_Core
 */

class FrontEndExcerptTest extends WP_UnitTestCase {

  private $front_end;

  public function setUp() {
    parent::setUp();
    $this->front_end = new Aucor_Core_Front_End;
  }

  public function tearDown() {
    unset($this->front_end);
    parent::tearDown();
  }

  // test front end sub feature

  public function test_front_end_excerpt() {
    $class = $this->front_end->get_sub_features()['aucor_core_front_end_excerpt'];
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
      10, has_filter('excerpt_more', array($class, 'aucor_core_excerpt_more'))
    );
    $this->assertSame(
      10, has_filter('excerpt_length', array($class, 'aucor_core_excerpt_length'))
    );

    // AUCOR_CORE_EXCERPT_MORE()

     // mock args
    $excerpt = 'Test string';

    // check that the return value is correct
    $this->assertSame(
      '...', $class->aucor_core_excerpt_more($excerpt)
    );

    // AUCOR_CORE_EXCERPT_LENGTH()

    // mock args
    $length = 100;

    // check that the return value is correct
    $this->assertEquals(
     20, $class->aucor_core_excerpt_length($length)
    );
  }

}
