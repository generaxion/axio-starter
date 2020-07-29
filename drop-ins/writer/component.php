<?php
/**
 * Component: Writer
 *
 * @example default (uses post_id)
 * Aucor_Writer::render();
 *
 * @example with term id (e.g. to specify only one writer)
 * Aucor_Writer::render([
 *  'term_id' => 25
 * ]);
 *
 * @example with term object (same effect as with term_id)
 * Aucor_Writer::render([
 *  'term_writer' => get_queried_object()
 * ]);
 *
 * @example with explicit post_id (e.g. if global $post isn't available)
 * Aucor_Writer::render([
 *  'post_id' => 25
 * ]);
 *
 * @package aucor_starter
 */
class Aucor_Writer extends Aucor_Component {

  public static function frontend($data) {
    if (!empty($data['writer'])) {
      foreach ($data['writer'] as $writer) {
        ?>
          <div <?php parent::render_attributes($data['attr']); ?>>
            <?php if ($writer['image_id']) { ?>
              <div class="writer__image">
                <?php
                  Aucor_Image::render([
                    'id'   => $writer['image_id'],
                    'size' => $writer['image_size'],
                  ]);
                ?>
              </div>
            <?php } ?>
            <div class="writer__info">
              <h4 class="writer__title"><?php echo (ask__('Writer: Title') . ' ' . $writer['name']); ?></h4>
              <?php
                if ($writer['description']) {
              ?>
              <p class="writer__description"><?php echo $writer['description']; ?></p>
                <?php
                }
              ?>
              <p class="writer__articles"><a href="<?php echo $writer['link']; ?>" class="writer__articles-link"><?php ask_e('Writer: Writer\'s articles'); ?></a></p>
            </div>
          </div>
        <?php
      }
    }
  }

  public static function backend($args = []) {

    $placeholders = [
      'term_id'     => '',
      'term_writer' => '',
      'post_id'     => get_the_ID(),
    ];

    $args = wp_parse_args($args, $placeholders);

    // get writer(s, posts may have many)
    if (empty($args['term_writer'])) {
      $args['term_writer'] = get_term_by('id', $args['term_id'], 'writer');
    }
    $args['post_writer'] = get_the_terms($args['post_id'], 'writer');

    // check validity
    if ($args['term_writer'] instanceof WP_Error) {
      return parent::error('Invalid term_id for writer');
    }
    if ($args['post_writer'] instanceof WP_Error) {
      return parent::error('Invalid post_id for writer');
    }

    $args['writer'] = array();

    // check if writers exist and setup args
    // check term_writer first as it's the most specific
    if (!empty($args['term_writer'])) {
      array_push($args['writer'], array(
        'name'        => $args['term_writer']->name,
        'description' => $args['term_writer']->description,
        'link'        => get_term_link($args['term_writer']),
        'image_id'    => get_field('writer_image', 'writer_' . $args['term_writer']->term_id),
        'image_size'  => 'thumbnail',
      ));
    } elseif (!empty($args['post_writer'])) {
        // may be many writers, loop through them
        foreach ($args['post_writer'] as $writer) {
          array_push($args['writer'], array(
            'name'        => $writer->name,
            'description' => $writer->description,
            'link'        => get_term_link($writer),
            'image_id'    => get_field('writer_image', 'writer_' . $writer->term_id),
            'image_size'  => 'thumbnail',
          ));
        }
    }

    // setup html attributes
    $args['attr']['class'][] = 'writer';

    return $args;
  }
}
