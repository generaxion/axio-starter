<?php
/**
 * Component: Menu Sub Pages (page hierarchy)
 *
 * @example
 * Aucor_Menu_Sub_Pages::render([
 *   'post' => $post_obj,
 * ]);
 *
 * @example
 * Aucor_Menu_Sub_Pages::render([
 *   'id'        => 123,
 *   'active_id' => 321,
 * ]);
 *
 * @package aucor_starter
 */
class Aucor_Menu_Sub_Pages extends Aucor_Component {

  public static function frontend($data) {

    // leave if no items
    if (empty($data['items'])) {
      return;
    }

    ?>

    <nav class="sub-pages" itemscope itemtype="http://schema.org/SiteNavigationElement/">

      <span class="<?php echo esc_attr(implode(' ', $data['parent_class'])); ?>">
        <a href="<?php echo esc_url($data['permalink']); ?>"><?php echo $data['post_title']; ?></a>
      </span>

      <ul class="sub-pages__list">
        <?php echo $data['items']; ?>
      </ul>

    </nav>

    <?php
  }

  public static function backend($args = []) {

    $placeholders = [

      // required (either)
      'id'    => 0,
      'post'  => null,

      // optional
      'active_id'          => 0,

      // internal
      'items'              => '',
      'post_title'         => '',
      'parent_class'       => [],
      'permalink'          => '',

    ];
    $args = wp_parse_args($args, $placeholders);

    // validate required fields
    if (empty($args['id']) && empty($args['post'])) {
      return parent::error('Missing post object ($args[\'post\']) or ID ($args[\'id\'])');
    }

    // setup target post
    if (!empty($args['id'])) {
      $args['post'] = get_post($args['id']);
    }

    // validate post object
    if (!($args['post'] instanceof WP_Post)) {
      return parent::error('Invalid post object ($args[\'post\'])');
    }

    // replace global $post temporarily
    global $post;
    $temp_post = $post;
    $post = $args['post'];
    setup_postdata($post);

    // find list parent
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

    // set pretended active id
    if (!empty($args['active_id'])) {
      global $pretend_id;
      $pretend_id = $args['active_id'];
    }

    // get list items
    $args['items'] = wp_list_pages([
      'child_of'    => $parent,
      'echo'        => 0,
      'link_after'  => '',
      'post_type'   => $post->post_type,
      'sort_column' => 'menu_order, post_title',
      'title_li'    => '',
      'walker'      => new Aucor_Walker_Page_With_Pretendable_Active_Item(),
    ]);

    // get parent info
    $parent_top = array_reverse(get_post_ancestors($post->ID));
    $biggest_parent_id = (!empty($parent_top) && isset($parent_top[0])) ? $parent_top[0] : $args['id'];
    $args['post_title'] = get_the_title($biggest_parent_id);
    $args['permalink']  = get_permalink($biggest_parent_id);
    $args['parent_class'][] = 'sub-pages__title';
    if (empty($parent_top) || $biggest_parent_id === $args['id']) {
      $args['parent_class'][] = 'current_page_item';
    }

    // revert to orignal $post object
    $post = $temp_post;
    setup_postdata($post);

    return $args;

  }

}

/**
 * Sub-pages navigation walker
 *
 * Current page item can be pretend to be whatever.
 */
class Aucor_Walker_Page_With_Pretendable_Active_Item extends Walker_Page {

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
