<?php
/**
 * Class Speed_Remove_Emojis
 */
class Aucor_Core_Speed_Remove_Emojis extends Aucor_Core_Sub_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'aucor_core_speed_remove_emojis');

    // var: name
    $this->set('name', 'Remove emoji polyfill');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Run feature
   */
  public function run() {
    add_action('init', array($this, 'aucor_core_disable_emojis'));
  }

  /**
   * Remove emoji polyfill
   */
  public static function aucor_core_disable_emojis() {
    remove_action('wp_head',             'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles',     'print_emoji_styles');
    remove_action('admin_print_styles',  'print_emoji_styles');
    remove_filter('the_content_feed',    'wp_staticize_emoji');
    remove_filter('comment_text_rss',    'wp_staticize_emoji');
    remove_filter('wp_mail',             'wp_staticize_emoji_for_email');
  }

}
