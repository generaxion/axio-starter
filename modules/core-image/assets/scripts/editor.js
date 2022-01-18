/* ==========================================================================
  core-image editor
========================================================================== */

/**
 * Modify style variants
 */
wp.domReady(() => {

  wp.blocks.unregisterBlockStyle('core/image', 'circle-mask');

});

/**
 * Modify alignment options
 */
wp.hooks.addFilter('blocks.registerBlockType', 'x/blockFilters', (settings, name) => {

  // @todo: restrict when bug fixed: https://github.com/WordPress/gutenberg/issues/19103
  // if (name === 'core/image') {
  //   return lodash.assign({}, settings, {
  //     supports: lodash.assign({}, settings.supports, {
  //       align: ['left', 'center', 'right', 'wide'],
  //     })
  //   });
  // }
  return settings;

});
