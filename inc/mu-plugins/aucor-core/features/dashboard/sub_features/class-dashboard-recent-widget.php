<?php
/**
 * Class Dashboard_Recent_Widget
 */
class Aucor_Core_Dashboard_Recent_Widget extends Aucor_Core_Sub_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'aucor_core_dashboard_recent_widget');

    // var: name
    $this->set('name', 'Adds a widget displaying recent activity on the site to the dashboard');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Run feature
   */
  public function run() {
    add_action('wp_dashboard_setup', array($this, 'register_aucor_recent_dashboard_widget'));
    add_action('admin_enqueue_scripts', array($this, 'aucor_recent_dashboard_widget_styles'));
  }

  /**
   * Register the widget
   */
  public static function register_aucor_recent_dashboard_widget() {
    global $wp_meta_boxes;

    add_meta_box( 'aucor_recent_dashboard_widget', __('Activity'), array('Aucor_Core_Dashboard_Recent_Widget', 'aucor_recent_dashboard_widget_display'), 'dashboard', 'side', 'high' );
  }

  /**
   * Build the widget to display
   */
  public static function aucor_recent_dashboard_widget_display() {
    $current_user_id = intval(get_current_user_id());
    $current_user_obj = get_user_by('ID', $current_user_id);
    $post_types = get_post_types(array('show_ui' => true));
    $skip_post_types = array('attachment', 'revision', 'acf-field', 'acf-field-group', 'nav_menu_item', 'polylang_mo');
    $post_types = array_diff($post_types, $skip_post_types);
    $date_format = get_option('date_format');
    $time_format = get_option('time_format');
    //Date format to j.n.Y and time format to H:i
    if (!strstr($date_format, '.Y')) {
      $date_format = 'j.n.Y';
      $time_format = 'H:i';
    }

    $user_posts = array();
    global $wpdb;

    /*
      * GET REVISIONS BY CURRENT USER
      * ==============================
      * Use $wpdb because there is no clean way to get revisions. We group the posts by post_parent because
      * multiple revisions might point to same post. We only need the post_parent ID because that points us
      * to the original post_type post that we will need. Grouping messes up post_modified but order seems
      * to be correct. This will break in multi-sites, I think.
      */

    $my_revisions = $wpdb->get_results("SELECT post_parent FROM $wpdb->posts WHERE post_author = $current_user_id AND post_type = 'revision' GROUP BY post_parent ORDER BY post_modified DESC LIMIT 4");

    foreach ($my_revisions as $revision) {
      array_push($user_posts, get_post($revision->post_parent));
    }

    // recently published
    $args = array(
      'post_type' => $post_types,
      'author' => $current_user_id,
      'posts_per_page' => 6,
      'post_status' => 'any',
      'orderby' => 'date',
      'order' => 'DESC',
      'no_found_rows' => true, // no pagination
      'update_post_term_cache' => false, // no tax
      'update_post_meta_cache' => false, // no meta
    );

    $user_query = new WP_Query( $args );

    while ($user_query->have_posts()) : $user_query->the_post();
      $post_is_unique = true;
      foreach ($user_posts as $user_post) {
        if ($user_query->post->ID == $user_post->ID) {
          $post_is_unique = false;
        }
      }
      if ($post_is_unique) {
        $post_revisions = wp_get_post_revisions($user_query->post->ID, '');
        if (!empty($post_revisions)) {
          $most_recent_revision_id = max(array_keys($post_revisions));
          $user_query->post->post_modified = $post_revisions[$most_recent_revision_id]->post_modified;
        }
        array_push($user_posts, $user_query->post);
      }
    endwhile;

    usort($user_posts, array('Aucor_Core_Dashboard_Recent_Widget', 'aucor_core_order_posts_array_by_modified_date'));
    $user_posts = array_reverse($user_posts);

    if (!empty($user_posts)) :
      ?>
      <div class="aucor-recent-section">
        <h3><?php echo esc_attr__('My content and changes', 'aucor-core'); ?></h3>
      <?php
        $limit = (count($user_posts) > 4) ? 4 : count($user_posts);
        echo '<ul>';
        for ($i=0; $i < $limit; $i++) {
          $title = $user_posts[$i]->post_title;
          $obj = get_post_type_object($user_posts[$i]->post_type);
          if (is_object($obj)) {
            $title .= ' (' . $obj->labels->singular_name . ')';
          }
          $modified_time = date_create($user_posts[$i]->post_modified);
      ?>
        <li><span class="aucor-recent-time"><?php echo date_format($modified_time, "$date_format $time_format" ); ?></span><span class="aucor-recent-link"><?php edit_post_link($title, '', '', $user_posts[$i]->ID); ?></span></li>
        <?php
      }
        ?>
        </ul>
      </div>
      <?php
    endif;

    // prevent users without post editing capabilities from viewing the recent edits section
    // (results in empty items for posts by others, so no new information is conveyed for them)
    $user_blacklist = apply_filters('aucor_core_recent_widget_user_blacklist', array('subscriber', 'contributor', 'author'));

    if (array_diff($current_user_obj->roles, $user_blacklist)) :
    ?>

    <div class="aucor-recent-section">
      <h3><?php echo esc_attr__('Recent edits', 'aucor-core'); ?></h3>
      <?php
      $args = array(
        'post_type' => $post_types,
        'posts_per_page' => 6,
        'post_status' => array('publish', 'private', 'future', 'pending'),
        'orderby' => 'modified',
        'order' => 'DESC',
        'no_found_rows' => true, // no pagination
        'update_post_term_cache' => false, // no tax
        'update_post_meta_cache' => false, // no meta
      );
      $query = new WP_Query($args);
      echo '<ul>';
      while ($query->have_posts()) : $query->the_post();
        $obj = get_post_type_object(get_post_type());
        $title = $query->post->post_title . ' (' . $obj->labels->singular_name . ')';
      ?>
        <li><span class="aucor-recent-time"><?php echo get_the_modified_date("$date_format $time_format"); ?></span><span class="aucor-recent-link"><?php edit_post_link($title, '', '', $query->post->ID); ?></span></li>
        <?php
      endwhile;
      echo '</ul>';
      ?>
    </div>
      <?php
    endif;
  }

  /**
   * Enqueue custom styles
   */
  public static function aucor_recent_dashboard_widget_styles($hook) {
    if ($hook == 'index.php') {
      wp_enqueue_style('aucor_core-dashboard-widget-styles', AUCOR_CORE_DIR . '/dist/styles/main.css');
    }
  }

  /**
   * Helper function - order posts from nearest to oldest
   */
  public static function aucor_core_order_posts_array_by_modified_date($a, $b) {
    return strcmp(strtotime($a->post_modified), strtotime($b->post_modified));
  }
}

