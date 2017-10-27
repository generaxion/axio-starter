<?php
/**
 * Template part: Social menu
 */

?>

<nav id="social-navigation" class="social-navigation" role="navigation" aria-label="<?php ask_e('Menu: Social Menu'); ?>" itemscope itemtype="http://schema.org/SiteNavigationElement">

  <?php wp_nav_menu(
    array(
      'theme_location'  => 'social',
      'container'       => '',
      'menu_id'         => 'menu-social-items',
      'menu_class'      => 'menu-social-items',
      'depth'           => 1,
      'link_before'     => '',
      'link_after'      => '',
      'fallback_cb'     => '',
    )
  ); ?>

</nav><!-- .menu-social -->
