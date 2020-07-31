<?php
/**
 * Component: Notification Banner
 *
 * @package aucor_starter
 */

class Aucor_Notification_Banner extends Aucor_Component {

  public static function frontend($data) {

    if ($data['active'] && !$data['hidden_on_this_page']) {
      ?>
      <div class="notification js-notification">

        <button class="notification__close js-notification-close">
          <?php Aucor_SVG::render( [ 'name' => 'close' ] ); ?>
        </button>

        <div class="notification__container">

            <?php
            if ( isset( $data['notif_type'] )) {
              Aucor_SVG::render( ['name' => $data['notif_type']] );
            }
            ?>

            <?php if ( isset($data['text']) ) { ?>
              <span class="notification__container__text"><?php echo $data['text']; ?></span>
            <?php } ?>

            <?php if ( is_array($data['link_array']) ) { ?>
              <a target="<?php echo $data['link_array']['target']; ?>" href="<?php echo $data['link_array']['url']; ?>" class="notification__container__more button js-notification-button"><?php echo $data['link_array']['title']; ?></a>
            <?php } ?>

        </div>

      </div>

      <?php
    }
  }

  public static function backend($args = []) {

    $data = array();

    if ( function_exists('pll_current_language') && function_exists('pll_default_language') && ( pll_default_language() == pll_current_language() ) ) { // polylang activate, default language active
      $lang_code = '';
    } elseif ( function_exists('pll_current_language') ) { // polylang activated, some other language active
      $lang_code = pll_current_language() . '_';
    } else { // no polylang
      $lang_code = '';
    }

    $data['active']               = get_field($lang_code . 'notification_active', 'option');
    $data['notif_type']           = get_field($lang_code . 'notification_type', 'option');
    $data['hidden_on_this_page']  = false;
    if ( is_array( get_field($lang_code . 'notification_hide', 'option') ) && in_array(get_the_ID(), get_field($lang_code . 'notification_hide', 'option')  ) ) {
      $data['hidden_on_this_page'] = true;
    }
    $data['text']       = get_field($lang_code . 'notification_text', 'option');
    $data['link_array'] = get_field($lang_code . 'notification_link', 'option');

    $args = wp_parse_args($args, $data);

    if (
      !isset($args['active']) ||
      empty($args['notif_type']) ||
      !isset($args['hidden_on_this_page']) ||
      ( empty($args['text']) && empty($args['link_array']) )
      ) {
      return parent::error('Missing critical acf data');
    }

    return $args;
  }

  // Helper function, returns the notification banner html as a string, escaped and without spaces/line breaks. To be used as an identifier
  public static function get_identifier() {

    $html_escaped         = esc_html(Aucor_Notification_Banner::get());
    $spaces_stripped      = str_replace(' ', '', $html_escaped);
    $line_breaks_stripped = str_replace("\n", '', $spaces_stripped);
    $semicolons_stripped  = str_replace(';', '', $line_breaks_stripped);

    return $semicolons_stripped;

  }

}


/**
 * Add options page
 */
if ( function_exists('acf_add_options_page') ) {
  acf_add_options_page(array(
    'page_title'      => 'Huomiolohko',
    'menu_title'      => 'Huomiolohko',
    'menu_slug'       => 'notification',
    'capability'      => 'edit_posts',
    'redirect'        => false,
    'icon_url'        => 'dashicons-warning',
    'update_button'		=> 'Tallenna',
    'updated_message'	=> 'Huomiolohko tallennettu',
  ));
}

/**
 * Make notification as a string available to JS
 * Used for checking that if the notification text changes, display banner again
 */
add_action('wp_footer', function() {

  $identifier = Aucor_Notification_Banner::get_identifier();
  ?>

  <script>
  var banner_notification_data = "<?php echo $identifier; ?>";
  </script>

  <?php
});
