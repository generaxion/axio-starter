/* ==========================================================================
  core-columns editor
========================================================================== */

/**
 * Modify alignment options
 */
wp.hooks.addFilter('blocks.registerBlockType', 'x/filters', (settings, name) => {

  if (name === 'core/columns') {
    return lodash.assign({}, settings, {
      supports: lodash.assign({}, settings.supports, {
        align: ['wide'],
      }),
    });
  }
  return settings;

});
