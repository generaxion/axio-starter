<?php
/**
 * ACF Block: Button
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param (int|string) $post_id The post ID this block is saved to.
 *
 * @package aucor_starter
 */

$align    = $block['align'] ? $block['align'] : 'default';
$type     = get_field('button_type');
$link     = get_field('button_link');
$title    = '';
$url      = '';
$text     = '';
$target   = '';

if (isset($link['title']) && !empty($link['title'])) {
  $title = $link['title'];
} elseif ($is_preview) {
  $title = ask__('Button: New button instructions');
}

if (isset($link['url']) && !empty($link['url'])) {
  $url = $link['url'];
} elseif ($is_preview) {
  $url = '#';
}

if (isset($link['target']) && !empty($link['target'])) {
  $target = $link['target'];
}

?>

<div class="wp-block-acf-button <?php echo 'align-' . esc_attr($align); ?>">
  <?php
    Aucor_Button::render([
      'title'     => $title,
      'type'      => $type,
      'url'       => $url,
      'target'    => $target,
    ]);
  ?>
</div>
