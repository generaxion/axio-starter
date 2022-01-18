<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package axio
 */

get_header(); ?>

  <div id="primary" class="primary primary--single">

    <?php while (have_posts()) : the_post(); ?>

      <article id="post-<?php the_ID(); ?>" <?php post_class('entry entry--post'); ?>>

        <div class="entry__header <?php echo has_post_thumbnail() ? 'entry__header--has-media' : 'entry__header--no-media'; ?>">
          <?php if (has_post_thumbnail()) : ?>
            <div class="entry__media">
              <?php
                X_Image::render([
                  'id'    => get_post_thumbnail_id(),
                  'size'  => 'large',
                ]);
              ?>
            </div>
          <?php endif; ?>
          <h1 class="entry__title"><?php the_title(); ?></h1>
          <div class="entry__meta"><?php echo x_get_posted_on(); ?></div>
        </div>

        <div class="entry__content blocks">
          <?php the_content(); ?>
        </div>

        <?php if (has_action('theme_entry_footer')) : ?>
          <footer class="entry__footer">
            <?php do_action('theme_entry_footer', get_the_ID()); ?>
          </footer>
        <?php endif; ?>

      </article>

    <?php endwhile; ?>

  </div><!-- #primary -->

<?php
get_footer();
