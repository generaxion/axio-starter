<?php
/**
 * Component: SVG
 *
 * @example
 * Aucor_SVG::render(['name' => 'plus']);
 */

 // @todo get new svgs

class Aucor_SVG extends Aucor_Component {

  /**
   * Image markup
   */
  public static function frontend($data) {
    ?>

    <?php if ($data['wrap']) : ?>
      <span class="icon-wrap">
    <?php endif; ?>

    <svg <?php parent::render_attributes($data['attr']); ?>>

      <?php if ($data['title']) : ?>
        <title><?php echo esc_html($data['title']); ?></title>
      <?php endif; ?>

      <?php if ($data['desc']) : ?>
        <desc><?php echo esc_html($data['desc']); ?></desc>
      <?php endif; ?>

      <use xlink:href="<?php echo esc_attr(get_template_directory_uri() . '/dist/sprite/sprite.svg?ver=' . aucor_starter_last_edited('svg') . '#icon-' . esc_html($data['name'])); ?>"></use>

    </svg>

    <?php if ($data['wrap']) : ?>
      </span>
    <?php endif; ?>

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
      'wrap'         => false,
      'attr'         => [],
      'title'        => '',
      'desc'         => '',
      'aria_hidden'  => true,

    ];
    $args = wp_parse_args($args, $placeholders);

    if (empty($args['name'])) {
      return parent::error('Missing icon name ($args[\'name\'])');
    }

    $args['attr']['aria-labelledby'] = ($args['title'] && $args['desc']) ? 'title desc' : '';

    if ($args['aria_hidden'] && !isset($args['attr']['aria-hidden'])) {
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
