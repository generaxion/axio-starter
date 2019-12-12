/* ==========================================================================
  editor-gutenberg.js
========================================================================== */

/**
 * Modify style variants.
 */
wp.domReady(function() {

  // disable default variants
  wp.blocks.unregisterBlockStyle('core/button',     'outline');
  wp.blocks.unregisterBlockStyle('core/button',     'squared');
  wp.blocks.unregisterBlockStyle('core/image',      'circle-mask');
  wp.blocks.unregisterBlockStyle('core/quote',      'large');
  wp.blocks.unregisterBlockStyle('core/separator',  'dots');
  wp.blocks.unregisterBlockStyle('core/separator',  'wide');

  // add custom variants
  //  wp.blocks.registerBlockStyle('core/paragraph', {
  //    name: 'lead',
  //    label: 'Lead paragraph',
  //  });

});

/**
 * Modify alignment options
 */
wp.hooks.addFilter(
  'blocks.registerBlockType',
  'aucor-starter/filters',
  function(settings, name) {

    var align;

    switch(name) {

      case 'core/embed':
      case 'core-embed/facebook':
      case 'core-embed/flickr':
      case 'core-embed/instagram':
      case 'core-embed/soundcloud':
      case 'core-embed/spotify':
      case 'core-embed/twitter':
      case 'core/file':
      case 'core/freeform':
      case 'core/heading':
      case 'core/list':
      case 'core/paragraph':
      case 'core/quote':
      case 'core/separator':
        align = false;
        break;

      case 'core/button':
        align = ['center'];
        break;

      case 'core/columns':
      case 'core/gallery':
      case 'core/table':
      case 'core/embed/issuu':
      case 'core/embed/slideshare':
      case 'core/embed/vimeo':
      case 'core/embed/youtube':
        align = ['wide'];
        break;

      case 'core/group':
      case 'core/media-text':
        align = ['wide', 'full'];
        break;

      case 'core/image':
        align = ['left', 'center', 'right', 'wide'];
      break;

      default:
        return settings;

    }

    return lodash.assign({}, settings, {
      supports: lodash.assign({}, settings.supports, {
        align: align,
      }),
    });

  }
);

/**
 * Force default block classnames (ie. 'wp-block-list')
 */
wp.hooks.addFilter(
  'blocks.registerBlockType',
  'aucor-starter/filters',
  function (settings, name) {
    return lodash.assign({}, settings, {
      supports: lodash.assign({}, settings.supports, {
        className: true
      }),
    });
  }
);
