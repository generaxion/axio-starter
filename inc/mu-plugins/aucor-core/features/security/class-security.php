<?php
/**
 * Class Security
 */
class Aucor_Core_Security extends Aucor_Core_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'aucor_core_security');

    // var: name
    $this->set('name', 'Security');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Initialize and add the sub_features to the $sub_features array
   */
  public function sub_features_init() {

    // var: sub_features
    $this->set('sub_features', array(
      'aucor_core_security_disable_admin_email_check' => new Aucor_Core_Security_Disable_Admin_Email_Check,
      'aucor_core_security_disable_file_edit'         => new Aucor_Core_Security_Disable_File_Edit,
      'aucor_core_security_disable_unfiltered_html'   => new Aucor_Core_Security_Disable_Unfiltered_Html,
      'aucor_core_security_head_cleanup'              => new Aucor_Core_Security_Head_Cleanup,
      'aucor_core_security_hide_users'                => new Aucor_Core_Security_Hide_Users,
      'aucor_core_security_remove_comment_moderation' => new Aucor_Core_Security_Remove_Comment_Moderation,
      'aucor_core_security_remove_commenting'         => new Aucor_Core_Security_Remove_Commenting,
    ));

  }

}
