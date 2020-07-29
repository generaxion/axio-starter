<?php
/**
 * Component: Person card
 *
 * @example
 * Aucor_Person_Card::render([
 *  'id'   => get_the_ID(),
 * ]);
 *
 * @example
 * Aucor_Person_Card::render([
 *  'post' => $post_object,
 * ]);
 *
 * @example
 * Aucor_Person_Card::render([
 *  'id'        => get_the_ID(),
 *  'image_size => 'large',
 * ]);
 *
 * @example
 * Aucor_Person_Card::render([
 *  'id'        => get_the_ID(),
 *  'attr'      => ['class' =>
 *    ['person-card--teaser']
 *  ],
 * ]);
 *
 * @package aucor_starter
 */
class Aucor_Person_Card extends Aucor_Component {

  public static function frontend($data) {

    ?>
    <article <?php parent::render_attributes($data['attr']); ?> itemscope itemtype="http://schema.org/Person">
      <?php if (!empty($data['attachment_id'] && $data['show_image'])) : ?>
        <div class="person-card__image">
          <a href="<?php echo esc_url($data['permalink']); ?>" tabindex="-1">
            <?php
              Aucor_Image::render([
                'id'   => $data['attachment_id'],
                'size' => $data['image_size'],
              ]);
            ?>
          </a>
        </div>
      <?php endif; ?>
      <div class="person-card__content">
        <h3 class="person-card__name">
          <a class="person-card__name__link" href="<?php echo esc_url($data['permalink']); ?>">
            <span itemprop="name"><?php echo $data['post_title']; ?></span>
          </a>
        </h3>

        <?php if (!empty($data['title'])) : ?>
          <span class="person-card__meta" itemprop="jobTitle"><?php echo $data['title']; ?></span>
        <?php endif; ?>

        <?php if (!empty($data['telephone'])) : ?>
          <span class="person-card__meta">
            <a class="person-card__meta__link" itemprop="telephone" href="<?php echo esc_url('tel:'. str_replace(' ', '', $data['telephone'])); ?>"><?php echo $data['telephone']; ?></a>
          </span>
        <?php endif; ?>

        <?php if (!empty($data['email'])) : ?>
          <span class="person-card__meta">
            <a class="person-card__meta__link" itemprop="email" href="<?php echo antispambot('mailto:' . $data['email']); ?>"><?php echo antispambot($data['email']); ?></a>
          </span>
        <?php endif; ?>
      </div>
    </article>
  <?php

  }

  public static function backend($args = []) {

    $placeholders = [

      // required (either one)
      'id'    => 0,
      'post'  => null,

      // optional
      'attr'  => [],

      // internal
      'attachment_id' => 0,
      'post_type'     => 'person',
      'post_title'    => '',
      'post_excerpt'  => '',
      'permalink'     => '',
      'show_image'    => true,
      'image_size'    => 'thumbnail',

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
    $args['post_excerpt']   = get_the_excerpt($args['post']);
    $args['title']          = get_field('title', $args['post']->ID);
    $args['telephone']      = get_field('telephone', $args['post']->ID);
    $args['email']          = get_field('email', $args['post']->ID);

    // setup html attributes
    if (!isset($args['attr']['class'])) {
      $args['attr']['class'] = [];
    }
    $args['attr']['class'][]  = 'person-card';
    $args['attr']['id'][]     = 'person-'. $args['post']->ID;

    return $args;

  }

}
