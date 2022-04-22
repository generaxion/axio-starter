<?php
/**
 * Component: Menu Primary
 *
 * @example
 * X_Menu_Primary::render();
 *
 * @package axio
 */
class X_Menu_Primary extends X_Component {

  public static function frontend($data) {
    ?>

    <nav <?php parent::render_attributes($data['attr']); ?>>

      <?php
        wp_nav_menu([
          'theme_location' => 'primary',
          'container'      => '',
          'menu_class'     => 'primary-navigation__items',
          'link_before'    => '',
          'link_after'     => '',
          'fallback_cb'    => '',
        ]);
      ?>

    </nav>

    <?php
  }

  public static function backend($args = []) {

    $placeholders = [

      // type
      'type' => 'desktop',

      // optional
      'attr' => [],

    ];
    $args = wp_parse_args($args, $placeholders);

    // classes
    if (!isset($args['attr']['class'])) {
      $args['attr']['class'] = [];
    }
    $args['attr']['class'][] = 'js-navigation';
    $args['attr']['class'][] = 'primary-navigation';
    $args['attr']['class'][] = 'header-navigation';

    // type
    $args['attr']['data-navigation-type'] = $args['type'];

    // a11y
    $args['attr']['aria-label'] = ask__('Menu: Primary Menu');

    // Schema.org
    $args['attr']['itemscope'] = null;
    $args['attr']['itemtype']  = 'https://schema.org/SiteNavigationElement';

    return $args;

  }

}
