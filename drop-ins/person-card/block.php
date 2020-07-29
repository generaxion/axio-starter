<?php
/**
 * ACF Block: Person Card
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param (int|string) $post_id The post ID this block is saved to.
 *
 * @package aucor_starter
 */

$title = get_field('title');
if (empty($title)) {
  $title = ask__('Person Card: Title');
}
$person_cards = get_field('person_cards');
$args         = array();

?>

<?php if ($person_cards) : ?>
  <div class="wp-block-acf-staff-list">
    <h2 class="wp-block-acf-staff-list__title"><?php echo $title; ?></h2>
    <?php foreach ($person_cards as $post) :
      setup_postdata($post);
      $args['post'] = $post;
      ?>

      <?php Aucor_Person_Card::render($args); ?>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
