/* ==========================================================================
  core-columns editor
========================================================================== */

/**
 * Modify alignment options
 */
wp.hooks.addFilter('blocks.registerBlockType', 'x/blockFilters', (settings, name) => {

   wp.blocks.registerBlockStyle('core/columns', {
     name: 'background',
     label: wp.i18n.__('Background'),
  });

  if (name === 'core/columns') {
    return lodash.assign({}, settings, {
      supports: lodash.assign({}, settings.supports, {
        align: ['wide'],
      }),
    });
  }
  return settings;

});
