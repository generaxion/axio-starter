<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package axio
 */

$title = ask__('Title: Archives');
if (is_tag() || is_category() || is_tax()) {
  $title = single_term_title('', false);
} elseif (is_home()) {
  $title = ask__('Title: Home');
}

$description = get_the_archive_description();

get_header(); ?>

  <div id="primary" class="primary primary--index">

    <div class="heading heading--index">
      <h1 class="heading__title"><?php echo esc_html($title); ?></h1>
      <div class="heading__description">
        <?php echo apply_filters('the_content', $description); ?>
      </div>
    </div>

    <div class="teaser-container js-teaser-container">
      <?php while (have_posts()) : the_post(); ?>
        <?php if (class_exists('X_Teaser')) : ?>
          <?php X_Teaser::render(['id' => get_the_ID()]); ?>
        <?php endif; ?>
      <?php endwhile; ?>
    </div>

    <?php X_Posts_Nav_Numeric::render(); ?>

  </div><!-- #primary -->

<?php
get_footer();
