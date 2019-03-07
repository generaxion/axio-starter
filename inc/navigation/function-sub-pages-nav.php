<?php
/**
 * Function for sub pages navigation
 *
 * @package aucor_starter
 */

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

  } elseif ($hierarchy_pos === 3) {

    $grand_parent = wp_get_post_parent_id($post->post_parent);
    $parent       = wp_get_post_parent_id($grand_parent);

  } elseif ($hierarchy_pos === 2) {

    $parent = wp_get_post_parent_id($post->post_parent);

  } elseif ($hierarchy_pos === 0) {

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
    'post_type'   => $post->post_type,
    'sort_column' => 'menu_order, post_title',
    'walker'      => $walker
  ));

  if (!empty($list)) :

    $parent_top = array_reverse(get_post_ancestors($post->ID));
    if (!empty($parent_top)) {
      $first_parent = get_page($parent_top[0]);
      $parent_css = '';
    }

    if (empty($parent_top) || $first_parent->ID === get_the_ID()) {
      $parent_css = 'current_page_item';
      $first_parent = get_page(get_the_ID());
    }

    ?>
    <nav class="sub-pages" itemscope itemtype="http://schema.org/SiteNavigationElement/">

      <span class="sub-pages__title <?php echo $parent_css; ?>">
        <a href="<?php echo get_permalink($first_parent->ID); ?>"><?php echo $first_parent->post_title; ?></a>
      </span>

      <ul class="sub-pages__list">
        <?php echo $list; ?>
      </ul>

    </nav>

    <?php

  endif;

  if (!empty($pretend_id)) {
    wp_reset_postdata();
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

    if (!empty($pretend_id) && $pretend_id === $page->ID) {
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
      if ($page->ID === $current_page) {
        $css_class[] = 'current_page_item';
      } elseif ($_current_page && $page->ID === $_current_page->post_parent) {
        $css_class[] = 'current_page_parent';
      }
    } elseif ($page->ID === get_option('page_for_posts')) {
      $css_class[] = 'current_page_parent';
    } elseif (!empty($pretend_id) && $page->ID === $pretend_id) {
      $css_class[] = 'current_page_item';
      $css_class[] = 'pretend_current_page_item';
    }

    $css_classes = implode(' ', apply_filters('page_css_class', $css_class, $page, $depth, $args, $current_page));

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
