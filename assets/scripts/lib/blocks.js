/**
 * Blocks
 */

/**
 * Add identifiers for first and last block
 */
const tagFirstAndLastBlock = () => {

  let blocks = document.querySelector('.blocks');
  if (blocks) {
    for (let i = 0; i < blocks.childNodes.length; i++) {
      if (blocks.childNodes[i].nodeType !== 3 && typeof blocks.childNodes[i].classList !== "undefined") {
        blocks.childNodes[i].classList.add('is-first-block');
        break;
      }
    }
    for (let i = (blocks.childNodes.length - 1); i >= 0; i--) {
      if (blocks.childNodes[i].nodeType !== 3 && typeof blocks.childNodes[i].classList !== "undefined") {
        blocks.childNodes[i].classList.add('is-last-block');
        break;
      }
    }
  }

  let innerBlocks = document.querySelectorAll('.inner-blocks');
  if (innerBlocks.length) {
    for (let i = 0; i < innerBlocks.length; i++) {
      for (let j = 0; j < innerBlocks[i].childNodes.length; j++) {
        if (innerBlocks[i].childNodes[j].nodeType !== 3 && typeof innerBlocks[i].childNodes[j].classList !== "undefined") {
          innerBlocks[i].childNodes[j].classList.add('is-first-inner-block');
          break;
        }
      }
      for (let j = (innerBlocks[i].childNodes.length - 1); j >= 0; j--) {
        if (innerBlocks[i].childNodes[j].nodeType !== 3 && typeof innerBlocks[i].childNodes[j].classList !== "undefined") {
          innerBlocks[i].childNodes[j].classList.add('is-last-inner-block');
          break;
        }
      }
    }
  }

};
tagFirstAndLastBlock();

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
