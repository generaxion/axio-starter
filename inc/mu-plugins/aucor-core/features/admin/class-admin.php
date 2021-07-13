<?php
/**
 * Class Admin
 */
class Aucor_Core_Admin extends Aucor_Core_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'aucor_core_admin');

    // var: name
    $this->set('name', 'Admin');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Initialize and add the sub_features to the $sub_features array
   */
  public function sub_features_init() {

    // var: sub_features
    $this->set('sub_features', array(
      'aucor_core_admin_gallery'           => new Aucor_Core_Admin_Gallery,
      'aucor_core_admin_image_link'        => new Aucor_Core_Admin_Image_Link,
      'aucor_core_admin_login'             => new Aucor_Core_Admin_Login,
      'aucor_core_admin_menu_cleanup'      => new Aucor_Core_Admin_Menu_Cleanup,
      'aucor_core_admin_notifications'     => new Aucor_Core_Admin_Notifications,
      'aucor_core_admin_profile_cleanup'   => new Aucor_Core_Admin_Profile_Cleanup,
      'aucor_core_admin_remove_customizer' => new Aucor_Core_Admin_Remove_Customizer,
    ));

  }

}
