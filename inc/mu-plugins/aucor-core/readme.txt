=== Aucor core ===
Contributors: Teemu Suoranta
Tags: wordpress, aucor, core
Requires at least: 4.7.3
Tested up to: 5.5.1
Requires PHP: 7.0
Stable tag: trunk
License: GPLv2+

Core plugin for WordPress projects.

== Description ==
The plugin contains the features and settings generally deemed to be the most commonly used in all projects. It is meant to be used together with [aucor-starter](https://github.com/aucor/aucor-starter) but functions on its own as well. Use the site specific plugin to configure the specs of this plugin.


== Contents ==

= Abstract Classes =

Directory: root

The models the features are built on

= Features and subfeatures =

Directory: `/features/`

Features (containing subfeatures) ranging from security settings to speed optimizations and dashboard cleanup.

admin:

* gallery
* image-links
* login
* admin menu cleanup
* notifications
* profile cleanup
* remove customizer

classic-editor:

* tinymce

dashboard:

* cleanup
* recent widget
* remove panels

front-end:

* excerpt
* html fixes

localization:

* polyfill
* string translations

plugins:

* acf
* gravityforms
* redirection
* seo
* yoast

security:

* disable admin email check
* disable file edit
* disable unfiltered html
* head cleanup
* hide users
* remove comment moderation
* remove commenting

speed:

* limit revisions
* move jquery
* remove emojis
* remove metabox

debug:

* style guide
* wireframe

= Helper functions =

Directory: root

Contains functions, like enhanced (internal) debugging, for all features/subfeatures to use

== Configuration (optional) ==

=  "Active" subfeatures =
* The *style guide* subfeature overrides the WP function `the_content()` with default markup for testing the most common tag styles, when the GET parameter '?ac-debug=styleguide' is found in the url. You can however replace this markup with a filter:

`add_filter('aucor_core_custom_markup', function($content) {
  $content = 'custom markup';
  return $content;
});`

* The *wireframe* subfeature adds outlines to all elements on page to help with visual debugging, when the GET parameter '?ac-debug=wireframe' is found in the url. It also appends '?ac-debug=wireframe' to the href value in all anchor tags on the page to keep the feature enabled during navigation.

= Disable feature/subfeature =
By default all the features/subfeatures are on, but you can disable the ones you don't want with filters. This need to be done in a separate plugin, however, because the hooks that the features latch onto are executed earlier than the theme setup, so filters in e.g. functions.php won't have any effect. Here is a minimal code snippet you can use to disable features:

`<?php
/**
 * Plugin Name: YOUR PLUGIN NAME
 */

// disable a feature in Aucor Core
add_filter('feature or subfeature key', '__return_false');`

Put this snippet in a file called plugin.php, in a directory named [YOUR PLUGIN NAME], and place the directory under the /plugins/ directory with your other plugins.

Note that if you disable a feature, all underlying subfeatures will be disabled as well.


== Installation ==
Download and activate. That's it.

== Changelog ==

= 1.1.4 =
Revert main file to "plugin.php" and add fallback to "aucor-core.php" for any sites activated during renamed version. There is duplicate plugin entry in plugins list with name "Aucor Core (Backwards Compatibility, Do Not Delete)". This is just for old sites that used the renamed plugin file and running it just includes the right plugin file and changes active plugin file to database and deactivates that file. Even if both files are running (via mu-plugins) no harm is done. You cannot delete this file as it will delete the whole plugin. This is temporary migration period (maybe 1-2 years) to get all the sites on board after it can be removed.

= 1.1.3 =
Fix issue with renaming plugin.php that caused fatal error on update.

= 1.1.1 =
Readme update, testing up to latest WP version.

= 1.1 =
Fixes to features along with more robust testing.

= 1.0 =
Initial release.
