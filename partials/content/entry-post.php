<?php
/**
 * Template part: Generic content template
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package aucor_starter
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('entry entry--post'); ?>>

  <div class="entry__content wysiwyg">
    <?php the_content(); ?>
  </div>

  <footer class="entry__footer">
    <?php aucor_starter_entry_footer(); ?>
    <?php aucor_starter_social_share_buttons(); ?>
  </footer>

</article>
