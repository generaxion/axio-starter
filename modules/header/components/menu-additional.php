<?php
/**
 * Component: Menu Upper
 *
 * @example
 * X_Menu_Additional::render();
 *
 * @package axio
 */
class X_Menu_Additional extends X_Component {

  public static function frontend($data) {

    if (!$data['has_menu']) {
      return;
    }

    ?>

    <nav <?php parent::render_attributes($data['attr']); ?>>

      <?php
        wp_nav_menu([
          'theme_location' => 'additional',
          'container'      => '',
          'menu_class'     => 'additional-navigation__items',
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
      'type' => 'desktop',
      'attr' => [],

      // internal
      'has_menu' => has_nav_menu('additional')

    ];
    $args = wp_parse_args($args, $placeholders);

    // classes
    if (!isset($args['attr']['class'])) {
      $args['attr']['class'] = [];
    }
    $args['attr']['class'][] = 'js-navigation';
    $args['attr']['class'][] = 'additional-navigation';
    $args['attr']['class'][] = 'header-navigation';

    // type
    $args['attr']['data-navigation-type'] = $args['type'];

    // a11y
    $args['attr']['aria-label'] = ask__('Menu: Additional Menu');

    // Schema.org
    $args['attr']['itemscope'] = null;
    $args['attr']['itemtype']  = 'https://schema.org/SiteNavigationElement';

    return $args;

  }

}
