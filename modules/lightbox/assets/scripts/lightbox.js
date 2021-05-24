/**
 * Lightbox (Tobi.js) support for native gallery and images
 * Requires link to media file from gallery/image settings.
 *
 * Try to find the a-tag parents to the images (the img-tag itself with the last two selectors), both gutenberg and classic editor.
 * Selectors:
 *   gutenberg gallery,
 *   classic gallery,
 *   gutenberg images AND classic images with caption,
 *   classic images without caption and with no or center align,
 *   classic images without caption and with left or right align
 */
const lightboxesInContent = () => {
  var imgItems = document.querySelectorAll('.blocks-gallery-item > figure > a, .gallery-item > .gallery-icon > a, .wp-block-image a, p > a > img, p > a > .wp-block-image');
  // if found, add .lightbox class that Tobi uses as selector to the items
  if (imgItems.length) {
    for (let i = 0; i < imgItems.length; i++) {
      let item = imgItems[i];
      var formats = ['.jpg', '.png', '.jpeg', '.gif'];
      // check (3 first selectors) href to verify media link
      if (item.href) {
        for (let j = 0; j < formats.length; j++) {
          if (item.href.includes(formats[j])) {
            item.classList.add('lightbox');
          }
        }
        // check for figcaption (images and gutenberg gallery) and add it to a data attribute
        if (item.nextElementSibling) {
          if (item.nextElementSibling.nodeName.toLowerCase() === 'figcaption') {
            item.dataset.caption = item.nextElementSibling.innerText;
          }
        } else if (item.parentNode.nextElementSibling) { // classic gallery
          if (item.parentNode.nextElementSibling.nodeName.toLowerCase() === 'figcaption') {
            item.dataset.caption = item.parentNode.nextElementSibling.innerText;
          }
        }
      } else if (item.parentNode.href) { // check (2 last selectors) href to verify media link
        for (let j = 0; j < formats.length; j++) {
          if (item.parentNode.href.includes(formats[j])) {
            item.parentNode.classList.add('lightbox');
          }
        }
      }
    }
  }
};
lightboxesInContent();

/**
 * Init lightbox
 */
document.addEventListener('DOMContentLoaded', () => {
  if (document.querySelectorAll('.lightbox').length > 0) {
    try {
      new Tobi({
        navLabel: [theme_strings_lightbox.prev, theme_strings_lightbox.next],
        closeLabel: theme_strings_lightbox.close,
        loadingIndicatorLabel: theme_strings_lightbox.loading,
        captionsSelector: 'self',
        captionAttribute: 'data-caption',
        zoom: false,
      });
    } catch (e) {
      console.log(e);
    }
  }
});
