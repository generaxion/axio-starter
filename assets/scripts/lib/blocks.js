/**
 * Blocks
 */

/**
 * Add identifiers for first and last block
 */
const tagFirstAndLastBlock = () => {

  let gutenbergContent = document.querySelector('.wysiwyg');
  if (gutenbergContent) {
    for (let i = 0; i < gutenbergContent.childNodes.length; i++) {
      if (gutenbergContent.childNodes[i].nodeType !== 3 && gutenbergContent.childNodes[i].classList !== "undefined") {
        gutenbergContent.childNodes[i].classList.add('is-first-block');
        break;
      }
    }
    for (let i = (gutenbergContent.childNodes.length - 1); i >= 0; i--) {
      if (gutenbergContent.childNodes[i].nodeType !== 3 && gutenbergContent.childNodes[i].classList !== "undefined") {
        gutenbergContent.childNodes[i].classList.add('is-last-block');
        break;
      }
    }
  }

};
tagFirstAndLastBlock();
