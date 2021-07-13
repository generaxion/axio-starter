<?php
/**
 * Class Dashboard_Cleanup
 */
class Aucor_Core_Dashboard_Cleanup extends Aucor_Core_Sub_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'aucor_core_dashboard_cleanup');

    // var: name
    $this->set('name', 'Removes unnecessary parts from the dashboard');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Run feature
   */
  public function run() {
    add_action('wp_dashboard_setup', array($this, 'aucor_core_admin_dashboard'), 99);
  }

  /**
   * Clean up dashboard
   */
  public static function aucor_core_admin_dashboard() {
    remove_meta_box('dashboard_right_now',       'dashboard', 'normal');
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
    remove_meta_box('dashboard_incoming_links',  'dashboard', 'normal');
    remove_meta_box('dashboard_activity',        'dashboard', 'normal');
    remove_meta_box('dashboard_plugins',         'dashboard', 'normal');
    remove_meta_box('wpseo-dashboard-overview',  'dashboard', 'normal');
    remove_meta_box('dashboard_quick_press',     'dashboard', 'side');
    remove_meta_box('dashboard_recent_drafts',   'dashboard', 'side');
    remove_meta_box('dashboard_primary',         'dashboard', 'side');
    remove_meta_box('dashboard_secondary',       'dashboard', 'side');
  }

}
