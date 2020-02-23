<?php
/**
 * Component: Menu Upper
 *
 * @example
 * Aucor_Menu_Upper::render();
 *
 * @package aucor_starter
 */
class Aucor_Menu_Upper extends Aucor_Component {

  public static function frontend($data) {

    if (!$data['has_menu']) {
      return;
    }

    ?>

    <nav <?php parent::render_attributes($data['attr']); ?>>

      <?php
        wp_nav_menu([
          'theme_location' => 'upper',
          'container'      => '',
          'menu_class'     => 'upper-navigation__items',
          'depth'          => 1,
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

      // optional
      'attr' => [],

      // internal
      'has_menu' => has_nav_menu('upper')

    ];
    $args = wp_parse_args($args, $placeholders);

    // classes
    if (!isset($args['attr']['class'])) {
      $args['attr']['class'] = [];
    }
    $args['attr']['class'][] = 'js-navigation';
    $args['attr']['class'][] = 'upper-navigation';
    $args['attr']['class'][] = 'header-navigation';

    // a11y
    $args['attr']['aria-label'] = ask__('Menu: Upper Menu');

    // Schema.org
    $args['attr']['itemscope'] = null;
    $args['attr']['itemtype']  = 'http://schema.org/SiteNavigationElement';

    return $args;

  }

}
