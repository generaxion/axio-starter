# Axio Starter (previously Aucor Starter)

**🖥 For developer from developers:**

Superior Gutenberg WordPress starter theme with modern build tools by **[Generaxion](https://www.generaxion.com)**. 250+ hours of development over 6 years to make the greatest starting point for WordPress site.

**Demo:** **[axio.generax.io](https://axio.generax.io)**

**🔌 Required plugins:**

* **[Axio Core](https://wordpress.org/plugins/axio-core/)**: Core functionality that is clever to be centrally updated.
* **[Advanced Custom Fields Pro](https://www.advancedcustomfields.com/)**: Some custom blocks use ACF. You can do without, but should remove them.

**🏷 Buzz-words**:

Gutenberg, Gulp, Yarn, SVG, SASS, Browsersync, a11y, l18n, Advanced Custom Fields, Polylang, Schema.org, Native lazyload, BEM, Babel, Responsive images

![screenshot-axio-generaxion](https://user-images.githubusercontent.com/9577084/150126560-28b2502e-b1fa-4a33-9bb0-78e6e2b16e04.png)

## Table of contents

1. [Directory structure](#1-directory-structure)
2. [Setup](#2-setup)
    1. [New site setup](#21-new-site-setup)
    2. [Developer setup](#22-developer-setup)
    3. [Work session setup](#23-work-session-setup)
3. [Components](#3-components)
    1. [Base component](#31-base-component)
    2. [Using components](#32-using-components)
    3. [Creating new component](#33-creating-new-components)
    4. [Validating arguments](#34-validating-arguments)
4. [Modules](#4-modules)
    1. [Default modules](#41-default-modules)
    2. [Module loading](#42-module-loading)
    3. [Module structure](#43-module-structure)
    4. [Creating new modules](#44-creating-new-modules)
    5. [Installing new modules](#45-installing-new-modules)
    6. [Disabling or deleting modules](#46-disabling-or-deleting-modules)
    7. [Module caveats](#47-module-caveats)
5. [Assets](#5-assets)
    1. [Styles](#51-styles)
    2. [Scripts](#52-scripts)
    3. [SVG](#53-svg)
    4. [Images](#54-images)
    5. [Fonts](#55-fonts)
    6. [Favicon](#56-favicon)
6. [Includes](#6-includes)
    1. [Functions.php](#61-functionsphp)
    2. [\_conf](#62-_conf)
    3. [Helpers](#63-helpers)
7. [Localization](#7-localization)
    1. [Registering strings](#71-registering-strings)
    2. [Using strings](#72-using-strings)
    3. [Localizator](#73-localizator)
8. [Workflows](#8-workflows)
    1. [Setting up your code editor](#81-setting-up-your-code-editor)
    2. [Navigating the code](#82-navigating-the-code)
9. [Philosophy](#9-philosophy)
    1. [Gutenberg](#91-gutenberg)
    2. [Scope of starter](#92-level-of-detail)
    3. [Level of detail](#93-level-of-detail)
    4. [Open source](#94-open-source)

## 1. Directory structure

| **Directory**                   | **Contents**  |
|---|---|
| `/acf-json/`    | automatically saved JSON versions of site specific fields from Advanced Custom Fields |
| `/assets/`      | global JS, SASS, images, SVG and fonts |
| `/bin/`         | shell scripts for bulk tasks/automations  |
| `/dist/`        | has processed, combined and optimized assets ready to be included to theme |
| `/modules/`     | features that are packaged into modules like blocks, template parts, post-types|
| `/inc/`         | global php files that are not part of template structure/modules |

## 2. Setup

### 2.1 New site setup

Do these theme installation steps before modifying anything.

#### Download & Extract

1. Download this repository
2. Extract into /wp-content/themes/ and rename for project like `sitename`

#### Run setup

![Project setup with setup.sh](https://user-images.githubusercontent.com/9577084/119214675-40060680-bad1-11eb-9587-0f8d41f5c938.png)

Run setup wizard in theme root with bash `sh bin/setup.sh`

| **Field**                   | **Meaning**  | **Default**  |
|---|---|---|
| **Site name**               | Name in style.css | `Axio by Generaxion` |
| **Local development url**   | Browsersync's mirror URL. Stored at `/assets/manifest.js` | `https://axio-starter.local` |
| **Author name**             |  Author in style.css | `Generaxion` |
| **Author URL**              | Author URL in style.css | `https://www.generaxion.com` |

#### Run localizator (if needed)

Theme strings are by default in English but we do support Finnish and probably Swedish in near future. If you would like to initialize strings in these languages, do the following:

1. Run `bin/localizator.sh`
2. Input language code
3. Select to remove language packages after running

#### Install Axio Core

Some of the functionality of Axio by Generaxion require plugin Axio Core. The plugin is centrally updated so that sites using starter will be easier to maintain and there will be less duplicate code from project to project. Axio by Generaxion won't have fatal errors without it, but for example localization won't work without it.

Download Axio Core from [WordPress.org](https://wordpress.org/plugins/axio-core/) or [Github](https://github.com/generaxion/axio-core) and activate.

**Protip**: If you are using composer: `composer require wpackagist-plugin/axio-core` or WP-CLI: `wp plugin install axio-core`.

#### First 15 minutes of your new site

Here's optional next steps:

1. Go through the `/modules/` and remove any unneeded. Just throw them to trash.
2. Save logo at `/assets/images/logo.svg`
3. Setup colors and fonts at `/assets/styles/utils/_variables.scss`

### 2.2 Developer setup

Every developer does this before first time working with the project.

1. Open terminal and navigate to `/wp-content/themes/sitename`
2. Run `yarn install` (fetches all node packages for build tools).

**Protip**: If you don't have Gulp installed locally run `npm install --global gulp-cli`. If you are missing Yarn, [install Yarn](https://yarnpkg.com/en/docs/install).

### 2.3 Work session setup

Do this everythime you start to work with the theme.

1. Open terminal and navigate to `/wp-content/themes/sitename`
2. Run `gulp watch` to activate build process in background. You'll get development proxy at http://localhost:3000 where changes to code will be updated automatically to browser (no need to reload).
3. To quit press `ctrl` + `c`

**Protip**: You can also run just `gulp` to build all the resources or just some resources with `gulp styles` or `gulp scripts`. Want to start the watch task but not open the Browsersync in browser? Start watch with quiet mode `qulp watch -q`.

## 3. Components

Components are the first unique building blocks of this theme. They are an evolution of WordPress's `get_template_part()` function that aim to fix underlying issues of that function:

1. **Arguments**: Template parts had no legitimate way to pass arguments (until WP 5.5.0).
2. **Returning and echoing**: All components can be either echoed or HTML markup can be returned.
3. **Validation**: Template part concept won't encourage to validate arguments early and end up with highly nested if checks for the code. In components you can exit early and have separated backend and frontend functions to gather and sanitize data.
4. **Context free**: You can create components to be used in blocks, templates and inside other components. It's up to you how context aware/independent components you want to build.

### 3.1 Base component

Components get their power from abstract class Component that keeps in the structure and required functionality for each component. Every component inherits from this class. The component structure is loosely inspired by React component concept.

### 3.2 Using components

There are two basic ways to use component:

```
X_Teaser::render();
X_Teaser::get();
```

The render function prints out the HTML markup of the component and get will return it. You can pass arguments in an array like so:

```
X_Teaser::render(['id' => 123]);
X_Teaser::render([
  'id'          => 123
  'hide_image'  => true,
]);
```

All components can be interacted with the same way. It is up to the component to validate the given args and pick what to do with what argument.

### 3.3 Creating new components

```php
<?php
/**
 * Component: Componet's name
 *
 * @example
 * X_Components_Name::render([
 *   'title'        => 'Title',
 *   'description'  => 'Descriptive text'
 *   'image'        => 123
 * ]);
 */
class X_Components_Name extends X_Component {

  public static function frontend($data) {
    ?>
    <div <?php parent::render_attributes($data['attr']); ?>>

      <?php if (!empty($data['image'])) : ?>

        <div class="components-name__image">
          X_Image::render([
            'id'        => $data['image'],
            'size'      => 'large',
          ]);
        </div>

      <?php endif; ?>

      <h3 class="components-name__title">
        <?php echo $data['title'] ?>
      </h3>

      <p class="components-name__description">
        <?php echo $data['description'] ?>
      </p>

    </div>

    <?php
  }

  public static function backend($args = []) {

    $default = [

      // required
      'title'       => '',
      'description' => '',

      // optional
      'attr'        => [],
      'image'       => '',

    ];

    // overrides defaults with given args
    $args = wp_parse_args($args, $default);

    // validate arguments
    if (empty($args['title']) || empty($args['description'])) {
      return parent::error('Missing title or/and description');
    }

    // set html attributes
    $args['attr']['class'][] = 'components-name';

    // or make conditioning
    if (!empty($args['image'])) {
      $args['attr']['class'][] = 'components-name--has-image';
    }

    // $args should be so pre-chewed that frontend can just use the data with simple empty() checks or foreach() loops
    return $args;
  }

}
```

### 3.4 Validating arguments

As in example above the rendering of component starts by passing data to backend function in `$args` that passes it to frontend function and renames it to `$data` (just to mentally separate raw input from sanitized).

Here are your validation strategies:

1. **Return error in backend**: `return parent::error('What heppened');` and this error is displayed if WP_DEBUG is activated. In production without WP_DEBUG, nothing is returned.
2. **Set default values in backend**: You should set good `$default` values in start to handle most common cases where all non critical arguments are not passed.
3. **Sanitize HTML attributes in frontend**: For passing big amount of HTML attributes, add them to key => value array and pass to `parent::render_attributes($attributes)`.

## 4. Modules

Modules are the biggest separation to traditional WordPress themes that build on components introduced before. Modules package PHP, HTML, SASS, JS and images to "mini plugins" that operate inside the theme.

Modules tackle these big level goals:

  1. **Organization**: Traditional WordPress theme file structure scatters each feature's files into many locations and some of the logic is in shared files with other features. Modules separated the logic by the feature.
  2. **Remove bloat**: Make it as easy as possible to discard features from the starter to not carry any unneeded features just because removing them is cumbersome.
  3. **Encourage standardization**: Features could be pre-built or modules from previous projects could be used easily for new projects.
  4. **Scalability**: In big projects the codebase gets easily messy because the logic is scattered in so many places. With modules, adding a new module adds very little additional complexity to the whole project.

### 4.1 Default modules

This theme comes with selection of default modules that are listed here. Modules have their own readme files at `/modules/module-name/docs/README.md`.

A few modules are required or there are more changes needed than just deleting the module to remove it. You can of course replace them but they have some critical functions that need to be implemented.

| **Module**             | **Required**   |  **Function**  |
|------------------------|----------------|----------------|
| `/footer/`             | Yes            | Template part for footer |
| `/header/`             | Yes            | Template part for header with menus and logo |
| `/hero/`               | Yes            | Custom block version of hero |
| `/image/`              | Yes            | Component to show responsive images |
| `/svg/`                | Yes            | Component to display SVG sprite icons |
| `/teaser/`             | Yes            | Component to display teaser cards |
| `/background/`         | -              | Replacement for core/group block with background color, image or video options. |
| `/buttons/`            | -              | Replacement for core/buttons block with ACF block and component. |
| `/core-columns/`       | -              | Gutenberg columns block |
| `/core-embed/`         | -              | Gutenberg embed blocks |
| `/core-gallery/`       | -              | Gutenberg gallery block |
| `/core-heading/`       | -              | Gutenberg heading block |
| `/core-image/`         | -              | Gutenberg image block |
| `/core-list/`          | -              | Gutenberg list block |
| `/core-paragraph/`     | -              | Gutenberg paragraph block |
| `/core-quote/`         | -              | Gutenberg quote block |
| `/core-table/`         | -              | Gutenberg table block |
| `/file/`               | -              | Replacement for core/file block and component |
| `/gravity-forms/`      | -              | Base styles and settings for Gravity Forms + Gutenberg block |
| `/lightbox/`           | -              | Shows gallery/image links to media file as lightbox |
| `/list-terms/`         | -              | Component that shows post's terms of given taxonomy |
| `/media-text/`         | -              | Replacament for core/media-text block |
| `/menu-social/`        | -              | Menu for social media channels with icons |
| `/posts-nav-numeric/`  | -              | Shows numeric navigation for pagination |
| `/search-form/`        | -              | Search form component |
| `/share-buttons/`      | -              | Social share buttons component |
| `/spacer/`             | -              | Replacement for core/spacer block |

### 4.2 Module loading

Each module have in their root a manifest file called `_.json`. This file declares what files needs to be loaded for this module (PHP, JS, SASS).

For PHP files, theme's `functions.php` goes through all `_.json` files and requires files. For assets Gulp goes through all the assets and processes them just like files in `/assets/`.

#### Example: _.json

```json
{
  "meta": {
    "title": "Teaser",
    "version": "1.0.0"
  },
  "php": {
    "inc": [
      "setup.php",
      "component.php"
    ]
  },
  "css": {
    "main.css": [
      "assets/styles/teaser.scss"
    ],
    "admin.css": [],
    "editor-gutenberg.css": [
      "assets/styles/teaser.scss"
    ]
  },
  "js": {
    "main.js": [],
    "editor-gutenberg.js": []
  }
}
```

Notice that SASS and JS files are targetted to specific compiled files. All PHP files are just included so no need to categorize them.

All SVG sprite files in `/assets/sprite/` and images in `/assets/images/` are loaded automatically by Gulp.

All compiled assets go to the same `/dist/` as regular assets.

#### Example: Modifying WP template hierarchy

WordPress has well documented [template hierarchy](https://developer.wordpress.org/themes/basics/template-hierarchy/) where you can name PHP file in certain way and put it to the root or second level directory of theme and WP finds it and includes it when appropriate.

By default WordPress won't find template files inside modules, but you can easily serve them with a filter in module's `setup.php` like so:

```php
/**
 * Host archive template in module
 */
add_action('template_include', function ($template) {
  if (is_post_type_archive('projects')) {
    return dirname(__FILE__) . '/archive-projects.php';
  }
  return $template;
});
```

### 4.3 Module structure

There are no strict rules on how module should be structured but there are a few recommendations.

#### Repeative naming is good

PHP files are often named very minimally:
 * `setup.php` – hooks and base for feature
 * `component.php` – the component of feature
 * `block.php` – Gutenberg block template
 * `helpers.php` – public helper functions
 * `endpoint.php` – queryable API endpoint
 * `cpt-{name}.php` and `tax-{name}.php` – registering data types

If module includes for example multiple components, you do need to name them better but other than that the directory already "namespaces" the files so there is no need to repeat module name.

#### Avoid excessive subdirectories

Modules bring some extra directories to begin with so don't make the directory situation more complicated if not necessary.

#### Use mini `/assets/`

For assets it's recommended to use simplified `/assets/` structure to separate PHP files and asset files.

### 4.4 Creating new modules

You should create module each time there is a feature that can be packaged into one intact thing. Module can be simple component like button, compatibility with some plugin, everything that goes into some post type or certain changes to wp-admin. You have to consider and decide what makes sense.

1. Create new directory under `/modules/`
2. Add `_.json` (use other modules as example)
3. Add `setup.php` and other needed files

If you have `gulp watch` active while creating modules or modifying `_.json` files the process will stop and Gulp asks you to restart the watch. This is somewhat annoying but we haven't found a smart way to reload list of watched files during watch process.

### 4.5 Installing new modules

You can install modules from previous projects or external code libraries by just doing simple copy and paste of the module directory. You need to run gulp to update the assets.

Check the module's readme for any additional steps.

### 4.6 Disabling or deleting modules

There is built-in way to disable module that prevents including PHP files and assets (for assets you need to run Gulp before taking effect).

Simply add underscore to the directory name to disable it: `teaser => _teaser`.

For deleting a module you can just throw it to the trash and be done with it (for the default modules marked as not required).

### 4.7 Module caveats

Modules are not a perfect solution but pretty simple take on a complex problem. Here are a few issues that you should know.

#### Declaring dependencies

There is no programming way to declare module to depend on another module. You can use resources from other modules but it's up to you to document it.

#### No namespacing

At the moment we still use prefixing instead of namespacing with functions so you should be aware not to have conflicting naming across modules.

#### Repeating hooks and function calls

By modularisation there are some additional code that wouldn't be otherwise needed. For example declaring allowed blocks could be done in one hook call for all the blocks but with modules each module declares only its own blocks creating many hook calls.

This is a small price to pay for better organization and scalability.

#### ACF JSON is tricky

Optimally you would both save and edit Advanced Custom Fields fieldsets so that the JSON files would also be under the module. At the moment ACF doesn't allow this legitimately.

You can load JSON fields from multiple locations but only save them in one. So the modules that come with ACF fields have them loading from the module but if you edit them with ACF the new version is saved in theme's `/acf-json/` and loaded there leaving the old duplicate file in module.

The ultimate solution would be either to have ACF alter the JSON behaviour or have ACF PHP API become so good that you could mostly write fields in PHP.

## 5. Assets

### 5.1 Styles

Styles are written in SASS. Global styles are found in `/assets/styles`. There's four separate stylesheets that are compiled automatically to `dist/styles` and enqueued to frontend.

  * `main.scss` front-end styles of website
  * `admin.scss` back-end styles for admin views
  * `editor-classic.scss` back-end styles for old TinyMCE based editor
  * `editor-gutenberg.scss` back-end styles for new Gutenberg editor

#### Direcotry structure

| **Directory** | **File**                  |  **Contents**  |
|-------------------|-----------------------|----------------|
| `/utils/`         | *                     | variables and functions |
| `/utils/`         | `_env.scss`           | environment variables (sass variabled until browser support is better) |
| `/utils/`         | `_variables.scss`     | CSS3 variables |
| `/utils/`         | `_mixins.scss`        | SASS functions |
| `/base/`          | *                     | global styles |
| `/base/`          | `_normalize.scss`     | unify browser defaults |
| `/base/`          | `_typography.scss`    | text base styles |
| `/base/`          | `_blocks.scss`        | Gutenberg base styles |
| `/base/`          | `_media.scss`         | image, svg and iframe base styles |
| `/base/`          | `_forms.scss`         | forms base styles |
| `/base/`          | `_print.scss`         | print base styles |
| `/elements/`      | *                     | global elements |
| `/layout/`        | *                     | layouts and templates |
| `/layout/`        | `_layout.scss`        | global layout styles |
| `/layout/`        | `_404.scss`           | 404 template |
| `/layout/`        | `_front-page.scss`    | front page |
| `/layout/`        | `_index.scss`         | generic archive |
| `/layout/`        | `_page.scss`          | generic page template |
| `/layout/`        | `_search.scss`        | search template |
| `/layout/`        | `_single.scss`        | generic post and custom post template |
| `@node-modules`   | *                     | vendor packages |
| `@modules`        | *                     | module specific styling |

#### Styles workflow

  * When you begin working, start the gulp with `gulp watch`
  * You get Browsersync URL at `https://localhost:3000` (check yours in console). Here the styles will automatically reload when you save your changes.
  * If you make a syntax error, a console will send you a notification and tell where the error is. If Gulp stops running, start it again with `gulp watch`.
  * The Gulp updates `/assets/last-edited.json` timestamps for styles and WP assets use it. This means that cache busting is done automatically.
  * There's Autoprefixer that adds prefixes automatically. (If you have to support very old browsers, set browsers in gulpfile.js)
  * In browser developer tools shows what styles is located in which SASS partial file (SASS Maps)

#### Adding new global styles

  1. Make a new file like `/assets/styles/elements/_card.scss`
  2. Go edit `main.scss`
  3. Import the new file with `@import "elements/card";`

**Protip:** If those styles are needed in Gutenberg editor as well, include the file in `editor-gutenberg.scss` as well.

#### Adding new module styles

  1. Make an new file like `module-name/assets/styles/card.scss`
  2. Import utilities with `@import '../../../../assets/styles/utils.scss';`
  3. Include by editing module's `_.json`

#### Naming

Theme uses [BEM methodology](http://getbem.com/) to organize class names. Quick example:

```
.teaser        <-- normal element (Block)
.teaser__title <-- sub-element    (Element)
.teaser--big   <-- variant        (Modifier)
```

BEM in HTML:
```html
<div class="teaser">
  <h2 class="teaser__title">Lorem ipsum</h2>
</div>
```

BEM in SASS:
```scss
.teaser {
  &__title {
    font-size: 1.25rem;
  }
}
```

**Protip:** Use your own judgement on how deep you should go. There is no right or wrong way. For example `.entry__footer__categories__item__label` might be better as just `.categories__label`.

### 5.2 Scripts

Javascript can be written with modern ES6 syntax as Babel compiles it to work on even older browsers.

#### Directory structure

  * `/lib/` directory for small global scripts
      * `in-viewport.js` adds helper classes to element you can use for entrance animations
      * `blocks.js` frontend markup enhancements for Gutenberg content
  * `main.js` primary js file that is run in footer
  * `editor-gutenberg.js` modifies gutenberg editor
  * `@node-modules` vendor scripts
  * `@modules` module specific js

#### Default vendor libraries

* [External SVG polyfill: svgxuse](https://github.com/Keyamoon/svgxuse)
* [Responsive video embds: fitvids (jQuery-free)](https://www.npmjs.com/package/fitvids)
* [Accessible modals/mobile menu: a11y-dialog](https://github.com/edenspiekermann/a11y-dialog)

**Protip:** If you are using jQuery, take into account that Axio Core moves jQuery to the bottom of the document as a speed optimization. If it causes a problem for you, add a filter `add_filter('axio_core_speed_move_jquery', '__return_false');`.


#### Add new global script

Put file in `/assets/scripts/lib/hello-world.js`. Add script to main.js (or some other file) in `/assets/manifest.js`:

```js
"main.js": [
  "scripts/main.js"
],
```

**Combine scripts in one file:**
```js
"main.js": [
  "scripts/lib/hello-world.js",
  "scripts/main.js"
],
```

#### Add vendor script with yarn (node_modules)

First, go to [npmjs.com](https://www.npmjs.com/) and find if your library is avaialble. Add your library in `package.json` devDependencies. Run `yarn install` or `yarn upgrade` (also updates all packages).

Include the script in `/assets/manifest.js`.

Add project libraries in `dependencies` and Gulp libraries in `devDependencies`. Both will go to same `node_modules` but it's much easier to later figure out what goes where.

```js
"main.js": [
  "../node_modules/fitvids/dist/fitvids.js",
  "scripts/main.js"
],
```

**Protip**: Gulp uses [Babel](https://babeljs.io/) to compile ES6 and React syntax to be compatible to older browsers. In some cases this may mess up older scripts from node_modules. If you have problems with the script (weird errors in console), add it to babelIgnores at `manifest.js`.

### 5.3 SVG

#### SVG Sprite

Put all icons to `/assets/sprite/` and Gulp will combine and minify them into `/dist/sprite/sprite.svg`.

In PHP you can get these images with:

```php
<?php X_SVG::render([
  'name' => 'facebook'
]); ?>
```

Theme includes one big SVG sprite `/assets/images/icons.svg`. Add your own svg icons in `/assets/sprite/` and Gulp will add them to this sprite with id from filename.

#### SVG as image

You can also place more complex (multi-colored) SVGs in `/assets/images/` and Gulp will compress them. They can be found in `/dist/images/`

### 5.4 Images

Put your static images in `/assets/images/` and Gulp will compress them a bit. Refer images in `/dist/images/`. In SASS `background('../images/bg.png')`

### 5.5 Fonts

You can put font files in `/assets/fonts/` and Gulp flattens sub directories and serves them to `/dist/fonts/`.

### 5.6 Favicon

You can put favicon files in `/assets/favicon/` and Gulp optimizes images and serves them to `/dist/favicon/`. You can use a tool like [RealFaviconGenerator](https://realfavicongenerator.net/) to make favicon.

## 6. Includes

Includes are all global PHP files that are not part of templates. So filters, actions and functions.

All global functions, hooks and setup should be on their own files organized at /inc/. The names of files should describe what the file does as following:

  * `register-` configures new settings and assets
  * `setup-` configures existing settings and assets
  * `function-` adds functions to be used in templates

### 6.1 Functions.php

The `/functions.php` is the place to require and autoload all PHP files that are not part of the current template. This file should only ever have requires and nothing else.

### 6.2 \_conf

The `/inc/_conf/` directory has some essential settings for theme that you basically want to review in every project and probably will return many times during development.

  * `register-assets.php` has all CSS and JS enqueues to templates as well as any arbitary code added to header or footer.
  * `register-blocks.php` defines which Gutenberg blocks are allowed. Notice that all blocks that are not defined here are not allowed and modules add their own blocks to the mix.
  * `register-colors.php` configure background colors to be available in blocks using backgrounds (background, media & text).
  * `register-image-sizes.php` register all global image sizes and responsive image sizes.
  * `register-localization.php` all global translatable strings for Polylang.

### 6.3 Helpers

Directory `/inc/helpers/`.

#### Dates

Function: `x_get_posted_on()`

Get published date.

#### Hardcoded ids

Function: `x_get_hardcoded_id($key)`

Save all harcoded ids in one place in refer them through this function. Example:

```
/**
 * Get hardcoded ID by key
 *
 * @param string $key a name of hardcoded id
 *
 * @return int harcoded id
 */
function x_get_hardcoded_id($key = '') {

  switch ($key) {

    case 'some-id':
      return 123;

    default:
      return 0;

  }

}
```

Used in template:
`x_get_hardcoded_id('some-id')`

**Protip:** Avoid hardcoding ids if possible. If you really need to do it, centralize them into this function.

#### Last edited

Function: `x_last_edited($asset)`

Get last edited timestamp from asset files. Timestamps are saved in `/assets/last-edited.json`.

#### Setup fallbacks

Include fallback function in case critical plugin is not active.

## 7. Localization

We don't really like .po files as they are confusing for customers, their build process is weird and are prone to errors, it's hard to change the "original" text later on and they are slow-ish to load. What we do like is [Polylang](https://polylang.pro/). If we are running a multi-lingual site, we want to use Polylang's String Translation to translate the strings in theme.

But we don't stop at using just Polylang. It's generally a little pain to have to register all the strings for your theme and it's very easy to forget to add something. We created our own wrapper function to give you error messages for missing string in `WP_DEBUG` mode.

**But what if I'm only making site in one language?** Well you can be a lazy developer and hardcode things but that is a bit sloppy. You can prepare for multiple languages from the start by using these functions and registering your strings already. These functions (and bunch of Polylang's) will work **even if you don't use Polylang** (thanks to `/inc/setup-fallbacks.php`).

### 7.1 Registering strings

Start off by registering some strings (static pieces of text in theme).

  * All global strings are registered at `/inc/_conf/register-localization.php`
  * Module specific strings are registered at module's `setup.php`.

You give a unique context (key) and the default text (value) for string. Example `"Header: Greeting" => "Hello"`

You can change these default texts (values) right here and they will update on templates. If you have Polylang installed, these strings will appear automatically on String Translations.

#### Example: Module strings

Module's `setup.php`:

```php
/**
 * Localization
 */
add_filter('axio_core_pll_register_strings', function($strings) {

  return array_merge($strings, [
    'Menu: Button label'  => 'Menu',
    'Menu: Open'          => 'Open menu',
  ]);

}, 10, 1);
```

### 7.2 Using strings

There are two ways to get translated string

  1. By key (Social share: Title)
  2. By value (Share on social media)

All the default strings are fetched by key. In that way you can go on and replace the default values on `/inc/_conf/register-localization.php` without having to search and replace anything anywhere.

##### Getting string by key

**Return string by key:**

Function: `ask__($key, $lang = null)`

Example: `ask__('Social share: Title')` => 'Share on social media' (or translated version)

**Echo string by key:**

Function: `ask_e($key, $lang = null)`

Example: `ask_e('Social share: Title')` => 'Share on social media' (or translated version)

**Protip:** If you are unsure of what the final text may really be, it's smart to use strings by key. If it makes sense, you can use values by key for everything. Polylang doesn't have it's own "return string by key" but we got your back.

##### Getting string by value

**Return string by value:**

Function: `asv__($key, $lang = null)`

Example: `asv__('Share on social media')` => 'Share on social media' (or translated version)

**Echo string by value:**

Function: `asv_e($key, $lang = null)`

Example: `asv_e('Share on social media')` => 'Share on social media' (or translated version)

**Protip:** This is the "normal" Polylang way of getting your translated strings. The downside is that if the default text you propose will be radically changed in String Translation the code might be hard to read (it will work nevertheless).

#### Using strings in JS

Enqueue string to frontend with `wp_localize_script()`:

```php
add_action('wp_enqueue_scripts', function() {
  wp_localize_script('x-js', 'theme_strings_variable_name', [
    'prev' => ask__('Lightbox: Prev'),
    'next' => ask__('Lightbox: Next'),
  ]);
});
```

This makes a global JS variable before given script id (here x-js) and you can use string in JS:

```js
console.log(theme_strings_variable_name.prev);
```

#### Debugging your strings

Debugging is the greatest benefit of using our string localization functions instead of Polylang defaults. If you have `WP_DEBUG` set to `true` in `wp-config.php` (which you should while developing), you will get error messages if you forget things. So example:

  * You add to header.php `ask_e('Header: Greeting')`
  * You forget to add this string to `/inc/_conf/register-localization.php`
  * You get error message and PHP error log entry that you tried to use `ask_e('Header: Greeting')` in this file on that line without registering the string

So there's really no excuse to forget to register your strings no more.

### 7.3 Localizator

Localizator is a shell script in `/bin/localizator.sh` and can be executed via `sh bin/localizator.sh`.

Localizator is a automated search & replace for registered string values so that all theme strings can initially be in English but we can have support for Finnish out of the box. It's a simplified tool to help in complex problem.

Localizator consists of two parts:

  1. **Language packages**: that are named `{lang_code}.txt` that are placed in `/bin/localizator/` or inside module `/modules/module/docs/localizator/`
  2. **Shell script**: finds selected locale's language packages and search & replaces the strings in PHP files.

#### Language packages

Language packages have only few formatting rules. Localizator parses the file from row to row so that each row either is a translatable string or ignored.

Translatable strings are in format:
`String key || String value`

Any spaces before or after values are ignored and string is split from `||` to key and value. Any rows missing `||` are intrepented as comments.

#### Shell script

Shell script should be executed only if your first language is not English and you have not modified existing strings already (you will lose your changes – script will work, though).

You can also execute it if installing external module that has its own packages. **Notice that localizator uses all packages it founds so remove unnecessary packages or those will be also used**.

#### Localizator caviats

The formatting of string registration needs to be as following:
```
'String key'    => 'String value' // ✅
'String key'=>'String value'      // ✅

"String key"    => "String value" // ❌
```

If you are using strings by value (`asv__('Hello world)`) those are not replaced by localizator and in general it is recommended to use strings by key (as defaults do).

## 8. Workflows

### 8.1 Setting up your code editor

Recommended code editor is [Visual Studio Code](https://code.visualstudio.com/) as it provides some great extensions and code navigation.

#### Extension: phpcs

Theme includes a `phpcs.xml` that has code formatting guidelines for PHP CodeSniffer. Using the plugin the editor will highlight all issues.

#### Extension: EditorConfig for VS Code

Theme has an `.editorconfig` file that sets your code editor settings accordingly. [Download the extension](http://editorconfig.org/#download) to your editor. The settings will automatically be applied when you edit code when you have the extension.

#### Settings: Clean up search

Remove build assets from search:

 1. Go to Code => Preferences => Settings
 2. Search the setting `Search: Exclude`
 3. Add new pattern `**/dist`

#### Other useful extensions

Here are some optional extensions that will help you:

  * **PHP Intelephense**: Smart helper tools for PHP code
  * **Sass**: Syntax highlight and autocomplete for styles
  * **Tabnine Autocomplete**: AI driven generic autocomplete for functions/variables that learns from your code. With recurring naming conventions, it becomes really useful.
  * **WordPress Snippet**: Autocomplete WordPress functions
  * **WooCommerce Snippet**: Autocomplete WooCommerce functions

### 8.2 Navigating the code

The fastest way to navigate code when you are familiar with the basic structure and naming conventions is to use the search.

By default key bindings are:

<kbd>⌘</kbd> + <kbd>P</kbd> or  <kbd>Ctrl</kbd> + <kbd>E</kbd>

You can search by directory name or file name. So if you are looking for some kind of component, you might first write `component` to hope to find `component.php` and add to search query `component teaser` to get the right one. Or just start with module name like `teaser` to get files under that module.

## 9. Philosophy

### 9.1 Gutenberg

Gutenberg is the new default WordPress editor so it is not a great long term plan to hold on to the old Classic Editor. It provides page builder -ish possibilities that were previously done with 3rd party plugins or themes.

#### Gutenberg styles

Axio by Generaxion includes default Gutenberg styles on front-end and overrides them with from theme. This makes a site more future-proof as Gutenberg will have breaking changes in future where some features will not work properly without correct styles (and default styles will take care of them to some degree). You may have to override some opinionated defaults, though.

In Gutenberg editor, there are still lots of default styles so there might be a few inconsistensies between front-end and back-end. This will get better in future versions of Gutenberg and starter.

#### Scoping

All Gutenberg and Classic Editor content should be inside frontend container with class `.blocks`. You should scope the styles for this to focus on right elements.

#### Margins and widths

In Gutenberg world, each block will define its own width as there can be wide blocks and full width blocks. There are variables to keep widths consistent.

**Protip:** Avoid resetting left and right margins if you are not sure what you are doing. You can easily make an element stick to left side of screen by adding `margin: 0` instead of `margin-top: 0`.

**Protip 2:** Use the mixins `@include spacing-s(margin-top)`, `@include spacing-m(margin-top)` or `@include spacing-l(margin-top)` to have responsive and unified margins.

#### Allowed blocks

**All blocks that are not explicitly allowed are disabled.** This means that if you install a plugin that has new blocks, those blocks are not shown before you allow them. You can allow them inside modules or at global `/inc/_conf/register-blocks.php`.

You can add new blocks by simply finding out their name like `acf/your-custom-block` or `some-plugin/some-block`.

#### Known Gutenberg issues

Gutenberg has still many improvements and bugfixes on the way. These are some issues at the moment:

  * You cannot disable Inline Image block because it comes from Paragraph block [#12680](https://github.com/WordPress/gutenberg/issues/12680)
  * Many features can't be disabled like paragraph drop caps.
  * Colors can't be scoped to specific blocks. If you register colors for Gutenberg, they will become available to every block that supports colors.

Gutenberg development is moving fast and there are a lot of people working hard to improve Gutenberg.

###  9.2 Scope of starter

Starter should have features that most of the projects need. The module structure allows little more flexibility in this as unneeded modules are easy to discard. Features that only benefit < 20% sites should not be part of starter.

###  9.3 Level of detail

The features included should be in a working stage and optimally looking professional even without additional styling. Additional styling is always appropriate but the baseline should be polished to some degree.

###  9.4 Open source

Opening the starter to public increases the quality and provides feedback and commits from large community. Without open sourcing the starter wouldn't be where it is today.
