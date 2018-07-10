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

  <?php get_template_part('partials/hero'); ?>

  <div id="primary" class="primary primary--index">
    <main id="main" class="main">

      <?php while (have_posts()) : the_post(); ?>

        <?php get_template_part('partials/teaser'); ?>

      <?php endwhile; ?>

      <?php aucor_starter_numeric_posts_nav(); ?>

    </main><!-- #main -->
  </div><!-- #primary -->

<?php
get_footer();
