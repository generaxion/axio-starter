/**
 * Project specific gulp configuration
 */

module.exports = {

  /**
   * URL for BrowserSync to mirror
   */
  devUrl: function() {
    return "https://aucor-starter.local";
  },

  /**
   * JS files
   *
   * "build-file-name.js": [
   *   "../node_modules/some-module/some-module.js",
   *   "scripts/cool-scripts.js"
   * ]
   */
  js: function() {
    return {

      // main js to be loaded in footer
      "main.js": [

        // polyfill for external x:link svg (https://github.com/Keyamoon/svgxuse)
        "../node_modules/svgxuse/svgxuse.js",

        // polyfill for object-fit
        "../node_modules/objectFitPolyfill/dist/objectFitPolyfill.min.js",

        // vanilla js version of fitvids, that makes iframe videos responsice (https://www.npmjs.com/package/fitvids)
        "../node_modules/fitvids/dist/fitvids.js",

        // lightweight lightbox script (https://github.com/rqrauhvmra/Tobi)
        "../node_modules/@rqrauhvmra/tobi/js/tobi.js",

        // project specific js
        "scripts/components/menu-primary.js",
        "scripts/components/markup-enhancements.js",
        "scripts/main.js"

      ],

      // critical js to be loaded in <head>
      "critical.js": [

        // library to lazyload images and iframes that have class "lazyload"
        "../node_modules/lazysizes/lazysizes.js",
        "../node_modules/lazysizes/plugins/aspectratio/ls.aspectratio.min.js",

        // project specific critical js
        "scripts/critical.js"

      ],

      // gutenberg editor specific js
      "editor-gutenberg.js": [

        "scripts/editor-gutenberg.js"

      ]

    }
  },

  /**
   * CSS files
   *
   * "build-file-name.css": [
   *   "../node_modules/some-module/some-module.css",
   *   "styles/main.scss"
   * ]
   */
  css: function() {
    return {

      "main.css": [
        "styles/main.scss"
      ],

      "editor-gutenberg.css": [
        "styles/editor-gutenberg.scss"
      ],

      "editor-classic.css": [
        "styles/editor-classic.scss"
      ],

      "admin.css": [
        "styles/admin.scss"
      ],

      "wp-login.css": [
        "styles/wp-login.scss"
      ]

    }
  }

};
