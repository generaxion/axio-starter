<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package axio
 */

get_header(); ?>

  <div id="primary" class="primary primary--404">

    <div class="heading heading--404">

      <h1 class="heading__title"><?php echo esc_html(ask__('Title: 404')); ?></h1>

      <div class="heading__description">
        <p role="status"><?php ask_e('404: Page not found description'); ?></p>
      </div>

    </div>

  </div><!-- #primary -->

<?php
get_footer();
