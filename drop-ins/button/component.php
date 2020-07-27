<?php
/**
 * Component: Button
 *
 * @example
 * Aucor_Button::render([
 *  'text' => 'Home',
 *  'attr' => [
 *    'class'  => ['button--primary'],
 *    'href'   => [get_home_url()],
 *    'target' => ['_blank'],
 *   ],
 * ]);
 *
 * @package aucor_starter
 */
class Aucor_Button extends Aucor_Component {
  public static function frontend($data) {
  ?>

    <a <?php parent::render_attributes($data['attr']); ?>>
      <?php echo $data['text']; ?>
    </a>

    <?php
  }

  public static function backend($args = []) {
    $placeholders = [
      // required
      'text'   => '',

      // optional
      'attr'   => [],
    ];

    $args = wp_parse_args($args, $placeholders);

    if (!isset($args['attr']['class'])) {
      $args['attr']['class'] = [];
    }

    $args['attr']['class'][] = 'button';

    // check for missing button text
    if (empty($args['text'])) {
      return parent::error('Missing button text ($args[\'text\'])');
    }

    // check for missing link href
    if (empty($args['attr']['href'])) {
      return parent::error('Missing link href ($args[\'attr\'][\'href\'])');
    }

    return $args;
  }
}
