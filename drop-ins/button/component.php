<?php
/**
 * Component: Button
 *
 * @example
 * Aucor_Button::render([
 *  'text' => 'Home',
 *  'url'  => get_home_url(),
 *  'attr' => [
 *    'class' => ['button--primary'],
 *   ],
 * ]);
 *
 * @package aucor_starter
 */
class Aucor_Button extends Aucor_Component {
  public static function frontend($data) {
  ?>

    <a <?php parent::render_attributes($data['attr']); ?> href="<?php echo $data['url']; ?>">
      <?php echo $data['text']; ?>
    </a>

    <?php
  }

  public static function backend($args = []) {
    $placeholders = [
      // required
      'text' => '',
      'url'  => '',

      // optional
      'attr' => [],
    ];

    $args = wp_parse_args($args, $placeholders);

    if (!isset($args['attr']['class'])) {
      $args['attr']['class'] = [];
    }

    $args['attr']['class'][] = 'button';

    // text
    if (empty($args['text'])) {
      return parent::error('Missing button text ($args[\'text\'])');
    }

    // url
    if (empty($args['url'])) {
      return parent::error('Missing button url ($args[\'url\'])');
    }

    return $args;
  }
}
