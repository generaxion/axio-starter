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
  el.addEventListener('load', function(e) {
    var preload = this.parentNode.querySelector('.lazyload-preload');
    if (preload) {
      preload.classList.add('lazyload-preload--ready');
    }
  });

});
