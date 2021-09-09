<?php
/**
 * ACF Block: Background
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param (int|string) $post_id The post ID this block is saved to.
 */

$align    = isset($block['align']) ? $block['align'] : 'full';
$classes  = isset($block['className']) ? $block['className'] : '';

$allowed_blocks = [
  'acf/button',
  'acf/buttons',
  'acf/spacer',
  'core/columns',
  'core/heading',
  'core/image',
  'core/list',
  'core/paragraph',
  'core/quote',
  'gravityforms/form',
];

$placeholder_content = [
  ['core/heading', [
    'placeholder' => __('Title'),
    'level'       => 2,
  ]],
  ['core/paragraph', [
    'placeholder' => __('Paragraph'),
  ]],
];

?>

<div class="wp-block-acf-background align<?php echo esc_attr($align); ?> <?php echo esc_attr($classes); ?>">
  <?php
    X_Background::render([
      'fields'        => get_fields(),
      'contents'      => '<InnerBlocks allowedBlocks="' . esc_attr(wp_json_encode($allowed_blocks)) . '" template="' . esc_attr(wp_json_encode($placeholder_content)) . '" />',
    ]);
  ?>
</div>
