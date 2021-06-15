<?php

/**
 * Component: Footer
 *
 * @example
 * Aucor_Footer::render();
 *
 * @package hw
 */
class X_Footer_Widgets extends X_Component {

  public static function frontend( $data ) {
    ?>
    <footer <?php parent::render_attributes( $data['attr'] ); ?>>

      <div class="site-footer__container">
        <?php
        dynamic_sidebar( 'footer' );
        ?>
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
    $args['attr']['id'] = 'site-footer-widgets';

    // Schema.org
    $args['attr']['itemscope'] = null;
    $args['attr']['itemtype']  = 'https://schema.org/WPFooter';

    return $args;
  }
}
