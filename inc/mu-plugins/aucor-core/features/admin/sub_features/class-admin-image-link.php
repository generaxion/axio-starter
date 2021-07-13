<?php
/**
 * Class Admin_Image_Link
 */
class Aucor_Core_Admin_Image_Link extends Aucor_Core_Sub_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'aucor_core_admin_image_link');

    // var: name
    $this->set('name', 'Force default setting for image link to "none" (option is autoloaded so this makes no extra db queries)');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Run feature
   */
  public function run() {
    add_action('admin_init', array($this, 'aucor_core_default_image_link_to_none'), 10);
  }

  /**
   * Force default setting for image link to "none" (option is autoloaded so this makes no extra db queries)
   */
  public static function aucor_core_default_image_link_to_none() {
    if (get_option('image_default_link_type') !== 'none') {
      update_option('image_default_link_type', 'none');
    }
  }

}
