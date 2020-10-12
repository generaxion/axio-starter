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
const init_lightboxes_in_content = () => {
  var imgItems = document.querySelectorAll('.blocks-gallery-item > figure > a, .gallery-item > .gallery-icon > a, .wp-block-image a, p > a > img, p > a > .wp-block-image');
  // if found, add .lightbox class that Tobi uses as selector to the items
  if (imgItems.length) {
    imgItems.forEach(function(item) {
      var formats = ['.jpg', '.png', '.jpeg', '.gif'];
      // check (3 first selectors) href to verify media link
      if (item.href) {
        if (formats.some(el => item.href.includes(el))) {
          item.classList.add('lightbox');
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
        if (formats.some(el => item.parentNode.href.includes(el))) {
          item.parentNode.classList.add('lightbox');
        }
      }
    });
  }
};
init_lightboxes_in_content();

/**
 * Init lightbox
 */
if (document.querySelectorAll('.lightbox').length) {
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
