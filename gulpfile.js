/**
 * Configuration for Gulp. Based largely on Sage by Roots.
 */

/**
 * Site config
 */
var manifest     = require('./assets/manifest.js');
var timestamps   = require('./assets/last-edited.json');

/**
 * Global modules
 */
var argv         = require('minimist')(process.argv.slice(2));
var autoprefixer = require('gulp-autoprefixer');
var beeper       = require('beeper');
var browsersync  = require('browser-sync').create();
var concat       = require('gulp-concat');
var flatten      = require('gulp-flatten');
var gulp         = require('gulp');
var gulpif       = require('gulp-if');
var imagemin     = require('gulp-imagemin');
var jshint       = require('gulp-jshint');
var lazypipe     = require('lazypipe');
var merge        = require('merge-stream');
var cssnano      = require('gulp-cssnano');
var plumber      = require('gulp-plumber');
var runsequence  = require('run-sequence');
var sass         = require('gulp-sass');
var sourcemaps   = require('gulp-sourcemaps');
var uglify       = require('gulp-uglify');
var rename       = require('gulp-rename');
var svgmin       = require('gulp-svgmin');
var svgstore     = require('gulp-svgstore');
var file         = require('gulp-file');

/**
 * Asset paths
 */
var path = {
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
 * Timestamps
 *
 * Update asset class timestamp to last-edited.json
 */
var updateTimestamp = function updateTimestamp(stamp) {

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

var jsAssets  = buildAssets(manifest.js());
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
 * Process: JS
 *
 * Sourcemap, combine, minimize.
 *
 * gulp.src(jsFiles)
 *   .pipe(jsTasks('main.js')
 *   .pipe(gulp.dest(path.base.dist + 'scripts'))
 * ```
 */
var jsTasks = function(filename) {

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
gulp.task('styles', [], function() {

  var merged = merge();

  // update last-edited.json
  updateTimestamp('css');

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
 * Task: Scripts
 *
 * `gulp scripts` - Runs JSHint then compiles, combines, and optimizes JS.
 */
gulp.task('scripts', ['jshint'], function() {

  var merged = merge();

  // process all assets
  for (i = 0; i < jsAssets.length; i++) {

    var asset = jsAssets[i];

    var jsTasksInstance = jsTasks(asset.name);

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

});

/**
 * Task: Fonts
 *
 * `gulp fonts` - Grabs all the fonts and outputs them in a flattened directory
 * structure. See: https://github.com/armed/gulp-flatten
 */
gulp.task('fonts', function() {

  return gulp.src([path.fonts.source + '**/*'])

    // flatten directory structures
    .pipe(flatten())

    // send to /dist/fonts/
    .pipe(gulp.dest(path.fonts.dist))

    // browsersync result
    .pipe(browsersync.stream());

});

/**
 * Task: Images
 *
 * `gulp images` - Run lossless compression on all the images.
 */
gulp.task('images', function() {

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

});

/**
 * Task: Svgstore
 *
 * Create a single sprite.svg file from files in /assets/sprite/.
 */
gulp.task('svgstore', function () {

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

});

/**
 * Task: JSHint
 *
 * `gulp jshint` - Lints configuration JSON and project JS.
 */
gulp.task('jshint', function() {

  var allJS = [];
  for (i = 0; i < jsAssets.length; i++) {
    var globsArray = jsAssets[i].globs;
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

});

/**
 * Task: Favicon
 *
 * `gulp favicon` - Run lossless compression for favicons.
 */
gulp.task('favicon', function() {

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
  var new_tab = 'local';
  if(argv.q) {
    new_tab = false;
  }
  // browsersync changes
  browsersync.init({
    files: [
      '{inc,partials,template-tags}/**/*.php',
      '*.php'
    ],
    proxy: manifest.devUrl(),
    snippetOptions: {
      whitelist: ['/wp-admin/admin-ajax.php'],
      blacklist: ['/wp-admin/**']
    },
    open: new_tab
  });

  // watch these files
  gulp.watch([path.styles.source   + '**/*'], ['styles']);
  gulp.watch([path.scripts.source  + '**/*'], ['jshint', 'scripts']);
  gulp.watch([path.fonts.source    + '**/*'], ['fonts']);
  gulp.watch([path.images.source   + '**/*'], ['images']);
  gulp.watch([path.sprite.source   +    '*'], ['svgstore']);
  gulp.watch([path.favicon.source  +    '*'], ['favicon']);
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
