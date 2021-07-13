/**
 * `gulp colors` automates the creation of editor-color-palette theme_support php file
 * and related scss and css files all from the manifest.js gulp configuration file.
 * V1.0

 *
 * Add config to manafest.js
 *
 colors: () => {
    return {
			"primary"         : {color: "#fe0700"},
			"primary-dark"    : {color: "#a00700"},
			"secondary"       : {color: "#d08a4e"},
			"black"           : {color: "#000"},
			"grey-dark"       : {color: "#333"},
			"grey"            : {color: "#777"},
			"grey-light"      : {color: "#bbb"},
			"grey-extra-light": {color: "#eee"},
			"white"           : {color: "#fff"},
    }
  },

 *
 * The following files are created:
 *
 ./assets/styles/utils/_variables-scss.scss
 ./assets/styles/utils/_variables-var.css
 ./assets/styles/utils/_variables-has.css
 ./inc/editor-color-palette.php
 */

const manifest = require('../assets/manifest.js');
if (!manifest || typeof manifest.colors !== "function") return;

const tinycolor = require("tinycolor2");
const fs = require('fs');

let config = {
	'colors': manifest.colors(),
}

exports.colors = () => {
	if (!config.colors) {
		console.log('No colors found in manifest!');
		return Promise.resolve();
	}
	let comment = "Created via `gulp colors`. Defined in theme's manifest.js"
	let scss_file = './assets/styles/utils/_variables-scss.scss';
	let var_file = './assets/styles/utils/_variables-var.css';
	let has_file = './assets/styles/utils/_variables-has.css'
	let themeSupportColor_file = './inc/auto/theme-support-color.php'
	let themeSupportText_file = './inc/auto/theme-support-text.php'
	let x_background_colors_file = './inc/auto/x-background-colors.php'
	let scssColors = ''
	let hasBackground = ''
	let hasColor = ''
	let hasSize = ''
	let varData = ''
	let themeSupportColor = ''
	let themeSupportSize = ''
	let x_background_colors = ''

	if (config.colors) {
		console.log("Create colors:")

		for (const obj of config.colors) {
			let slug = obj.slug
			let color = obj.color
			let name = obj.name
			let dark = obj.dark
			let tcolor = tinycolor(color)
			let styles = `background:${color}; color:white; display:block;`;

			console.log(`%c\t🎨 ${slug} = ${color}`, styles);

			scssColors += `$color-${slug}: ${color};\n`;

			hasBackground += `.has-${slug}-background-color {background-color: var(--color-${slug})}\n`;
			hasColor += `.has-${slug}-color {color: var(--color-${slug})}\n`;

			varData += `\t--color-${slug}: ${color};\n`;

			themeSupportColor += `
  [ 'name' => '${name ?? slug.charAt(0).toUpperCase() + slug.slice(1)}', 
    'slug' => '${slug}', 
    'color' => '${color}', 
  ],`;

			x_background_colors += `
	'${slug}' => [
		'label'   => __( '${name ?? slug.charAt(0).toUpperCase() + slug.slice(1)}' ),
		'color'   => '${color}',
		'is_dark' => ${dark ?? tcolor.isDark()},
	],`;

		}


		themeSupportColor = `add_theme_support( 'editor-color-palette', [${themeSupportColor}
]);
`

		x_background_colors = `add_filter( 'x_background_colors', function( $colors = [] ) {
	return array_merge( $colors, [ ${x_background_colors} ] );
} );
`

	}

	if (config.sizes) {
		console.log("Sizes - create sizes:")

		varData += `\n`

		for (let i in config.sizes) {
			let size = config.sizes[i].split(':')
			let key = size[0]
			let val = size[1]

			console.log(`\t🖌 ${key} = ${val}`);

			themeSupportSize += `
  [ 'name' => '${key.charAt(0).toUpperCase() + key.slice(1)}', 
    'shortName' => '${key.charAt(0).toUpperCase()}', 
    'slug' => '${key}', 
    'size' => '${val}', 
  ],`;

			hasSize += `.has-${key}-font-size {font-size: var(--size-${key})}\n`;

			varData += `\t--size-${key}: ${val};\n`;

		}

		themeSupportSize = `add_theme_support( 'editor-font-sizes', [${themeSupportSize}
]);
`
	}

	varData = `/* ${comment} */\n${varData}`

	scssColors = `// ${comment}\n${scssColors}`

	let hasData = `/* ${comment} */ 
${hasBackground}
${hasColor}
${hasSize}`

	themeSupportColor = `<?php\n// ${comment}\n${themeSupportColor}\n`

	themeSupportSize = `<?php\n// ${comment}\n${themeSupportSize}\n`

	x_background_colors = `<?php\n// ${comment}\n${x_background_colors}\n`

	varData = `:root {\n${varData}}`

	console.log('Colors - write Files');

	console.log(`\t${scss_file}`);
	fs.writeFileSync(scss_file, scssColors);

	console.log(`\t${var_file}`);
	fs.writeFileSync(var_file, varData);

	console.log(`\t${has_file}`);
	fs.writeFileSync(has_file, hasData);

	//console.log(`\t${themeSupportColor_file}`);
	//fs.writeFileSync(themeSupportColor_file, themeSupportColor);

	console.log(`\t${themeSupportText_file}`);
	fs.writeFileSync(themeSupportText_file, themeSupportSize);

	console.log(`\t${x_background_colors_file}`);
	fs.writeFileSync(x_background_colors_file, x_background_colors);

	return Promise.resolve();
}

