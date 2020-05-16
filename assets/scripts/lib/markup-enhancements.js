/**
 * Content markup enhancements
 */

/**
 * Add identifiers for first and last block
 */
let tag_first_and_last_block = function() {

  let gutenberg_content = document.querySelector('.wysiwyg');
  if (gutenberg_content) {
    for (let i = 0; i < gutenberg_content.childNodes.length; i++) {
      if (gutenberg_content.childNodes[i].nodeType !== 3 && gutenberg_content.childNodes[i].classList !== "undefined") {
        gutenberg_content.childNodes[i].classList.add('is-first-block');
        break;
      }
    }
    for (let i = (gutenberg_content.childNodes.length - 1); i >= 0; i--) {
      if (gutenberg_content.childNodes[i].nodeType !== 3 && gutenberg_content.childNodes[i].classList !== "undefined") {
        gutenberg_content.childNodes[i].classList.add('is-last-block');
        break;
      }
    }
  }

}


/**
 * Make tables responsive
 */
let responsive_tables_in_content = function() {

  const tables = document.querySelectorAll('.wysiwyg .wp-block-table table');
  if (tables) {
    for (var i = 0; i < tables.length; i++) {

      // add modifier class to affected table
      tables[i].classList.add('wp-block-table--responsive');

      // create new wrapper
      var wrapper = document.createElement('div');

      // take all classes from table
      wrapper.setAttribute('class', tables[i].getAttribute('class'));

      // reset table classes
      tables[i].removeAttribute('class');

      // wrap the table
      tables[i].parentNode.insertBefore(wrapper, tables[i]);
      wrapper.appendChild(tables[i]);

    }
  }

};

/**
 * Classic Editor image markup "polyfill"
 *
 * Wrap old images with captions to make alignment work and markup fit Gutenberg style
 * <figure class="wp-caption"><img></figure> => <div class="wp-block-image"><figure class="wp-caption"><img></figure></div>
 */
let wrap_old_images_with_caption = function() {
  let figures = document.querySelectorAll('.wysiwyg .wp-caption');
  if (figures.length) {
    for (let i = 0; i < figures.length; i++) {
      if (!figures[i].parentNode.classList.contains('wp-block-image')) {
        let wrapper = document.createElement('div');
        wrapper.setAttribute('class', 'wp-block-image');
        figures[i].parentNode.insertBefore(wrapper, figures[i]);
        wrapper.appendChild(figures[i]);
      }
    }
  }
};
wrap_old_images_with_caption();

/**
 * Classic Editor aligned image markup "polyfill"
 *
 * Wrap old aligned images without caption to make markup fit Gutenberg style
 * <p><img class="alignleft">Text<p> => <div class="wp-block-image"><figure class="alignleft"><img></figure></div><p>Text</p>
 */
let wrap_old_aligned_images = function() {
  let aligned_parent;
  let aligned = document.querySelectorAll('.wysiwyg img.alignleft, .wysiwyg img.alignright');
  if (aligned.length) {
    for (var i = 0; i < aligned.length; i++) {

      // save references
      aligned_parent = aligned[i].parentNode;

      // if parent is paragraph, unwrap
      if (aligned_parent.nodeName === 'P') {
        aligned_parent.parentNode.insertBefore(aligned[i], aligned_parent);
        // remove paragraph if its now empty
        if (aligned_parent.childNodes.length === 0) {
          aligned_parent.parentNode.removeChild(aligned_parent);
        }
      }

      // find and remove alignment from img
      var alignment = (aligned[i].classList.contains('alignleft')) ? 'alignleft' : 'alignright';
      aligned[i].classList.remove(alignment);

      // wrap with figure
      var figure = document.createElement('figure');
      figure.setAttribute('class', alignment);
      aligned[i].parentNode.insertBefore(figure, aligned[i]);
      figure.appendChild(aligned[i]);

      // wrap with .wp-block-image
      var div = document.createElement('div');
      div.setAttribute('class', 'wp-block-image');
      figure.parentNode.insertBefore(div, figure);
      div.appendChild(figure);

    }
  }
};
wrap_old_aligned_images();

/**
 * Add body class .has-no-hero-background
 */
var body_hero_background_indicator = function() {

  if (document.querySelector('.hero--no-background')) {
    document.body.classList.add('has-no-hero-background');
  }

};
body_hero_background_indicator();

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
let init_lightboxes_in_content = function() {
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
}


/**
 * Run
 */
document.addEventListener('DOMContentLoaded', function() {
  tag_first_and_last_block();
  responsive_tables_in_content();
  wrap_old_images_with_caption();
  wrap_old_aligned_images();
  body_hero_background_indicator();
  init_lightboxes_in_content();
});
