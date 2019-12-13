/**
 * Toggle button
 */

var component_toggle = function(toggle) {

  toggle.addEventListener('click', function() {

    var all_toggles = document.querySelectorAll('.js-menu-toggle');


    if (toggle.classList.contains('menu-toggle--active')) {

      // remove .active class from hamburger icon
      for (var i = 0; i < all_toggles.length; i++) {
        all_toggles[i].classList.remove('menu-toggle--active');
      }

      // remove .active class to menu container
      document.body.classList.remove('is-active-menu');

      // focus out of the menu
      toggle.dispatchEvent(new Event('focus'));

    } else {

      // remove .active class from hamburger icon
      for (var i = 0; i < all_toggles.length; i++) {
        all_toggles[i].classList.add('menu-toggle--active');
      }

      // .active class to menu container
      document.body.classList.add('is-active-menu');
    }
  });

  // make the call chainable
  return this;

};
