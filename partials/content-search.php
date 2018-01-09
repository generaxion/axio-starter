<?php
/**
 * Template part: Search results
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package aucor_starter
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <header class="entry-header">
    <?php the_title(sprintf('<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>'); ?>

    <?php if (get_post_type() == 'post') : ?>
    <div class="entry-meta">
      <?php aucor_starter_posted_on(); ?>
    </div><!-- .entry-meta -->
    <?php endif; ?>
  </header><!-- .entry-header -->

  <div class="entry-summary">
    <?php the_excerpt(); ?>
  </div><!-- .entry-summary -->

  <footer class="entry-footer">
    <?php aucor_starter_entry_footer(); ?>
  </footer><!-- .entry-footer -->
</article><!-- #post-## -->
