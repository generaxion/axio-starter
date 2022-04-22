/**
 * Dropdown menu
 *
 * Timer for hover exit: better usability
 * Works with keyboard: a11y
 * Desktop menu with touch: doubletap
 * Mobile menu with touch
 * Works at least with 3 levels (probably more)
 */
const componentDropdownMenu = (args) => {

  // setup args
  let menu = args.menu;
  let menuType = args.type;
  let hoverTimeout;

  // validate
  if (!menu) {
    console.log('Invalid drop-down menu');
    return;
  }

  /**
   * Helper: Get all ancestors
   */
  const getAllAncestors = (item, css_class) => {

    let result = [];
    let ancestor = item.parentElement;
    while (ancestor && !ancestor.isEqualNode(menu)) {
      if (ancestor.classList.contains(css_class)) {
        result.push(ancestor);
      }
      ancestor = ancestor.parentElement;
    }
    return result;

  };

  /**
   * Helper: Get closest ancestor
   */
  const getAncestor = (item, css_class) => {

    const result = getAllAncestors(item, css_class);
    if (result.length) {
      return result[0];
    }
    return null;

  };

  /**
   * Helper: Is element inside menu
   */
  const isElementInsideMenu = (el) => {

    while ((el = el.parentElement) !== null) {
      if (el.nodeType !== Node.ELEMENT_NODE) {
        continue;
      }
      if (el.isEqualNode(menu)) {
        return true;
      }
    }
    return false;

  };

  /**
   * Helper: Is desktop menu
   *
   * Checks if window is wider than set desktop limit.
   *
   * @return bool is desktop width screen
   */
  const isDesktopMenu = () => {

    if (menuType === 'mobile') {
      return false;
    }
    return true;

  };

   /**
    * Helper: Show menu item children <li class="menu-item-has-children">
    */
   const activateMenuItem = (li) => {

    // validate
    if (!li) {
      return;
    }

    // actiate <ul>
    const ul = li.querySelector('.sub-menu');
    if (ul) {
      // acticate <li>
      li.setAttribute('aria-expanded', 'true');

      ul.setAttribute('aria-hidden', 'false');
      // check that <ul> fits viewport
      if (ul.getBoundingClientRect().right > (window.innerWidth || document.documentElement.clientWidth)) {
        ul.classList.add('is-out-of-bounds');
      }
    }

    // activate parents <li> + <ul>
    const ancestors = getAllAncestors(li, 'menu-item-has-children');
    for (let i = 0; i < ancestors.length; i++) {
      activateMenuItem(ancestors[i]);
    }

  };

   /**
    * Helper: Hide menu item children <li class="menu-item-has-children">
    */
   function deactivateMenuItem(li) {

    // validate
    if (!li) {
      return;
    }

    li.classList.remove('is-clicked');

    // deactivate <ul>
    const ul = li.querySelector('.sub-menu');
    if (ul) {
      // deactivate <li>
      li.setAttribute('aria-expanded', 'false');

      ul.setAttribute('aria-hidden', 'true');
      ul.classList.remove('is-out-of-bounds');
    }

    // deactivate children <li> + <ul>
    const children = li.querySelectorAll('.menu-item-has-children');
    for (let i = 0; i < children.length; i++) {
      deactivateMenuItem(children[i]);
    }

  }

  /**
   * Helper: Toggle menu item
   */
  const toggleMenuItem = (li) => {

    if (li) {
      if (li.getAttribute('aria-expanded') === 'false') {
        activateMenuItem(li);
      } else {
        deactivateMenuItem(li);
      }
    }

  };

  /**
   * Helper: Reset all menu-items' state
   */
  const resetMenuItems = () => {

    const items_with_children = menu.querySelectorAll('.menu-item-has-children');
    for (let i = 0; i < items_with_children.length; i++) {
      deactivateMenuItem(items_with_children[i]);
      items_with_children[i].classList.remove('is-tapped');
    }

  };

  /**
   * Event: Handle mouse enter hover
   */
  const menuItemMouseEnter = (e) => {

    if (isDesktopMenu()) {

      // clear any previously set closing timeout
      clearTimeout(hoverTimeout);

      // deactivate all <li> that are not part of this DOM tree
      const ancestors = getAllAncestors(e.currentTarget, 'menu-item-has-children');
      const li_with_children = menu.querySelectorAll('.menu-item-has-children');
      for (let j = 0; j < li_with_children.length; j++) {
        if (li_with_children[j] !== e.currentTarget && ancestors.indexOf(li_with_children[j]) === -1) {
          deactivateMenuItem(li_with_children[j]);
        }
      }

      // activate hovered <li>
      activateMenuItem(e.currentTarget);

    }

  };

  /**
   * Event: Handle mouseleave hover
   *
   * Close menu when hover timer has ended (only for desktop menus)
   */
  const menuItemMouseLeave = (e) => {

    // delay closing for more natural hover
    if (isDesktopMenu()) {
      hoverTimeout = setTimeout(function(li) {
        deactivateMenuItem(li);
      }, 750, e.currentTarget);
    }

  };

  /**
   * Event: Dropdown caret clicked
   *
   * Open sub-menu and change caret state
   */
  const caretClickEvent = (e) => {

    // activate or deactivate <li>
    toggleMenuItem(getAncestor(e.currentTarget, 'menu-item-has-children'));

    // don't trigger parent(s)
    e.stopPropagation();

  };

   /**
    * Event: Click on empty link (a[href="#"])
    */
   const emptyLinkClickEvent = (e) => {

    // cancel default action
    e.preventDefault();

    // activate or deactivate <li>
    const li = getAncestor(e.currentTarget, 'menu-item-has-children');
    if (li) {
      if (li.classList.contains('is-clicked')) {
        deactivateMenuItem(li);
        li.classList.remove('is-clicked');
      } else {
        activateMenuItem(li);
        li.classList.add('is-clicked');
      }
    }

  };

  /**
   * Event: Touch outside menu after menu has been opened with single tap
   *
   * Closes menus if touch is outside of menus
   */
  const outsideMenuTouchEvent = (e) => {

    // if the target of the tap isn't menu nor a descendant of menu
    if (isDesktopMenu() && !isElementInsideMenu(e.currentTarget)) {
      resetMenuItems();
    }

    // remove this event listener
    document.removeEventListener('ontouchstart', outsideMenuTouchEvent, false);

  };

  /**
   * Event: Menu item parent a touched
   *
   * In desktop mode, open sub-menu with first click and navigate
   * only when doubletapped
   */
  const menuItemParentLinkTouch = (e) => {

    if (!isDesktopMenu()) {
      return;
    }

    const li = getAncestor(e.currentTarget, 'menu-item-has-children');

    if (!li.classList.contains('is-tapped')) {

      // first tap: don't go to <a> yet
      e.preventDefault();

      // remove .tapped class and close all <li> that don't belong to this DOM tree
      const ancestors = getAllAncestors(e.currentTarget, 'menu-item-has-children');
      const li_with_children = menu.querySelectorAll('.menu-item-has-children');
      for (let j = 0; j < li_with_children.length; j++) {
        if (li_with_children[j] !== e.currentTarget && ancestors.indexOf(li_with_children[j]) === -1) {
          li_with_children[j].classList.remove('is-tapped');
          deactivateMenuItem(li_with_children[j]);
        }
      }

      // add .tapped class and activate <li>
      li.classList.add('is-tapped');
      activateMenuItem(li);

      // add event listener to click outside menu
      document.addEventListener('touchstart', outsideMenuTouchEvent, {passive: true});

    }

   };

  /**
   * Init
   */
  const initDropdownMenu = () => {

    // close all menus
    resetMenuItems();

    // setup hover hooks (menu-item)
    const menuItems = menu.querySelectorAll('.menu-item');
    for (let j = 0; j < menuItems.length; j++) {
      menuItems[j].addEventListener('mouseenter', menuItemMouseEnter);
      menuItems[j].addEventListener('mouseleave', menuItemMouseLeave);
    }

    // setup click hooks (carets)
    const menuCarets = menu.querySelectorAll('.js-menu-caret');
    for (let k = 0; k < menuCarets.length; k++) {
      menuCarets[k].addEventListener('click', caretClickEvent);
    }

    // setup click hooks (empty links)
    const emptyLinks = menu.querySelectorAll('a[href="#"]');
    for (let l = 0; l < emptyLinks.length; l++) {
      emptyLinks[l].addEventListener('click', emptyLinkClickEvent);
    }

    // setup touch hooks (parent menu-item a)
    const submenuParentLinks = menu.querySelectorAll('.menu-item-has-children a');
    for (let m = 0; m < submenuParentLinks.length; m++) {
      submenuParentLinks[m].addEventListener('touchstart', menuItemParentLinkTouch, {passive: true});
    }

    // open current-menu-item parent if inside mobile-menu
    const isInsideMobileMenuContainer = getAncestor(menu, 'js-mobile-menu');
    if (isInsideMobileMenuContainer) {
      const currentMenuItem = menu.querySelector('.current-menu-item');
      if (currentMenuItem) {
        const currentMenuItemParents = getAllAncestors(currentMenuItem, 'menu-item-has-children');
        for (let n = 0; n < currentMenuItemParents.length; n++) {
          activateMenuItem(currentMenuItemParents[n]);
        }
      }
    }

  };
  initDropdownMenu();

  // make the call chainable
  return this;

};

/**
 * Init dropdown-menus
 */
const dropdownMenus = document.querySelectorAll('.js-navigation');
for (let i = 0; i < dropdownMenus.length; i++) {
  componentDropdownMenu({
    menu: dropdownMenus[i],
    type: dropdownMenus[i].getAttribute('data-navigation-type') === 'mobile' ? 'mobile' : 'desktop'
  });
}
