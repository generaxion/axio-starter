<?php
/**
 * Class SpeedMoveJqueryTest
 *
 * @package Aucor_Core
 */

class SpeedMoveJqueryTest extends WP_UnitTestCase {

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

  public function test_speed_move_jquery() {
    $class = $this->speed->get_sub_features()['aucor_core_speed_move_jquery'];
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
      10, has_action('wp_default_scripts', array($class, 'aucor_core_move_jquery_into_footer'))
    );

    // AUCOR_CORE_MOVE_JQUERY_INTO_FOOTER()

    // mock args
    $scripts = new WP_Scripts();
    $scripts->add('jquery', false, array('jquery-core', 'jquery-migrate'));
    $scripts->add('jquery-core', '/jquery.js', array());
    $scripts->add('jquery-migrate', '/jquery-migrate.js', array());

    // run callback function
    $class->aucor_core_move_jquery_into_footer($scripts);

    // check that data has not beed added to the dependencies (group was not changed from default 0)
    $this->assertFalse(
      $scripts->get_data('jquery', 'group')
    );
    $this->assertFalse(
      $scripts->get_data('jquery-core', 'group')
    );
    $this->assertFalse(
      $scripts->get_data('jquery-migrate', 'group')
    );

    // move out of admin view (we set it previously in test-security as index.php)
    unset($GLOBALS['current_screen']);

    // WP 5.5 removed jquery-migrate, bit will be adding it back in 5.6, so perform a version check on some of the asserts
    global $wp_version;
    $minor = substr($wp_version, 0, 3); // for e.g. version 5.5.1 returns 5.5

    // run callback function
    $class->aucor_core_move_jquery_into_footer($scripts);

    // check output
    if ($minor !== '5.5') {
      $this->expectOutputRegex('/^(?:<script[^>]+><\\/script>\\n){2}$/');
    } else {
      $this->expectOutputRegex('/^(?:<script[^>]+><\\/script>\\n){1}$/');
    }

    // check that nothing gets put in the done array
    $scripts->do_items('jquery', 0);
    $this->assertNotContains('jquery', $scripts->done);
    $this->assertNotContains('jquery-core', $scripts->done);
    $this->assertNotContains('jquery-migrate', $scripts->done);

    // check that the items get ut in the done array (the group has changed)
    $scripts->do_items('jquery', 1);
    $this->assertContains('jquery', $scripts->done);
    $this->assertContains('jquery-core', $scripts->done);
    if ($minor !== '5.5') {
      $this->assertContains('jquery-migrate', $scripts->done);
    }
  }

}
