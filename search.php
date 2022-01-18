<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package axio
 */

get_header(); ?>

  <div id="primary" class="primary primary--search">

    <div class="heading heading--search">

      <h1 class="heading__title">
        <?php echo esc_html(ask__('Title: Search')) . ': '; ?>
        <?php echo esc_html(get_search_query()); ?>
      </h1>

      <?php if (!have_posts()) : ?>
        <div class="heading__description">
          <p role="status"><?php ask_e('Search: Nothing found description'); ?></p>
        </div>
        <?php if (class_exists('X_Search_Form')) : ?>
          <?php X_Search_Form::render(); ?>
        <?php endif; ?>
      <?php endif; ?>

    </div>

    <?php if (have_posts()) : ?>

      <div class="teaser-container js-teaser-container">

        <?php while (have_posts()) : the_post(); ?>

          <?php if (class_exists('X_Teaser')) : ?>
            <?php X_Teaser::render(['id' => get_the_ID()]); ?>
          <?php endif; ?>

        <?php endwhile; ?>

      </div>

      <?php X_Posts_Nav_Numeric::render(); ?>

    <?php endif; ?>

  </div><!-- #primary -->

<?php
get_footer();
