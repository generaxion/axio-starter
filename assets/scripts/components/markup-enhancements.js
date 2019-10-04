/**
 * Content markup enhancements
 */

/**
 * Make tables responsive
 */
var responsive_tables_in_content = function() {

  var tables = document.querySelectorAll('.wysiwyg .wp-block-table');
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
responsive_tables_in_content();

/**
 * Classic Editor image markup "polyfill"
 *
 * Wrap old images with captions to make alignment work and markup fit Gutenberg style
 * <figure class="wp-caption"><img></figure> => <div class="wp-block-image"><figure class="wp-caption"><img></figure></div>
 */
var wrap_old_images_with_caption = function() {
  var figures = document.querySelectorAll('.wysiwyg .wp-caption');
  if (figures.length) {
    for (i = 0; i < figures.length; i++) {
      if (!figures[i].parentNode.classList.contains('wp-block-image')) {
        var wrapper = document.createElement('div');
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
var wrap_old_aligned_images = function() {
  var aligned_parent;
  var aligned = document.querySelectorAll('.wysiwyg img.alignleft, .wysiwyg img.alignright');
  if (aligned.length) {
    for (i = 0; i < aligned.length; i++) {

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
