/**
 * Columns front-end
 */

/**
 * Add columns count classes to cloumn blocks like before: 'has-3-columns'
 */
 const addColumnCountClasses = function() {

  const columnBlocks = document.querySelectorAll('.wp-block-columns');
  if (columnBlocks.length) {
    for (let i = 0; i < columnBlocks.length; i++) {
      const columnBlock = columnBlocks[i];
      const columns = columnBlock.querySelectorAll('.wp-block-column');
      columnBlock.classList.add('has-' + columns.length + '-columns');
    }
  }

};
addColumnCountClasses();

/**
 * Add column type
 */
const addColumnTypeClasses = function() {

  const columnBlocks = document.querySelectorAll('.wp-block-column');
  if (columnBlocks.length) {
    for (let i = 0; i < columnBlocks.length; i++) {

      const columnBlock       = columnBlocks[i];
      const children          = columnBlock.querySelectorAll(':scope > *');
      const imageBlock        = columnBlock.querySelector('.wp-block-image');
      const listBlock         = columnBlock.querySelector('.wp-block-list');
      const backgroundBlock   = columnBlock.querySelector('.wp-block-acf-background');

      if (children.length == 0) {
        columnBlock.classList.add('is-empty-column');
      } else if (imageBlock && children.length == 1) {
        columnBlock.classList.add('is-image-column');
      } else if (listBlock && children.length == 1) {
        columnBlock.classList.add('is-list-column');
      } else if (backgroundBlock && children.length == 1) {
        columnBlock.classList.add('is-background-column');
      } else {
        columnBlock.classList.add('is-default-column');
      }

    }
  }

};
addColumnTypeClasses();
