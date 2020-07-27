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

$align                     = $block['align'];

$args                      = array();
$args['text']              = get_field('button_link')['title'];
$args['attr']['href'][]    = get_field('button_link')['url'];
$args['attr']['target'][]  = get_field('button_link')['target'];

if (!empty(get_field('button_type'))) {
  $args['attr']['class'][] = 'button--' . get_field('button_type');
}

?>

<div class="wp-block-acf-button <?php echo 'align-' . $align; ?>">
  <?php Aucor_Button::render($args); ?>
</div>
