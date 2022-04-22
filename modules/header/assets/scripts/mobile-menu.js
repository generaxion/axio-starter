/**
 * Mobile menu
 */
const componentMobileMenu = (args) => {

  // setup args
  let menu     = args.menu;
  let site     = args.site;
  let toggles  = args.toggles;

  // validate
  if (!menu || !site || !toggles.length) {
    console.log('Invalid mobile_menu args');
    return;
  }

  // setup a11y dialog
  const dialog = new A11yDialog(menu, site);

  // tasks to open menu visually
  const openMenu = () => {
   document.body.classList.add('is-active-menu');
  };

  // tasks to close menu visually
  const closeMenu = () => {

    document.body.classList.add('is-closing-menu');
    setTimeout(() => {
      document.body.classList.remove('is-active-menu');
      document.body.classList.remove('is-closing-menu');
     }, 200);

  };

  // hooks
  dialog.on('show', (element, event) => {
    openMenu();
  });
  dialog.on('hide', (element, event) => {
    closeMenu();
  });

  // toggle click
  const handleToggle = (e) => {
    if (document.body.classList.contains('is-active-menu')) {
       dialog.hide();
    } else {
      dialog.show();
    }
  };

  // close on anchor link
  const anchorLinks = menu.querySelectorAll('a[href*="#"]');
  for (let i = 0; i < anchorLinks.length; i++) {
    if (anchorLinks[i].getAttribute('href') !== '#') {
      anchorLinks[i].addEventListener('click', (e) => {
        dialog.hide();
      });
    }
  }

  for (let i = 0; i < toggles.length; i++) {
    toggles[i].addEventListener('click', handleToggle, false);
  }

  // make the call chainable
  return this;

};

/**
 * Init mobile menu
 */
componentMobileMenu({
  menu:     document.querySelector('.js-mobile-menu'),
  site:     document.querySelector('.js-page'),
  toggles:  document.querySelectorAll('.js-menu-toggle')
});

