<?php
/**
 * Class Security_Hide_Users
 */
class Aucor_Core_Security_Hide_Users extends Aucor_Core_Sub_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'aucor_core_security_hide_users');

    // var: name
    $this->set('name', 'Hide users\' identities');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Run feature
   */
  public function run() {
      add_filter('the_author', array($this, 'aucor_core_rename_authors'), 100);
      add_filter('the_modified_author', array($this, 'aucor_core_rename_authors'), 100);
      add_filter('get_the_author_link', array($this, 'aucor_core_author_link_to_front_page'), 100);
      add_filter('rest_endpoints', array($this,'aucor_core_disable_user_endpoints'), 1000);
  }

  /**
   * Rename users to sitename (only front-end)
   *
   * @param string $name the name of the author
   *
   * @return string name of the author
   */
  public static function aucor_core_rename_authors($name) {
    if (is_admin()) {
      return $name;
    }
    return get_bloginfo('name');
  }

  /**
   * Link user to front page
   *
   * @param string $url link to author archive
   *
   * @return string link to site url
   */
  public static function aucor_core_author_link_to_front_page($url) {
    return get_site_url();
  }

  /**
   * Disable users from REST API for users that are not logged in
   *
   * @param array $endpoints registered routes
   *
   * @return array registered routes
   */
  public static function aucor_core_disable_user_endpoints($endpoints) {
    if (is_user_logged_in()) {
      return $endpoints;
    }

    // disable list of users
    if (isset($endpoints['/wp/v2/users'])) {
      unset($endpoints['/wp/v2/users']);
    }
    // disable single user
    if (isset($endpoints['/wp/v2/users/(?P<id>[\d]+)'])) {
      unset($endpoints['/wp/v2/users/(?P<id>[\d]+)']);
    }
    return $endpoints;
  }

}
