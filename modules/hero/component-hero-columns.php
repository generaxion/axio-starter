<?php
/**
 * Component: Hero with columns layout
 *
 * @package axio
 */
class X_Hero_Columns extends X_Component {

  public static function frontend($data) {
    ?>

    <div <?php parent::render_attributes($data['attr']); ?>>

      <?php if (!empty($data['image_id']) || !empty($data['video'])) : ?>
        <div class="hero-columns__media">
          <?php if (!empty($data['video'])) : ?>
            <div class="hero-columns__media__video">
              <video autoplay="autoplay" loop="loop" muted="muted" playsinline="playsinline" width="<?php echo esc_attr($data['video']['width']); ?>" height="<?php echo esc_attr($data['video']['height']); ?>" poster="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7">
                <source src="<?php echo esc_attr($data['video']['url']); ?>" type="<?php echo esc_attr($data['video']['mime_type']); ?>">
              </video>
            </div>
          <?php elseif (!empty($data['image_id'])) : ?>
            <div class="hero-columns__media__image">
              <?php
                X_Image::render([
                  'id'    => $data['image_id'],
                  'size'  => 'large',
                ]);
              ?>
            </div>
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <div class="hero-columns__container">
        <div class="hero-columns__container__inner inner-blocks">
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
      'video'             => null,
      'layout'            => 'full',

    ];
    $args = wp_parse_args($args, $placeholders);

    if (!isset($args['attr']['class'])) {
      $args['attr']['class'] = [];
    }
    $args['attr']['class'][] = 'hero';
    $args['attr']['class'][] = 'hero-columns';

    $f = $args['fields'];

    // image
    if (isset($f['image']) && !empty($f['image'])) {
      $args['image_id'] = $f['image'];
    }
    if (empty($args['image_id']) && has_post_thumbnail()) {
      $args['image_id'] = get_post_thumbnail_id();
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

    // alignment
    $alignment = 'default';
    if (isset($f['columns_align']) && !empty($f['columns_align'])) {
      $alignment = $f['columns_align'];
    }
    $args['attr']['class'][] = 'hero-columns--align-' . $alignment;

    if (!empty($args['image_id']) || !empty($args['video'])) {
      $args['attr']['class'][] = 'hero-columns--has-media';
    } else {
      $args['attr']['class'][] = 'hero-columns--no-media';
    }

    // aspect ratio
    $use_original_aspect_ratio = false;
    if (isset($f['columns_aspect_ratio']) && !empty($f['columns_aspect_ratio'])) {
      $use_original_aspect_ratio = $f['columns_aspect_ratio'];
    }
    $args['attr']['class'][] = 'hero-columns--aspect-ratio-' . ($use_original_aspect_ratio ? 'original' : 'default');

    return $args;

  }

}
