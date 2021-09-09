<?php
/**
 * ACF Block: Media & Text
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param (int|string) $post_id The post ID this block is saved to.
 */

$align    = isset($block['align']) ? $block['align'] : 'default';
$classes  = isset($block['className']) ? $block['className'] : '';

$allowed_blocks = [
  'core/heading',
  'core/paragraph',
  'core/image',
  'core/quote',
  'core/list',
  'core/columns',
  'acf/buttons',
  'acf/button',
  'acf/spacer'
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
<div class="wp-block-acf-media-text align<?php echo esc_attr($align); ?> <?php echo esc_attr($classes); ?>">
  <?php
    X_Media_Text::render([
      'is_preview'  => $is_preview,
      'contents'    => '<InnerBlocks allowedBlocks="' . esc_attr(wp_json_encode($allowed_blocks)) . '" template="' . esc_attr(wp_json_encode($placeholder_content)) . '" />',
      'fields'      => get_fields(),
      'width'       => $align,
    ]);
  ?>
</div>
