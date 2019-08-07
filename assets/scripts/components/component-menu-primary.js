/**
 * Aucor Navigation.js
 * -------------------
 *
 * Features:
 * - only adds classes, no show() or hide()
 * - timer for hover exit: better usability
 * - works with keyboard: a11y
 * - desktop menu with touch: doubletap
 * - mobile menu with touch
 * - works at least with 3 levels (probably more)
 *
 */
component_primary_menu = function(args) {

  var extend = function (defaults, args) {
    var extended = {};
    var prop;
    for (prop in defaults) {
        if (Object.prototype.hasOwnProperty.call(defaults, prop)) {
            extended[prop] = defaults[prop];
        }
    }
    for (prop in args) {
        if (Object.prototype.hasOwnProperty.call(args, prop)) {
            extended[prop] = args[prop];
        }
    }
    return extended;
  };

  // Default settings
  var defaults = {
    desktop_min_width: 501,
    menu_container: '.primary-navigation',
    menu_toggle: '#menu-toggle',
  };

  var settings          = extend(args),
      desktop_min_width = settings.desktop_min_width, // match this to $menu-visible SASS variable
      menu_container    = document.querySelector(settings.menu_container),
      menu_toggle       = document.querySelector(settings.menu_toggle),
      screen_w,
      hover_timer,
      focus_timer;

  if (!menu_container || !menu_toggle) {
    console.log('Invalid menu_container or menu_toggle');
    return;
  }

  /**
   * Is desktop menu
   *
   * Checks if window is wider than set desktop limit.
   *
   * @return bool is desktop width screen
   */
  function is_desktop_menu() {

    screen_w = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
    if(screen_w < desktop_min_width) {
      return false;
    }
    return true;

  }

  /**
   * Hover timer (only for desktop menus)
   *
   * Keeps sub-menu open for a small time when hover has left the element.
   */
  var open_sub_menu = function(e) {

    if (is_desktop_menu()) {

      // clear timer
      clearTimeout(hover_timer);

      // make sure hover_timer did it's thing even if it didn't have time to fire
      // -> close all .sub-menus that don't belong to this DOM tree
      var this_tree_submenus = [];

      // get submenus on tree parents
      var current_parent = this.parentElement;
      while (!current_parent.isEqualNode(menu)) {
        if (current_parent.classList.contains('sub-menu')) {
            this_tree_submenus.push(current_parent);
        }
        current_parent = current_parent.parentElement;
      }

      // get submenus on tree descendants
      var current_descendants = this.querySelectorAll('.sub-menu');
      for (var d = 0; d < current_descendants.length; d++) {
        this_tree_submenus.push(current_descendants[d]);
      }

      // fetch all open submenus
      var all_open_sub_menus = menu_container.querySelectorAll('.open');
      for (var j = 0; j < all_open_sub_menus.length; j++) {
        // close the submenu only if not in current tree
        if (this_tree_submenus.indexOf(all_open_sub_menus[j]) === -1) {
          all_open_sub_menus[j].classList.remove('open');
        }
      }

      // open child sub-menu
      if (this.querySelector('.sub-menu')) {
        this.querySelector('.sub-menu').classList.add('open');
      }

    }

  };

  /**
   * Close menu when hover timer has ended (only for desktop menus)
   *
   * Triggers when mouse leaves menu element.
   */
  var close_sub_menu = function(e) {
    var t = this;
    // create timeout that let's the cursor get outside of menu for a moment
    if (is_desktop_menu()) {
      hover_timer = setTimeout( function() {
        var parent = t.parentElement;
        while (!parent.isEqualNode(menu)) {
          parent.classList.remove('open');
          parent = parent.parentElement;
        }
        if (t.querySelector('.open')) {
          t.querySelector('.open').classList.remove('open');
        }
      }, 750 );
    }
  };

  var open_submenu_with_click = function(e) {

    var li = null;
    var parent = e.target.parentElement;
    while (!parent.isEqualNode(menu)) {
      if (parent.classList.contains('menu-item')) {
        li = parent;
        break;
      }
      parent = parent.parentElement;
    }

    // toggle .open class to child .sub-menu
    li.querySelector('.sub-menu').classList.toggle('open');

    // toggle .active class to this <li>
    if (!is_desktop_menu()) {
      li.classList.toggle('active');
    }

    // don't trigger parent(s)
    e.stopPropagation();
  };

  var items_with_children = menu_container.querySelectorAll('.menu-item-has-children');
  for (var i = 0; i < items_with_children.length; i++) {
    var item = items_with_children[i];
    item.addEventListener('mouseover', open_sub_menu);
    item.addEventListener('mouseleave', close_sub_menu);

    var caret = item.querySelector('.js-menu-caret');
    if (caret) {

      /* Open sub-menu with click to <button>
      ----------------------------------------------- */
      caret.addEventListener('click', open_submenu_with_click);

    }

  }

  /* Keyboard (tab)
  ----------------------------------------------- */
  var on_link_focus = function(e) {
    // open sub-menu below
    var submenu_below = e.target.parentElement.querySelector('.sub-menu');
    if (submenu_below) {
      submenu_below.classList.add('open');
    }

    // open all sub-menus above
    var parent = e.target.parentElement;
    while (!parent.isEqualNode(menu)) {
      if (parent.classList.contains('sub-menu')) {
        parent.classList.add('open');
      }
      parent = parent.parentElement;
    }
  };

  var on_link_blur = function(e) {
    // close sub-menu below
    var submenu_below = e.target.parentElement.querySelector('.sub-menu');
    if (submenu_below) {
      submenu_below.classList.remove('open');
    }

    // close all sub-menus above
    var parent = e.target.parentElement;
    while (!parent.isEqualNode(menu)) {
      if (parent.classList.contains('sub-menu')) {
        parent.classList.remove('open');
      }
      parent = parent.parentElement;
    }
  };

  var links = menu_container.querySelectorAll('a');
  for (var k = 0; k < links.length; k++) {
    var link = links[k];

    link.addEventListener('focus', on_link_focus);
    link.addEventListener('blur', on_link_blur);
  }

  /* Toggle menu (hamburger)
  ----------------------------------------------- */

  menu_toggle.addEventListener('click', function() {
    if (menu_toggle.classList.contains('menu-toggle--active')) {

      // remove .active class from hamburger icon
      menu_toggle.classList.remove('menu-toggle--active');
      menu_toggle.setAttribute('aria-expanded', 'false');

      // remove .active class to menu container
      menu_container.classList.remove('active');

      // focus out of the menu
      menu_toggle.dispatchEvent(new Event('focus'));

    } else {

      // .active class to hamburger icon
      menu_toggle.classList.add('menu-toggle--active');
      menu_toggle.setAttribute('aria-expanded', 'true');

      // .active class to menu container
      menu_container.classList.add('active');
    }
  });

  /* Empty links "#": open sub-menu
  ----------------------------------------------- */

//  $menu.find('a[href="#"]').click(function(e) {
//
//    // don't go to "#"
//    e.preventDefault();
//
//    // do the same stuff as clicking to .menu-item-has-children
//    $(this).parent('.menu-item-has-children').trigger('click');
//
//  });


  /* Touch + desktop menu: doubletap
  ----------------------------------------------- */

  var touchStartFn;
  var maybeCloseMenuFn;

  if ('ontouchstart' in window) {

    var findAndRemoveClass = function(container, className) {
      var elements = container.querySelectorAll('.' + className);
      for(var e = 0; e < elements.length; e++) {
        elements[e].classList.remove(className);
      }
    };

    var targetInsideMenu = function(elem) {
      var isInsideMenu = false;
      while ((elem = elem.parentElement) !== null) {
        if (elem.nodeType !== Node.ELEMENT_NODE) {
          continue;
        }
        if (elem.isEqualNode(menu)) {
          isInsideMenu = true;
        }
      }
      return isInsideMenu;
    };

    // maybe close menu after it has been opened by tap
    maybeCloseMenuFn = function(e) {

      // if the target of the tap isn't menu nor a descendant of menu
      if (menu !== e.target && !targetInsideMenu(e.target) && is_desktop_menu()) {

        // reset menu state to default
        findAndRemoveClass(menu, 'open');
        findAndRemoveClass(menu, 'tapped');
        findAndRemoveClass(menu, 'active');
      }

      // remove this event listener
      document.removeEventListener("ontouchstart", maybeCloseMenuFn, false);

    };

    touchStartFn = function(e) {
      // only fire on desktop menu
      if (!is_desktop_menu()) {
        return false;
      }

      var current_list_item = this.parentElement;
      var current_parent;

      if (!current_list_item.classList.contains('tapped')) {

        // first tap: don't go to <a> yet
        e.preventDefault();

        // remove .tapped class to <li> that don't belong to this DOM tree
        var this_parents_li = [];
        current_parent = current_list_item;
        while(!current_parent.isEqualNode(menu)) {
          if(current_parent.classList.contains('tapped')) {
            this_parents_li.push(current_parent);
          }
          current_parent = current_parent.parentElement;
        }
        var all_tapped = menu_container.querySelectorAll('.tapped');
        for (var j = 0; j < all_tapped.length; j++) {
          // Close the submenu only if not in current tree
          if (this_parents_li.indexOf(all_tapped[j]) === -1) {
            all_tapped[j].classList.remove('tapped');
          }
        }

        // add .tapped class to <li> element
        current_list_item.classList.add('tapped');

        // close all .sub-menus that don't belong to this DOM tree
        var this_parents_submenu = [];
        current_parent = current_list_item;
        while (!current_parent.isEqualNode(menu)) {
          if (current_parent.classList.contains('open')) {
            this_parents_submenu.push(current_parent);
          }
          current_parent = current_parent.parentElement;
        }
        var all_open_submenus = menu_container.querySelectorAll('.open');
        for (var t = 0; t < all_open_submenus.length; t++) {
          // Close the submenu only if not in current tree
          if (this_parents_submenu.indexOf(all_open_submenus[t]) === -1) {
            all_open_submenus[t].classList.remove('open');
          }
        }

        // open .sub-menu below
        if (current_list_item.querySelector('.sub-menu')) {
          current_list_item.querySelector('.sub-menu').classList.add('open');
        }

        // open all .sub-menus above
        current_parent = this.parentElement;
        while (!current_parent.isEqualNode(menu)) {
          if (current_parent.classList.contains('sub-menu')) {
              current_parent.classList.add('open');
          }
          current_parent = current_parent.parentElement;
        }

        // add EventListener to second click
        document.addEventListener('touchstart', maybeCloseMenuFn, false);

      } else {

        // second tap: go to <a>

        // remove .tapped from current <li>
        current_list_item.classList.remove('tapped');

        // close .sub-menus
        findAndRemoveClass(menu, 'open');

      }

    };

    // add eventlisteners for each <a> with a sub-menu
    var parent_links = menu_container.querySelectorAll('.menu-item-has-children > a');
    for (var p = 0; p < parent_links.length; p++) {
      parent_links[p].addEventListener('touchstart', touchStartFn, false);
    }

  }

  // make the call chainable
  return this;
};
