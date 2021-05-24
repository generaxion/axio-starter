<?php
/**
 * Header
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package axio
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

<?php do_action('theme_before_page'); ?>

<div id="page" class="site js-page">

  <a class="skip-to-content" href="#content"><?php ask_e('Accessibility: Skip to content'); ?></a>

  <?php do_action('theme_header'); ?>

  <div id="content" class="site-content" role="main" itemscope itemprop="mainContentOfPage">
