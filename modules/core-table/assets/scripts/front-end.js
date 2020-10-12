/**
 * Table front-end
 */

/**
 * Make tables responsive
 */
let responsive_tables_in_content = function() {

  const tables = document.querySelectorAll('.blocks .wp-block-table table');
  if (tables) {
    for (var i = 0; i < tables.length; i++) {

      // add modifier class to affected table
      tables[i].classList.add('wp-block-table--responsive');

      // create new wrapper
      var wrapper = document.createElement('div');

      // take all classes from table
      wrapper.setAttribute('class', tables[i].getAttribute('class'));

      // reset table classes
      tables[i].removeAttribute('class');

      // wrap the table
      tables[i].parentNode.insertBefore(wrapper, tables[i]);
      wrapper.appendChild(tables[i]);

    }
  }

};

document.addEventListener('DOMContentLoaded', () => {
  responsive_tables_in_content();
});
