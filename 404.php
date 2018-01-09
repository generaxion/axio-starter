<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package aucor_starter
 */

get_header(); ?>

  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

      <div class="error-404 not-found">
        <div class="page-content">
          <h1 class="entry-title"><?php ask_e('404: Page not found'); ?></h1>
          <div class="entry-content">
            <p><?php ask_e('404: Page not found description'); ?></p>
            <div class="search-404 search-form">
              <?php get_search_form(); ?>
            </div>
          </div>
        </div><!-- .page-content -->
      </div><!-- .error-404 -->

    </main><!-- #main -->
  </div><!-- #primary -->

<?php
get_footer();
