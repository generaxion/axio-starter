<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package aucor_starter
 */

get_header(); ?>

  <?php 
    if (has_action('theme_hero')) {
      do_action('theme_hero');
    } 
  ?>

  <div id="primary" class="primary primary--single">

    <?php while (have_posts()) : the_post(); ?>

      <article id="post-<?php the_ID(); ?>" <?php post_class('entry entry--post'); ?>>

        <div class="entry__content wysiwyg">
          <?php the_content(); ?>
        </div>


        <?php if(has_action('theme_after_post')) : ?>
          <footer class="entry__footer">
            <?php do_action('theme_after_post'); ?>
          </footer>
        <?php endif; ?>

      </article>

    <?php endwhile; ?>

  </div><!-- #primary -->

<?php
get_footer();
