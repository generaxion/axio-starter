/**
 * Aucor Navigation.js
 * -------------------
 *
 * Features:
 * - only adds classes, no show() or hide()
 * - timer for hover exit: better usability
 * - works with tabs: a11y
 * - desktop menu with touch: doubletap
 * - mobile menu with touch
 * - works at least with 3 levels (probably more)
 *
 */

(function($) {

  $.fn.aucor_navigation = function( options ) {

    // Default settings
    var defaults = {
      desktop_min_width: 501,
      menu_toggle: "#menu-toggle",
    };

    var settings = $.extend( {}, defaults, options ),
        $menu = $(this),
        desktop_min_width = settings.desktop_min_width, // match this to $menu-visible SASS variable
        $menu_toggle = $(settings.menu_toggle), // hamburger icon
        screen_w,
        hover_timer,
        focus_timer;

    /* Get menu type
    ----------------------------------------------- */

    function is_desktop_menu() {
      screen_w = $(window).width();
      if(screen_w < desktop_min_width) {
        return false;
      }
      return true;
    }

    /* Hover timer: only for desktop menus
    ----------------------------------------------- */

    $menu.find('.menu-item-has-children').on('mouseover', function() {
      if(is_desktop_menu()) {

        // clear timer
        clearTimeout(hover_timer);

        // make sure hover_timer did it's thing even if it didn't have time to fire
        // -> close all .sub-menus that don't belong to this DOM tree
        $menu.find('.sub-menu').not($(this).find('.sub-menu'), $(this).parents('.sub-menu')).removeClass('open');

        // open child sub-menu
        $(this).find('.sub-menu').first().addClass('open');

      }
    }).on('mouseleave', function() {

      // create timeout that let's the cursor get outside of menu for a moment
      if(is_desktop_menu()) {
        var $el = $(this);
        hover_timer = setTimeout( function() {
          $el.parents('.sub-menu').removeClass('open');
          $el.find('.sub-menu').removeClass('open');
        }, 750 );
      }

    });

    /* Open sub-menu with click to <li>
    ----------------------------------------------- */

    $menu.find('.menu-item-has-children').click(function (e) {

      // toggle .open class to child .sub-menu
      $(this).find('.sub-menu').first().toggleClass('open');

      // toggle .active class to this <li>
      if(!is_desktop_menu()) {
        $(this).toggleClass('active');
      }

      // don't trigger parent(s)
      e.stopPropagation();

    });

    /* Keyboard (tab)
    ----------------------------------------------- */

    $menu.on('focus', '.menu-item-has-children a', function(e) {

      // open sub-menu below
      $(this).parent('li').find('.sub-menu').first().addClass( 'open' );

      // open all sub-menus above
      $(this).parents('.sub-menu').addClass( 'open' );

    }).on('blur', '.menu-item-has-children a', function(e) {

      // close sub-menu below
      $(this).parent('li').find('.sub-menu').first().removeClass('open');

      // close all sub-menus above
      $(this).parents('.sub-menu').removeClass('open');

    });

    /* Toggle menu (hamburger)
    ----------------------------------------------- */

    $menu_toggle.click(function() {
      if($menu_toggle.hasClass('active')) {

        // remove .active class from hamburger icon
        $menu_toggle.removeClass('active').attr('aria-expanded', 'false');

        // remove .active class to menu container
        $menu.removeClass('active');

        // focus out of the menu
        $menu_toggle.focus();

      } else {

        // .active class to hamburger icon
        $menu_toggle.addClass('active').attr('aria-expanded', 'true');

        // .active class to menu container
        $menu.addClass('active');
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
    var $parent_links = $menu.find('.menu-item-has-children > a');

    if ('ontouchstart' in window) {


      // maybe close menu after it has been opened by tap
      maybeCloseMenuFn = function(e) {

      // if the target of the tap isn't menu nor a descendant of menu
      if (!$menu.is(e.target) && $menu.has(e.target).length === 0 && is_desktop_menu()) {

        // reset menu state to default
        $menu.find('.open').removeClass('open');
        $menu.find('.tapped').removeClass('tapped');
        $menu.find('.active').removeClass('active');

      }

        // remove this event listener
        if(typeof removeEventListener === 'function') {
          document.removeEventListener("ontouchstart", maybeCloseMenuFn, false);
        }

      };

      touchStartFn = function(e) {

        // only fire on desktop menu
        if(!is_desktop_menu()) {
          return false;
        }

        var $current_list_item = $(this).parent('li');

        if ( !$current_list_item.hasClass('tapped') ) {

          // first tap: don't go to <a> yet
          e.preventDefault();

          // remove .tapped class to <li> that don't belong to this DOM tree
          $menu.find('.tapped').not($(this).parents('li')).removeClass('tapped');

          // add .tapped class to <li> element
          $current_list_item.addClass('tapped');

          // close all .sub-menus that don't belong to this DOM tree
          $menu.find('.sub-menu').not($(this).parents('.sub-menu')).removeClass('open');

          // open .sub-menu below
          $current_list_item.find('.sub-menu').first().addClass('open');

          // open all .sub-menus above
          $(this).parents('.sub-menu').addClass('open');

          // add EventListener to second click
          if(typeof addEventListener === 'function') {
            document.addEventListener('touchstart', maybeCloseMenuFn, false);
          }

        } else {

          // second tap: go to <a>

          // remove .tapped from current <li>
          $current_list_item.removeClass('tapped');

          // close .sub-menus
          $menu.find('.sub-menu').removeClass('open');

        }

      };

      // add eventlisteners for each <a> with a sub-menu
      $.each($parent_links, function(i, link) {
        if(typeof addEventListener === 'function') {
          link.addEventListener('touchstart', touchStartFn, false);
        }
      });

    }

    // make the call chainable
    return this;
  };

})(jQuery);
