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
 * Components
 */
require_once 'inc/components/component.php';
require_once 'inc/components/hero.php';
require_once 'inc/components/image.php';
require_once 'inc/components/menu-primary.php';
require_once 'inc/components/menu-social.php';
require_once 'inc/components/menu-sub-pages.php';
require_once 'inc/components/menu-toggle.php';
require_once 'inc/components/menu-additional.php';
require_once 'inc/components/posts-nav-numeric.php';
require_once 'inc/components/search-form.php';
require_once 'inc/components/share-buttons.php';
require_once 'inc/components/svg.php';
require_once 'inc/components/teaser.php';
require_once 'inc/components/list-terms.php';
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
require_once 'inc/hooks-menu.php';
require_once 'inc/setup-theme-support.php';
