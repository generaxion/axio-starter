/* ==========================================================================
  core-quote editor
========================================================================== */

/**
 * Modify style variants
 */
wp.domReady(() => {

  //  wp.blocks.registerBlockStyle('core/paragraph', {
  //    name: 'lead',
  //    label: 'Lead paragraph',
  //  });

});

/**
 * Modify alignment options
 */
wp.hooks.addFilter('blocks.registerBlockType', 'x/blockFilters', (settings, name) => {

  if (name === 'core/paragraph') {
    return lodash.assign({}, settings, {
      supports: lodash.assign({}, settings.supports, {
        align: false,
      })
    });
  }
  return settings;

});
