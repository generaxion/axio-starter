/* ==========================================================================
  core-separator editor
========================================================================== */

/**
 * Modify style variants
 */
wp.domReady(() => {

  wp.blocks.unregisterBlockStyle('core/separator', 'dots');
  wp.blocks.unregisterBlockStyle('core/separator', 'wide');

});

/**
 * Modify alignment options
 */
wp.hooks.addFilter('blocks.registerBlockType', 'aucor-starter/filters', (settings, name) => {

  if (name === 'core/separator') {
    return lodash.assign({}, settings, {
      supports: lodash.assign({}, settings.supports, {
        align: false,
      })
    });
  }
  return settings;

});
