<?php
/**
 * Template part: Teaser
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package aucor_starter
 */

?>

<article id="teaser-<?php the_ID(); ?>" <?php post_class('teaser teaser--' . get_post_type()); ?>>

  <div class="teaser__thumbnail">

    <a href="<?php the_permalink(); ?>">
      <?php if (has_post_thumbnail()) : ?>
        <?php echo aucor_starter_get_image(get_post_thumbnail_id(), 'thumbnail'); ?>
      <?php else : ?>
        <div class="teaser__thumbnail__fallback"></div>
      <?php endif; ?>
    </a>

  </div>

  <div class="teaser__content">

    <header class="teaser__header">
      <?php the_title(sprintf('<h2 class="teaser__header__title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>'); ?>
    </header>

    <div class="teaser__summary">
      <?php the_excerpt(); ?>
    </div>

  </div>

</article>
