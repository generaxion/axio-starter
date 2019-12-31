/**
 * Dropdown menu

 * Timer for hover exit: better usability
 * Works with keyboard: a11y
 * Desktop menu with touch: doubletap
 * Mobile menu with touch
 * Works at least with 3 levels (probably more)
 */
var component_dropdown_menu = function(args) {

  // setup args
  var desktop_min_width = args.desktop_min_width, // match this to $menu-visible SASS variable
      menu              = args.menu,
      screen_w,
      hover_timeout;

  // validate
  if (!menu) {
    console.log('Invalid drop-down menu');
    return;
  }

  /**
   * Helper: Get all ancestors
   */
  function get_all_ancestors(item, css_class) {

    var result = [];
    var ancestor = item.parentElement;
    while (!ancestor.isEqualNode(menu)) {
      if (ancestor.classList.contains(css_class)) {
        result.push(ancestor);
      }
      ancestor = ancestor.parentElement;
    }
    return result;

  }

  /**
   * Helper: Get closest ancestor
   */
  function get_ancestor(item, css_class) {

    var result = get_all_ancestors(item, css_class);
    if (result.length) {
      return result[0];
    }
    return null;

  }

  /**
   * Helper: Is element inside menu
   */
  function is_element_inside_menu(el) {

    while ((el = el.parentElement) !== null) {
      if (el.nodeType !== Node.ELEMENT_NODE) {
        continue;
      }
      if (el.isEqualNode(menu)) {
        return true;
      }
    }
    return false;

  }

  /**
   * Helper: Is desktop menu
   *
   * Checks if window is wider than set desktop limit.
   *
   * @return bool is desktop width screen
   */
  function is_desktop_menu() {

    screen_w = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
    if (screen_w < desktop_min_width) {
      return false;
    }
    return true;

  }

   /**
    * Helper: Show menu item children <li class="menu-item-has-children">
    */
   function activate_menu_item(li) {

    // validate
    if (!li) {
      return;
    }

    // acticate <li>
    li.setAttribute('aria-expanded', 'true');

    // actiate <ul>
    var ul = li.querySelector('.sub-menu');
    if (ul) {
      ul.setAttribute('aria-hidden', 'false');
      // check that <ul> fits viewport
      if (ul.getBoundingClientRect().right > (window.innerWidth || document.documentElement.clientWidth)) {
        ul.classList.add('is-out-of-bounds');
      }
    }

    // activate parents <li> + <ul>
    var ancestors = get_all_ancestors(li, 'menu-item-has-children');
    for (var i = 0; i < ancestors.length; i++) {
      activate_menu_item(ancestors[i]);
    }

  }

   /**
    * Helper: Hide menu item children <li class="menu-item-has-children">
    */
   function deactivate_menu_item(li) {

    // validate
    if (!li) {
      return;
    }

    // deactivate <li>
    li.setAttribute('aria-expanded', 'false');

    // deactivate <ul>
    var ul = li.querySelector('.sub-menu');
    if (ul) {
      ul.setAttribute('aria-hidden', 'true');
      ul.classList.remove('is-out-of-bounds');
    }

    // deactivate children <li> + <ul>
    var children = li.querySelectorAll('.menu-item-has-children');
    for (var i = 0; i < children.length; i++) {
      deactivate_menu_item(children[i]);
    }

  }

  /**
   * Helper: Toggle menu item
   */
  function toggle_menu_item(li) {

    if (li) {
      if (li.getAttribute('aria-expanded') == 'false') {
        activate_menu_item(li);
      } else {
        deactivate_menu_item(li);
      }
    }

  }

  /**
   * Helper: Reset all menu-items' state
   */
  function reset_menu_items() {

    var items_with_children = menu.querySelectorAll('.menu-item-has-children');
    for (var i = 0; i < items_with_children.length; i++) {
      deactivate_menu_item(items_with_children[i]);
      items_with_children[i].classList.remove('is-tapped');
    }

  }

  /**
   * Event: Handle mouse enter hover
   */
  function menu_item_mouseenter(e) {

    if (is_desktop_menu()) {

      // clear any previously set closing timeout
      clearTimeout(hover_timeout);

      // deactivate all <li> that are not part of this DOM tree
      var ancestors = get_all_ancestors(e.currentTarget, 'menu-item-has-children');
      var li_with_children = menu.querySelectorAll('.menu-item-has-children');
      for (var j = 0; j < li_with_children.length; j++) {
        if (li_with_children[j] !== e.currentTarget && ancestors.indexOf(li_with_children[j]) === -1) {
          deactivate_menu_item(li_with_children[j]);
        }
      }

      // activate hovered <li>
      activate_menu_item(e.currentTarget);

    }

  };

  /**
   * Event: Handle mouseleave hover
   *
   * Close menu when hover timer has ended (only for desktop menus)
   */
  var menu_item_mouseleave = function(e) {

    // delay closing for more natural hover
    if (is_desktop_menu()) {
      hover_timeout = setTimeout(function(li) {
        deactivate_menu_item(li);
      }, 750, e.currentTarget);
    }

  };

  /**
   * Event: Dropdown caret clicked
   *
   * Open sub-menu and change caret state
   */
  var caret_click_event = function(e) {

    // activate or deactivate <li>
    toggle_menu_item(get_ancestor(e.currentTarget, 'menu-item-has-children'));

    // don't trigger parent(s)
    e.stopPropagation();

  };

   /**
    * Event: Click on empty link (a[href="#"])
    */
   function empty_a_click_event(e) {

    // cancel default action
    e.preventDefault();

    // activate or deactivate <li>
    toggle_menu_item(get_ancestor(e.currentTarget, 'menu-item-has-children'));

   }

  /**
   * Event: Menu item parent a touched
   *
   * In desktop mode, open sub-menu with first click and navigate
   * only when doubletapped
   */
   function menu_item_parent_a_touch_event(e) {

    if (!is_desktop_menu()) {
      return;
    }

    var li = get_ancestor(e.currentTarget, 'menu-item-has-children');

    if (!li.classList.contains('is-tapped')) {

      // first tap: don't go to <a> yet
      e.preventDefault();

      // remove .tapped class and close all <li> that don't belong to this DOM tree
      var ancestors = get_all_ancestors(e.currentTarget, 'menu-item-has-children');
      var li_with_children = menu.querySelectorAll('.menu-item-has-children');
      for (var j = 0; j < li_with_children.length; j++) {
        if (li_with_children[j] !== e.currentTarget && ancestors.indexOf(li_with_children[j]) === -1) {
          li_with_children[j].classList.remove('is-tapped');
          deactivate_menu_item(li_with_children[j]);
        }
      }

      // add .tapped class and activate <li>
      li.classList.add('is-tapped');
      activate_menu_item(li);

      // add event listener to click outside menu
      document.addEventListener('touchstart', outside_menu_touch_event, false);

    }

   }

  /**
   * Event: Touch outside menu after menu has been opened with single tap
   *
   * Closes menus if touch is outside of menus
   */
    // maybe close menu after it has been opened by tap
  function outside_menu_touch_event(e) {

    // if the target of the tap isn't menu nor a descendant of menu
    if (is_desktop_menu() && !is_element_inside_menu(e.currentTarget)) {
      reset_menu_items();
    }

    // remove this event listener
    document.removeEventListener('ontouchstart', outside_menu_touch_event, false);

  }

  /**
   * Init
   */
  function init_dropdown_menu() {

    // close all menus
    reset_menu_items();

    // setup hover hooks (menu-item)
    var menu_items = menu.querySelectorAll('.menu-item');
    for (var j = 0; j < menu_items.length; j++) {
      menu_items[j].addEventListener('mouseenter', menu_item_mouseenter);
      menu_items[j].addEventListener('mouseleave', menu_item_mouseleave);
    }

    // setup click hooks (carets)
    var menu_carets = menu.querySelectorAll('.js-menu-caret');
    for (var k = 0; k < menu_carets.length; k++) {
      menu_carets[k].addEventListener('click', caret_click_event);
    }

    // setup click hooks (empty links)
    var empty_a = menu.querySelectorAll('a[href="#"]');
    for (var l = 0; l < empty_a.length; l++) {
      empty_a[l].addEventListener('click', empty_a_click_event);
    }

    // setup touch hooks (parent menu-item a)
    var menu_item_a = menu.querySelectorAll('.menu-item-has-children a');
    for (var m = 0; m < menu_item_a.length; m++) {
      menu_item_a[m].addEventListener('touchstart', menu_item_parent_a_touch_event, false);
    }

  }
  init_dropdown_menu();

  // make the call chainable
  return this;

};
