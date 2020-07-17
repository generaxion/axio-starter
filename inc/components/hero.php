<?php
/**
 * Component: Hero
 *
 * @example
 * Aucor_Hero::render();
 *
 * @package aucor_starter
 */
class Aucor_Hero extends Aucor_Component {

  public static function frontend($data) {
    ?>

    <div <?php parent::render_attributes($data['attr']); ?>>

      <?php if (!empty($data['image'])) : ?>
        <div class="hero__media">
          <div class="hero__media__image">
            <?php echo $data['image']; ?>
          </div>
          <div class="hero__media__dimming"></div>
        </div>
      <?php endif; ?>

      <div class="hero__container">
        <div class="hero__container__inner">

          <?php if (!empty($data['contents'])) : ?>

            <?php echo $data['contents']; ?>

          <?php else : ?>

            <h1><?php echo $data['title']; ?></h1>

            <?php if (!empty($data['meta'])) : ?>
              <div class="hero__meta"><?php echo $data['meta']; ?></div>
            <?php endif; ?>

            <?php if (!empty($data['description'])) : ?>
              <p class="hero__description"><?php echo $data['description']; ?></p>
            <?php endif; ?>

          <?php endif; ?>

        </div>
      </div>

    </div>
    <?php
  }

  public static function backend($args = []) {

    $placeholders = [

      // required (nothing)

      // optional
      'attr'  => [],

      // internal
      'title'       => '',
      'description' => '',
      'meta'        => '',
      'contents'    => '',
      'image_id'    => null,
      'image'       => '',
      'layout'      => 'full',

    ];
    $args = wp_parse_args($args, $placeholders);

    if (!isset($args['attr']['class'])) {
      $args['attr']['class'] = [];
    }
    $args['attr']['class'][] = 'hero';

    // title
    $args['title'] = (is_singular()) ? get_the_title() : self::get_the_archive_title();

    // description
    $args['description'] = (is_singular()) ? get_post_meta(get_the_ID(), 'lead', true) : get_the_archive_description();

    // meta
    if (is_singular() && get_post_type() === 'post') {
      $args['meta'] = aucor_starter_get_posted_on();
    }

    // image id
    if (empty($args['image_id']) && is_singular() && has_post_thumbnail()) {
      $args['image_id'] = get_post_thumbnail_id();
    }

    $size = 'hero';
    // @todo: fix proper image size
    if ($args['layout'] == 'half') {
      $size = 'large';
    }

    if (!empty($args['image_id'])) {
      $args['image'] = Aucor_Image::get([
        'id'    => $args['image_id'],
        'size'  => $size,
      ]);
    }

    if (!empty($args['image'])) {
      $args['attr']['class'][] = 'hero--has-media';
    } else {
      $args['attr']['class'][] = 'hero--no-media';
    }
    $args['attr']['class'][] = 'hero--layout-' . $args['layout'];

    return $args;

  }

  /**
   * Get archive title
   *
   * @return string the title
   */
  public static function get_the_archive_title() {

    $title = ask__('Title: Archives');

    if (is_tag() || is_category() || is_tax()) {
      $title = single_term_title('', false);
    } elseif (is_home()) {
      $title = ask__('Title: Home');
    } elseif (is_search()) {
      $title = ask__('Title: Search') . ': <span class="search-terms">' . get_search_query() . '</span>';
    } elseif (is_404()) {
      $title = ask__('Title: 404');
    }

    return $title;

  }

}
