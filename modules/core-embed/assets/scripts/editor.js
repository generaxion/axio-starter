/* ==========================================================================
  core-embed(s) editor
========================================================================== */

/**
 * Modify alignment options
 */
wp.hooks.addFilter('blocks.registerBlockType', 'x/blockFilters', (settings, name) => {

  switch(name) {

    case 'core/embed':
    case 'core-embed/flickr':
    case 'core-embed/soundcloud':
    case 'core-embed/spotify':
    case 'core-embed/twitter':
      return lodash.assign({}, settings, {
        supports: lodash.assign({}, settings.supports, {
          align: false,
        })
      });

    case 'core/embed/issuu':
    case 'core/embed/slideshare':
    case 'core/embed/vimeo':
    case 'core/embed/youtube':
      return lodash.assign({}, settings, {
        supports: lodash.assign({}, settings.supports, {
          align: ['wide'],
        }),
        attributes: lodash.assign({}, settings.attributes, {
          align: lodash.assign({}, settings.attributes.align, {
            default: 'wide',
          })
        }),
      });

    default:
      return settings;

  }

});
