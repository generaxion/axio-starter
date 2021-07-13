<?php
/**
 * Class Admin_Profile_Cleanup
 */
class Aucor_Core_Admin_Profile_Cleanup extends Aucor_Core_Sub_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'aucor_core_admin_profile_cleanup');

    // var: name
    $this->set('name', 'Remove admin color scheme picker and profile contact methods');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Run feature
   */
  public function run() {
    remove_all_actions('admin_color_scheme_picker');
    add_filter( 'user_contactmethods', array($this, 'aucor_core_remove_contact_methods'), 10, 1 );
  }

  /**
   * Remove profile contact methods
   *
   * @param array $contact available contact methods
   *
   * @return array available contact methods
   */
  public static function aucor_core_remove_contact_methods($contact) {
    unset($contact['aim']);
    unset($contact['jabber']);
    unset($contact['yim']);
    unset($contact['googleplus']);
    unset($contact['twitter']);
    unset($contact['facebook']);

    return $contact;
  }

}
