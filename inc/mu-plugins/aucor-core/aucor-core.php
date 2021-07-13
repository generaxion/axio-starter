<?php
/**
 * Plugin Name:    Aucor Core (Backwards Compatibility, Do Not Delete)
 * Description:    Auto-migrates old plugin naming to new – do not activate or delete
 * Version:        1.1.4
 * Author:         Aucor Oy
 * Author URI:     https://www.aucor.fi
 * Text Domain:    aucor-core
 */

/**
 * Main file used to be plugin.php but it was renamed
 * to this file and that was a mistake as WP saves
 * plugin file path to DB and causes errors on updating.
 *
 * To fix this mess, we'll need to keep this auto-migration
 * for some sites that started using this plugin during the
 * unlucky renaming phase to autofix it and remove it maybe
 * for version 2.0.0.
 */

// include all plguin functionality
require_once 'plugin.php';

/**
 * Auto-migrate active plugin data in DB to stop
 * using "aucor-core.php" and prefer "plugin.php"
 */

function aucor_core_migrate_active_plugin($active_plugins) {

  $active_plugins_changed = false;
  if (is_array($active_plugins) && !empty($active_plugins)) {
    foreach ($active_plugins as $i => $name) {
      if ($name == 'aucor-core/aucor-core.php') {
        $active_plugins[$i] = 'aucor-core/plugin.php';
        $active_plugins_changed = true;
      }
    }
    // remove duplicate plugin activations
    if ($active_plugins_changed) {
      $active_plugins = array_unique($active_plugins);
    }
  }
  return $active_plugins;

}

$single_active_plugins = get_option('active_plugins');
$single_clean_active_plugins = aucor_core_migrate_active_plugin($single_active_plugins);
if ($single_active_plugins !== $single_clean_active_plugins) {
  update_option('active_plugins', $single_clean_active_plugins);
}

if (is_multisite()) {
  $network_active_plugins = get_site_option('active_plugins');
  $network_clean_active_plugins = aucor_core_migrate_active_plugin($network_active_plugins);
  if ($network_active_plugins !== $network_clean_active_plugins) {
    update_site_option('active_plugins', $network_clean_active_plugins);
  }
}


