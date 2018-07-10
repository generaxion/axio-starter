/* ==========================================================================
  critical.js
========================================================================== */

/**
 * Before lazyloaded image is loaded
 */
document.addEventListener('lazybeforeunveil', function(e){

  // current <img> element
  var el = e.target;

  /**
   * Hide possible pre-load image when current image is loaded:
   * <img class="lazyload"> <-- actual image
   * <img class="lazyload-preload"> <-- preload image
   */
  el.addEventListener('load', function() {
    // when loaded, animate blurry version
    var sibling = el.nextSibling;
    if (sibling.nodeType === 1 && sibling !== el && sibling && sibling !== null && sibling !== undefined) {
      if (typeof sibling.classList.contains !== "undefined") {
        if (sibling.classList.contains('lazyload-preload')) {
          sibling.classList.add('lazyload-preload--ready');
        }
      } else {
        // legacy browser, skip logic
        sibling.classList.add('lazyload-preload--ready');
      }

    }

  });

});

