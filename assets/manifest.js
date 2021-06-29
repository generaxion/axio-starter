/**
 * Project specific gulp configuration
 */

module.exports = {

	/**
	 * URL for BrowserSync to mirror
	 */
	devUrl: () => "https://axio-starter.local",

  /**
   * SDM
   * @returns {{colors: string[]}}
   */
  vars: () => {
    return {
      "colors": [
        "primary:#fe0700",
        "primary-dark:#a00700",
        "secondary:#d08a4e",
        "black:#000",
        "grey-dark:#333",
        "grey:#777",
        "grey-light:#bbb",
        "grey-extra-light:#eee",
        "white:#fff",
      ],
    }
  },

  /**
   * SDM
	 * https://fonts.google.com/
   */
  fonts: () => "https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,900;1,400;1,900&display=swap",

	/**
   * JS files
   *
   * "build-file-name.js": [
   *   "../node_modules/some-module/some-module.js",
   *   "scripts/cool-scripts.js"
   * ]
   */
  js   : () => {
    return {

      // main js to be loaded in footer
      "main.js": [

        // IE11 polyfill for external x:link svg (https://github.com/Keyamoon/svgxuse)
        //"node_modules/svgxuse/svgxuse.js",

        // IE11 polyfill for object-fit
        //"node_modules/objectFitPolyfill/dist/objectFitPolyfill.min.js",

        // IE11 polyfill for forEach
        //"node_modules/nodelist-foreach-polyfill/index.js",

        // IE 11 ponyfill for css vars
        //"node_modules/css-vars-ponyfill/dist/css-vars-ponyfill.min.js",

        // vanilla js version of fitvids, that makes iframe videos responsice (https://www.npmjs.com/package/fitvids)
        "node_modules/fitvids/dist/fitvids.js",

        // project specific js
        "assets/scripts/lib/blocks.js",
        "assets/scripts/main.js",

      ],

      // gutenberg editor specific js
      "editor-gutenberg.js": [

        "assets/scripts/editor-gutenberg.js",

      ],

    }
  },

  /**
   * Babel ignores
   *
   * Babel messes up scripts that use "this" and these need to be skipped
   *
   * @see https://stackoverflow.com/a/34983495
   */
  babelIgnores: () => {
    return [
      "./node_modules/@rqrauhvmra/tobi/js/tobi.js",
      "./node_modules/axios/dist/axios.min.js",
      "./modules/lightbox/assets/vendor/tobi/js/tobi.js",
      "./modules/lightbox/assets/vendor/tobi/js/tobi.min.js",
    ];
  },

  /**
   * CSS files
   *
   * "build-file-name.css": [
   *   "../node_modules/some-module/some-module.css",
   *   "styles/main.scss"
   * ]
   */
  css: () => {
    return {

      "utils.css": [
        "assets/styles/utils.scss",
      ],

      "main.css": [
        "assets/styles/main.scss",
      ],

      "editor-gutenberg.css": [
        "assets/styles/editor-gutenberg.scss",
      ],

      "editor-classic.css": [
        "assets/styles/editor-classic.scss",
      ],

      "admin.css": [
        "assets/styles/admin.scss",
      ],

    }
  },

};
