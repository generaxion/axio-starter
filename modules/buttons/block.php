<?php
/**
 * ACF Block: Buttons
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param (int|string) $post_id The post ID this block is saved to.
 *
 * @package axio
 */

$f = get_fields();

$class = [];
$class[] = 'wp-block-acf-button';
$class[] = 'buttons';

$alignment = isset($f['buttons_alignment']) ? $f['buttons_alignment'] : 'auto';
$class[] = 'buttons--align-' . $alignment;

$layout = isset($f['buttons_layout']) ? $f['buttons_layout'] : 'horizontal';
$class[] = 'buttons--layout-' . $layout;

if (isset($block['className']) && !empty($block['className'])) {
  $class[] = $block['className'];
}

?>

<div class="<?php echo esc_attr(implode(' ', $class)); ?>">
  <?php if (isset($f['buttons']) && !empty($f['buttons'])) : ?>
    <?php foreach ($f['buttons'] as $button) : ?>
      <?php
        if (isset($button['button_link']) && is_array($button['button_link']) && !empty($button['button_link'])) {
          $url    = isset($button['button_link']['url']) ? $button['button_link']['url'] : '';
          $title  = isset($button['button_link']['title']) ? $button['button_link']['title'] : '';
          $target = isset($button['button_link']['target']) && !empty($button['button_link']['target']) ? $button['button_link']['target'] : '_self';
          $type   = isset($button['button_type']) && !empty($button['button_type']) ? $button['button_type'] : 'default';
          if (!empty($url) && !empty($title)) {
            X_Button::render([
              'title'      => $title,
              'url'        => $url,
              'target'     => $target,
              'type'       => $type,
            ]);
          }
        }
      ?>
    <?php endforeach; ?>
  <?php elseif ($is_preview) : ?>
    <?php
      X_Button::render([
        'title'    => __('Button'),
        'url'      => '#',
      ]);
    ?>
  <?php endif; ?>
</div>
