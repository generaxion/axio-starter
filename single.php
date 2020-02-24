<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package aucor_starter
 */

get_header(); ?>

  <?php Aucor_Hero::render(); ?>

  <div id="primary" class="primary primary--single">

    <?php while (have_posts()) : the_post(); ?>

      <article id="post-<?php the_ID(); ?>" <?php post_class('entry entry--post'); ?>>

        <div class="entry__content wysiwyg">
          <?php the_content(); ?>
        </div>

        <footer class="entry__footer">
          <?php
            Aucor_List_Terms::render([
              'title'     => ask__('Taxonomies: Categories'),
              'taxonomy'  => 'category'
            ]);
            Aucor_List_Terms::render([
              'title'     => ask__('Taxonomies: Keywords'),
              'taxonomy'  => 'post_tag'
            ]);
            Aucor_Share_Buttons::render([
              'section_title' => ask__('Social share: Title')
            ]);
          ?>
        </footer>

      </article>

    <?php endwhile; ?>

  </div><!-- #primary -->

<?php
get_footer();
