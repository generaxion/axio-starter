<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package aucor_starter
 */

get_header(); ?>

  <?php
    if (has_action('theme_hero')) {
      do_action('theme_hero');
    }
  ?>

  <div id="primary" class="primary primary--search">

    <?php if (have_posts()) : ?>

      <div class="teaser-container">

        <?php while (have_posts()) : the_post(); ?>

          <?php if (class_exists('Aucor_Teaser')) : ?>
            <?php Aucor_Teaser::render(['id' => get_the_ID()]); ?>
          <?php endif; ?>

        <?php endwhile; ?>

      </div>

      <?php Aucor_Posts_Nav_Numeric::render(); ?>

    <?php else : ?>

      <article class="entry entry--search-empty">

        <div class="entry__content">

          <p role="status"><?php ask_e('Search: Nothing found description'); ?></p>

          <?php if (class_exists('Aucor_Search_Form')) : ?>
            <?php
              Aucor_Search_Form::render([
                'attr' => [
                  'class' => ['search-form--no-results'],
                ],
              ]);
            ?>
          <?php endif; ?>

        </div>

      </article>

    <?php endif; ?>

  </div><!-- #primary -->

<?php
get_footer();
