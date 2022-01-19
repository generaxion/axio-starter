<?php
/**
 * Component: Menu Legal
 *
 * @example
 * X_Menu_Legal::render();
 *
 * @package axio
 */
class X_Menu_Legal extends X_Component {

  public static function frontend($data) {

    if (!$data['has_menu']) {
      return;
    }

    ?>

    <nav <?php parent::render_attributes($data['attr']); ?>>

      <?php
        wp_nav_menu([
          'theme_location' => 'legal',
          'container'      => '',
          'menu_class'     => 'legal-navigation__items',
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
      'has_menu' => has_nav_menu('legal')

    ];
    $args = wp_parse_args($args, $placeholders);

    // classes
    if (!isset($args['attr']['class'])) {
      $args['attr']['class'] = [];
    }
    $args['attr']['class'][] = 'legal-navigation';

    // a11y
    $args['attr']['aria-label'] = ask__('Menu: Legal Menu');

    // Schema.org
    $args['attr']['itemscope'] = null;
    $args['attr']['itemtype']  = 'https://schema.org/SiteNavigationElement';

    return $args;

  }

}
