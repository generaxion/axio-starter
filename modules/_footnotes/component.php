<?php
/**
 * Component: Image
 *
 * @example
 * Aucor_Image::render([
 *  'id'   => get_post_thumbnail_id(),
 *  'size' => 'hero',
 * ]);
 */

class Aucor_Footnotes extends Aucor_Component {

  /**
   * Image markup
   *
   * @param $data
   */
  public static function frontend($data) {
    ?>
    <div <?php parent::render_attributes($data['attr']); ?>>
      <?php echo Footnotes_SD::instance()->get_footnotes(); ?>
    </div>
    <?php
  }

  /**
   * Fetch and setup image data
   *
   * @param array $args
   *
   * @return array|\WP_Error
   */
  public static function backend($args = []) {

    $placeholders = [

      // required
      //'id'   => null,

      // optional
      'attr' => [],

    ];

    $args = wp_parse_args($args, $placeholders);

    //if (empty($args['id'])) {
    //  return parent::error('Missing attachment_id ($args[\'id\'])');
    //}



    if (!isset($args['attr']['class'])) {
      $args['attr']['class'] = [];
    }
    $args['attr']['class'][] = 'footnotes';

    //$args['attr']['class'][] = 'id-' . esc_html($args['id']);

    return $args;
  }
}
