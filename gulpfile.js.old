/**
 * Configuration for Gulp. Based largely on Sage by Roots.
 */

/**
 * Site config
 */
const manifest     = require('./assets/manifest.js');
const timestamps   = require('./assets/last-edited.json');

/**
 * Global modules
 */
const argv         = require('minimist')(process.argv.slice(2));
const autoprefixer = require('gulp-autoprefixer');
const beeper       = require('beeper');
const browsersync  = require('browser-sync').create();
const concat       = require('gulp-concat');
const flatten      = require('gulp-flatten');
const { series, paralell }  = require('gulp');
const gulpif       = require('gulp-if');
const imagemin     = require('gulp-imagemin');
const jshint       = require('gulp-jshint');
const lazypipe     = require('lazypipe');
const merge        = require('merge-stream');
const cssnano      = require('gulp-cssnano');
const plumber      = require('gulp-plumber');
const runsequence  = require('run-sequence');
const sass         = require('gulp-sass');
const sourcemaps   = require('gulp-sourcemaps');
const uglify       = require('gulp-uglify');
const rename       = require('gulp-rename');
const svgmin       = require('gulp-svgmin');
const svgstore     = require('gulp-svgstore');
const file         = require('gulp-file');

/**
 * Asset paths
 */
const path = {
  "base" : {
    "source": "assets/",
    "dist":   "dist/",
  },
  "scripts" : {
    "source": "assets/scripts/",
    "dist":   "dist/scripts/",
  },
  "styles" : {
    "source": "assets/styles/",
    "dist":   "dist/styles/",
  },
  "fonts" : {
    "source": "assets/fonts/",
    "dist":   "dist/fonts/",
  },
  "images" : {
    "source": "assets/images/",
    "dist":   "dist/images/",
  },
  "sprite" : {
    "source": "assets/sprite/",
    "dist":   "dist/sprite/",
  },
  "favicon" : {
    "source": "assets/favicon/",
    "dist":   "dist/favicon/",
  }
};

/**
 * Disable or enable features
 */
const enabled = {

  // disable source maps when `--production`
  maps: !argv.production,

  // fail styles task on error when `--production`
  failStyleTask: argv.production,

  // fail due to JSHint warnings only when `--production`
  failJSHint: argv.production,

  // strip debug statments from javascript when `--production`
  stripJSDebug: argv.production

};

/**
 * Timestamps
 *
 * Update asset class timestamp to last-edited.json
 */
const updateTimestamp = (stamp) => {

  timestamps[stamp] = Date.now();

  return file(
    'last-edited.json',
    JSON.stringify(timestamps, null, 2),
    {src: true}
  )
  .pipe(gulp.dest('./assets'));

};

/**
 * Build variable for assets
 *
 * Create array with information of assets:
 * {
 *   'name': main.css,
 *   'globs': 'assets/main.scss,assets/print.scss'
 * }
 */
const buildAssets = (buildFiles) => {

  let result = [];
  for (let buildFile in buildFiles) {

    // set correct asset paths
    for (i = 0; i < buildFiles[buildFile].length; i++) {
      buildFiles[buildFile][i] = path.base.source + buildFiles[buildFile][i];
    }

    result.push({
      'name': buildFile,
      'globs': buildFiles[buildFile],
    });
  }
  return result;

};

const jsAssets  = buildAssets(manifest.js());
const cssAssets = buildAssets(manifest.css());

/**
 * Process: CSS
 *
 * SASS, autoprefix, sourcemap styles.
 *
 * gulp.src(cssFiles)
 *   .pipe(cssTasks('main.css')
 *   .pipe(gulp.dest(path.base.dist + 'styles'))
 */
const cssTasks = (filename) => {

  return lazypipe()

    // catch syntax errors (don't break pipe)
    .pipe(function() {
      return gulpif(!enabled.failStyleTask, plumber());
    })

    // init sourcemaps
    .pipe(function() {
      return gulpif(enabled.maps, sourcemaps.init());
    })

    // sass
    .pipe(function() {
      return gulpif('*.scss', sass({
        outputStyle: 'nested', // libsass doesn't support expanded yet
        precision: 8,
        includePaths: ['.'],
        errLogToConsole: !enabled.failStyleTask
      }));
    })

    // combine files
    .pipe(concat, filename)

    // autoprefix
    .pipe(autoprefixer, {
      browsers: [
        'last 2 versions',
        'android 4'
      ]
    })

    // minify
    .pipe(cssnano, {
      safe: true
    })

    // build sourcemaps
    .pipe(function() {
      return gulpif(enabled.maps, sourcemaps.write('.', {
        sourceRoot: path.styles.source
      }));
    })();

};

/**
 * Process: JS
 *
 * Sourcemap, combine, minimize.
 *
 * gulp.src(jsFiles)
 *   .pipe(jsTasks('main.js')
 *   .pipe(gulp.dest(path.base.dist + 'scripts'))
 * ```
 */
const jsTasks = filename => {

  updateTimestamp('js');

  return lazypipe()

    // init sourcemaps
    .pipe(function() {
      return gulpif(enabled.maps, sourcemaps.init());
    })

    // combine files
    .pipe(concat, filename)

    // minify
    .pipe(uglify, {
      compress: {
        'drop_debugger': enabled.stripJSDebug
      }
    })

    // build sourcemaps
    .pipe(function() {
      return gulpif(enabled.maps, sourcemaps.write('.', {
        sourceRoot: path.scripts.source
      }));
    })();

};

/**
 * Task: Styles
 *
 * `gulp styles` - Compiles, combines, and optimizes Bower CSS and project CSS.
 * By default this task will only log a warning if a precompiler error is
 * raised. If the `--production` flag is set: this task will fail outright.
 */
function styles() {

  const merged = merge();

  // update last-edited.json
  updateTimestamp('css');

  // process all assets
  for (i = 0; i < cssAssets.length; i++) {

    let asset = cssAssets[i];
    const cssTasksInstance = cssTasks(asset.name);

    // handle possible errors
    if (!enabled.failStyleTask) {
      cssTasksInstance.on('error', function(err) {
        console.error(err.message);
        this.emit('end');
      });
    }

    // merge
    merged.add(gulp.src(asset.globs, {base: 'styles'})
      .pipe(cssTasksInstance));

  }

  return merged
    .on('error', function(err) {
      beeper();
    })
    .pipe(gulp.dest(path.styles.dist))
    .pipe(browsersync.stream({match: '**/*.css'}));

};

exports.styles = styles;

/**
 * Task: Scripts
 *
 * `gulp scripts` - Runs JSHint then compiles, combines, and optimizes JS.
 */
function scripts() {
  const merged = merge();

  // process all assets
  for (i = 0; i < jsAssets.length; i++) {

    let asset = jsAssets[i];

    const jsTasksInstance = jsTasks(asset.name);

    merged.add(
      gulp.src(asset.globs, {base: 'scripts'})
        .pipe(jsTasksInstance)
    );

  }

  return merged
    .on('error', function(err) {
      beeper();
      console.log(err);
    })
    .pipe(gulp.dest(path.scripts.dist))
    .pipe(browsersync.stream({match: '**/*.js'}));

};

exports.scripts = scripts;

/**
 * Task: Fonts
 *
 * `gulp fonts` - Grabs all the fonts and outputs them in a flattened directory
 * structure. See: https://github.com/armed/gulp-flatten
 */
function fonts() {
  return gulp.src([path.fonts.source + '**/*'])

    // flatten directory structures
    .pipe(flatten())

    // send to /dist/fonts/
    .pipe(gulp.dest(path.fonts.dist))

    // browsersync result
    .pipe(browsersync.stream());

};
exports.fonts = fonts;

/**
 * Task: Images
 *
 * `gulp images` - Run lossless compression on all the images.
 */
function images() {

  return gulp.src([path.images.source + '**/*'])

    // optimize images
    .pipe(imagemin({
      progressive: true,
      interlaced: true,
      svgoPlugins: [{removeUnknownsAndDefaults: false}, {cleanupIDs: false}, {removeDimensions: true}]
    }))

    // send to /dist/images
    .pipe(gulp.dest(path.images.dist))

    // browsersync result
    .pipe(browsersync.stream());

};

exports.images = images;

/**
 * Task: Svgstore
 *
 * Create a single sprite.svg file from files in /assets/sprite/.
 */
function svgstore() {

  updateTimestamp('svg');

  return gulp.src(path.sprite.source + '*.svg')

  // rename SVG IDs by "icon-filename"
  .pipe(rename({prefix: 'icon-'}))

  // optimize SVG
  .pipe(svgmin())

  // store SVG into sprite
  .pipe(svgstore())
  .pipe(gulp.dest(path.sprite.dist))

  // browsersync result
  .pipe(browsersync.stream());

};

exports.svgstore = svgstore;

/**
 * Task: JSHint
 *
 * `gulp jshint` - Lints configuration JSON and project JS.
 */

function jshint() {

  let allJS = [];
  for (i = 0; i < jsAssets.length; i++) {
    let globsArray = jsAssets[i].globs;
    for (j = 0; j < globsArray.length; j++) {
      allJS.push(globsArray[j]);
    }
  }

  return gulp.src([
    'gulpfile.js'
  ].concat(allJS))
    .pipe(jshint())
    .pipe(jshint.reporter('jshint-stylish'))
    .pipe(gulpif(enabled.failJSHint, jshint.reporter('fail')));

};

exports.jshint = jshint;

/**
 * Task: Favicon
 *
 * `gulp favicon` - Run lossless compression for favicons.
 */
function favicon {

  return gulp.src([path.favicon.source + '**/*'])

    // optimize images
    .pipe(imagemin({
      progressive: true,
      interlaced: true,
      svgoPlugins: [
        {removeUnknownsAndDefaults: false},
        {cleanupIDs: false},
        {removeDimensions: true}
      ]
    }))

    // send to /dist/favicon
    .pipe(gulp.dest(path.favicon.dist));

};

exports.favicon = favicon;

/**
 * Task: Clean
 *
 * `gulp clean` - Deletes the build folder entirely.
 */
function clean() {
  require('del').bind(null, [path.base.dist]));
}

exports.clean = clean;

/**
 * Task: Watch
 *
 * `gulp watch` - Use BrowserSync to proxy your dev server and synchronize code
 * changes across devices. Specify the hostname of your dev server at
 * `manifest.devUrl`. When a modification is made to an asset, run the
 * build step for that asset and inject the changes into the page.
 * See: http://www.browsersync.io
 */
// function watch() {
//   const new_tab = 'local';
//   if(argv.q) {
//     new_tab = false;
//   }
//   // browsersync changes
//   browsersync.init({
//     files: [
//       '{inc,partials,template-tags}/**/*.php',
//       '*.php'
//     ],
//     proxy: manifest.devUrl(),
//     snippetOptions: {
//       whitelist: ['/wp-admin/admin-ajax.php'],
//       blacklist: ['/wp-admin/**']
//     },
//     open: new_tab
//   });

//   // watch these files
    watch([path.styles.source   + '**/*'], ['styles']);
//   gulp.watch([path.scripts.source  + '**/*'], ['jshint', 'scripts']);
//   gulp.watch([path.fonts.source    + '**/*'], ['fonts']);
//   gulp.watch([path.images.source   + '**/*'], ['images']);
//   gulp.watch([path.sprite.source   +    '*'], ['svgstore']);
//   gulp.watch([path.favicon.source  +    '*'], ['favicon']);
//   gulp.watch(['assets/manifest.js'],          ['build']);

// });

exports.build = series(clean, parallel(styles, scripts));

// exports.watch = watch;

/**
 * Task: Build
 *
 * `gulp build` - Run all the build tasks but don't clean up beforehand.
 * Generally you should be running `gulp` instead of `gulp build`.
 */
gulp.task('build', function(callback) {

  runsequence(
    'styles',
    'scripts',
    ['fonts', 'images', 'svgstore'],
    'favicon',
    callback
  );

});

/**
 * Task: Default
 *
 * `gulp` - Run a complete build. To compile for production run `gulp --production`.
 */
gulp.task('default', ['clean'], function() {

  gulp.start('build');

});
