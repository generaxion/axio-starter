<?php
/**
 * Component: Footer
 *
 * @example
 * X_Footer::render();
 *
 * @package axio
 */
class X_Footer extends X_Component {

  public static function frontend($data) {
    ?>
    <footer <?php parent::render_attributes($data['attr']); ?>>

      <div class="site-footer__container">

        <div class="site-footer__main">

          <div class="site-footer__branding">
            <span class="site-footer__branding__title">
              <?php bloginfo('name'); ?>
            </span>
          </div>

        </div>

        <div class="site-footer__additional">

          <?php if (class_exists('X_Menu_Social')) : ?>
            <?php X_Menu_Social::render(); ?>
          <?php endif; ?>

          <?php X_Menu_Legal::render(); ?>

        </div>

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
    $args['attr']['class'][] = 'js-site-footer';

    // id
    $args['attr']['id'] = 'colophon';

    // Schema.org
    $args['attr']['itemscope'] = null;
    $args['attr']['itemtype']  = 'https://schema.org/WPFooter';

    return $args;

  }

}
