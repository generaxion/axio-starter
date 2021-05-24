<?php
/**
 * Component: Menu Social
 *
 * @example
 * X_Menu_Social::render();
 *
 * @package axio
 */
class X_Menu_Social extends X_Component {

  public static function frontend($data) {
    ?>

    <nav <?php parent::render_attributes($data['attr']); ?>>

      <?php
        wp_nav_menu([
          'theme_location' => 'social',
          'container'      => '',
          'menu_class'     => 'social-navigation__items',
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

    ];
    $args = wp_parse_args($args, $placeholders);

    // classes
    if (!isset($args['attr']['class'])) {
      $args['attr']['class'] = [];
    }
    $args['attr']['class'][] = 'social-navigation';

    // a11y
    $args['attr']['aria-label'] = ask__('Menu: Social Menu');

    // Schema.org
    $args['attr']['itemscope'] = null;
    $args['attr']['itemtype']  = 'https://schema.org/SiteNavigationElement';

    return $args;

  }

}
