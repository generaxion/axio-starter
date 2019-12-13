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
require_once 'components/component.php';
require_once 'components/hero.php';
require_once 'components/image.php';
require_once 'components/menu-primary.php';
require_once 'components/menu-social.php';
require_once 'components/menu-sub-pages.php';
require_once 'components/menu-toggle.php';
require_once 'components/menu-upper.php';
require_once 'components/posts-nav-numeric.php';
require_once 'components/search-form.php';
require_once 'components/share-buttons.php';
require_once 'components/svg.php';
require_once 'components/teaser.php';
require_once 'components/list-terms.php';
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
require_once 'inc/setup-menu-hooks.php';
require_once 'inc/setup-theme-support.php';
