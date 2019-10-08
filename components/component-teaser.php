<?php
/**
 * Component: Teaser
 *
 * @example
 * Aucor_Teaser::render([
 *  'id'   => get_the_ID(),
 * ]);
 *
 * @example
 * Aucor_Teaser::render([
 *  'post' => $post_object,
 * ]);
 *
 * @package aucor_starter
 */
class Aucor_Teaser extends Aucor_Component {

  public static function frontend($data) {
    ?>

    <article <?php parent::render_attributes($data['attr']); ?>>

      <?php if (!empty($data['attachment_id'])) : ?>
        <div class="teaser__thumbnail">
          <a href="<?php echo esc_url($data['permalink']); ?>" tabindex="-1">
            <?php
              Aucor_Image::render([
                'id'   => $data['attachment_id'],
                'size' => 'thumbnail',
              ]);
            ?>
          </a>
        </div>
      <?php endif; ?>

      <div class="teaser__content">

        <header class="teaser__header">
          <h2 class="teaser__header__title">
            <a href="<?php echo esc_url($data['permalink']); ?>">
              <?php echo $data['post_title']; ?>
            </a>
          </h2>
        </header>

        <div class="teaser__summary">
          <?php echo $data['post_excerpt']; ?>
        </div>

      </div>

    </article>
    <?php
  }

  public static function backend($args = []) {

    $placeholders = [

      // required (either one)
      'id'    => 0,
      'post'  => null,

      // optioal
      'attr'  => [],

      // internal
      'attachment_id' => 0,
      'post_type'     => '',
      'post_title'    => '',
      'post_excerpt'  => '',
      'permalink'     => '',

    ];
    $args = wp_parse_args($args, $placeholders);

    // validate required fields
    if (empty($args['id']) && empty($args['post'])) {
      return parent::error('Missing post object ($args[\'post\']) or ID ($args[\'id\'])');
    }

    // setup target post
    if (!empty($args['id'])) {
      $args['post'] = get_post($args['id']);
    }

    // validate post object
    if (!($args['post'] instanceof WP_Post)) {
      return parent::error('Invalid post object ($args[\'post\'])');
    }

    // validate post status
    if ($args['post']->post_status !== 'publish') {
      return parent::error('Target post is not published');
    }

    // setup rest internal vars
    $args['attachment_id']  = get_post_thumbnail_id($args['post']);
    $args['id']             = $args['post']->ID;
    $args['permalink']      = get_permalink($args['post']);
    $args['post_title']     = get_the_title($args['post']);
    $args['post_type']      = $args['post']->post_type;
    $args['post_excerpt']   = get_the_excerpt($args['post']);

    // setup html attributes
    if (!isset($args['attr']['class'])) {
      $args['attr']['class'] = [];
    }
    $args['attr']['class'][] = 'teaser';
    $args['attr']['class'][] = 'teaser--' . $args['post_type'];

    return $args;

  }

}
