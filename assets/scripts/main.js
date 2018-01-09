/* ==========================================================================
  main.js
========================================================================== */

// navigation
aucor_navigation(document.getElementById('primary-navigation'), {
  desktop_min_width: 501, // min width in pixels
  menu_toggle: '#menu-toggle' // selector for toggle
});

// responsive videos
fitvids();


// add jquery as dependency in functions.php and uncomment the following if you need jquery
//
// (function($) {
//   $(document).ready(function(){
//
//   });
// })(jQuery);

