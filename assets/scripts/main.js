/* ==========================================================================
  main.js
========================================================================== */

/**
 * Navigation
 */
aucor_navigation(document.getElementById('primary-navigation'), {
  desktop_min_width: 890, // min width in pixels
  menu_toggle: '#menu-toggle' // selector for toggle
});

/**
 * Responsive videos
 */
fitvids();

/**
 * Polyfill object-fit for lazyloaded
 */
if (typeof objectFitPolyfill === "function") {
  document.addEventListener('lazybeforeunveil', function(e){

    // current <img> element
    var el = e.target;

    objectFitPolyfill();
    el.addEventListener('load', function() {
      objectFitPolyfill();
    });

  });
}

/**
 * Lightbox
 */
if(document.querySelectorAll('.lightbox').length) {
  // init Tobi
  try {
    const tobi = new Tobi({
      // variables from script localization in register-assets.php
      navLabel: [aucor_starter_strings.prev, aucor_starter_strings.next],
      closeLabel: aucor_starter_strings.close,
      loadingIndicatorLabel: aucor_starter_strings.loading,
      captionsSelector: 'self',
      captionAttribute: 'data-caption',
      zoom: false,
  });
  } catch (e) {
    console.log(e);
  }
}
