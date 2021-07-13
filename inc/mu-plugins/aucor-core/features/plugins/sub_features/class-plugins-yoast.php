<?php
/**
 * Class Plugins_Yoast
 */
class Aucor_Core_Plugins_Yoast extends Aucor_Core_Sub_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'aucor_core_plugins_yoast');

    // var: name
    $this->set('name', 'Settings for the Yoast plugin');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Run feature
   */
  public function run() {
    add_action('admin_init', array($this, 'aucor_core_remove_wpseo_notifications'));
    add_filter('wpseo_metabox_prio', array($this, 'aucor_core_seo_metabox_prio'));
    add_filter('the_seo_framework_metabox_priority', array($this, 'aucor_core_seo_metabox_prio'));
    add_filter( 'wpseo_opengraph_image_size', array($this, 'aucor_core_filter_wpseo_opengraph_image_size'), 5, 1);
    add_filter( 'wpseo_twitter_image_size', array($this, 'aucor_core_filter_wpseo_opengraph_image_size'), 5, 1);
  }

  /**
   * Remove Yoast notifications
   */
  public static function aucor_core_remove_wpseo_notifications() {
    if (class_exists('Yoast_Notification_Center')) {
      remove_action('admin_notices', array(Yoast_Notification_Center::get(), 'display_notifications'));
      remove_action('all_admin_notices', array(Yoast_Notification_Center::get(), 'display_notifications'));
    }
  }

  /**
   * Lower Yoast/SEO Framework metabox priority
   *
   * @return string metabox priority
   */
  public static function aucor_core_seo_metabox_prio() {
    return 'low';
  }

  /**
   * Default og:image size (mainly to prevent huge default images)
   *
   * @return string image size
   */
   public static function aucor_core_filter_wpseo_opengraph_image_size($original) {
    return 'large';
  }

}
