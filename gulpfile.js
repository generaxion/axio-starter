/**
 * Configuration for Gulp. Based largely on Sage by Roots.
 */

/**
 * Site config
 */
const manifest = require('./assets/manifest.js');
const timestamps = require('./assets/last-edited.json');

/**
 * Global modules
 */
const argv = require('minimist')(process.argv.slice(2));
const autoprefixer = require('gulp-autoprefixer');
const beeper = require('beeper');
const browsersync = require('browser-sync').create();
const concat = require('gulp-concat');
const flatten = require('gulp-flatten');
const gulp = require('gulp');
const del = require('del');
const gulpif = require('gulp-if');
const imagemin = require('gulp-imagemin');
const jshint = require('gulp-jshint');
const lazypipe = require('lazypipe');
const merge = require('merge-stream');
const cleancss = require('gulp-clean-css');
const plumber = require('gulp-plumber');
const sass = require('gulp-sass');
const sourcemaps = require('gulp-sourcemaps');
const uglify = require('gulp-uglify');
const rename = require('gulp-rename');
const svgstore = require('gulp-svgstore');
const file = require('gulp-file');
const babel = require('gulp-babel');

const fs = require('fs');
const path_module = require('path');

const {processFonts} = require('./gulpfiles/fonts.js')
const {vars} = require('./gulpfiles/create-vars.js')


/**
 * Asset paths
 */
const path = {
	"base"   : {
		"source": "assets/",
		"dist"  : "dist/",
	},
	"scripts": {
		"source": "assets/scripts/",
		"dist"  : "dist/scripts/",
	},
	"styles" : {
		"source": "assets/styles/",
		"dist"  : "dist/styles/",
	},
	"fonts"  : {
		"source": "assets/fonts/",
		"dist"  : "dist/fonts/",
	},
	"images" : {
		"source": "assets/images/",
		"dist"  : "dist/images/",
	},
	"sprite" : {
		"source": "assets/sprite/",
		"dist"  : "dist/sprite/",
	},
	"favicon": {
		"source": "assets/favicon/",
		"dist"  : "dist/favicon/",
	},
	"modules": {
		"source": "modules/",
	},
};

/**
 * Disable or enable features
 */
const enabled = {
	// disable source maps when `--production`
	maps         : !argv.production,
	// fail styles task on error when `--production`
	failStyleTask: argv.production,
	// fail due to JSHint warnings only when `--production`
	failJSHint   : argv.production,
	// strip debug statments from javascript when `--production`
	stripJSDebug : argv.production,
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
		{src: true},
	)
		.pipe(gulp.dest('./assets'));
};

/**
 * getModules helper function for collecting all modules
 */
const getModules = () => {
	return fs.readdirSync(path.modules.source)
					 .filter(function(module) {
						 if (!module.includes("_", 0)) {
							 return fs.statSync(path_module.join('./modules/', module)).isDirectory();
						 }
					 });
}
/**
 * getModuleJsons helper function for collecting all modules _.json files
 */
var getModuleJsons = () => {
	var jsons = [];
	var modules = getModules();

	for (let i = 0; i < modules.length; i++) {
		if (!modules[i].includes("_", 0) && !modules[i].includes(".")) {
			jsons.push({
				'name': modules[i],
				'json': require('./modules/' + modules[i] + '/_.json'),
			});
		}
	}
	return jsons;
}

const getAssets = () => {
	let manifest_json = {
		'js' : manifest.js(),
		'css': manifest.css(),
	}

	getModuleJsons().forEach(module => {
		if (module.json.css) {
			Object.entries(module.json.css).forEach(([target, sources]) => {
				if (typeof sources !== 'undefined' && sources.length > 0) {
					sources.forEach(source => {
						manifest_json.css[target].push('modules/' + module.name + '/' + source);
					});
				}
			});
		}
		if (module.json.js) {
			Object.entries(module.json.js).forEach(([target, sources]) => {
				if (typeof sources !== 'undefined' && sources.length > 0) {
					sources.forEach(source => {
						manifest_json.js[target].push('modules/' + module.name + '/' + source);
					});
				}
			});
		}
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
			'name' : buildFile,
			'globs': buildFiles[buildFile],
		});
	}
	return result;
};
var jsAssets = buildAssets(getAssets().js);
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
				outputStyle    : 'nested', // libsass doesn't support expanded yet
				precision      : 8,
				includePaths   : ['.'],
				errLogToConsole: !enabled.failStyleTask,
			}));
		})
		// autoprefix
		.pipe(autoprefixer, {
			"grid": "no-autoplace",
		})
		// combine files
		.pipe(concat, filename)
		// minify
		.pipe(cleancss, {})
		// build sourcemaps
		.pipe(function() {
			return gulpif(enabled.maps, sourcemaps.write('.', {
				sourceRoot: path.styles.source,
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
				presets  : ["@babel/preset-env", "@babel/preset-react"],
				overrides: [
					{
						test      : manifest.babelIgnores(),
						sourceType: "script",
					},
				],
			});
		})

		// combine files
		.pipe(concat, filename)
		// minify
		.pipe(uglify, {
			compress: {
				'drop_debugger': enabled.stripJSDebug,
			},
		})
		// build sourcemaps
		.pipe(function() {
			return gulpif(enabled.maps, sourcemaps.write('.', {
				sourceRoot: path.scripts.source,
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
					.pipe(cssTasksInstance),
		);
	}
	return merged
		.on('error', function(err) {
			beeper();
		})
		.pipe(gulp.dest(path.styles.dist))
		.pipe(gulpif(!argv.q, browsersync.stream({match: '**/*.css'})))
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
					.pipe(jsTasksInstance),
		);
	}
	return merged
		.on('error', function(err) {
			beeper();
			console.log(err);
		})
		.pipe(gulp.dest(path.scripts.dist))
		.pipe(gulpif(!argv.q, browsersync.stream({match: '**/*.js'})));
});

/**
 * Task: Fonts
 *
 * `gulp fonts` - Grabs all the fonts and outputs them in a flattened directory
 * structure. See: https://github.com/armed/gulp-flatten
 */
gulp.task('fonts', async () => {

	await del(path.fonts.dist);
	await del(path.fonts.source);

	await processFonts();

	return gulp.src([path.fonts.source + '**/*'])
						 // flatten directory structures
						 .pipe(flatten())
						 // send to /dist/fonts/
						 .pipe(gulp.dest(path.fonts.dist))
						 // browsersync result
						 .pipe(gulpif(!argv.q, browsersync.stream()));
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
		path.modules.source + '**/images/*',
	];

	return gulp
		.src(image_sources)
		// optimize images
		.pipe(
			imagemin({
				progressive: true,
				interlaced : true,
				svgoPlugins: [{removeUnknownsAndDefaults: false}, {cleanupIDs: false}, {removeDimensions: true}],
			}),
		)

		// send to /dist/images
		.pipe(flatten())
		.pipe(gulp.dest(path.images.dist))

		// browsersync result
		.pipe(gulpif(!argv.q, browsersync.stream()));

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
		err => console.error({err}),
	);

	// Add module sprites to spriteSources if icon with the same name is not found
	// @todo maybe turn into async function
	const dropIns = getModules();

	// Get module filenames
	for (const module of dropIns) {
		await fs.promises.readdir(path.modules.source + module + '/assets/sprite').then(
			files => files.forEach(file => spriteSources.push(path.modules.source + module + '/assets/sprite/' + file)),
			err => null, // directory doesn't exist
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
			if (path !== searchFilePath && file == searchFile && spriteFilenameReference[path] && file !== '.DS_Store') {
				delete spriteFilenameReference[searchFilePath];
				console.log(`SVG sprite duplicate: ${searchFilePath}`);
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
									 {removeViewBox: false},
									 {collapseGroups: true},
									 {
										 convertColors: {
											 currentColor: true,
										 },
									 },
								 ],
							 }),
						 ]))
						 // store SVG into sprite
						 .pipe(svgstore())
						 .pipe(gulp.dest(path.sprite.dist))
						 // browsersync result
						 .pipe(gulpif(!argv.q, browsersync.stream()));

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
		'gulpfile.js',
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
							 interlaced : true,
							 svgoPlugins: [
								 {removeUnknownsAndDefaults: false},
								 {cleanupIDs: false},
								 {removeDimensions: true},
							 ],
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

	if (!argv.q) {
		// browsersync changes unless in quiet mode
		browsersync.init({
			files         : [
				'{inc,blocks,modules}/**/*.php',
				'*.php',
			],
			proxy         : manifest.devUrl(),
			snippetOptions: {
				whitelist: ['/wp-admin/admin-ajax.php'],
				blacklist: ['/wp-admin/**'],
			},
			open          : 'local',
		});
	}

	// watch these files
	gulp.watch(path.styles.source + '**/*', gulp.task('styles'));
	gulp.watch(path.scripts.source + '**/*', gulp.task('scripts'));
	gulp.watch(path.fonts.source + '**/*', gulp.task('fonts'));
	gulp.watch(path.images.source + '**/*', gulp.task('images'));
	gulp.watch(path.sprite.source + '*', gulp.task('svgstore'));
	gulp.watch(path.favicon.source + '*', gulp.task('favicon'));

	// modules
	gulp.watch(path.modules.source + '**/*.scss', gulp.task('styles'));
	gulp.watch(path.modules.source + '**/*.js', gulp.task('scripts'));
	gulp.watch(path.modules.source + '**/images/*', gulp.task('images'));
	gulp.watch(path.modules.source + '**/sprite/*', gulp.task('svgstore'));

	gulp.watch([
		'gulpfile.js',
		'assets/manifest.js',
		path.modules.source + '*/_.json',
	], () => {
		console.error("\n⚠️  Congifuration modified. Restart gulp. ⚠️\n");
		beeper();
		process.exit();
	});

	gulp.watch([
			path.modules.source + '*',
		],
		gulp.task('default'),
	)
});

/**
 * Task: Build
 *
 * `gulp build` - Run all the build tasks but don't clean up beforehand.
 * Generally you should be running `gulp` instead of `gulp build`.
 */
gulp.task('build', gulp.series(
	gulp.parallel(vars),
	gulp.parallel('styles', 'scripts', 'jshint'),
	gulp.parallel('fonts', 'images', 'svgstore', 'favicon'),
));

/**
 * Task: Default
 *
 * `gulp` - Run a complete build. To compile for production run `gulp --production`.
 */
gulp.task('default', gulp.series('clean', 'build'));


/**
 * SD Gulp
 */
//exports.vars = vars

