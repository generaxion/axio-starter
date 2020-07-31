/**
 * Notification bar
 *
 * Saves closed "state" to a cookie. Checks that if the content
 * is changed, display to notification again
 */

var notificationBar = function() {

  var notification = page.querySelector('.js-notification');

  // get current banner data from WP
  var notification_data_current = "bannerdata=" + encodeURI(banner_notification_data); // banner_notification_data is set in php with wp_footer action

  // console.log(banner_notification_data);

  // get banner data from cookie
  var all_cookies = document.cookie;
  var cookie_array = all_cookies.split("; ");
  for (i = 0; i < cookie_array.length; i++) {
    if ( cookie_array[i].match('bannerdata') ) {
      var banner_data_in_cookie =  cookie_array[i];
    }
  }

  if (notification && notification_data_current) {

    // display notification if notification string in cookie is old. will be displayd also if nothing found in cookies
    if ( banner_data_in_cookie !== (notification_data_current) ) {
      document.addEventListener('DOMContentLoaded', function() {
        notification.classList.add('js-notification--active');
      });
    }

    // close button or link button clicked
    notification.addEventListener('click', function(e) {
      if (typeof e.target.classList !== 'undefined' && ( e.target.classList.contains('js-notification-close') || e.target.classList.contains('js-notification-button') )  ) {

        notification.classList.remove('js-notification--active');

        // set a cookie that will hide the notification for a month
        var now = new Date();
        now.setMonth( now.getMonth() + 1 );
        document.cookie = notification_data_current + "; expires=" + now.toUTCString();

      }
    });
  }

};

notificationBar();
