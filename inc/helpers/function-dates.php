<?php
/**
 * Function for post meta data
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
