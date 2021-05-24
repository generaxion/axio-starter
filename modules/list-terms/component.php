<?php
/**
 * Component: List Terms
 *
 * @example post_tag
 * X_List_Terms::render([
 *  'title'     => 'Tags',
 *  'taxonomy'  => 'post_tag'
 * ]);
 *
 * @example category
 * X_List_Terms::render([
 *  'title'     => 'Categories',
 *  'taxonomy'  => 'category'
 * ]);
 *
 * @example fixed id
 * X_List_Terms::render([
 *  'title'     => 'Fixed ID categories,
 *  'id'        => '1'.
 *  'taxonomy'  => 'category'
 * ]);
 *
 * @package axio
 */

class X_List_Terms extends X_Component {
  public static function frontend($data) {

    if (empty($data['terms'])) {
      return;
    }
    ?>

    <div <?php parent::render_attributes($data['attr']); ?>>
      <?php if (!empty($data['title'])) : ?>
        <span class="list-terms__title"><?php echo $data['title']; ?></span>
      <?php endif; ?>
      <?php foreach ($data['terms'] as $term) : ?>
        <a href="<?php echo esc_attr(get_term_link($term)); ?>" class="list-terms__term"><?php echo $term->name; ?></a>
      <?php endforeach; ?>
    </div>
    <?php
  }

  public static function backend($args = []) {
    $placeholders = [
      'id'              => get_the_ID(),
      'title'           => '',
      'taxonomy'        => '',
      'terms'           => [],
      'attr'            => [],
    ];

    $args = wp_parse_args($args, $placeholders);

    // validate required fields
    if (empty($args['taxonomy'])) {
        return parent::error('Missing taxonomy ($args[\'taxonomy\'])');
    }

    // validate taxonomy
    $args['terms'] = wp_get_object_terms($args['id'], $args['taxonomy']);

    if ($args['terms'] instanceof WP_Error) {
        return parent::error('Invalid taxonomy ($args[\'post\'])');
    }

    $args['attr']['class'][] = 'list-terms';

    return $args;
  }
}
