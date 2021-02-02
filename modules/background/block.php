<?php

/**
 * ACF Block: Cover
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param (int|string) $post_id The post ID this block is saved to.
 */

$align = $block['align'] ? $block['align'] : 'full';

$allowed_blocks = [
  'acf/button',
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

$contents = $content;
if ($is_preview) {
  $contents .= '<InnerBlocks allowedBlocks="' . esc_attr(wp_json_encode($allowed_blocks)) . '" template="' . esc_attr(wp_json_encode($placeholder_content)) . '" />';
}

$fields = get_fields();

if (isset($block['className'])) {
  $classes = explode(' ', $block['className']);
  foreach ($classes as $class) {
    $fields['class'][] = $class;
  }
}
?>

<div class="wp-block-acf-background align<?php echo esc_attr($align); ?>">
  <?php
    Aucor_Background::render([
      'fields'        => $fields,
      'contents'      => $contents
    ]);
  ?>
</div>
