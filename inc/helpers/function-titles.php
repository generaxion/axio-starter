<?php
/**
 * Function for fetching archive titles
 *
 * @package aucor_starter
 */

/**
 * Get archive title
 *
 * @return string the title
 */
function aucor_starter_get_the_archive_title() {

  $title = ask__('Title: Archives');

  if (is_tag() || is_category() || is_tax()) {
    $title = single_term_title('', false);
  } elseif (is_home()) {
    $title = ask__('Title: Home');
  } elseif (is_search()) {
    $title = ask__('Title: Search') . ': <span class="search-terms">' . get_search_query() . '</span>';
  } elseif (is_404()) {
    $title = ask__('Title: 404');
  }

  return $title;

}
