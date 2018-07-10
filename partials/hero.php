<?php
/**
 * Template part: Hero
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package aucor_starter
 */

// extra classes
$class = array();

// title
if (is_singular()) {
  $title = get_the_title();
} else {
  $title = aucor_starter_get_the_archive_title();
}


// description
$description = '';
if (is_singular()) {
  $description = get_post_meta(get_the_ID(), 'lead', true);
} else {
  $description = get_the_archive_description();
}

// background
$image = '';
if (is_singular() && has_post_thumbnail()) {
  $image = aucor_starter_get_image(get_post_thumbnail_id(), 'hero', ['lazyload' => 'animated']);

}

if (!empty($image)) {
  $class[] = 'hero--has-background';
} else {
  $class[] = 'hero--no-background';
}

?>

<div class="hero <?php echo implode(', ', $class); ?>">

  <?php if (!empty($image)) : ?>
    <div class="hero__background">
      <div class="hero__background__image">
        <?php echo $image; ?>
      </div>
      <div class="hero__background__dimming"></div>
    </div>
  <?php endif; ?>

  <div class="hero__container">

    <h1 class="hero__title"><?php echo $title; ?></h1>

    <?php if (!empty($description)) : ?>
      <p class="hero__description"><?php echo $description; ?></p>
    <?php endif; ?>

  </div>

</div>
