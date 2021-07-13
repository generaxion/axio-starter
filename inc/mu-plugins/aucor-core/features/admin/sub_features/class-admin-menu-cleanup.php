<?php
/**
 * Class Admin_Menu_Cleanup
 */
class Aucor_Core_Admin_Menu_Cleanup extends Aucor_Core_Sub_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'aucor_core_admin_menu_cleanup');

    // var: name
    $this->set('name', 'Clean up admin menus for non-admins');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Run feature
   */
  public function run() {
    add_action('admin_menu', array($this, 'aucor_core_cleanup_admin_menu'), 9999);
  }

  /**
   * Clean up admin menus for non-admins
   *
   * The Customizer is removed differently bacause the slug that would be used
   * as an argument is dynamically declared based on what page you currently are on
   * --> /wp-admin/menu.php:190
   */
  public static function aucor_core_cleanup_admin_menu() {
    if (!current_user_can('administrator')) {
      remove_submenu_page('themes.php', 'themes.php');

      global $submenu;
      if (isset($submenu['themes.php'])) {
        foreach ($submenu['themes.php'] as $index => $menu_item) {
          if (in_array('Customize', $menu_item)) {
            unset($submenu['themes.php'][$index]);
          }
        }
      }
    }
  }

}
