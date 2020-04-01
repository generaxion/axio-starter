/* ==========================================================================
  main.js
========================================================================== */

/**
 * Init dropdown-menus
 */
var dropdown_menus = document.querySelectorAll('.js-navigation');
for (var i = 0; i < dropdown_menus.length; i++) {
  component_dropdown_menu({
    desktop_min_width: 890,
    menu: dropdown_menus[i]
  });
}

/**
 * Init mobile menu
 */
component_mobile_menu({
  menu:     document.querySelector('.js-mobile-menu'),
  site:     document.querySelector('.js-page'),
  toggles:  document.querySelectorAll('.js-menu-toggle')
});

/**
 * Init Responsive videos
 */
fitvids();

/**
 * Init polyfill object-fit for lazyloaded
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
