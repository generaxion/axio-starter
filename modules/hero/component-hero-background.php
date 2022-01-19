<?php
/**
 * Component: Hero with background layout
 *
 * @package axio
 */
class X_Hero_Background extends X_Component {

  public static function frontend($data) {
    ?>

    <div <?php parent::render_attributes($data['attr']); ?>>

    <?php if (!empty($data['image_id']) || !empty($data['video'])) : ?>
        <div class="hero-bg__media">
          <?php if (!empty($data['video'])) : ?>
            <div class="hero-bg__media__video">
              <video autoplay="autoplay" loop="loop" muted="muted" playsinline="playsinline" width="<?php echo esc_attr($data['video']['width']); ?>" height="<?php echo esc_attr($data['video']['height']); ?>" poster="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7">
                <source src="<?php echo esc_attr($data['video']['url']); ?>" type="<?php echo esc_attr($data['video']['mime_type']); ?>">
              </video>
            </div>
          <?php elseif (!empty($data['image_id'])) : ?>
            <div class="hero-bg__media__image">
              <?php
                X_Image::render([
                  'id'    => $data['image_id'],
                  'size'  => 'hero',
                ]);
              ?>
            </div>
          <?php endif; ?>
          <div class="hero-bg__media__dimming" style="opacity:<?php echo esc_attr($data['dimming_opacity'] / 100); ?>"></div>
        </div>
      <?php endif; ?>

      <div class="hero-bg__container">
        <div class="hero-bg__container__inner inner-blocks">
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
      'dimming_opacity'   => 20,
      'is_dark_mode'      => true,

    ];
    $args = wp_parse_args($args, $placeholders);

    if (!isset($args['attr']['class'])) {
      $args['attr']['class'] = [];
    }
    $args['attr']['class'][] = 'hero';
    $args['attr']['class'][] = 'hero-bg';

    $f = $args['fields'];

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

    // dimming opacity
    if (isset($f['dimming']) && !empty($f['dimming'])) {
      $args['dimming_opacity'] = absint($f['dimming']);
    }

    // dark mode
    if (empty($args['image_id']) && empty($args['video'])) {
      $args['is_dark_mode'] = false;
    }

    if ($args['is_dark_mode']) {
      $args['attr']['class'][] = 'is-dark-mode';
    }

    if (!empty($args['image_id']) || !empty($args['video'])) {
      $args['attr']['class'][] = 'hero-bg--has-media';
    } else {
      $args['attr']['class'][] = 'hero-bg--no-media';
    }

    return $args;

  }

}
