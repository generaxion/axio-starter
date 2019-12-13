/* ==========================================================================
  main.js
========================================================================== */

/**
 * Init menus
 */
var menus = document.querySelectorAll('.js-navigation');
for (var i = 0; i < menus.length; i++) {
  component_dropdown_menu({
    desktop_min_width: 890,
    menu: menus[i]
  });
}

/**
 * Init menu-toggles
 */
var menu_toggles = document.querySelectorAll('.js-menu-toggle');
for (var i = 0; i < menu_toggles.length; i++) {
  component_toggle(menu_toggles[i]);
}

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
