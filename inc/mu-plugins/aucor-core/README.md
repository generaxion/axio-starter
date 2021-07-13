# Aucor Core

[![Build Status](https://api.travis-ci.org/aucor/aucor-core.svg?branch=master)](https://travis-ci.org/aucor/aucor-core)

Core plugin for WordPress projects. The plugin contains the features and settings generally deemed to be the most commonly used in all projects. It is meant to be used together with [aucor-starter](https://github.com/aucor/aucor-starter) but functions on it's own as well. Use the site specific plugin to configure the specs of this plugin.

## How to install

1. Download this repository
1. Extract into /plugins/
1. Activate

(When released, will be available on WordPress.org)

## Contents

### Abstract Classes

Directory: root

The models the features are built on

### Features and subfeatures

Directory: `/features/`

Features (containing subfeatures) ranging from security settings to speed optimizations and dashboard cleanup.

- admin
    - gallery
    - image-links
    - login
    - admin menu cleanup
    - notifications
    - profile cleanup
    - remove customizer
- classic-editor
    - tinymce
- dashboard
    - cleanup
    - recent widget
    - remove panels
- front-end
    - excerpt
    - html fixes
- localization
    - polyfill
    - string translations
- plugins
    - acf
    - gravityforms
    - redirection
    - seo
    - yoast
- security
    - disable admin email check
    - disable file edit
    - disable unfiltered html
    - head cleanup
    - hide users
    - remove comment moderation
    - remove commenting
- speed
    - limit revisions
    - move jquery
    - remove emojis
    - remove metabox
- debug
    - style guide
    - wireframe

### Helper functions

Directory: root

Contains functions, like enhanced (internal) debugging, for all features/subfeatures to use

## Configuration (optional)

### "Active" subfeatures
- The *style guide* subfeature overrides the WP function `the_content()` with default markup for testing the most common tag styles, when the GET parameter '?ac-debug=styleguide' is found in the url. You can however replace this markup with a filter:
```
add_filter('aucor_core_custom_markup', function($content) {
  $content = 'custom markup';
  return $content;
});
```
- The *wireframe* subfeature adds outlines to all elements on page to help with visual debugging, when the GET parameter '?ac-debug=wireframe' is found in the url. It also appends '?ac-debug=wireframe' to the href value in all anchor tags on the page to keep the feature enabled during navigation.

### Disable feature/subfeature
By default all the features/subfeatures are on but you can disable the ones you don't want with filters. This need to be done in it’s own plugin however. This is because the hooks that the features latch onto are executed earlier than the theme setup, so filters in e.g. functions.php won’t have any effect. Here is a minimal code snippet you can use to disable features:

```
<?php
/**
 * Plugin Name: YOUR PLUGIN NAME
 */

// disable a feature in Aucor Core
add_filter('feature or subfeature key', '__return_false');
```

Put this snippet in a file called plugin.php, in a directory named [YOUR PLUGIN NAME], and place the directory under the /plugins/ directory with your other plugins.

Note that if you disable a feature, all underlying subfeatures will be disabled as well.

### What's the deal with "Aucor Core (Backwards Compatibility, Do Not Delete)"

The plugin's main file was plugin.php but it was renamed to aucor-core.php and there was period until it was noticed that this did cause major issues while updating the plugin as WP deactivates the plugin if it cannot find the plugin main file (that it saves in database when activating plugin). Main file is reverted back to plugin.php but there are probably still some sites that have been activated with aucor-core.php and this file provides backwards compatibility for those.

This is just for old sites that used the renamed plugin file and running it just includes the right plugin file and changes active plugin file to database and deactivates that file. Even if both files are running (via mu-plugins) no harm is done. You cannot delete this file as it will delete the whole plugin. This is temporary migration period (maybe 1-2 years) to get all the sites on board after it can be removed.
