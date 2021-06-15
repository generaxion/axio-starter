<?php

/**
 * Component: Menu Upper
 *
 * @example
 * Aucor_Menu_Additional::render();
 *
 * @package lor
 */
class X_Menu extends X_Component {

  public static function frontend($data) {

    if (!$data['has_menu']) return;

    ?>

    <nav <?php parent::render_attributes($data['attr']); ?>>

      <?php
      $menu = wp_nav_menu([
        'echo'           => false,
        'theme_location' => $data['menu'],
        'container'      => '',
        'menu_class'     => 'menu_' . $data['menu'] . '__items',
        'depth'          => $data['depth'],
        'link_before'    => '',
        'link_after'     => '',
        'fallback_cb'    => '',
      ]);

      echo $menu;
      ?>

    </nav>

    <?php
  }

  public static function backend($args = []) {

    $placeholders = [

      // optional
      'attr'     => [],
      'menu'     => 'primary',
      'depth'    => 3,

      // internal
      'has_menu' => null,

    ];
    $args         = wp_parse_args($args, $placeholders);

    if (has_nav_menu($args['menu']))
      $args['has_menu'] = true;

    // classes
    if (!isset($args['attr']['class'])) {
      $args['attr']['class'] = [];
    }
    $args['attr']['class'][] = 'menu-module';
    $args['attr']['class'][] = 'menu-' . $args['menu'];
    $args['attr']['class'][] = 'js-navigation';

    // a11y
    $args['attr']['aria-label'] = 'Menu ' . $args['menu'];

    // Schema.org
    $args['attr']['itemscope'] = null;
    $args['attr']['itemtype']  = 'https://schema.org/SiteNavigationElement';

    return $args;

  }

}
