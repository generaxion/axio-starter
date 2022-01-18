/* ==========================================================================
  core-table editor
========================================================================== */

/**
 * Modify style variants
 */
wp.domReady(() => {

  wp.blocks.unregisterBlockStyle('core/table', 'stripes');

});

/**
 * Modify alignment options
 */
wp.hooks.addFilter('blocks.registerBlockType', 'x/blockFilters', (settings, name) => {

  if (name === 'core/table') {
    return lodash.assign({}, settings, {
      supports: lodash.assign({}, settings.supports, {
        align: ['wide'],
      })
    });
  }
  return settings;

});
