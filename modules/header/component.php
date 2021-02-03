<?php
/**
 * Component: Header
 *
 * @example
 * Aucor_Header::render();
 *
 * @package aucor_starter
 */
class Aucor_Header extends Aucor_Component {

  public static function frontend($data) {
    ?>
    <header <?php parent::render_attributes($data['attr']); ?>>

      <div class="site-header__inner">

        <div class="site-header__branding">
          <a href="<?php echo esc_url(home_url('/')); ?>" class="site-header__title" rel="home" itemprop="headline">
            <img class="site-header__logo" width="300" height="100" src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/logo.svg" loading="lazy" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" />
          </a>
        </div>

        <?php Aucor_Menu_Toggle::render(); ?>

        <div class="site-header__menus">
          <?php
            Aucor_Menu_Additional::render([
              'attr' => [
                'class' => ['site-header__additional', 'desktop-menu']
              ]
            ]);
          ?>

          <?php
            Aucor_Menu_Primary::render([
              'attr' => [
                'class' => ['site-header__main', 'desktop-menu']
              ]
            ]);
          ?>

        </div>

      </div>

    </header>
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
    $args['attr']['class'][] = 'site-header';

    // id
    $args['attr']['id'] = 'masthead';

    // Schema.org
    $args['attr']['itemscope'] = null;
    $args['attr']['itemtype']  = 'https://schema.org/WPHeader';

    return $args;

  }

}
