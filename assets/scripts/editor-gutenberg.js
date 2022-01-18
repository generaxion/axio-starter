/* ==========================================================================
  editor-gutenberg.js
========================================================================== */

'use strict';
/* global wp, lodash */

/**
 * Modify featured image size
 */
wp.hooks.addFilter(
  'editor.PostFeaturedImage.imageSize',
  'x/featured-image-size',
  (size, attachment_id, post_id) => 'medium'
);

/**
 * Force default block classnames (ie. 'wp-block-list')
 */
wp.hooks.addFilter(
  'blocks.registerBlockType',
  'x/blockFilters',
  (settings, name) => {

    // skip block types without wrapper or have known issues
    const skip_blocks = [
      'core/html',
      'core/shortcode',
      'core/block',
      'core/file',
    ];
    if (skip_blocks.indexOf(name) !== -1) {
      return settings;
    }

    return lodash.assign({}, settings, {
      supports: lodash.assign({}, settings.supports, {
        className: true
      }),
    });
  }
);
