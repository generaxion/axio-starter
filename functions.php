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
require_once 'inc/_conf/register-menus.php';

/**
 * Editor
 */
require_once 'inc/editor/setup-classic-editor.php';
require_once 'inc/editor/setup-gutenberg.php';
require_once 'inc/editor/setup-theme-support.php';

/**
 * Forms
 */
require_once 'inc/forms/function-search-form.php';

/**
 * Helpers
 */
require_once 'inc/helpers/function-dates.php';
require_once 'inc/helpers/function-entry-footer.php';
require_once 'inc/helpers/function-hardcoded-ids.php';
require_once 'inc/helpers/function-html-attributes.php';
require_once 'inc/helpers/function-last-edited.php';
require_once 'inc/helpers/function-titles.php';
require_once 'inc/helpers/setup-fallbacks.php';

/**
 * Media
 */
require_once 'inc/media/function-image.php';
require_once 'inc/media/function-svg.php';

/**
 * Navigation
 */
require_once 'inc/navigation/function-menu-toggle.php';
require_once 'inc/navigation/function-numeric-posts-nav.php';
require_once 'inc/navigation/function-share-buttons.php';
require_once 'inc/navigation/function-sub-pages-nav.php';
require_once 'inc/navigation/setup-menu-hooks.php';


