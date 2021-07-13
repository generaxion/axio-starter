<?php
/**
 * Class SecurityRemoveCommentingTest
 *
 * @package Aucor_Core
 */

class SecurityRemoveCommentingTest extends WP_UnitTestCase {

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

  public function test_security_remove_commenting() {
    $class = $this->security->get_sub_features()['aucor_core_security_remove_commenting'];
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

    // check action and filter hooks
    $this->assertSame(
      10, has_action('admin_init', array($class, 'aucor_core_disable_comments_post_types_support'))
    );
    $this->assertSame(
      10, has_action('admin_menu', array($class, 'aucor_core_disable_comments_admin_menu'))
    );
    $this->assertSame(
      10, has_action('admin_init', array($class, 'aucor_core_disable_comments_admin_menu_redirect'))
    );
    $this->assertSame(
      10, has_action('admin_init', array($class, 'aucor_core_disable_comments_dashboard'))
    );
    $this->assertSame(
      10, has_action('wp_before_admin_bar_render', array($class, 'aucor_core_admin_bar_render'))
    );
    $this->assertSame(
      10, has_filter('comments_array', array($class, 'aucor_core_disable_comments_hide_existing_comments'))
    );
    $this->assertSame(
      20, has_filter('comments_open', '__return_false')
    );
    $this->assertSame(
      20, has_filter('pings_open', '__return_false')
    );

    // AUCOR_CORE_DISABLE_COMMENTS_POST_TYPES_SUPPORT()

    // run callback function
    $class->aucor_core_disable_comments_post_types_support();

    $post_types = get_post_types();

    // check that support has been removed from post types
    foreach ($post_types as $post_type) {
      $this->assertFalse(
        post_type_supports($post_type, 'comments'), $post_type . ' supports comments'
      );
      $this->assertFalse(
        post_type_supports($post_type, 'trackbacks'), $post_type . ' supports trackbacks'
      );
    }

    // AUCOR_CORE_DISABLE_COMMENTS_ADMIN_MENU()

    global $menu;

    // mock menu pages
    add_menu_page('Comments', 'Comments', 'edit_posts', 'edit-comments.php');

    // run callback function
    $class->aucor_core_disable_comments_admin_menu();

    // check that the menu item has been removed
    foreach ($menu as $item) {
      $this->assertNotEquals(
        'edit-comments.php', $item[2], $item[0] . ' contains edit-comments.php'
      );
    }

    // AUCOR_CORE_DISABLE_COMMENTS_ADMIN_MENU_REDIRECT()

    // this function is only partially covered, as the other branch calls exit, which makes it untestable

    global $pagenow;
    $pagenow = 'index.php';

    $class->aucor_core_disable_comments_admin_menu_redirect();

    $this->assertSame(
      'index.php', $pagenow
    );

    // $pagenow = 'edit-comments.php';
    // $class->aucor_core_disable_comments_admin_menu_redirect();

    // AUCOR_CORE_DISABLE_COMMENTS_DASHBOARD()

    global $wp_meta_boxes;

    // mock metabox
    add_meta_box(
      'dashboard_recent_comments',
      'Test',
      'test_callback',
      'dashboard',
      'normal'
    );

    // check taht the metabox is present
    $this->assertNotEmpty(
      $wp_meta_boxes['dashboard']['normal']['default']['dashboard_recent_comments']
    );

    // run callback function
    $class->aucor_core_disable_comments_dashboard();

    // check that the correct item has been removed
    $this->assertEmpty(
      $wp_meta_boxes['dashboard']['normal']['default']['dashboard_recent_comments']
    );

    // AUCOR_CORE_ADMIN_BAR_RENDER()

    global $wp_admin_bar;

    // mock admin bar
    $wp_admin_bar = new WP_Admin_Bar;
    $wp_admin_bar->add_node(array(
        'id' => 'comments'
      )
    );
    // add extra item so the admin bar isn't empty when checking after removal
    $wp_admin_bar->add_node(array(
        'id' => 'test'
      )
    );

    // run callback function
    $class->aucor_core_admin_bar_render();

    // check that the correct value has been removed
    $this->assertArrayNotHasKey(
      'comments', $wp_admin_bar->get_nodes()
    );

    // AUCOR_CORE_DISABLE_COMMENTS_HIDE_EXISTING_COMMENTS()

    // mock comments
    $comment1 = $this->factory->comment->create();
    $comment2 = $this->factory->comment->create();
    $comments =  array($comment1, $comment2);

    // check that the callback function returns correct values
    $this->assertSame(
      array(), $class->aucor_core_disable_comments_hide_existing_comments($comments)
    );
  }

}
