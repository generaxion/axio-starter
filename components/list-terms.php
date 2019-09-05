<?php
/**
 * Component: List Terms
 *
 * @example post_tag
 * Aucor_List_Terms::render([
 *  'title'     => 'Tags',
 *  'taxonomy'  => 'post_tag'
 * ]);
 *
 * @example category
 * Aucor_List_Terms::render([
 *  'title'     => 'Categories',
 *  'taxonomy'  => 'category'
 * ]);
 * 
 * @example fixed id
 * Aucor_List_Terms::render([
 *  'title'     => 'Fixed ID categories,
 *  'id'        => '1'.
 *  'taxonomy'  => 'category'
 * ]);
 *
 * @package aucor_starter
 */

class Aucor_List_Terms extends Aucor_Component {
  public static function frontend($data) {
    if (empty($data['terms'])) {
        return;
    } ?>

    <div <?php parent::render_attributes($data['attr']); ?>>
      <?php if (!empty($data['title'])) : ?>
        <span class="aucor-list-terms__title"><?php echo $data['title'] ?></span>
      <?php endif; ?>
      <?php for ($i = 0; $i < count($data['terms']); $i++) : ?>
        <a href="<?php echo get_term_link($data['terms'][$i]) ?>" class="aucor-list-terms__term"><?php echo $data['terms'][$i]->name ?></a>
      <?php endfor; ?>
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

    $args['attr']['class'][] = 'aucor-list-terms';

    return $args;
  }
}
