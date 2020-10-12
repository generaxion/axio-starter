<?php
/**
 * Component: Footer
 *
 * @example
 * Aucor_Footer::render();
 *
 * @package aucor_starter
 */
class Aucor_Footer extends Aucor_Component {

  public static function frontend($data) {
    ?>
    <footer <?php parent::render_attributes($data['attr']); ?>>

      <div class="site-footer__container">

        <div class="site-footer__branding">
          <span class="site-footer__branding__title">
            <?php bloginfo('name'); ?>
          </span>
        </div>

        <?php if (class_exists('Aucor_Menu_Social')) : ?>
          <div class="site-footer__social">
            <?php Aucor_Menu_Social::render(); ?>
          </div>
        <?php endif; ?>

      </div>


    </footer>
    <?php
  }

  public static function backend($args = []) {

    $placeholders = [
      // optional
      'attr'           => [],

    ];
    $args = wp_parse_args($args, $placeholders);

    // classes
    if (!isset($args['attr']['class'])) {
      $args['attr']['class'] = [];
    }
    $args['attr']['class'][] = 'site-footer';

    // id
    $args['attr']['id'] = 'colophon';

    // Schema.org
    $args['attr']['itemscope'] = null;
    $args['attr']['itemtype']  = 'https://schema.org/WPFooter';

    return $args;

  }

}
