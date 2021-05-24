<?php
/**
 * ACF Block: File
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param (int|string) $post_id The post ID this block is saved to.
 *
 * @package axio
 */

$files = get_field('files');
?>

<div class="wp-block-acf-files">
  <?php if (!empty($files)) : ?>
    <?php foreach ($files as $file) : ?>
      <?php if (!empty($file['file'])) : ?>
        <?php
          X_File::render([
            'id'    => $file['file'],
            'title' => $file['title'],
          ]);
        ?>
      <?php endif; ?>
    <?php endforeach; ?>
    <?php elseif ($is_preview) : ?>
      <div class="wp-block-acf-files__empty">
        <?php ask_e('Files: New block instructions'); ?>
      </div>
  <?php endif; ?>
</div>
