/**
 * Configuration for Gulp. Based largely on Sage by Roots.
 */

/**
 * Manifest
 *
 * Requires manifest.js file
 */
function get_manifest() {
  return require('./assets/manifest.js');
}

/**
 * Site config
 */
var manifest       = get_manifest();
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
const gulp         = require('gulp');
const del          = require('del');
const gulpif       = require('gulp-if');
const imagemin     = require('gulp-imagemin');
const jshint       = require('gulp-jshint');
const lazypipe     = require('lazypipe');
const merge        = require('merge-stream');
const cleancss     = require('gulp-clean-css');
const plumber      = require('gulp-plumber');
const sass         = require('gulp-sass');
const sourcemaps   = require('gulp-sourcemaps');
const uglify       = require('gulp-uglify');
const rename       = require('gulp-rename');
const svgstore     = require('gulp-svgstore');
const file         = require('gulp-file');
const babel        = require('gulp-babel');

const fs           = require('fs');
const path_module  = require('path');

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
  },
  "drop_ins" : {
    "source": "drop-ins/",
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
 * getDropIns helper function for collecting all drop-ins
 */
const getDropIns = () => {
  return  fs.readdirSync(path.drop_ins.source)
            .filter(function(drop_in) {
              if (!drop_in.includes("_", 0)) {
                return fs.statSync(path_module.join('./drop-ins/', drop_in)).isDirectory();
              }
            });
}
/**
 * getDropInJsons helper function for collecting all drop-ins _.json files
 */
var getDropInJsons = () => {
  var jsons = [];
  var drop_ins = getDropIns();

  for (let i = 0; i < drop_ins.length; i++) {
    if (!drop_ins[i].includes("_", 0) && !drop_ins[i].includes(".")) {
      jsons.push({
        'name': drop_ins[i],
        'json': require('./drop-ins/' + drop_ins[i] + '/_.json'),
      });
    }
  }
  return jsons;
}

const getAssets = () => {
  let manifest_json = {
    'js': manifest.js(),
    'css': manifest.css(),
  }

  getDropInJsons().forEach(drop_in => {

    Object.entries(drop_in.json.css).forEach(([target, sources]) => {
      if (typeof sources !== 'undefined' && sources.length > 0) {
        sources.forEach(source => {
          manifest_json.css[target].push('drop-ins/' + drop_in.name + '/' + source);
        });
      }
    });

    Object.entries(drop_in.json.js).forEach(([target, sources]) => {
      if (typeof sources !== 'undefined' && sources.length > 0) {
        sources.forEach(source => {
          manifest_json.js[target].push('drop-ins/' + drop_in.name + '/' + source);
        });
      }
    });
  });

  return manifest_json;
}

/**
 * Build variable for assets
 *
 * Create array with information of assets:
 * {
 *   'name': main.css,
 *   'globs': 'assets/main.scss,assets/print.scss'
 * }
 */
var buildAssets = (buildFiles) => {
  let result = [];
  for (let buildFile in buildFiles) {
    // set correct asset paths
    /*for (i = 0; i < buildFiles[buildFile].length; i++) {
      buildFiles[buildFile][i] = path.base.source + buildFiles[buildFile][i];
    }*/
    result.push({
      'name': buildFile,
      'globs': buildFiles[buildFile],
    });
  }
  return result;
};
var jsAssets  = buildAssets(getAssets().js);
var cssAssets = buildAssets(getAssets().css);

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
    // autoprefix
    .pipe(autoprefixer, {
      "grid": "no-autoplace"
    })
    // combine files
    .pipe(concat, filename)
    // minify
    .pipe(cleancss, {})
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
const jsTasks = (filename) => {
  updateTimestamp('js');
  return lazypipe()
    // init sourcemaps
    .pipe(function() {
      return gulpif(enabled.maps, sourcemaps.init());
    })

    // transpile
    .pipe(function() {
      return babel({
        presets: ["@babel/preset-env", "@babel/preset-react"],
        // override because of use of "this" in IIFE with Babel in Tobi.js: https://stackoverflow.com/questions/34973442/how-to-stop-babel-from-transpiling-this-to-undefined-and-inserting-use-str
        overrides: [{
          test: [
            "./node_modules/@rqrauhvmra/tobi/js/tobi.js",
            "./node_modules/axios/dist/axios.min.js",
          ],
          sourceType: "script",
        }],
      });
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
gulp.task('styles', () => {
  const merged = merge();
  cssAssets = buildAssets(getAssets().css);

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
    merged.add(
      gulp.src(asset.globs, {base: 'styles'})
        .pipe(cssTasksInstance)
    );
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
gulp.task('scripts', () => {
  const merged = merge();
  jsAssets = buildAssets(getAssets().js);

  // process all assets
  for (i = 0; i < jsAssets.length; i++) {
    let asset = jsAssets[i];
    const jsTasksInstance = jsTasks(asset.name);
    //merge
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
gulp.task('fonts', () => {
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
gulp.task('images', () => {

  // Gather all image sources to one array
  let image_sources = [
    path.images.source + '**/*',
    path.drop_ins.source + '**/images/*'
  ];

  return gulp
    .src(image_sources)
    // optimize images
    .pipe(
      imagemin({
        progressive: true,
        interlaced: true,
        svgoPlugins: [{removeUnknownsAndDefaults: false}, {cleanupIDs: false}, {removeDimensions: true}]
      })
    )

    // send to /dist/images
    .pipe(flatten())
    .pipe(gulp.dest(path.images.dist))

    // browsersync result
    .pipe(browsersync.stream());
});

/**
 * Task: Svgstore
 *
 * Create a single sprite.svg file from files in /assets/sprite/.
 */
gulp.task('svgstore', async () => {

  updateTimestamp('svg');

  // Gather all svg sources to one array
  let spriteSources = [];

  // Get names of icons in /assets/sprite/ directory for later name comparison
  await fs.promises.readdir(path.sprite.source).then(
    files => files.forEach(file => spriteSources.push(path.sprite.source + file)),
    err => console.error({err})
  );

  // Add Drop-in sprites to spriteSources if icon with the same name is not found
  // @todo maybe turn into async function
  const dropIns = getDropIns();

  // Get drop-in filenames
  for (const drop_in of dropIns) {
    await fs.promises.readdir(path.drop_ins.source + drop_in + '/assets/sprite').then(
      files => files.forEach(file => spriteSources.push(path.drop_ins.source + drop_in + '/assets/sprite/' + file)),
      err => null // directory doesn't exist
    );
  }

  // Make reference with path and filename
  let spriteFilenameReference = [];
  for (const file of spriteSources) {
    spriteFilenameReference[file] = file.replace(/^.*[\\\/]/, '');
  }

  // Remove duplicates
  for (const [path, file] of Object.entries(spriteFilenameReference)) {
    for (const [searchFilePath, searchFile] of Object.entries(spriteFilenameReference)) {
      if (path !== searchFilePath && file == searchFile && spriteFilenameReference[path]) {
        delete spriteFilenameReference[searchFilePath];
        console.log(`SVG sprite duplicate ignored: ${searchFilePath}`);
      }
    }
  }

  return gulp.src(Object.keys(spriteFilenameReference))
  // rename SVG IDs by "icon-filename"
  .pipe(rename({prefix: 'icon-'}))
  // optimize SVG
  .pipe(imagemin([
    imagemin.svgo({
      plugins: [
        {
          removeViewBox: false,
          collapseGroups: true
        }
      ]
    })
  ]))
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
gulp.task('jshint', () => {
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
});

/**
 * Task: Favicon
 *
 * `gulp favicon` - Run lossless compression for favicons.
 */
gulp.task('favicon', () => {
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
gulp.task('clean', () => {
  return del(path.base.dist);
});

/**
 * Task: Watch
 *
 * `gulp watch` - Use BrowserSync to proxy your dev server and synchronize code
 * changes across devices. Specify the hostname of your dev server at
 * `manifest.devUrl`. When a modification is made to an asset, run the
 * build step for that asset and inject the changes into the page.
 * See: http://www.browsersync.io
 */
gulp.task('watch', () => {
  var new_tab = 'local';
  if (argv.q) {
    new_tab = false;
  }
  var sonic = false;
  if (argv.s) {
    sonic = true;
  }
  // browsersync changes
  browsersync.init({
    files: [
      '{inc,components,blocks,partials}/**/*.php',
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
  gulp.watch(path.styles.source   + '**/*', gulp.task('styles'));
  gulp.watch(path.scripts.source  + '**/*', gulp.task('scripts'));
  gulp.watch(path.fonts.source    + '**/*', gulp.task('fonts'));
  gulp.watch(path.images.source   + '**/*', gulp.task('images'));
  gulp.watch(path.sprite.source   +    '*', gulp.task('svgstore'));
  gulp.watch(path.favicon.source  +    '*', gulp.task('favicon'));

  // Drop-ins
  gulp.watch(path.drop_ins.source +           '**/*.scss', gulp.task('styles'));
  gulp.watch(path.drop_ins.source +       '**/*.js', gulp.task('scripts'));
  gulp.watch(path.drop_ins.source +    '**/images/*', gulp.task('images'));
  gulp.watch(path.drop_ins.source +     '**/sprite/*', gulp.task('svgstore'));

  gulp.watch([
    'gulpfile.js',
    'assets/manifest.js',
    path.drop_ins.source + '*/_.json'
  ], () => {
    console.error("\n⚠️  Congifuration files modified. Restart gulp. ⚠️\n");
    beeper();
    process.exit();
  });

  gulp.watch([
    path.drop_ins.source + '*',
  ],
    gulp.task('default')
  )
});

/**
 * Task: Build
 *
 * `gulp build` - Run all the build tasks but don't clean up beforehand.
 * Generally you should be running `gulp` instead of `gulp build`.
 */

gulp.task('build', gulp.series(
  gulp.parallel('styles', 'scripts','jshint'),
  gulp.parallel('fonts', 'images', 'svgstore', 'favicon')
));

/**
 * Task: Default
 *
 * `gulp` - Run a complete build. To compile for production run `gulp --production`.
 */
gulp.task('default', gulp.series('clean', 'build'));
