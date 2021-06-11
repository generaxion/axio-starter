<?php

/**
 * https://amp.dev/documentation/components/amp-img/
 */


/**
 * AMP functionality
 * orig from https://github.com/billerickson/EA-Starter/blob/master/inc/amp.php
 **/

/**
 * Is AMP?
 * Conditional tag
 */
function sd_is_amp() {
  return function_exists('amp_is_available') && amp_is_available();
  //if ( !is_admin() || wp_doing_ajax() ) && ! wp_doing_cron()) return false;
  // we still want to show the admin bar
  //if (is_user_logged_in()) return false;
  //return true;
}




/**
 * Generate a class attribute and an AMP class attribute binding.
 *
 * @param string $default Default class value.
 * @param string $active  Value when the state enabled.
 * @param string $state   State variable to toggle based on.
 *
 * @return string HTML attributes.
 */
function sd_amp_class($default, $active, $state) {
  $output = '';
  if (sd_is_amp()) {
    $output .= sprintf(
      ' [class]="%s"',
      esc_attr(
        sprintf(
          '%s ? \'%s\' : \'%s\'',
          $state,
          $default . ' ' . $active,
          $default
        )
      )
    );
  }
  $output .= sprintf(' class="%s"', esc_attr($default));

  return $output;
}

/**
 * Add the AMP toggle 'on' attribute.
 *
 * @param string $state   State to toggle.
 * @param array  $disable , list of states to disable
 *
 * @return string The 'on' attribute.
 */
function sd_amp_toggle($state = '', $disable = []) {
  if (!sd_is_amp())
    return;

  $settings = sprintf(
    '%1$s: ! %1$s',
    esc_js($state)
  );

  if (!empty($disable)) {
    foreach ($disable as $disableState) {
      $settings .= sprintf(
        ', %s: false',
        esc_js($disableState)
      );
    }
  }

  return sprintf(
    ' on="tap:AMP.setState({%s})"',
    $settings
  );

}

/**
 * AMP Nav Dropdown toggle and class attributes.
 *
 * @param string $theme_location Theme location.
 * @param int    $depth          Depth.
 *
 * @return string The class and on attributes.
 */
function sd_amp_nav_dropdown($theme_location = false, $depth = 0) {

  $key = 'nav';
  if (!empty($theme_location))
    $key .= ucwords($theme_location);

  global $submenu_index;
  $submenu_index++;
  $key .= 'SubmenuExpanded' . $submenu_index;

  if (1 < $depth)
    $key .= 'Depth' . $depth;

  return sd_amp_toggle($key) . sd_amp_class('submenu-expand', 'expanded', $key);
}
