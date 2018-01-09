<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package aucor_starter
 */

get_header(); ?>

  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

    <?php if (have_posts()) : ?>

      <header class="page-header">
        <?php
          the_archive_title('<h1 class="page-title">', '</h1>');
          the_archive_description('<div class="taxonomy-description">', '</div>');
        ?>
      </header><!-- .page-header -->

      <?php while (have_posts()) : the_post(); ?>

        <?php get_template_part('partials/content'); ?>

      <?php endwhile; ?>

      <?php aucor_starter_numeric_posts_nav(); ?>

    <?php else : ?>

      <?php get_template_part('partials/content', 'none'); ?>

    <?php endif; ?>

    </main><!-- #main -->
  </div><!-- #primary -->

<?php
get_footer();
