/* ==========================================================================
  main.js
========================================================================== */

/**
 * Navigation
 */
aucor_navigation(document.getElementById('primary-navigation'), {
  desktop_min_width: 501, // min width in pixels
  menu_toggle: '#menu-toggle' // selector for toggle
});

/**
 * Responsive videos
 */
fitvids();


// add jquery as dependency in functions.php and uncomment the following if you need jquery
//
// (function($) {
//   $(document).ready(function(){
//
//   });
// })(jQuery);

/**
 * Polyfill object-fit for lazyloaded
 */
if (typeof objectFitPolyfill === "function") {
  document.addEventListener('lazybeforeunveil', function(e){
    objectFitPolyfill();
    el.addEventListener('load', function() {
      objectFitPolyfill();
    });
  });
}
