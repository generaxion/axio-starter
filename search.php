<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package aucor_starter
 */

get_header(); ?>

  <?php Aucor_Hero::render(); ?>

  <div id="primary" class="primary primary--search">

    <main id="main" class="main">

    <?php if (have_posts()) : ?>

      <div class="teaser-container">
        <?php while (have_posts()) : the_post(); ?>
          <?php Aucor_Teaser::render(['id' => get_the_ID()]); ?>
        <?php endwhile; ?>
      </div>

      <?php Aucor_Posts_Nav_Numeric::render(); ?>

    <?php else : ?>

      <article class="entry entry--search-empty">

        <div class="entry__content">
          <p><?php ask_e('Search: Nothing found description'); ?></p>
          <?php
            Aucor_Search_Form::render([
              'attr' => [
                'class' => ['search-form--no-results'],
              ],
            ]);
          ?>
        </div>

      </article>

    <?php endif; ?>

    </main><!-- #main -->

  </div><!-- #primary -->

<?php
get_footer();
