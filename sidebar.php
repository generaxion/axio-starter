<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */

?>

<aside id="secondary" class="widget-area" role="complementary" itemscope itemtype="http://schema.org/WPSideBar">
  <?php aucor_starter_sub_pages_navigation(); ?>
  <?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside><!-- #secondary -->

