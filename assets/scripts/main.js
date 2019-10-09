/* ==========================================================================
  main.js
========================================================================== */

/**
 * Primary menu
 */
var primary_menu = component_primary_menu({
  desktop_min_width: 890,
  menu: '.primary-navigation',
  menu_toggle: '#menu-toggle'
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
    objectFitPolyfill();
    e.target.addEventListener('load', function() {
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
