/* ==========================================================================
  editor.js
========================================================================== */

/**
 * Modify style variants.
 */
wp.domReady(function() {

  // remove button styles
  wp.blocks.unregisterBlockStyle('core/button', 'default');
  wp.blocks.unregisterBlockStyle('core/button', 'outline');
  wp.blocks.unregisterBlockStyle('core/button', 'squared');

  // remove separator styles
  wp.blocks.unregisterBlockStyle('core/separator', 'dots');

//  // add lead paragraph style
//  wp.blocks.registerBlockStyle('core/paragraph', {
//    name: 'lead',
//    label: 'Lead paragraph',
//  });

});
