/* ==========================================================================
  main.js
========================================================================== */

/**
 * Primary menu
 */
var primary_menu = component_primary_menu({
  desktop_min_width: 890,
  menu_container: '.primary-navigation',
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
