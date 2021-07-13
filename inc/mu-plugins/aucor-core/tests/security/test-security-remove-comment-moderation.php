<?php
/**
 * Class SecurityRemoveCommentModerationTest
 *
 * @package Aucor_Core
 */

class SecurityRemoveCommentModerationTest extends WP_UnitTestCase {

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

  public function test_security_remove_comment_moderation() {
    $class = $this->security->get_sub_features()['aucor_core_security_remove_comment_moderation'];
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
      11, has_filter('comment_moderation_recipients', array($class, 'aucor_core_comment_moderation_post_author_only'))
    );

    // AUCOR_CORE_COMMENT_MODERATION_POST_AUTHOR_ONLY()

    // mock user, post, comments, args
    $user = $this->factory->user->create(array('role' => 'subscriber', 'user_email' => 'user@user.user'));
    $post = $this->factory->post->create(array('post_author' => $user));
    $comment = $this->factory->comment->create(array('comment_post_ID' => $post));
    $emails = array('admin@admin.admin');

    // check that the callback function returns correct value
    $this->assertSame(
      array('admin@admin.admin'), $class->aucor_core_comment_moderation_post_author_only($emails, $comment)
    );

    // increase user capabilities
    get_userdata($user)->set_role('editor');

    // check that the callback function returns correct value
    $this->assertSame(
      array('user@user.user'), $class->aucor_core_comment_moderation_post_author_only($emails, $comment)
    );
  }
}
