<?php
/**
 * Header
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package aucor_starter
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?> itemscope itemtype="https://schema.org/WebPage">

<div class="mobile-menu js-mobile-menu">
  <div class="mobile-menu__nav" role="dialog">
    <?php Aucor_Menu_Toggle::render(); ?>
    <div class="mobile-menu__nav__inner">
      <?php Aucor_Menu_Primary::render(); ?>
      <?php Aucor_Menu_Additional::render(); ?>
    </div>
  </div>
  <div class="mobile-menu__overlay" data-a11y-dialog-hide tabindex="-1"></div>
</div>

<div id="page" class="site js-page">

  <a class="skip-to-content" href="#content"><?php ask_e('Accessibility: Skip to content'); ?></a>

  <header id="masthead" class="site-header" itemscope itemtype="https://schema.org/WPHeader">

    <div class="site-header__inner">

      <div class="site-header__branding">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="site-header__title" rel="home" itemprop="headline">
          <img class="site-header__logo" width="150" height="80" src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/logo.svg" loading="lazy" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" />
        </a>
      </div>

      <?php Aucor_Menu_Toggle::render(); ?>

      <div class="site-header__menus">
        <?php
          Aucor_Menu_Additional::render([
            'attr' => [
              'class' => ['site-header__additional', 'desktop-menu']
            ]
          ]);
        ?>

        <?php
          Aucor_Menu_Primary::render([
            'attr' => [
              'class' => ['site-header__main', 'desktop-menu']
            ]
          ]);
        ?>

      </div>

    </div>

  </header>

  <div id="content" class="site-content" role="main" itemscope itemprop="mainContentOfPage">
