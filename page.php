<?php
/**
 * Default template for pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package aucor_starter
 */

get_header(); ?>

  <?php get_template_part('partials/content/hero'); ?>

  <div id="primary" class="primary primary--page">

    <main id="main" class="main">

      <?php while (have_posts()) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('entry entry--page'); ?>>

          <div class="entry__content wysiwyg">
            <?php the_content(); ?>
          </div>

        </article>

      <?php endwhile; ?>

    </main><!-- #main -->

  </div><!-- #primary -->

<?php
get_footer();
