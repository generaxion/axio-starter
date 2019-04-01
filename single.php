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

        <article id="post-<?php the_ID(); ?>" <?php post_class('entry entry--post'); ?>>

          <div class="entry__content wysiwyg">
            <?php the_content(); ?>
          </div>

          <footer class="entry__footer">
            <?php aucor_starter_entry_footer(); ?>
            <?php aucor_starter_social_share_buttons(); ?>
          </footer>

        </article>

      <?php endwhile; ?>

    </main><!-- #main -->

  </div><!-- #primary -->

<?php
get_footer();
