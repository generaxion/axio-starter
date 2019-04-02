/**
 * Synchronize Gutenberg and Classic Editor front-end markup
 *
 * Gutenberg has some differences in HTML markup. Add these
 * new things to old markup.
 */

/**
 * Wrap old images with captions to make alignment work and markup fit Gutenberg style
 *
 * <figure class="wp-caption"><img></figure> => <div class="wp-block-image"><figure class="wp-caption"><img></figure></div>
 */
function wrap_old_images_with_caption() {
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
}
wrap_old_images_with_caption();

/**
 * Wrap old aligned images without caption to make markup fit Gutenberg style
 *
 * <p><img class="alignleft">Text<p> => <div class="wp-block-image"><figure class="alignleft"><img></figure></div><p>Text</p>
 */
function wrap_old_aligned_images() {
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
}
wrap_old_aligned_images();
