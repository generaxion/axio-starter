/**
 * Mobile menu
 */
var component_mobile_menu = function(args) {

  // setup args
  var menu     = args.menu,
      site     = args.site,
      toggles  = args.toggles;

  // validate
  if (!menu || !site || !toggles.length) {
    console.log('Invalid mobile_menu args');
    return;
  }

  // setup a11y dialog
  var dialog = new A11yDialog(menu, site);

  // tasks to open menu visually
  var open_menu = function() {

   document.body.classList.add('is-active-menu');

  };

  // tasks to close menu visually
  var close_menu = function() {

    document.body.classList.add('is-closing-menu');
    setTimeout(function(){
      document.body.classList.remove('is-active-menu');
      document.body.classList.remove('is-closing-menu');
     }, 200);

  };

  // hooks
  dialog.on('show', function (element, event) {
    open_menu();
  });
  dialog.on('hide', function (element, event) {
    close_menu();
  });


  // toggle click
  var handle_toggle = function(e) {
    if (document.body.classList.contains('is-active-menu')) {
       dialog.hide();
    } else {
      dialog.show();
    }
  };

  for (var i = 0; i < toggles.length; i++) {
    toggles[i].addEventListener('click', handle_toggle, false);
  }

  // make the call chainable
  return this;

};

/**
 * Init mobile menu
 */
component_mobile_menu({
  menu:     document.querySelector('.js-mobile-menu'),
  site:     document.querySelector('.js-page'),
  toggles:  document.querySelectorAll('.js-menu-toggle')
});

