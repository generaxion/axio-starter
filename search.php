<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package aucor_starter
 */

get_header(); ?>

  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

    <?php if (have_posts()) : ?>

      <header class="page-header">
        <h1 class="page-title"><?php printf(ask__('Search: Title') . '<span class="search-terms">' . get_search_query() . '</span>'); ?></h1>
      </header><!-- .page-header -->

      <?php while (have_posts()) : the_post(); ?>

        <?php get_template_part('partials/content', 'search'); ?>

      <?php endwhile; ?>

      <?php aucor_starter_numeric_posts_nav(); ?>

    <?php else : ?>

      <?php get_template_part('partials/content', 'none'); ?>

    <?php endif; ?>

    </main><!-- #main -->
  </div><!-- #primary -->

<?php
get_footer();
