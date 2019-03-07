<?php
/**
 * Function for custom search form
 *
 * @package aucor_starter
 */

/**
 * Custom search form
 *
 * @example aucor_starter_search_form('search-header')
 * @example aucor_starter_search_form('search-header', ['submit' => aucor_starter_get_svg('submit')])
 *
 * @param string $id HTML ID tag
 * @param array  $args options for form element
 */
function aucor_starter_search_form($id, $args = array()) {

  // set defaults
  $defaults = array(
    'class'              => 'search-form',
    'action'             => home_url('/'),
    'value'              => get_search_query(),
    'name'               => 's',
    'submit'             => ask__('Search: Submit'), // can be HTML, icons etc
    'placeholder'        => ask__('Search: Placeholder'),
    'screen-reader-text' => ask__('Search: Screen reader label'),
  );

  // parse args
  $args = wp_parse_args($args, $defaults);

  // create ID for input
  $input_id = $id . '-input';

  ?>
  <form id="<?php echo esc_attr($id); ?>" role="search" method="get" class="<?php echo esc_attr($args['class']); ?>" action="<?php echo esc_url($args['action']); ?>">

    <label for="<?php echo esc_attr($input_id); ?>" class="search-form__label screen-reader-text"><?php echo esc_attr($args['screen-reader-text']); ?></label>

    <input
      type="search"
      class="search-form__input"
      id="<?php echo esc_attr($input_id); ?>"
      name="<?php echo esc_attr($args['name']); ?>"
      value="<?php echo esc_attr($args['value']); ?>"
      placeholder="<?php echo esc_attr($args['placeholder']); ?>"
    />

    <button type="submit" class="search-form__submit"><?php echo $args['submit']; ?></button>

  </form>
  <?php

}
