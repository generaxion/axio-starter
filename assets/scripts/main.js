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
