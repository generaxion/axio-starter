<?php
/**
 * Component: Media & Text
 *
 * @example
 * X_Media_Text::render();
 *
 * @package axio
 */
class X_Media_Text extends X_Component {

  public static function frontend($data) {
    ?>

    <div <?php parent::render_attributes($data['attr']); ?>>

      <div class="media-text__media">
        <?php if (!empty($data['has_media'])) : ?>
          <?php if ($data['type'] == 'image') : ?>
            <div class="media-text__media__image">
              <?php echo $data['image']; ?>
            </div>
            <?php elseif ($data['type'] == 'video') : ?>
              <div class="media-text__media__video">
                <?php
                  /**
                   * Notes on video element:
                   * 1. Obsolete width and height is set for browser rendering, they don't really matter
                   * 2. Transparent poster is set for faster rendering
                   */
                ?>
                <video autoplay="autoplay" loop="loop" muted="muted" playsinline="playsinline" width="800" height="450" loading="lazy" poster="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7">
                  <source src="<?php echo esc_attr($data['video_url']); ?>" type="video/mp4" />
                </video>
              </div>
            <?php endif; ?>
          <?php elseif ($data['is_preview']) : ?>
            <div class="media-text__media__image"></div>
          <?php endif; ?>
        </div>

      <div class="media-text__content">
        <div class="media-text__content__inner inner-blocks">
          <?php if (!empty($data['contents'])) : ?>
            <?php echo $data['contents']; ?>
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
      'attr'        => [],
      'fields'      => [],
      'width'       => 'wide',
      'is_preview'  => false,

      // internal
      'contents'    => '',
      'image_id'    => null,
      'video_url'   => null,
      'image'       => '',
      'position'    => 'right',
      'vertical'    => 'middle',

      // block
      'type'        => 'image',
      'has_media'   => false,

    ];
    $args = wp_parse_args($args, $placeholders);

    if (!isset($args['attr']['class'])) {
      $args['attr']['class'] = [];
    }
    $args['attr']['class'][] = 'media-text';

    $f = $args['fields'];

    /**
     * Type
     */
    $type = isset($f['type']) ? $f['type'] : null;
    if (is_string($type) && !empty($type)) {
      $args['type'] = $type;
    }
    $args['attr']['class'][] = 'media-text--type-' . $args['type'];
    $args['attr']['class'][] = 'js-media-text--type-' . $args['type'];

    /**
     * Media: Video
     */
    if ($args['type'] === 'video' && !empty($f['video'])) {

        $args['video_url'] = $f['video'];
        $args['has_media'] = true;

    } elseif ($args['type'] == 'image') {

      /**
       * Media: image
       */
      $image_id = $f['image'];
      if (!empty($image_id)) {
        $args['image_id'] = $image_id;
        $args['has_media'] = true;
      }
    }

    /**
     * Position
     */
    $media_position = isset($f['position']) ? $f['position'] : $args['position'];
    if (!empty($media_position) && is_string($media_position)) {
      $args['attr']['class'][] = 'media-text--position-' . $media_position;
    }

    /**
     * Vertical align
     */
    $text_vertical = isset($f['align']) ? $f['align'] : $args['vertical'];
    if (!empty($text_vertical) && is_string($text_vertical)) {
      $args['attr']['class'][] = 'media-text--align-' . $text_vertical;
    }

    /**
     * Background
     */
    if (isset($f['background']) && !empty($f['background'])) {

      $args['attr']['class'][] = 'background-color';
      $args['attr']['class'][] = 'background-color--' . $f['background'];
      $colors = apply_filters('x_background_colors', []);
      if (isset($colors[$f['background']]) && isset($colors[$f['background']]['is_dark']) && $colors[$f['background']]['is_dark']) {
        $args['attr']['class'][] = 'is-dark-mode';
      }

    }

    // image size
    $size = 'media_text_wide';
    if ($args['width'] == 'full') {
      $size = 'media_text_full';
    }

    if (!empty($args['image_id'])) {
      $args['image'] = X_Image::get([
        'id'    => $args['image_id'],
        'size'  => $size,
      ]);
    }

    // fallbacks
    if (!$args['has_media']) {
      $args['attr']['class'][] = 'media-text--no-media';
    }

    return $args;

  }

}
