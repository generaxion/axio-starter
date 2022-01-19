<?php
/**
 * Component: Background
 *
 * @example
 * X_Background::render([
 *   'contents' => '<h1>Title</h1>',
 *   'fields'   => get_fields(),
 * ]);
 *
 * @package axio
 */
class X_Background extends X_Component {

  public static function frontend($data) {
  ?>

    <section <?php parent::render_attributes($data['attr']); ?>>
      <?php if ($data['has_background']) : ?>
          <div class="background__media js-background__media">
            <?php if ($data['type'] == 'image') : ?>
              <?php
              X_Image::render([
                'id'       => $data['image_id'],
                'size'     => 'background',
              ]);
              ?>
            <?php elseif ($data['type'] == 'video') : ?>
              <div class="background__media__video-wrapper">
                <?php
                  /**
                   * Notes on video element:
                   * 1. Obsolete width and height is set for browser rendering, they don't rellay matter
                   * 2. Transparent poster is set for faster rendering
                   */
                ?>
                <video autoplay="autoplay" loop="loop" muted="muted" playsinline="playsinline" width="800" height="450" poster="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7">
                  <source src="<?php echo esc_attr($data['video_url']); ?>" type="video/mp4">
                </video>
              </div>
            <?php endif; ?>
          <?php if ($data['dimming_opacity'] > 0) : ?>
            <div class="background__dimming" style="opacity:<?php echo esc_attr($data['dimming_opacity']); ?>%"></div>
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <div class="background__content inner-blocks">
        <?php echo $data['contents']; ?>
      </div>

    </section>
    <?php
  }

  public static function backend($args = []) {

    $placeholders = [

      // required
      'contents'                      => '',
      'fields'                        => [],

      // optional
      'attr'  => [],

      // internal
      'is_editor'                    => false,
      'is_dark_mode'                 => true,
      'video_url'                    => null,
      'image_id'                     => null,
      'has_background'               => false,
      'type'                         => 'color',
      'dimming_opacity'              => 0
    ];

    $args = wp_parse_args($args, $placeholders);

    if (!isset($args['attr']['class'])) {
      $args['attr']['class'] = [];
    }
    $args['attr']['class'][] = 'background';
    $args['attr']['class'][] = 'js-background';

    $f = $args['fields'];

    // type
    $type = isset($f['background_media_type']) ? $f['background_media_type'] : null;
    if (is_string($type) && !empty($type)) {
      $args['type'] = $type;
    }
    $args['attr']['class'][] = 'background--type-' . $args['type'];

    /**
     * Background: color
     */
    if ($args['type'] === 'color') {

      $args['is_dark_mode'] = false;

      if (isset($f['background_color']) && !empty($f['background_color'])) {
        $args['attr']['class'][] = 'background-color';
        $args['attr']['class'][] = 'background-color--' . $f['background_color'];
        $colors = apply_filters('x_background_colors', []);
        if (isset($colors[$f['background_color']]) && isset($colors[$f['background_color']]['is_dark'])) {
          $args['is_dark_mode'] = $colors[$f['background_color']]['is_dark'];
        }
      } else {
        $args['attr']['class'][] = 'background-color';
        $args['attr']['class'][] = 'background-color--none';
      }

    } elseif ($args['type'] === 'video' && !empty($f['background_video'])) {

      $args['video_url'] = $f['background_video'];
      $args['has_background'] = true;

    } elseif ($args['type'] == 'image') {

      /**
       * Background: image
       */
      $image_id = $f['background_image'];
      if (!empty($image_id)) {
        $args['image_id'] = $image_id;
        $args['has_background'] = true;
      }

    }

    /**
     * Dimming
     */
    if (in_array($args['type'], ['image', 'video'])) {

      $dimming = $f['background_dimming'];

      $dimming_amount = 0;
      if (isset($f['background_dimming']) && !empty($f['background_dimming'])) {
        $dimming_amount = (int) $f['background_dimming'];
      }
      $args['dimming_opacity'] = $dimming_amount;

    }

    /**
     * Sizing
     */
    $min_height = isset($f['background_height']) ? $f['background_height'] : null;
    if (!empty($min_height) && is_string($min_height)) {
      $args['attr']['class'][] = 'background--height-' . $min_height;
    }

    /**
     * Content position
     */
    $position = isset($f['background_content_align']) ? $f['background_content_align'] : null;
    if (empty($position) || !is_string($position)) {
      $position = 'middle';
    }
    $args['attr']['class'][] = 'background--vertical-align-' . $position;

    /**
     * Content background
     */
    $has_content_background = isset($f['background_has_content_background']) ? $f['background_has_content_background'] : null;
    if (empty($has_content_background)) {
      $args['attr']['class'][] = 'background--content-background-none';
    } else {
      $args['attr']['class'][] = 'background--content-background-light';
      $args['is_dark_mode'] = false;
    }

    /**
     * Dark mode
     */
    if (isset($f['background_content_mode'])) {
      $manual_mode = $f['background_content_mode'];
      if (is_string($manual_mode) && $manual_mode !== 'auto') {
        $args['is_dark_mode'] = $manual_mode !== 'light';
      }
    }
    $color_mode = $args['is_dark_mode'] ? 'is-dark-mode' : 'is-light-mode';
    $args['attr']['class'][] = $color_mode;

    /**
     * Front end / editor mode
     */
    $args['is_editor'] = (is_admin());
    $args['attr']['class'][] = $args['is_editor'] ? 'background--env-editor' : 'background--env-front';

    /**
     * Extra classes
     */
    if (isset($f['class'])) {
      foreach ($f['class'] as $class) {
        $args['attr']['class'][] = $class;
      }
    }

    return $args;

  }

}
