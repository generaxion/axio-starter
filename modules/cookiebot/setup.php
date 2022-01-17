<?php
/**
 * Cookiebot
 *
 * @package axio
 */

/*
 * Add attribute data-cookieconsent="ignore" to x-js script
 *
 * Fixes problem where CookieBot is blocking main.js when only necessary cookies are allowed
 */
add_filter('script_loader_tag', function($tag, $handle, $src) {

  if (in_array($handle, ['x-js'])) {
    $tag = str_replace('<script ', '<script data-cookieconsent="ignore" ', $tag);
  }
  return $tag;

}, 10, 3);
