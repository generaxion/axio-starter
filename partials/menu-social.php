<?php
/**
 * Template part: Social menu
 *
 * @package aucor_starter
 */

?>

<nav id="social-navigation" class="social-navigation" aria-label="<?php ask_e('Menu: Social Menu'); ?>" itemscope itemtype="http://schema.org/SiteNavigationElement">

  <?php
  wp_nav_menu(array(
    'theme_location' => 'social',
    'container'      => '',
    'menu_id'        => 'social-navigation__items',
    'menu_class'     => 'social-navigation__items',
    'depth'          => 1,
    'link_before'    => '',
    'link_after'     => '',
    'fallback_cb'    => '',
  ));
  ?>

</nav><!-- #social-navigation -->
