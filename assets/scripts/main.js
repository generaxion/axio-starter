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
 * Default lightbox (Tobi.js) support for native gallery.
 * Requires link to media file from gallery settings.
 */
// try to find gallery items (a-tags with the link to the media file), both gutenberg and classic editor
var wpGallery = document.querySelectorAll('.blocks-gallery-item figure a, .gallery-item .gallery-icon a');
// if found, add .lightbox class, that Tobi uses as selector, to the items
if (wpGallery.length) {
  wpGallery.forEach(function(item) {
    item.classList.add('lightbox');
  });
  // init Tobi
  try {
    const tobi = new Tobi();
  } catch (e) {
    console.log(e);
  }
}
