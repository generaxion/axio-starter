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

  <?php Aucor_Hero::render(); ?>

  <div id="primary" class="primary primary--index">
    <main id="main" class="main">

      <div class="teaser-container">
        <?php while (have_posts()) : the_post(); ?>
          <?php Aucor_Teaser::render(['id' => get_the_ID()]); ?>
        <?php endwhile; ?>
      </div>

      <?php Aucor_Posts_Nav_Numeric::render(); ?>

    </main><!-- #main -->
  </div><!-- #primary -->

<?php
get_footer();
