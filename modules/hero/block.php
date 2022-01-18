<?php
/**
 * ACF Block: Hero
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param (int|string) $post_id The post ID this block is saved to.
 */

$allowed_content = [
  'core/heading',
  'core/paragraph',
  'acf/buttons',
];

$placeholder_content = [
  ['core/heading', [
    'placeholder' => __('Page title'),
    'level'       => 1,
    'value'       => !empty(get_the_title()) ? get_the_title() : '',
  ]],
  ['core/paragraph', [
    'placeholder' => __('Write an excerpt (optional)'),
  ]],
];

$layout = get_field('layout') ? get_field('layout') : 'background';

$args = [
  'contents'          => '<InnerBlocks template="' . esc_attr(wp_json_encode($placeholder_content)) . '" allowedBlocks="' . esc_attr(wp_json_encode($allowed_content)) . '" />',
  'fields'            => get_fields(),
  'is_preview'        => $is_preview,
];

?>
<div class="wp-block-hero alignfull">
  <?php
    if ($layout === 'columns') {
      X_Hero_Columns::render($args);
    } elseif ($layout === 'stack') {
      X_Hero_Stack::render($args);
    } else {
      X_Hero_Background::render($args);
    }
  ?>
</div>
