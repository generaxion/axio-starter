/* ==========================================================================
  main.js
========================================================================== */

/**
 * Init Responsive videos
 */
fitvids();

/**
 * Init polyfill object-fit for lazyloaded
 */
if (typeof objectFitPolyfill === "function") {
  objectFitPolyfill();
}

/**
 * Init lightbox
 */
if (document.querySelectorAll('.lightbox').length) {
  try {
    new Tobi({
      // variables from script localization in register-assets.php
      navLabel: [theme_strings.prev, theme_strings.next],
      closeLabel: theme_strings.close,
      loadingIndicatorLabel: theme_strings.loading,
      captionsSelector: 'self',
      captionAttribute: 'data-caption',
      zoom: false,
    });
  } catch (e) {
    console.log(e);
  }
}
