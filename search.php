<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package aucor_starter
 */

get_header(); ?>

<?php get_template_part('partials/content/hero'); ?>

  <div id="primary" class="primary primary--search">

    <main id="main" class="main">

    <?php if (have_posts()) : ?>

      <div class="teaser-container">
        <?php while (have_posts()) : the_post(); ?>
          <?php get_template_part('partials/content/teaser'); ?>
        <?php endwhile; ?>
      </div>

      <?php aucor_starter_numeric_posts_nav(); ?>

    <?php else : ?>

      <article class="entry entry--search-empty">

        <div class="entry__content">
          <p><?php ask_e('Search: Nothing found description'); ?></p>
            <?php aucor_starter_search_form('search-form--search-empty', ['class' => 'search-form--search-empty']); ?>
        </div>

      </article>

    <?php endif; ?>

    </main><!-- #main -->

  </div><!-- #primary -->

<?php
get_footer();
