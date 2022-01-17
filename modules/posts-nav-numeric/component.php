<?php
/**
 * Component: Menu Toggle
 *
 * @example
 * X_Posts_Nav_Numeric::render();
 *
 * @example
 * X_Posts_Nav_Numeric::render([
 *   'wp_query'   => $custom_wp_query,
 *   'paged_var'  => 'custom_get_var',
 *   'label_next' => 'Next',
 *   'label_prev' => 'Previous',
 * ]);
 *
 * @package axio
 */
class X_Posts_Nav_Numeric extends X_Component {

  public static function frontend($data) {
    ?>

    <nav <?php parent::render_attributes($data['attr']); ?>>
      <ul itemscope itemtype="https://schema.org/SiteNavigationElement/Pagination">
        <?php foreach ($data['items'] as $item) : ?>
          <li <?php parent::render_attributes($item['attr']); ?>>
            <?php if (!empty($item['url'])) : ?>
              <a <?php parent::render_attributes($item['sub-attr']); ?>>
                <span><?php echo $item['label']; ?></span>
              </a>
            <?php else : ?>
              <span <?php parent::render_attributes($item['sub-attr']); ?>>
              <?php echo $item['label']; ?>
              </span>
            <?php endif; ?>
          </li>
        <?php endforeach; ?>
      </ul>
    </nav>

    <?php
  }

  public static function backend($args = []) {

    $placeholders = [

      // required (none)

      // optional
      'attr'               => [],
      'wp_query'           => null,
      'paged_var'          => '',
      'label_next'         => X_SVG::get(['name' => 'chevron-right']) . '<span class="screen-reader-text">' . ask__('Navigation: Next') . '</span>',
      'label_prev'         => X_SVG::get(['name' => 'chevron-right']) . '<span class="screen-reader-text">' . ask__('Navigation: Previous') . '</span>',

      // internal
      'items'              => [],

    ];
    $args = wp_parse_args($args, $placeholders);

    // setup WP_Query
    global $wp_query;
    $wp_query_temp = null;
    if ($args['wp_query'] instanceof WP_Query) {
      $wp_query_temp = $wp_query;
      $wp_query = $args['wp_query'];
    }

    // classes
    if (!isset($args['attr']['class'])) {
      $args['attr']['class'] = [];
    }
    $args['attr']['class'][] = 'numeric-navigation';
    $args['attr']['role'] = 'navigation';
    $args['attr']['aria-label'] = ask__('Navigation: Numeric pagination');

    $paged_variable        = (empty($args['paged_var'])) ? 'paged' : $args['paged_var'];
    $has_default_paged_var = ($paged_variable === 'paged') ? true : false;
    $max_num_pages         = $wp_query->max_num_pages;

    // no pagination, bail early
    if ($max_num_pages <= 1) {
      // reset previous global wp_query
      if (!empty($wp_query_temp)) {
        $wp_query = $wp_query_temp;
      }
      return $args;
    }

    // curent page number
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

    // remove current paged var from url
    $clean_url = esc_url(remove_query_arg($paged_variable));

    // previous post link
    $prev_page_url = '';
    if ($has_default_paged_var && get_previous_posts_link()) {
      $prev_page_url = previous_posts(false);
    } elseif ($paged > 1) {
      $prev_page_url = add_query_arg($paged_variable, ($paged - 1), $clean_url);
    }
    if (!empty($prev_page_url)) {
      $args['items'][] = [
        'url'     => $prev_page_url,
        'label'   => $args['label_prev'],
        'type'    => 'previous',
        'active'  => false,
      ];
    }

    // first page
    if (!in_array(1, $links)) {
      $args['items'][] = [
        'url'     => ($has_default_paged_var) ? get_pagenum_link(1) : $clean_url,
        'label'   => '1',
        'type'    => 'pagenum',
        'active'  => ($paged === 1),
      ];
      if (!in_array(2, $links)) {
        $args['items'][] = [
          'url'     => '',
          'label'   => '…',
          'type'    => 'separator',
          'active'  => false,
        ];
      }
    }

    // link to current page, plus 2 pages in either direction if necessary
    sort($links);

    foreach ((array) $links as $page_nmb) {
      $args['items'][] = [
        'url'     => ($has_default_paged_var) ? get_pagenum_link($page_nmb) : add_query_arg($paged_variable, $page_nmb, $clean_url),
        'label'   => $page_nmb,
        'type'    => 'pagenum',
        'active'  => ($paged === $page_nmb),
      ];
    }

    // last page
    if (!in_array($max, $links)) {

      if (!in_array($max - 1, $links)) {
        $args['items'][] = [
          'url'   => '',
          'label' => '…',
          'type'    => 'separator',
          'active'  => false,
        ];
      }

      $args['items'][] = [
        'url'     => ($has_default_paged_var) ? get_pagenum_link($max) : add_query_arg($paged_variable, $max, $clean_url),
        'label'   => $max,
        'type'    => 'pagenum',
        'active'  => ($paged === $max),
      ];

    }

    // next post link
    $next_page_url = '';
    if ($has_default_paged_var && get_next_posts_link()) {
      $next_page_url = next_posts($max, false);
    } elseif ($paged < $max && $max > 1) {
      $next_page_url = add_query_arg($paged_variable, ($paged + 1), $clean_url);
    }
    if (!empty($next_page_url)) {
      $args['items'][] = [
        'url'   => $next_page_url,
        'label' => $args['label_next'],
        'type'    => 'next',
        'active'  => false,
      ];
    }

    // add meta attributes to items
    foreach ($args['items'] as $key => $item) {

      $attr = [];
      $attr['class'] = [];

      $sub_attr = [];
      $sub_attr['class'] = [];

      $attr['class'][] = 'numeric-navigation__item';
      $attr['class'][] = 'numeric-navigation__item--' . $item['type'];

      if ($item['active']) {
        $attr['class'][] = 'numeric-navigation__item--active';
        $sub_attr['aria-current'] = 'true';
      }

      if ($item['type'] === 'pagenum') {
        if ($item['active']) {
          $sub_attr['aria-label'] = sprintf(ask__('Navigation: Current page x'), $item['label']);
        } else {
          $sub_attr['aria-label'] = sprintf(ask__('Navigation: Go to page x'), $item['label']);
        }
      }

      if ($item['type'] === 'separator') {
        $attr['aria-hidden'] = 'true';
      }

      if (!empty($item['url'])) {
        $sub_attr['href'] = $item['url'];
      }

      $args['items'][$key]['attr'] = $attr;
      $args['items'][$key]['sub-attr'] = $sub_attr;

    }

    // reset previous global wp_query
    if (!empty($wp_query_temp)) {
      $wp_query = $wp_query_temp;
    }

    // add base class for all items
    foreach ($args['items'] as $key => $item) {
      $args['items'][$key]['class'][] = 'numeric-navigation__item';
    }

    return $args;

  }

}
