<?php
/**
 * Plugin Name:    Aucor Core
 * Description:    Core functionality to Aucor Starter powered sites
 * Version:        1.1.4
 * Author:         Aucor Oy
 * Author URI:     https://www.aucor.fi
 * Text Domain:    aucor-core
 */

// constant: plugin's root directory (used in some sub_features)
define('AUCOR_CORE_DIR', plugins_url('', __FILE__));

class Aucor_Core {

  // var: active instance of class
  private static $instance;

  // var: list of features in the plugin - array
  public $features;

  public function __construct() {

    /* Features
    ----------------------------------------------- */

    require_once 'abstract-feature.php';
    require_once 'features/admin/class-admin.php';
    require_once 'features/classic-editor/class-classic-editor.php';
    require_once 'features/dashboard/class-dashboard.php';
    require_once 'features/debug/class-debug.php';
    require_once 'features/front-end/class-front-end.php';
    require_once 'features/localization/class-localization.php';
    require_once 'features/plugins/class-plugins.php';
    require_once 'features/security/class-security.php';
    require_once 'features/speed/class-speed.php';

    /* Sub features
    ----------------------------------------------- */

    require_once 'abstract-sub-feature.php';

    // admin
    require_once 'features/admin/sub_features/class-admin-gallery.php';
    require_once 'features/admin/sub_features/class-admin-image-link.php';
    require_once 'features/admin/sub_features/class-admin-login.php';
    require_once 'features/admin/sub_features/class-admin-menu-cleanup.php';
    require_once 'features/admin/sub_features/class-admin-notifications.php';
    require_once 'features/admin/sub_features/class-admin-profile-cleanup.php';
    require_once 'features/admin/sub_features/class-admin-remove-customizer.php';

    // classic-editor
    require_once 'features/classic-editor/sub_features/class-editor-tinymce.php';

    // dashboard
    require_once 'features/dashboard/sub_features/class-dashboard-cleanup.php';
    require_once 'features/dashboard/sub_features/class-dashboard-recent-widget.php';
    require_once 'features/dashboard/sub_features/class-dashboard-remove-panels.php';

    // debug
    require_once 'features/debug/sub_features/class-debug-style-guide.php';
    require_once 'features/debug/sub_features/class-debug-wireframe.php';

    // front-end
    require_once 'features/front-end/sub_features/class-front-end-excerpt.php';
    require_once 'features/front-end/sub_features/class-front-end-html-fixes.php';

    // localization
    require_once 'features/localization/sub_features/class-localization-polyfill.php';
    require_once 'features/localization/sub_features/class-localization-string-translations.php';

    // plugins
    require_once 'features/plugins/sub_features/class-plugins-acf.php';
    require_once 'features/plugins/sub_features/class-plugins-gravityforms.php';
    require_once 'features/plugins/sub_features/class-plugins-redirection.php';
    require_once 'features/plugins/sub_features/class-plugins-seo.php';
    require_once 'features/plugins/sub_features/class-plugins-yoast.php';

    // security
    require_once 'features/security/sub_features/class-security-disable-admin-email-check.php';
    require_once 'features/security/sub_features/class-security-disable-file-edit.php';
    require_once 'features/security/sub_features/class-security-disable-unfiltered-html.php';
    require_once 'features/security/sub_features/class-security-head-cleanup.php';
    require_once 'features/security/sub_features/class-security-hide-users.php';
    require_once 'features/security/sub_features/class-security-remove-comment-moderation.php';
    require_once 'features/security/sub_features/class-security-remove-commenting.php';

    // speed
    require_once 'features/speed/sub_features/class-speed-limit-revisions.php';
    require_once 'features/speed/sub_features/class-speed-move-jquery.php';
    require_once 'features/speed/sub_features/class-speed-remove-emojis.php';
    require_once 'features/speed/sub_features/class-speed-remove-metabox.php';

    /* Helper functions
    ----------------------------------------------- */

    require_once 'helpers.php';

    /* Initialize features
    ----------------------------------------------- */

    $features = array(
      'aucor_core_admin'          => new Aucor_Core_Admin,
      'aucor_core_classic_editor' => new Aucor_Core_Classic_Editor,
      'aucor_core_dashboard'      => new Aucor_Core_Dashboard,
      'aucor_core_front_end'      => new Aucor_Core_Front_End,
      'aucor_core_localization'   => new Aucor_Core_Localization,
      'aucor_core_plugins'        => new Aucor_Core_Plugins,
      'aucor_core_security'       => new Aucor_Core_Security,
      'aucor_core_speed'          => new Aucor_Core_Speed,
      'aucor_core_debug'          => new Aucor_Core_Debug,
    );

  }

  /**
   * Get the features
   */
  public function get_features() {
    return $this->features;
  }

  /**
   * Get instance
   */
  public static function get_instance() {

    if (!isset(self::$instance)) {
      self::$instance = new Aucor_Core();
    }
    return self::$instance;

  }

}

// init
add_action('plugins_loaded', function() {
  $aucor_core = Aucor_Core::get_instance();
});

// load translations
add_action('plugins_loaded', function () {
  load_plugin_textdomain( 'aucor-core', false, basename( dirname( __FILE__ ) ) . '/languages/' );
});
