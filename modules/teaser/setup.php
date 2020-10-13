<?php
/**
 * Module: Teaser
 *
 * @package aucor_starter
 */

/**
 * Image sizing
 */
add_filter('theme_image_sizing', function($sizes) {

  $sizes['teaser'] = [
    'primary'    => 'thumbnail',
    'supporting' => ['thumbnail'],
    'sizes'      => '250px'
  ];

  return $sizes;

});
