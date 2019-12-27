<?php
/**
 * Component: Menu Toggle
 *
 * @example
 * Aucor_Menu_Toggle::render();
 *
 * @example
 * Aucor_Menu_Toggle::render([
 *   'label' => 'Open menu',
 * ]);
 *
 * @package aucor_starter
 */
class Aucor_Menu_Toggle extends Aucor_Component {

  public static function frontend($data) {
    ?>

    <button <?php parent::render_attributes($data['attr']); ?>>

      <svg class="menu-toggle__svg icon" aria-hidden="true" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100">
        <g class="menu-toggle__svg__g">
          <path class="menu-toggle__svg__line menu-toggle__svg__line--1" d="M5 13h90v14H5z"/>
          <path class="menu-toggle__svg__line menu-toggle__svg__line--2" d="M5 43h90v14H5z"/>
          <path class="menu-toggle__svg__line menu-toggle__svg__line--3" d="M5 73h90v14H5z"/>
          <path class="menu-toggle__svg__close-line menu-toggle__svg__close-line--1" d="M5 43h90v14H5z"/>
          <path class="menu-toggle__svg__close-line menu-toggle__svg__close-line--2" d="M5 43h90v14H5z"/>
        </g>
      </svg>

      <?php if (!empty($data['label'])) : ?>
        <span class="menu-toggle__label" aria-hidden="true">
          <?php echo esc_html($data['label']); ?>
        </span>
      <?php endif; ?>

      <span class="menu-toggle__label-open">
        <?php echo esc_html($data['label-open']); ?>
      </span>

      <span class="menu-toggle__label-close">
        <?php echo esc_html($data['label-close']); ?>
      </span>

    </button>

    <?php
  }

  public static function backend($args = []) {

    $placeholders = [

      // required (none)

      // optional
      'attr'               => [],
      'id'                 => '',
      'label'              => '',
      'label-open'         => ask__('Menu: Open'),
      'label-close'        => ask__('Menu: Close'),

    ];
    $args = wp_parse_args($args, $placeholders);

    // classes
    if (!isset($args['attr']['class'])) {
      $args['attr']['class'] = [];
    }
    $args['attr']['class'][] = 'js-menu-toggle';
    $args['attr']['class'][] = 'menu-toggle';

    return $args;

  }

}
