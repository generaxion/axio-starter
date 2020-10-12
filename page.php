<?php
/**
 * Default template for pages.
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

  <div id="primary" class="primary primary--page">

      <?php while (have_posts()) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('entry entry--page'); ?>>

          <div class="entry__content blocks">

            <?php the_content(); ?>

          </div>

        </article>

      <?php endwhile; ?>

  </div><!-- #primary -->

<?php
get_footer();
