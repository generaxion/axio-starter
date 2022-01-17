<?php
/**
 * Component: Teaser
 *
 * @example
 * X_Teaser::render([
 *  'id'   => get_the_ID(),
 * ]);
 *
 * @example
 * X_Teaser::render([
 *  'post' => $post_object,
 * ]);
 *
 * @package axio
 */
class X_Teaser extends X_Component {

  public static function frontend($data) {
    ?>

    <article <?php parent::render_attributes($data['attr']); ?>>

      <a class="teaser__link" href="<?php echo esc_url($data['permalink']); ?>">
        <span class="screen-reader-text"><?php echo $data['post_title']; ?></span>
      </a>

      <div class="teaser__card">

        <?php if (!empty($data['attachment_id'])) : ?>
          <div class="teaser__thumbnail">
            <?php
              X_Image::render([
                'id'   => $data['attachment_id'],
                'size' => 'teaser',
              ]);
            ?>
          </div>
        <?php endif; ?>

        <div class="teaser__content">

          <header class="teaser__header">
            <h2 class="teaser__title"><?php echo $data['post_title']; ?></h2>
          </header>

          <div class="teaser__summary">
            <?php echo $data['post_excerpt']; ?>
          </div>

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

    // basic data
    $args['id']         = $args['post']->ID;
    $args['post_type']  = $args['post']->post_type;

    // setup html attributes
    if (!isset($args['attr']['class'])) {
      $args['attr']['class'] = [];
    }
    $args['attr']['class'][] = 'teaser';

    // post type
    $args['attr']['class'][] = 'teaser--' . $args['post_type'];

    // setup rest internal vars
    if (empty($args['attachment_id'])) {
      $args['attachment_id']  = get_post_thumbnail_id($args['post']);
    }
    $args['attr']['class'][] = !empty($args['attachment_id']) ? 'teaser--has-media' : 'teaser--no-media';


    // setup url
    $args['permalink']      = get_permalink($args['post']);

    // setup title
    $args['post_title']     = get_the_title($args['post']);

    // setup excerpt
    $args['post_excerpt']   = get_the_excerpt($args['post']);
    if (!empty($args['post_excerpt'])) {
      $args['post_excerpt'] = wpautop($args['post_excerpt']);
    }

    return $args;

  }

}
