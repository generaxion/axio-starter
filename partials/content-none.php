<?php
/**
 * Template part: Posts not found
 *
 * @package aucor_starter
 */

?>

<article class="error-404 not-found">
  <div class="page-content">
    <h1 class="entry-title"><?php ask_e('Search: Nothing found'); ?></h1>
    <div class="entry-content">
      <p><?php ask_e('Search: Nothing found description'); ?></p>
      <div class="search-form search-404">
        <?php get_search_form(); ?>
      </div>
    </div>
  </div><!-- .page-content -->
</article><!-- .error-404 -->
