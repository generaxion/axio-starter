<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package aucor_starter
 */

get_header(); ?>

  <?php get_template_part('partials/content/hero'); ?>

  <div id="primary" class="primary primary--404">
    <main id="main" class="main">

      <article class="entry entry--404">

        <div class="entry__content">
          <p><?php ask_e('404: Page not found description'); ?></p>
          <?php aucor_starter_search_form('search-form--404', ['class' => 'search-form--404']); ?>
        </div>

      </article><!-- .entry-404 -->

    </main><!-- #main -->
  </div><!-- #primary -->

<?php
get_footer();
