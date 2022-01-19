<?php
/**
 * Hero: Data structures
 *
 * @package axio
 */

/**
 * Get post types with hero block
 */
function x_get_post_types_with_hero() {
  return ['page'];
}

/**
 * Register image sizes
 */
add_action('after_setup_theme', function() {

  add_image_size('hero_l', 2000, 750, true);  // hero @1,33x 3:1
  add_image_size('hero_m', 1500, 500, true);  // hero @1x 3:1
  add_image_size('hero_s',  800, 500, true);  // hero mobile 8:5

});

/**
 * Image sizing
 */
add_filter('theme_image_sizing', function($sizes) {

  $sizes['hero'] = [
    'primary'    => 'hero_m',
    'supporting' => ['hero_l', 'hero_m', 'hero_s'],
    'sizes'      => '100vw'
  ];

  return $sizes;

});

/**
 * Register block
 */
add_action('acf/init', function () {

  if (function_exists('acf_register_block_type')) {
    acf_register_block_type([
      'name'              => 'hero',
      'title'             => __('Hero'),
      'render_template'   => dirname(__FILE__) . '/block.php',
      'multiple'          => false,
      'keywords'          => ['header', 'title', 'hero'],
      'category'          => 'common',
      'icon'              => 'slides',
      'mode'              => 'preview',
      'align'             => 'full',
      'post_types'        => x_get_post_types_with_hero(),
      'supports'          => [
        'align'      => ['full'],
        'mode'       => false,
        'jsx'        => true,
      ],
    ]);
  }

});

/**
 * Allow hero block
 */
add_filter('allowed_block_types_all', function($blocks, $block_editor_context) {

  if ($block_editor_context->post instanceof WP_Post && in_array($block_editor_context->post->post_type, x_get_post_types_with_hero())) {
    $blocks[] = 'acf/hero';
  }
  return $blocks;

}, 11, 2);


/**
 * Auto append hero block
 */
add_action('init', function () {

  foreach (x_get_post_types_with_hero() as $post_type) {
    $post_type_object = get_post_type_object($post_type);
    if ($post_type_object instanceof WP_Post_Type) {
      $post_type_object->template = [
        ['acf/hero'],
        ['core/paragraph'],
      ];
    }
  }

});

/**
 * Load ACF fields
 */
add_filter('acf/settings/load_json', function ($paths) {

  $paths[] = dirname(__FILE__) . '/acf-json';
  return $paths;

});

/**
 * Copy hero image and/or title to post or other way around if empty
 *
 * @param int     $post_id the current post_id
 * @param WP_Post $post_obj the current post object
 * @param bool    $update is this update
 */
add_action('save_post', function($post_id, $post_obj, $update) {

  if (in_array(get_post_type($post_id), x_get_post_types_with_hero())) {

    $blocks = parse_blocks($post_obj->post_content);

    if (!empty($blocks) && is_array($blocks)) {
      foreach ($blocks as $block) {
        if (isset($block['blockName']) && $block['blockName'] === 'acf/hero') {

          // copy block image into featured image if doesn't exist
          if (!has_post_thumbnail($post_id)) {
            if (isset($block['attrs']['data']['image']) && is_numeric($block['attrs']['data']['image'])) {
              set_post_thumbnail($post_id, $block['attrs']['data']['image']);
            }
          }

          // copy block title to post title or post title to block title
          if (isset($block['innerBlocks']) && !empty($block['innerBlocks'])) {
            foreach ($block['innerBlocks'] as $inner_block) {
              if (isset($inner_block['blockName']) && $inner_block['blockName'] === 'core/heading' && isset($inner_block['innerHTML'])) {
                $block_title = trim(wp_strip_all_tags($inner_block['innerHTML'], true));
                // copy block title to post title if it is not set
                if (empty($post_obj->post_title) && !empty($block_title)) {
                  wp_update_post([
                    'ID'          => $post_id,
                    'post_title'  => $block_title,
                    'post_name' => '', // force new slug
                  ]);
                }
                // copy post title to block title if it is not set
                if (empty($block_title) && !empty($post_obj->post_title)) {
                  $content = $post_obj->post_content;
                  $new_title_tag = str_replace('</h1>', $post_obj->post_title . '</h1>', $inner_block['innerHTML']);
                  $modified_content = str_replace($inner_block['innerHTML'], $new_title_tag, $content);
                  if ($content !== $modified_content) {
                    wp_update_post([
                      'ID'            => $post_id,
                      'post_content'  => $modified_content,
                    ]);
                  }
                }

                break; // only check first heading of hero

              }
            }
          }

          break; // only check first occurance of hero

        }
      }
    }
  }

}, 10, 3);
