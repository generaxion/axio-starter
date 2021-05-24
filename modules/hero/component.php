<?php
/**
 * Component: Hero
 *
 * @example
 * X_Hero::render();
 *
 * @package axio
 */
class X_Hero extends X_Component {

  public static function frontend($data) {
    ?>

    <div <?php parent::render_attributes($data['attr']); ?>>

      <?php if (!empty($data['image'])) : ?>
        <div class="hero__background">
          <div class="hero__background__image">
            <?php echo $data['image']; ?>
          </div>
          <div class="hero__background__dimming"></div>
        </div>
      <?php endif; ?>

      <div class="hero__container">

        <h1 class="hero__title"><?php echo $data['title']; ?></h1>

        <?php if (!empty($data['meta'])) : ?>
          <div class="hero__meta"><?php echo $data['meta']; ?></div>
        <?php endif; ?>

        <?php if (!empty($data['description'])) : ?>
          <p class="hero__description"><?php echo $data['description']; ?></p>
        <?php endif; ?>

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
      'image'       => '',

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
      $args['meta'] = x_get_posted_on();
    }

    // background
    if (is_singular() && has_post_thumbnail()) {
      $args['image'] = X_Image::get([
        'id'       => get_post_thumbnail_id(),
        'size'     => 'hero',
        'lazyload' => 'animated',
      ]);
    }

    if (!empty($args['image'])) {
      $args['attr']['class'][] = 'hero--has-background';
    } else {
      $args['attr']['class'][] = 'hero--no-background';
    }

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
