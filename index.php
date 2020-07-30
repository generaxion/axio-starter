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
 * @package aucor_starter
 */

get_header(); ?>

  <?php
    if (has_action('theme_hero')) {
      do_action('theme_hero');
    }
  ?>

  <div id="primary" class="primary primary--index">

      <div class="teaser-container">
        <?php while (have_posts()) : the_post(); ?>
          <?php if (class_exists('Aucor_Teaser')) : ?>
            <?php Aucor_Teaser::render(['id' => get_the_ID()]); ?>
          <?php endif; ?>
        <?php endwhile; ?>
      </div>

      <?php Aucor_Posts_Nav_Numeric::render(); ?>

  </div><!-- #primary -->

<?php
get_footer();
