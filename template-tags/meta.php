<?php
/**
 * Functions for meta data
 *
 * @package aucor_starter
 */

/**
 * Posted on
 */
function aucor_starter_posted_on() {

  $time_string_format = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
  $time_string = sprintf($time_string_format, esc_attr(get_the_date('j.n.Y')), esc_html(get_the_date()));
  echo '<span class="posted-on">' . $time_string . '</span>';

}

/**
 * Entry footer
 */
function aucor_starter_entry_footer() {

  // hide category and tag text for pages
  if ( get_post_type() === 'post' ) {

    $categories_list = get_the_category_list(', ');
    if ($categories_list) {
      printf('<span class="cat-links">' . ask__('Taxonomies: Categories') . ': %1$s' . '</span>', $categories_list);
    }

    $tags_list = get_the_tag_list('', ', ');
    if ($tags_list) {
      printf('<span class="tags-links">' . ask__('Taxonomies: Keywords') . ': %1$s' . '</span>', $tags_list);
    }
  }

}
