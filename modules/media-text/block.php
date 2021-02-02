<?php
/**
 * ACF Block: Media & Text
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param (int|string) $post_id The post ID this block is saved to.
 */

$align = $block['align'] ? $block['align'] : 'default';

$allowed_blocks = [
  'core/heading',
  'core/paragraph',
  'core/image',
  'core/quote',
  'core/list',
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


$contents = $content;

if ($is_preview) {
  $contents .= '<InnerBlocks allowedBlocks="' . esc_attr(wp_json_encode($allowed_blocks)) . '" template="' . esc_attr(wp_json_encode($placeholder_content)) . '" />';
}

$class = [];
if (!empty($block['className']) ) {
  $class[] = $block['className'];
}

?>
<div class="wp-block-acf-media-text align<?php echo esc_attr($align); ?>">
  <?php
    Aucor_Media_Text::render([
      'is_preview'  => $is_preview,
      'contents'    => $contents,
      'fields'      => get_fields(),
      'width'       => $block['align'],
      'attr'        => [
        'class' => $class
      ]
    ]);
  ?>
</div>
