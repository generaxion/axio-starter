<?php
/**
 * Function for social share buttons
 *
 * @package aucor_starter
 */

/**
 * Social share buttons
 *
 * Display share links to social media platforms.
 *
 * @example aucor_starter_social_share_buttons()
 */
function aucor_starter_social_share_buttons() {

  $url = (!is_tax()) ? get_permalink() : get_term_link(get_queried_object()->term_id);
  $title = get_the_title();

  ?>
  <div class="social-share">

    <span class="social-share__title h3"><?php ask_e('Social share: Title'); ?></span>

    <a href="<?php echo esc_url("https://www.facebook.com/sharer/sharer.php?u=$url"); ?>" target="_blank" class="social-share__link social-share__link--facebook">
      <?php echo aucor_starter_get_svg('facebook'); ?>
      <span class="social-share__link__label"><?php ask_e('Social share: Facebook'); ?></span>
    </a>

    <a href="<?php echo esc_url("https://twitter.com/share?url=$url"); ?>" target="_blank" class="social-share__link social-share__link--twitter">
      <?php echo aucor_starter_get_svg('twitter'); ?>
      <span class="social-share__link__label"><?php ask_e('Social share: Twitter'); ?></span>
    </a>

    <a href="<?php echo esc_url("https://www.linkedin.com/shareArticle?mini=true&title=$title&url=$url"); ?>" target="_blank" class="social-share__link social-share__link--linkedin">
      <?php echo aucor_starter_get_svg('linkedin'); ?>
      <span class="social-share__link__label"><?php ask_e('Social share: LinkedIn'); ?></span>
    </a>

  </div>
  <?php

}
