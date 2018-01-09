<?php
/**
 * Hide users' identities
 *
 * @package aucor_starter
 */

/**
 * Rename users to sitename (only front-end)
 *
 * @param string $name the name of the author
 *
 * @return string name of the author
 */
function aucor_starter_rename_authors($name) {

  if (is_admin()) {
    return $name;
  }

  return get_bloginfo('name');

}
add_filter('the_author', 'aucor_starter_rename_authors', 100);
add_filter('the_modified_author', 'aucor_starter_rename_authors', 100);

/**
 * Link user to front page
 *
 * @param string $url link to author archive
 *
 * @return string link to site url
 */
function aucor_starter_author_link_to_front_page($url) {

  return get_site_url();

}
add_filter('get_the_author_link', 'aucor_starter_author_link_to_front_page', 100);

/**
 * Disable users from REST API
 *
 * @param array $endpoints registered routes
 *
 * @return array registered routes
 */
function aucor_starter_disable_user_endpoints($endpoints) {

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
add_filter('rest_endpoints', 'aucor_starter_disable_user_endpoints', 1000);
