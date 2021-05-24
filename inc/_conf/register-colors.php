<?php
/**
 * Register: Colors
 *
 * @package axio
 */

add_filter('x_background_colors', function ($colors = []) {

  return array_merge($colors, [

    'default' => [
      'label'   => __('Default'),
      'color'   => 'transparent',
      'is_dark' => false,
    ],

    'light' => [
      'label'   => __('Light'),
      'color'   => 'hsl(0, 0%, 95%)',
      'is_dark' => false,
    ],

    // 'dark' => [
    //   'label'   => __('Dark'),
    //   'color'   => 'hsl(0, 0%, 5%)',
    //   'is_dark' => true,
    // ],

  ]);

});

/**
 * Enqueue inline color varaibles
 */
function x_enqueue_color_variables() {

  $return = '';

  $colors = apply_filters('x_background_colors', []);
  if (!empty($colors)) {
    foreach ($colors as $name => $arr) {
      if (isset($arr['color']) && !empty($arr['color'])) {
        $return .= '.background-color.background-color--' . esc_attr($name) . '{background: ' . esc_attr($arr['color']) . ';}';
      }
    }
  }

  return $return;

}
