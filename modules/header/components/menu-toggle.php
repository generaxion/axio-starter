<?php
/**
 * Component: Menu Toggle
 *
 * @example
 * X_Menu_Toggle::render();
 *
 * @example
 * X_Menu_Toggle::render([
 *   'label' => 'Open menu',
 * ]);
 *
 * @package axio
 */
class X_Menu_Toggle extends X_Component {

  public static function frontend($data) {
    ?>

    <button <?php parent::render_attributes($data['attr']); ?>>

      <span class="menu-toggle__icon">
        <?php X_SVG::render(['name' => 'menu']); ?>
        <?php X_SVG::render(['name' => 'close']); ?>
      </span>

      <?php if (!empty($data['label'])) : ?>
        <span class="menu-toggle__label" aria-hidden="true">
          <?php echo esc_html($data['label']); ?>
        </span>
      <?php endif; ?>

      <span class="menu-toggle__label-open">
        <?php echo esc_html($data['label-open']); ?>
      </span>

      <span class="menu-toggle__label-close">
        <?php echo esc_html($data['label-close']); ?>
      </span>

    </button>

    <?php
  }

  public static function backend($args = []) {

    $placeholders = [

      // required (none)

      // optional
      'attr'               => [],
      'id'                 => '',
      'label'              => '',
      'label-open'         => ask__('Menu: Open'),
      'label-close'        => ask__('Menu: Close'),

    ];
    $args = wp_parse_args($args, $placeholders);

    // classes
    if (!isset($args['attr']['class'])) {
      $args['attr']['class'] = [];
    }
    $args['attr']['class'][] = 'js-menu-toggle';
    $args['attr']['class'][] = 'menu-toggle';

    return $args;

  }

}
