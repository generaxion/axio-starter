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
  'core/buttons',
];

$placeholder_content = [
  ['core/heading', [
    'placeholder' => __('Title'),
    'level'       => 1
  ]],
  ['core/paragraph', [
    'placeholder' => __('Excerpt'),
  ]],
];

$contents = $content;
if ($is_preview) {
  $contents .= '<innerBlocks template="' . esc_attr(wp_json_encode($placeholder_content)) . '" allowedBlocks="' . esc_attr(wp_json_encode($allowed_content)) . '" templateLock="all" />';
}

?>
<div class="wp-block-hero alignfull">
  <?php
    Aucor_Hero::render([
      'contents' => $contents,
      'image_id' => get_field('hero__image'),
      'layout'   => !empty(get_field('hero__alignment')) ? get_field('hero__alignment') : 'full',
    ]);
  ?>
</div>
