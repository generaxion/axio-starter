<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package aucor_starter
 */

get_header(); ?>

<?php get_template_part('partials/hero'); ?>

  <div id="primary" class="primary primary--search">

    <main id="main" class="main">

    <?php if (have_posts()) : ?>

      <?php while (have_posts()) : the_post(); ?>

        <?php get_template_part('partials/teaser'); ?>

      <?php endwhile; ?>

      <?php aucor_starter_numeric_posts_nav(); ?>

    <?php else : ?>

      <article class="entry entry--search-empty">

        <header class="entry__header">
          <h1 class="entry__header__title"><?php ask_e('Search: Nothing found'); ?></h1>
        </header><!-- .entry__header -->

        <div class="entry__content">
          <p><?php ask_e('Search: Nothing found description'); ?></p>
          <div class="search-form search-form--search-empty">
            <?php aucor_starter_search_form('search-form--search-empty'); ?>
          </div>
        </div>

      </article>

    <?php endif; ?>

    </main><!-- #main -->

  </div><!-- #primary -->

<?php
get_footer();
