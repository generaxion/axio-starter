/**
 * Project specific gulp configuration
 */

module.exports = {

  /**
   * URL for BrowserSync to mirror
   */
  devUrl: function() {
    return "https://aucor_starter.local";
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

        // project specific js
        "scripts/components/navigation.js",
        "scripts/main.js"

      ],

      // critical js to be loaded in <head>
      "critical.js": [

        // library to lazyload images and iframes that have class "lazyload"
        "../node_modules/lazysizes/lazysizes.min.js",

        // project specific critical js
        "scripts/critical.js"

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

      "admin.css": [
        "styles/admin.scss"
      ],

      "editor.css": [
        "styles/editor.scss"
      ],

      "wp-login.css": [
        "styles/wp-login.scss"
      ]

    }
  }

};
