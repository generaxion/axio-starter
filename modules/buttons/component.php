<?php
/**
 * Component: Button
 *
 * @package axio
 */

class X_Button extends X_Component {

  public static function frontend($data) {
    ?>
      <a <?php parent::render_attributes($data['attr']); ?>>
        <span><?php echo $data['title']; ?></span>
      </a>
    <?php
  }

  public static function backend($args = []) {

    $placeholders = [

      // required
      'title'      => '',
      'url'        => '#',

      // optional
      'attr'       => [],
      'target'     => '_self',
      'type'       => 'default',
    ];

    $args = wp_parse_args($args, $placeholders);

    if (!isset($args['attr']['class'])) {
      $args['attr']['class'] = [];
    }
    // use prefixed class to avoid styling clashes
    $args['attr']['class'][] = 'c-button';

    $args['attr']['class'][] = 'c-button--type-' . $args['type'];

    if (!isset($args['attr']['href'])) {
      $args['attr']['href'] = $args['url'];
    }
    if (!isset($args['attr']['target'])) {
      $args['attr']['target'] = $args['target'];
    }

    return $args;

  }
}
