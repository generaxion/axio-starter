<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package aucor_starter
 */

get_header(); ?>

  <?php get_template_part('partials/content/hero'); ?>

  <div id="primary" class="primary primary--single">

    <main id="main" class="main">

      <?php while (have_posts()) : the_post(); ?>

        <?php get_template_part('partials/content/entry-post'); ?>

      <?php endwhile; ?>

    </main><!-- #main -->

  </div><!-- #primary -->

<?php
get_footer();
