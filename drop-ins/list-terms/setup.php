<?php
/**
 * Setup: List Terms
 *
 * @package aucor_starter
 */

add_action('theme_after_post', function() {
  Aucor_List_Terms::render([
    'title'     => ask__('Taxonomies: Categories'),
    'taxonomy'  => 'category'
  ]);
  Aucor_List_Terms::render([
    'title'     => ask__('Taxonomies: Keywords'),
    'taxonomy'  => 'post_tag'
  ]);
}, 100, 1);