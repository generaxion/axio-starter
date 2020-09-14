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
 * @package aucor_starter
 */

/**
 * Configuration
 */
require_once 'inc/_conf/register-assets.php';
require_once 'inc/_conf/register-blocks.php';
require_once 'inc/_conf/register-image-sizes.php';
require_once 'inc/_conf/register-localization.php';

/**
 * Components
 */
require_once 'inc/components/component.php';
require_once 'inc/components/image.php';
require_once 'inc/components/posts-nav-numeric.php';
require_once 'inc/components/svg.php';
/**
 * Helpers
 */
require_once 'inc/helpers/function-dates.php';
require_once 'inc/helpers/function-hardcoded-ids.php';
require_once 'inc/helpers/function-last-edited.php';

/**
 * Hooks and setup
 */
require_once 'inc/setup-classic-editor.php';
require_once 'inc/setup-fallbacks.php';
require_once 'inc/setup-gutenberg.php';
require_once 'inc/setup-theme-support.php';


/**
 * Drop-in PHP autoloader
 *
 * You can disable a drop-in by starting directory with underscore
 */
foreach (glob(__DIR__ . '/drop-ins/*', GLOB_ONLYDIR) as $dir) {
  if (!strstr($dir, '/drop-ins/_') && file_exists($dir . '/_.json')) {
    $parts = json_decode(file_get_contents($dir . '/_.json'), true);
    if (isset($parts['php']) && isset($parts['php']['inc'])) {
      foreach ($parts['php']['inc'] as $file) {
        if (!strstr($file, '..')) {
          require_once $dir . '/' . $file;
        }
      }
    }
  }
}

