<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package aucor_starter
 */

get_header(); ?>

  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

    <?php while (have_posts()) : the_post(); ?>

      <?php get_template_part('partials/content'); ?>

      <?php
      // if comments are open or we have at least one comment, load up the comment template
      if (comments_open() || get_comments_number()) {
        comments_template();
      }
      ?>

    <?php endwhile; ?>

    </main><!-- #main -->
  </div><!-- #primary -->

<?php
get_footer();
