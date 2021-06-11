/**
 * use, get-google-fonts
 * https://www.npmjs.com/package/get-google-fonts
 */
const GetGoogleFonts = require('get-google-fonts');

const manifest = require('../assets/manifest.js');

/**
 * @type {string} fonts: () =>
 *     "https://fonts.googleapis.com/css2?family=Lexend:wght@500;700&family=Merriweather:ital,wght@0,400;0,900;1,400;1,900&display=swap",
 */
let config = manifest.fonts();

function processFonts() {

  if (!config) return Promise.resolve();

  return new GetGoogleFonts().download(config, {
    outputDir  : './dist/fonts/',
    overwriting: true,
    verbose    : true,
    path       : './',
  }).catch((e) => {
    console.log(e)
  })
}

exports.fonts = processFonts;
