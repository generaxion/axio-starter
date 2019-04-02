<?php
/**
 * Function for numeric posts navigation
 *
 * @package aucor_starter
 */

/**
 * Numeric posts navigation
 *
 * Show pagination in numeric format instead of just link to next and previous page.
 *
 * @example aucor_starter_numeric_posts_nav()
 * @example aucor_starter_numeric_posts_nav($search, 'filter_p')
 *
 * @param WP_Query $custom_query a query outside of main query
 * @param string   $custom_paged_var a custom string for paged variable
 */
function aucor_starter_numeric_posts_nav($custom_query = null, $custom_paged_var = null) {

  $next_label = aucor_starter_get_svg('caret-right') . '<span class="screen-reader-text">' . ask__('Navigation: Next') . '</span>';
  $prev_label = aucor_starter_get_svg('caret-right') . '<span class="screen-reader-text">' . ask__('Navigation: Previous') . '</span>';

  global $wp_query;

  if (!empty($custom_query)) {
    $wp_query_temp = $wp_query;
    $wp_query = $custom_query;
  }

  $paged_variable        = (empty($custom_paged_var)) ? 'paged' : $custom_paged_var;
  $has_default_paged_var = ($paged_variable === 'paged') ? true : false;
  $max_num_pages         = $wp_query->max_num_pages;

  // remove current paged var from url
  $clean_url = esc_url(remove_query_arg($paged_variable));

  if ($max_num_pages <= 1) {
    return;
  }

  if ($has_default_paged_var) {
    $paged = get_query_var($paged_variable) ? absint(get_query_var($paged_variable)) : 1;
  } else {
    $paged = (isset($_GET[$paged_variable]) && !empty($_GET[$paged_variable])) ? absint($_GET[$paged_variable]) : 1;
  }

  $max = absint($max_num_pages);

  // add current page to the array
  if ($paged >= 1) {
    $links[] = $paged;
  }

  // add the pages around the current page to the array
  if ($paged >= 3) {
    $links[] = $paged - 1;
    $links[] = $paged - 2;
  }

  if (($paged + 2) <= $max) {
    $links[] = $paged + 2;
    $links[] = $paged + 1;
  }

  echo '<nav class="navigation numeric-navigation"><ul itemscope itemtype="http://schema.org/SiteNavigationElement/Pagination">' . "\n";

  // previous post link
  if ($has_default_paged_var && get_previous_posts_link()) {
    printf('<li class="numeric-navigation__item numeric-navigation__item--previous">%s</li>' . "\n", get_previous_posts_link($prev_label));
  } elseif ($paged > 1) {
    printf('<li class="numeric-navigation__item numeric-navigation__item--previous"><a itemprop="relatedLink/pagination" href="%s">%s</a></li>' . "\n", add_query_arg($paged_variable, ($paged - 1), $clean_url), $prev_label);
  }

  // page 1
  if (!in_array(1, $links)) {
    $active = ($paged === 1) ? 'numeric-navigation__item--active' : '';
    $class = 'class="numeric-navigation__item numeric-navigation__item--pagenum ' . $active . '"';
    if ($has_default_paged_var) {
      printf('<li %s><a itemprop="relatedLink/pagination" href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link(1)), '1');
    } else {
      printf('<li %s><a itemprop="relatedLink/pagination" href="%s">%s</a></li>' . "\n", $class, $clean_url, '1');
    }
    if (!in_array(2, $links)) {
      echo '<li class="numeric-navigation__item numeric-navigation__item--separator">…</li>';
    }
  }

  // link to current page, plus 2 pages in either direction if necessary
  sort($links);
  foreach ((array) $links as $link) {
    $active = ($paged === $link) ? 'numeric-navigation__item--active' : '';
    $class = 'class="numeric-navigation__item numeric-navigation__item--pagenum ' . $active . '"';
    $url = ($paged_variable === 'paged') ? esc_url(get_pagenum_link($link)) : add_query_arg($paged_variable, $link, $clean_url);
    printf('<li %s><a itemprop="relatedLink/pagination" href="%s">%s</a></li>' . "\n", $class, $url, $link);
  }

  if (!in_array($max, $links)) {
    if (!in_array($max - 1, $links)) {
      echo '<li class="numeric-navigation__item numeric-navigation__item--separator">…</li>' . "\n";
    }

    $active = ($paged === $max) ? 'numeric-navigation__item--active' : '';
    $class = 'class="numeric-navigation__item numeric-navigation__item--pagenum ' . $active . '"';
    if ($paged_variable === 'paged') {
      printf('<li %s><a itemprop="relatedLink/pagination" href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($max)), $max);
    } else {
      printf('<li><a itemprop="relatedLink/pagination" href="%s">%s</a></li>' . "\n", add_query_arg($paged_variable, $max, $clean_url), $max);
    }
  }

  // next post Link
  if ($has_default_paged_var && get_next_posts_link()) {
    printf('<li class="numeric-navigation__item numeric-navigation__item--next">%s</li>' . "\n", get_next_posts_link($next_label)); // add custom next posts label
  } elseif ($paged < $max && $max > 1) {
    printf('<li class="numeric-navigation__item numeric-navigation__item--next"><a itemprop="relatedLink/pagination" href="%s">%s</a></li>' . "\n", add_query_arg($paged_variable, ($paged + 1), $clean_url), $next_label);
  }

  echo '</ul></nav>' . "\n";

  // reset previous global wp_query
  if (!empty($wp_query_temp)) {
    $wp_query = $wp_query_temp;
  }

}
