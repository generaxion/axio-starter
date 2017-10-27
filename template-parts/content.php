<?php
/**
 * Template part: Generic content template
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <header class="entry-header">

    <?php
      if ( is_single() ) {
        the_title( '<h1 class="entry-title">', '</h1>' );
      } else {
        the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
      }
    ?>

    <div class="entry-meta">
      <?php aucor_starter_posted_on(); ?>
    </div><!-- .entry-meta -->

  </header><!-- .entry-header -->

  <div class="entry-content">
    <?php the_content(); ?>
  </div><!-- .entry-content -->

  <footer class="entry-footer">
    <?php aucor_starter_entry_footer(); ?>
  </footer><!-- .entry-footer -->
</article><!-- #post-## -->
