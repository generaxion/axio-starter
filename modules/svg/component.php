<?php
/**
 * Component: SVG
 *
 * @example
 * X_SVG::render(['name' => 'plus']);
 */

class X_SVG extends X_Component {

  /**
   * Image markup
   */
  public static function frontend($data) {
    ?>

    <svg <?php parent::render_attributes($data['attr']); ?>>
      <?php if ($data['title']) : ?>
        <title><?php echo esc_html($data['title']); ?></title>
      <?php endif; ?>
      <use xlink:href="<?php echo esc_attr(get_template_directory_uri() . '/dist/sprite/sprite.svg?ver=' . x_last_edited('svg') . '#icon-' . esc_html($data['name'])); ?>"></use>
    </svg>

    <?php
  }

  /**
   * Fetch and setup image data
   *
   * @param array $args
   */
  public static function backend($args = []) {

    $placeholders = [

      // required
      'name'         => null,

      // optional
      'attr'         => [],
      'title'        => '',

    ];
    $args = wp_parse_args($args, $placeholders);

    if (empty($args['name'])) {
      return parent::error('Missing icon name ($args[\'name\'])');
    }

    if (!empty($args['title'])) {
      $args['attr']['aria-labelledby'] = 'title';
    } else {
      $args['attr']['aria-hidden'] = 'true';
    }

    if (!isset($args['attr']['class'])) {
      $args['attr']['class'] = [];
    }
    $args['attr']['class'][] = 'icon';
    $args['attr']['class'][] = 'icon-' . esc_html($args['name']);

    return $args;

  }

}
