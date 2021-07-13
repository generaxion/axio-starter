<?php
/**
 * Class Security_Head_Cleanup
 */
class Aucor_Core_Security_Head_Cleanup extends Aucor_Core_Sub_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'aucor_core_security_head_cleanup');

    // var: name
    $this->set('name', 'Removes unnecessary parts from the head');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Run feature
   */
  public function run() {

    // Hide generator from HTML
    add_filter('the_generator', '__return_empty_string');

    // Disable XML-RPC
    add_filter('xmlrpc_enabled', '__return_false');

    // Remove X-Pingback header
    add_filter('wp_headers', array($this, 'aucor_core_remove_pingback_header'));

    // Remove Pingback functionality
    add_filter('xmlrpc_methods', array($this, 'aucor_core_remove_pingback_functionality'));

    // Remove junk from head
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'index_rel_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'start_post_rel_link', 10, 0);
    remove_action('wp_head', 'parent_post_rel_link', 10, 0);
    remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
    remove_action('wp_head', 'rest_output_link_wp_head', 10);
    remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
  }

  public static function aucor_core_remove_pingback_header($headers) {
    unset($headers['X-Pingback']);
    return $headers;
  }

  public static function aucor_core_remove_pingback_functionality($methods) {
    unset($methods['pingback.ping']);
    return $methods;
  }

}
