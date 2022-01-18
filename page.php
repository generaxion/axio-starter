<?php
/**
 * Default template for pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package axio
 */

get_header(); ?>

  <div id="primary" class="primary primary--page">

      <?php while (have_posts()) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('entry entry--page'); ?>>

          <?php if (!has_block('acf/hero') && !strstr(get_the_content(), '<h1 ')) : ?>
            <div class="heading heading--page">
              <h1 class="heading__title"><?php the_title(); ?></h1>
            </div>
          <?php endif; ?>

          <div class="entry__content blocks">

            <?php the_content(); ?>

          </div>

        </article>

      <?php endwhile; ?>

  </div><!-- #primary -->

<?php
get_footer();
