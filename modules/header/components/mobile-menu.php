<?php
/**
 * Component: Mobile Menu
 *
 * @example
 * X_Mobile_Menu::render();
 *
 * @package axio
 */
class X_Mobile_Menu extends X_Component {

  public static function frontend($data) {
    ?>

    <div <?php parent::render_attributes($data['attr']); ?>>
      <div class="mobile-menu__nav" role="dialog">
        <?php X_Menu_Toggle::render(); ?>
        <div class="mobile-menu__nav__inner">
          <?php X_Menu_Primary::render(); ?>
          <?php X_Menu_Additional::render(); ?>
        </div>
      </div>
      <div class="mobile-menu__overlay" data-a11y-dialog-hide tabindex="-1"></div>
    </div>

    <?php
  }

  public static function backend($args = []) {

    $placeholders = [

      // optional
      'attr' => [],

    ];
    $args = wp_parse_args($args, $placeholders);

    // classes
    if (!isset($args['attr']['class'])) {
      $args['attr']['class'] = [];
    }
    $args['attr']['class'][] = 'mobile-menu';
    $args['attr']['class'][] = 'js-mobile-menu';

    return $args;

  }

}
