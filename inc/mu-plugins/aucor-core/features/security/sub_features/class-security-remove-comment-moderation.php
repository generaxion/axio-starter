<?php
/**
 * Class Security_Remove_Comment_Moderation
 */
class Aucor_Core_Security_Remove_Comment_Moderation extends Aucor_Core_Sub_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'aucor_core_security_remove_comment_moderation');

    // var: name
    $this->set('name', 'Remove comment moderation emails from admin user, only send to post author');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Run feature
   */
  public function run() {
    add_filter('comment_moderation_recipients', array($this, 'aucor_core_comment_moderation_post_author_only'), 11, 2);
  }

  /**
   * Remove comment moderation emails from admin user, only send to post author
   *
   * @see https://wordpress.org/plugins/comment-moderation-e-mail-to-post-author/
   *
   * @param array $emails list of email addresses
   * @param int   $comment_id the ID of comment
   *
   * @return array list of email addresses
   */
  public static function aucor_core_comment_moderation_post_author_only($emails, $comment_id) {
    $comment = get_comment($comment_id);
    $post    = get_post($comment->comment_post_ID);
    $user    = get_userdata($post->post_author);

    // return only the post author if the author can modify comments
    if (user_can($user->ID, 'edit_comment', $comment_id) && !empty($user->user_email)) {
      return array($user->user_email);
    }
    return $emails;
  }

}
