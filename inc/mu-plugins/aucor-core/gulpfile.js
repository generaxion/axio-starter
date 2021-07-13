/**
 * Configuration for Gulp. Based largely on Sage by Roots.
 */

/**
 * Site config
 */
var manifest     = require('./assets/manifest.js');

/**
 * Global modules
 */
var argv         = require('minimist')(process.argv.slice(2));
var autoprefixer = require('gulp-autoprefixer');
var beeper       = require('beeper');
var browsersync  = require('browser-sync').create();
var concat       = require('gulp-concat');
var gulp         = require('gulp');
var gulpif       = require('gulp-if');
var lazypipe     = require('lazypipe');
var merge        = require('merge-stream');
var cssnano      = require('gulp-cssnano');
var plumber      = require('gulp-plumber');
var runsequence  = require('run-sequence');
var sass         = require('gulp-sass');
var sourcemaps   = require('gulp-sourcemaps');
/**
 * Asset paths
 */
var path = {
  "base" : {
    "source": "assets/",
    "dist":   "dist/",
  },
  "styles" : {
    "source": "assets/styles/",
    "dist":   "dist/styles/",
  }
};

/**
 * Disable or enable features
 */
var enabled = {

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
 * Build variable for assets
 *
 * Create array with information of assets:
 * {
 *   'name': main.css,
 *   'globs': 'assets/main.scss,assets/print.scss'
 * }
 */
var buildAssets = function(buildFiles) {

  var result = [];
  for (var buildFile in buildFiles) {

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

var cssAssets = buildAssets(manifest.css());

/**
 * Process: CSS
 *
 * SASS, autoprefix, sourcemap styles.
 *
 * gulp.src(cssFiles)
 *   .pipe(cssTasks('main.css')
 *   .pipe(gulp.dest(path.base.dist + 'styles'))
 */
var cssTasks = function(filename) {

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
 * Task: Styles
 *
 * `gulp styles` - Compiles, combines, and optimizes Bower CSS and project CSS.
 * By default this task will only log a warning if a precompiler error is
 * raised. If the `--production` flag is set: this task will fail outright.
 */
gulp.task('styles', [], function() {

  var merged = merge();

  // process all assets
  for (i = 0; i < cssAssets.length; i++) {

    var asset = cssAssets[i];
    var cssTasksInstance = cssTasks(asset.name);

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

});

/**
 * Task: Clean
 *
 * `gulp clean` - Deletes the build folder entirely.
 */
gulp.task('clean', require('del').bind(null, [path.base.dist]));

/**
 * Task: Watch
 *
 * `gulp watch` - Use BrowserSync to proxy your dev server and synchronize code
 * changes across devices. Specify the hostname of your dev server at
 * `manifest.devUrl`. When a modification is made to an asset, run the
 * build step for that asset and inject the changes into the page.
 * See: http://www.browsersync.io
 */
gulp.task('watch', function() {

  // browsersync changes
  browsersync.init({
    files: [
      '{inc,partials,template-tags}/**/*.php',
      '*.php'
    ],
    snippetOptions: {
      whitelist: ['/wp-admin/admin-ajax.php'],
      blacklist: ['/wp-admin/**']
    }
  });

  // watch these files
  gulp.watch([path.styles.source   + '**/*'], ['styles']);
  gulp.watch(['assets/manifest.js'],          ['build']);

});

/**
 * Task: Build
 *
 * `gulp build` - Run all the build tasks but don't clean up beforehand.
 * Generally you should be running `gulp` instead of `gulp build`.
 */
gulp.task('build', function(callback) {

  runsequence(
    'styles',
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
