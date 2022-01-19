<?php
/**
 * Component: Hero with stack layout
 *
 * @package axio
 */
class X_Hero_Stack extends X_Component {

  public static function frontend($data) {
    ?>

    <div <?php parent::render_attributes($data['attr']); ?>>

    <?php if (!empty($data['image_id']) || !empty($data['video'])) : ?>
        <div class="hero-stack__media">
          <?php if (!empty($data['video'])) : ?>
            <div class="hero-stack__media__video">
              <video autoplay="autoplay" loop="loop" muted="muted" playsinline="playsinline" width="<?php echo esc_attr($data['video']['width']); ?>" height="<?php echo esc_attr($data['video']['height']); ?>" poster="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7">
                <source src="<?php echo esc_attr($data['video']['url']); ?>" type="<?php echo esc_attr($data['video']['mime_type']); ?>">
              </video>
            </div>
          <?php elseif (!empty($data['image_id'])) : ?>
            <div class="hero-stack__media__image">
              <?php
                X_Image::render([
                  'id'    => $data['image_id'],
                  'size'  => 'hero',
                ]);
              ?>
            </div>
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <div class="hero-stack__container">
        <div class="hero-stack__container__inner inner-blocks">
          <?php echo $data['contents']; ?>
        </div>
      </div>

    </div>
    <?php
  }

  public static function backend($args = []) {

    $placeholders = [

      // required (nothing)
      'fields'            => [],
      'contents'          => '',

      // optional
      'is_preview'        => false,
      'attr'              => [],

      // internal
      'image_id'          => null,
      'image'             => null,
      'layout'            => 'full',

    ];
    $args = wp_parse_args($args, $placeholders);

    if (!isset($args['attr']['class'])) {
      $args['attr']['class'] = [];
    }
    $args['attr']['class'][] = 'hero';
    $args['attr']['class'][] = 'hero-stack';

    $f = $args['fields'];

    // image
    if (isset($f['image']) && !empty($f['image'])) {
      $args['image_id'] = $f['image'];
    }
    if (empty($args['image_id']) && has_post_thumbnail()) {
      $args['image_id'] = get_post_thumbnail_id();
    }

    $size = 'hero';
    if ($args['layout'] == 'columns') {
      $size = 'large';
    }

    if (!empty($args['image_id'])) {
      $args['image'] = X_Image::get([
        'id'    => $args['image_id'],
        'size'  => $size,
      ]);
    }

    // image
    if (isset($f['image']) && !empty($f['image'])) {
      $args['image_id'] = $f['image'];
    }

    // video
    if (isset($f['video']) && !empty($f['video']) && is_array($f['video'])) {
      $args['video'] = [
        'url'        => $f['video']['url'],
        'mime_type'  => $f['video']['mime_type'],
        'width'      => $f['video']['width'],
        'height'     => $f['video']['height'],
      ];
    }

    if (!empty($args['image_id']) || !empty($args['video'])) {
      $args['attr']['class'][] = 'hero-stack--has-media';
    } else {
      $args['attr']['class'][] = 'hero-stack--no-media';
    }

    return $args;

  }

}
