<?php

/**
 * Component: Footer
 *
 * @example
 * Aucor_Footer::render();
 *
 * @package hw
 */
class X_Footer_Menus extends X_Component {

  public static function frontend( $data ) {
    ?>
    <footer <?php parent::render_attributes( $data['attr'] ); ?>>

      <div class="site-footer__container">
        <div class="site-footer__menu">
          <?php
          X_Menu::render( [ 'menu' => 'footer' ] );
          ?>
        </div>
      </div>

    </footer>
    <?php
  }

  public static function backend( $args = [] ) {

    $placeholders = [
      // optional
      'attr' => [],

    ];
    $args         = wp_parse_args( $args, $placeholders );

    // classes
    if ( ! isset( $args['attr']['class'] ) ) {
      $args['attr']['class'] = [];
    }
    $args['attr']['class'][] = 'site-footer';

    // id
    $args['attr']['id'] = 'site-footer-menu';

    // Schema.org
    $args['attr']['itemscope'] = null;
    $args['attr']['itemtype']  = 'https://schema.org/WPFooter';

    return $args;
  }
}
