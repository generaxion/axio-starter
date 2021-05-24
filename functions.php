<?php
/**
 * Include PHP files, nothing else.
 *
 * All the functions, hooks and setup should be on their own
 * filer organized at /inc/. The names of files should describe
 * what the file does as following:
 *
 * `register-`  configures new settings and assets
 * `setup-`     configures existing settings and assets
 * `function-`  adds functions to be used in templates
 *
 * @package axio
 */

/**
 * Configuration
 */
require_once 'inc/_conf/register-assets.php';
require_once 'inc/_conf/register-blocks.php';
require_once 'inc/_conf/register-colors.php';
require_once 'inc/_conf/register-image-sizes.php';
require_once 'inc/_conf/register-localization.php';

/**
 * Helpers
 */
require_once 'inc/helpers/function-dates.php';
require_once 'inc/helpers/function-hardcoded-ids.php';
require_once 'inc/helpers/function-last-edited.php';

/**
 * Hooks and setup
 */
require_once 'inc/class-component.php';
require_once 'inc/setup-acf.php';
require_once 'inc/setup-classic-editor.php';
require_once 'inc/setup-fallbacks.php';
require_once 'inc/setup-gutenberg.php';
require_once 'inc/setup-theme-support.php';


/**
 * Module PHP autoloader
 *
 * You can disable a module by starting directory with underscore
 */
foreach (glob(__DIR__ . '/modules/*', GLOB_ONLYDIR) as $dir) {
  if (!strstr($dir, '/modules/_') && file_exists($dir . '/_.json')) {
    $parts = json_decode(file_get_contents($dir . '/_.json'), true);
    if (isset($parts['php'], $parts['php']['inc'])) {
      foreach ($parts['php']['inc'] as $file) {
        if (!strstr($file, '..')) {
          require_once $dir . '/' . $file;
        }
      }
    }
  }
}

