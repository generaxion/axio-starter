<?php
/**
 * Functions for navigation
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

  $next_label = ask__('Navigation: Next');
  $prev_label = ask__('Navigation: Previous');

  global $wp_query;

  if (!empty($custom_query)) {
    $wp_query_temp = $wp_query;
    $wp_query = $custom_query;
  }

  $paged_variable        = (empty($custom_paged_var)) ? 'paged' : $custom_paged_var;
  $has_default_paged_var = ($paged_variable == 'paged') ? true : false;
  $max_num_pages         = $wp_query->max_num_pages;

  // remove current paged var from url
  $clean_url = esc_url(remove_query_arg($paged_variable));

  if ( $max_num_pages <= 1 ) {
    return;
  }

  if ($has_default_paged_var) {
    $paged = get_query_var($paged_variable) ? absint( get_query_var($paged_variable) ) : 1;
  } else {
    $paged = (isset($_GET[$paged_variable]) && !empty($_GET[$paged_variable])) ? absint($_GET[$paged_variable]) : 1;
  }

  $max = intval($max_num_pages);

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
    printf('<li>%s</li>' . "\n", get_previous_posts_link($prev_label));
  } elseif ($paged > 1) {
    printf('<li><a itemprop="relatedLink/pagination" href="%s">%s</a></li>' . "\n", add_query_arg($paged_variable, ($paged - 1), $clean_url), $prev_label);
  }

  // page 1
  if (!in_array(1, $links)) {
    $class = ($paged == 1) ? ' class="active"' : '';
    if ($has_default_paged_var) {
      printf('<li%s><a itemprop="relatedLink/pagination" href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link( 1 )), '1');
    } else {
      printf('<li%s><a itemprop="relatedLink/pagination" href="%s">%s</a></li>' . "\n", $class, $clean_url, '1');
    }
    if (!in_array(2, $links)) {
      echo '<li>…</li>';
    }
  }

  // link to current page, plus 2 pages in either direction if necessary
  sort($links);
  foreach ((array) $links as $link) {
    $class = ($paged == $link) ? ' class="active"' : '';
    $url = ($paged_variable == 'paged') ? esc_url(get_pagenum_link($link)) : add_query_arg($paged_variable, $link, $clean_url);
    printf('<li%s><a itemprop="relatedLink/pagination" href="%s">%s</a></li>' . "\n", $class, $url, $link);
  }

  if (!in_array($max, $links)) {
    if (!in_array($max - 1, $links)) {
      echo '<li>…</li>' . "\n";
    }

    $class = ($paged == $max) ? ' class="active"' : '';
    if ($paged_variable == 'paged') {
      printf('<li%s><a itemprop="relatedLink/pagination" href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($max)), $max);
    } else {
      printf('<li><a itemprop="relatedLink/pagination" href="%s">%s</a></li>' . "\n", add_query_arg($paged_variable, $max, $clean_url), $max);
    }
  }

  // next post Link
  if ($has_default_paged_var && get_next_posts_link()) {
    printf('<li>%s</li>' . "\n", get_next_posts_link($next_label)); // add custom next posts label
  } elseif ($paged < $max && $max > 1) {
    printf('<li><a itemprop="relatedLink/pagination" href="%s">%s</a></li>' . "\n", add_query_arg($paged_variable, ($paged + 1), $clean_url), $next_label);
  }

  echo '</ul></nav>' . "\n";

  // reset previous global wp_query
  if (!empty($wp_query_temp)) {
    $wp_query = $wp_query_temp;
  }

}

/**
 * Sub-pages navigation walker
 *
 * Current page item can be pretend to be whatever.
 */
class aucor_starter_Pretendable_Walker extends Walker_Page {

  /**
   * Starts the element output.
   *
   * @see Walker::start_el()
   *
   * @param string   $output used to append additional content (passed by reference)
   * @param WP_Post  $page menu item data object
   * @param int      $depth depth of menu item used for padding
   * @param stdClass $args an object of wp_nav_menu() arguments
   * @param int      $current_page current item ID
   */
  function start_el(&$output, $page, $depth = 0, $args = array(), $current_page = 0) {

    // get currently pretended ID
    global $pretend_id;

    if (!empty($pretend_id) && $pretend_id == $page->ID) {
      $args['link_before'] = '<span class="current_page_item pretend_current_page_item">';
      $args['link_after']  = '</span>';
    }

    // item css classes
    $css_class = array();

    if (isset($args['pages_with_children'][$page->ID])) {
      $css_class[] = 'page_item_has_children';
    }

    if (!empty($current_page && empty($pretend_id))) {
      $_current_page = get_post($current_page);
      if ($_current_page && in_array( $page->ID, $_current_page->ancestors)) {
        $css_class[] = 'current_page_ancestor';
      }
      if ($page->ID == $current_page) {
        $css_class[] = 'current_page_item';
      } elseif ($_current_page && $page->ID == $_current_page->post_parent) {
        $css_class[] = 'current_page_parent';
      }
    } elseif ($page->ID == get_option('page_for_posts')) {
      $css_class[] = 'current_page_parent';
    } elseif (!empty($pretend_id) && $page->ID == $pretend_id) {
      $css_class[] = 'current_page_item';
      $css_class[] = 'pretend_current_page_item';
    }

    $css_classes = implode(' ', apply_filters( 'page_css_class', $css_class, $page, $depth, $args, $current_page));

    // empty title
    if ($page->post_title === '') {
      $page->post_title = '#' . $page->ID;
    }

    $args['link_before'] = empty($args['link_before'] ) ? '' : $args['link_before'];
    $args['link_after'] = empty($args['link_after'] ) ? '' : $args['link_after'];

    $title = apply_filters( 'the_title', $page->post_title, $page->ID );

    $output .= sprintf(
      '<li class="%s"><a href="%s">%s%s%s</a>',
      $css_classes,
      get_permalink( $page->ID ),
      $args['link_before'],
      $title,
      $args['link_after']
    );

    // add caret for items with children
    // if ($args['has_children'] == true) {
    //   $output .= '<button class="caret">+</button>';
    // }

  }

}

/**
 * Sub pages navigation
 *
 * Show hierarchial pages of current page.
 */
function aucor_starter_sub_pages_navigation() {

  global $post;
  global $pretend_id;

  if (!empty($pretend_id) && is_numeric($pretend_id)) {
    $post = get_post($pretend_id);
    setup_postdata($post);
  }

  $hierarchy_pos = count($post->ancestors);

  if ($hierarchy_pos > 3) {

    $great_grand_parent = wp_get_post_parent_id($post->post_parent);
    $grand_parent       = wp_get_post_parent_id($great_grand_parent);
    $parent             = wp_get_post_parent_id($grand_parent);

  } elseif ($hierarchy_pos == 3) {

    $grand_parent = wp_get_post_parent_id($post->post_parent);
    $parent       = wp_get_post_parent_id($grand_parent);

  } elseif ($hierarchy_pos == 2) {

    $parent = wp_get_post_parent_id($post->post_parent);

  } elseif ($hierarchy_pos == 0) {

    $parent = $post->ID;

  } else {

    $parent = $post->post_parent;

  }

  $walker = new aucor_starter_Pretendable_Walker();

  $list = wp_list_pages(array(
    'echo'        => 0,
    'child_of'    => $parent,
    'link_after'  => '',
    'title_li'    => '',
    'sort_column' => 'menu_order, post_title',
    'walker'      => $walker
  ));

  if (!empty($list)) :

    $parent_top = array_reverse(get_post_ancestors($post->ID));
    if (!empty($parent_top)) {
      $first_parent = get_page($parent_top[0]);
      $parent_css = '';
    }

    if (empty($parent_top) || $first_parent->ID == get_the_ID()) {
      $parent_css = 'current_page_item';
      $first_parent = get_page(get_the_ID());
    }

    ?>
    <nav class="sub-pages-navigation" itemscope itemtype="http://schema.org/SiteNavigationElement/">

      <span class="h2" class="<?php echo $parent_css; ?>">
        <a href="<?php echo get_permalink($first_parent->ID); ?>"><?php echo $first_parent->post_title; ?></a>
      </span>

      <ul class="sub-pages-list">
        <?php echo $list; ?>
      </ul>

    </nav>

    <?php

  endif;

  if (!empty($pretend_id)) {
    wp_reset_postdata();
  }

}
