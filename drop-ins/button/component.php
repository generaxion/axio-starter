<?php
/**
 * Component: Button
 *
 * @example
 * Aucor_Button::render([
 *  'title' => 'Home',
 *  'url'   => '#'
 * ]);
 *
 * @package aucor_starter
 */
class Aucor_Button extends Aucor_Component {

  public static function frontend($data) {
    ?>

    <a <?php parent::render_attributes($data['attr']); ?>>
      <?php echo $data['title']; ?>
    </a>

    <?php
  }

  public static function backend($args = []) {

    $placeholders = [
      // required
      'title'    => '',
      'url'      => '',

      // optional
      'attr'    => [],
      'type'    => '',
      'target'  => '',
    ];

    $args = wp_parse_args($args, $placeholders);

    // check for missing button title
    if (empty($args['title'])) {
      return parent::error('Missing button text ($args[\'title\'])');
    }

    // check for missing url
    if (empty($args['url']) && !isset($args['attr']['href'])) {
      return parent::error('Missing button URL');
    }

    if (!isset($args['attr']['class'])) {
      $args['attr']['class'] = [];
    }
    $args['attr']['class'][] = 'button';

    // type
    if (!empty($args['type'])) {
      $args['attr']['class'][] = 'button--type-' . $args['type'];
    }

    // url
    if (!isset($args['attr']['href'])) {
      $args['attr']['href'] = $args['url'];
    }

    // target
    if (!empty($args['target']) && !isset($args['attr']['target'])) {
      $args['attr']['target'] = $args['target'];
    }

    return $args;
  }
}
