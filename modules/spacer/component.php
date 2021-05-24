<?php
/**
 * Component: Spacer
 *
 * @example
 * X_Spacer::render();
 *
 * @package axio
 */
class X_Spacer extends X_Component {
  public static function frontend($data) {
  ?>
    <div <?php parent::render_attributes($data['attr']); ?>>
      <?php if ($data['preview']) : ?>
        <div class="spacer__indicator"></div>
      <?php endif; ?>
    </div>
    <?php
  }

  public static function backend($args = [])
  {
    $placeholders = [

      // optional
      'size'    => 'm',
      'preview' => false,
      'attr'    => [],

    ];

    $args = wp_parse_args($args, $placeholders);

    if (!isset($args['attr']['class'])) {
      $args['attr']['class'] = [];
    }
    $args['attr']['class'][] = 'spacer';
    $args['attr']['class'][] = 'spacer--size-' . $args['size'];

    if ($args['preview']) {
      $args['attr']['class'][] = 'is-preview';
    }

    return $args;
  }
}
