<?php
/**
 * Custom template tags for this theme.
 */

/*
  Contents
  ==================================
  01. Get SVG
  02. Social share buttons
  03. Numeric posts navigation
  04. Sub-pages navigation
  05. Posted on
  06. Entry footer
  07. Menu toggle btn
  08.
  ==================================
 */


/* =========================================================
  01. Get SVG
 ======================================================== */

function aucor_starter_get_svg( $icon, $args = array() ) {

  // Set defaults
  $defaults = array(
    'wrap'        => true, // Wrap in <span>
    'class'        => '',
    'title'       => '',
    'desc'        => '',
    'aria_hidden' => true, // Hide from screen readers.
  );

  // Set SVG variable
  $svg = '';

  // Parse args
  $args = wp_parse_args( $args, $defaults );

  // Add extra space before classes
  $args['class'] = $args['class'] ? ' ' . $args['class'] : '';

  // Set aria hidden
  $aria_hidden = ( $args['aria_hidden'] === true ) ? ' aria-hidden="true"' : '';

  // Set ARIA
  $aria_labelledby = ( $args['title'] && $args['desc'] ) ? ' aria-labelledby="title desc"' : '';

  if( $args['wrap'] === true ) {
    $svg .= '<span class="icon-wrap">';
  }

  // Begin SVG markup
  $svg .= '<svg class="icon icon-' . esc_html( $icon ) . esc_html($args['class']) . '"' . $aria_hidden . $aria_labelledby . ' role="img">';
    // If there is a title, display it.
    if ( $args['title'] ) {
      $svg .= '<title>' . esc_html( $args['title'] ) . '</title>';
    }
    // If there is a description, display it.
    if ( $args['desc'] ) {
      $svg .= '<desc>' . esc_html( $args['desc'] ) . '</desc>';
    }
  $svg .= '<use xlink:href="' . get_template_directory_uri() . '/dist/sprite/sprite.svg?ver=' . aucor_starter_last_edited('svg') . '#icon-' . esc_html( $icon ) . '"></use>';
  $svg .= '</svg>';

  if( $args['wrap'] === true ) {
    $svg .= '</span>';
  }

  return $svg;
}


/* =========================================================
  02. Social share buttons
 ======================================================== */

function aucor_starter_social_share_buttons() {
  $url = (!is_tax()) ? get_permalink() : get_term_link(get_queried_object()->term_id);
  $title = get_the_title();
  ?>
  <div class="social-share-container">
    <span class="h3"><?php ask_e('Social share: Title'); ?></span>
    <a data-social-media="Facebook" href="<?php echo "https://www.facebook.com/sharer/sharer.php?u=$url"; ?>" target="_blank" class="social-share-link social-share-fb">
      <?php echo aucor_starter_get_svg('facebook'); ?>
      <span class="social-share-service"><?php ask_e('Social share: Facebook'); ?></span>
    </a>
    <a data-social-media="Twitter" href="<?php echo "https://twitter.com/share?url=$url"; ?>" target="_blank" class="social-share-link social-share-twitter">
      <?php echo aucor_starter_get_svg('twitter'); ?>
      <span class="social-share-service"><?php ask_e('Social share: Twitter'); ?></span>
    </a>
    <a data-social-media="LinkedIn" href="<?php echo "https://www.linkedin.com/shareArticle?mini=true&title=$title&url=$url"; ?>" target="_blank" class="social-share-link social-share-linkedin">
      <?php echo aucor_starter_get_svg('linkedin'); ?>
      <span class="social-share-service"><?php ask_e('Social share: LinkedIn'); ?></span>
    </a>
  </div>
<?php
}

/* =========================================================
  03. Numeric posts navigation
 ======================================================== */

function aucor_starter_numeric_posts_nav($custom_query = null, $custom_paged_var = null) {

  $next_label = ask__('Navigation: Next');
  $prev_label = ask__('Navigation: Previous');

  global $wp_query;

  if(!empty($custom_query)) {
    $wp_query_temp = $wp_query;
    $wp_query = $custom_query;
  }

  $paged_variable = (empty($custom_paged_var)) ? 'paged' : $custom_paged_var;
  $has_default_paged_var = ($paged_variable == 'paged') ? true : false;

  $max_num_pages = $wp_query->max_num_pages;

  // remove current paged var from url
  $clean_url = esc_url(remove_query_arg($paged_variable));

  if( $max_num_pages <= 1 )
    return;

  if($has_default_paged_var) {
    $paged = get_query_var($paged_variable) ? absint( get_query_var($paged_variable) ) : 1;
  } else {
    $paged = (isset($_GET[$paged_variable]) && !empty($_GET[$paged_variable])) ? absint($_GET[$paged_variable]) : 1;
  }

  $max = intval( $max_num_pages );

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
    printf( '<li>%s</li>' . "\n", get_previous_posts_link($prev_label) );
  } elseif($paged > 1) {
    printf( '<li><a itemprop="relatedLink/pagination" href="%s">%s</a></li>' . "\n", add_query_arg($paged_variable, ($paged - 1), $clean_url), $prev_label );
  }

  // page 1
  if (!in_array( 1, $links)) {
    $class = ($paged == 1) ? ' class="active"' : '';
    if($has_default_paged_var) {
      printf('<li%s><a itemprop="relatedLink/pagination" href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1');
    } else {
      printf('<li%s><a itemprop="relatedLink/pagination" href="%s">%s</a></li>' . "\n", $class, $clean_url, '1');
    }
    if (!in_array(2, $links)) {
      echo '<li>…</li>';
    }
  }

  // link to current page, plus 2 pages in either direction if necessary
  sort( $links );
  foreach ((array) $links as $link) {
    $class = ( $paged == $link ) ? ' class="active"' : '';
    $url = ($paged_variable == 'paged') ? esc_url(get_pagenum_link( $link )) : add_query_arg($paged_variable, $link, $clean_url);
    printf( '<li%s><a itemprop="relatedLink/pagination" href="%s">%s</a></li>' . "\n", $class, $url, $link );
  }

  if (!in_array($max, $links)) {
    if (!in_array($max - 1, $links)) {
      echo '<li>…</li>' . "\n";
    }

    $class = ($paged == $max) ? ' class="active"' : '';
    if($paged_variable == 'paged') {
      printf('<li%s><a itemprop="relatedLink/pagination" href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($max)), $max);
    } else {
      printf('<li><a itemprop="relatedLink/pagination" href="%s">%s</a></li>' . "\n", add_query_arg($paged_variable, $max, $clean_url), $max);
    }
  }

  // next Post Link
  if ($has_default_paged_var && get_next_posts_link()) {
    printf( '<li>%s</li>' . "\n", get_next_posts_link($next_label) ); // add custom next posts label
  } elseif ($paged < $max && $max > 1) {
    printf( '<li><a itemprop="relatedLink/pagination" href="%s">%s</a></li>' . "\n", add_query_arg($paged_variable, ($paged + 1), $clean_url), $next_label );
  }

  echo '</ul></nav>' . "\n";

  // reset previous global wp_query
  if(!empty($wp_query_temp )) {
    $wp_query = $wp_query_temp;
  }

}


/* =========================================================
  04. Sub-pages navigation (pretendable)
 ======================================================== */

class aucor_starter_Pretendable_Walker extends Walker_Page {
   function start_el(&$output, $page, $depth = 0, $args = array(), $current_page = 0) {
    global $pretend_id;

    if(!empty($pretend_id) && $pretend_id == $page->ID ) {
      $args['link_before'] = '<span class="current_page_item pretend_current_page_item">';
      $args['link_after'] = '</span>';
    }

    // item css classes
    $css_class = array();

    if (isset($args['pages_with_children'][$page->ID])) {
      $css_class[] = 'page_item_has_children';
    }
    if (!empty( $current_page && empty($pretend_id))) {
      $_current_page = get_post( $current_page );
      if ($_current_page && in_array( $page->ID, $_current_page->ancestors)) {
        $css_class[] = 'current_page_ancestor';
      }
      if ($page->ID == $current_page ) {
        $css_class[] = 'current_page_item';
      } elseif ($_current_page && $page->ID == $_current_page->post_parent) {
        $css_class[] = 'current_page_parent';
      }
    } elseif ( $page->ID == get_option('page_for_posts') ) {
      $css_class[] = 'current_page_parent';
    } elseif (!empty($pretend_id) && $page->ID == $pretend_id) {
      $css_class[] = 'current_page_item';
      $css_class[] = 'pretend_current_page_item';
    }

    $css_classes = implode( ' ', apply_filters( 'page_css_class', $css_class, $page, $depth, $args, $current_page ) );

    // empty title
    if ($page->post_title === '') {
      $page->post_title = '#' . $page->ID ;
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
    //if($args['has_children'] == true) {
    //  $output .= '<button class="caret">+</button>';
    //}

  }
}

function aucor_starter_sub_pages_navigation() {

  global $post;
  global $pretend_id;

  if(!empty($pretend_id) && is_numeric($pretend_id)) {
    $post = get_post($pretend_id);
    setup_postdata($post);
  }

  $hierarchy_pos = count($post->ancestors);
  if( $hierarchy_pos > 3 ) {
    $great_grand_parent = wp_get_post_parent_id( $post->post_parent );
    $grand_parent = wp_get_post_parent_id( $great_grand_parent );
    $parent = wp_get_post_parent_id($grand_parent);
  } elseif( $hierarchy_pos == 3 ) {
    $grand_parent = wp_get_post_parent_id( $post->post_parent );
    $parent = wp_get_post_parent_id($grand_parent);
  } elseif( $hierarchy_pos == 2 ) {
    $parent = wp_get_post_parent_id( $post->post_parent );
  } elseif( $hierarchy_pos == 0 ) {
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

  if(!empty($list)) {
    $parent_top = array_reverse(get_post_ancestors($post->ID));
    if(!empty($parent_top)) {
      $first_parent = get_page($parent_top[0]);
      $parent_css = '';
    }

    if(empty($parent_top) || $first_parent->ID == get_the_ID()) {
      $parent_css = 'current_page_item';
      $first_parent = get_page(get_the_ID());
    }

 ?>
    <nav class="sub-pages-navigation" itemscope itemtype="http://schema.org/SiteNavigationElement/">
      <span class="h2" class="<?php echo $parent_css; ?>"><a href="<?php echo get_permalink($first_parent->ID); ?>"><?php echo $first_parent->post_title; ?></a></span>
      <ul><?php echo $list; ?></ul>
    </nav>

<?php

  } //!empty($list)

  if(!empty($pretend_id)) {
    wp_reset_postdata();
  }

}


/* =========================================================
  05. Posted on
 ======================================================== */

function aucor_starter_posted_on() {
  $time_string_format = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
  $time_string = sprintf( $time_string_format, esc_attr( get_the_date( 'j.n.Y' ) ), esc_html( get_the_date() ));
  echo '<span class="posted-on">' . $time_string . '</span>';
}


/* =========================================================
  06. Entry footer
 ======================================================== */

function aucor_starter_entry_footer() {
  // Hide category and tag text for pages.
  if ( get_post_type() === 'post' ) {

    $categories_list = get_the_category_list(', ');
    if ( $categories_list ) {
      printf( '<span class="cat-links">' . ask__('Taxonomies: Categories') . ': %1$s' . '</span>', $categories_list );
    }

    $tags_list = get_the_tag_list('', ', ');
    if ( $tags_list ) {
      printf( '<span class="tags-links">' . ask__('Taxonomies: Keywords') . ': %1$s' . '</span>', $tags_list );
    }
  }
}


/* =========================================================
 *  07. Menu toggle btn
 ======================================================== */

function aucor_starter_menu_toggle_btn( $id, $args = array() ) {

  // Set defaults
  $defaults = array(
    'class'                => '',
    'label'                => '',
    'screen-reader-text'   => ask__('Menu: Button label'),
  );

  // Parse args
  $args = wp_parse_args($args, $defaults);

  // Setup class
  $class = 'menu-toggle';
  if(!empty($args['class'])) {
    $class .= ' ' . trim($args['class']);
  }

?>

  <button id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($class); ?>" aria-expanded="false">
    <span class="screen-reader-text"><?php echo esc_html($args['screen-reader-text']); ?></span>
    <svg class="icon icon-menu-toggle" aria-hidden="true" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100">
      <g class="svg-menu-toggle">
        <path class="line line-1" d="M5 13h90v14H5z"/>
        <path class="line line-2" d="M5 43h90v14H5z"/>
        <path class="line line-3" d="M5 73h90v14H5z"/>
        <path class="close-line close-line-1" d="M5 43h90v14H5z"/>
        <path class="close-line close-line-2" d="M5 43h90v14H5z"/>
      </g>
    </svg>
    <?php if(!empty($args['label'])) : ?>
      <span class="menu-toggle-label"><?php echo esc_html($args['label']); ?></span>
    <?php endif; ?>
  </button>

<?php
}

/* =========================================================
  08.
 ======================================================== */
