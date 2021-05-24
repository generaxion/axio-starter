<?php
/**
 * Component: Share Buttons (for social media)
 *
 * @example
 * X_Share_Buttons::render();
 *
 * @example
 * X_Share_Buttons::render([
 *   'section_title'  => 'Share this article',
 *   'post_title'     => 'Custom post title',
 *   'permalink'      => get_permalink(),
 * ]);
 *
 * @package axio
 */
class X_Share_Buttons extends X_Component {

  public static function frontend($data) {
    ?>
    <div <?php parent::render_attributes($data['attr']); ?>>

      <span class="social-share__title"><?php echo $data['section_title']; ?></span>

      <a class="social-share__link social-share__link--facebook" href="<?php echo esc_url('https://www.facebook.com/sharer/sharer.php?u=' . $data['permalink']); ?>" target="_blank">
        <?php X_SVG::render(['name' => 'facebook']); ?>
        <span class="social-share__link__label"><?php ask_e('Social share: Facebook'); ?></span>
      </a>

      <a class="social-share__link social-share__link--twitter" href="<?php echo esc_url('https://twitter.com/share?url=' . $data['permalink']); ?>" target="_blank">
        <?php X_SVG::render(['name' => 'twitter']); ?>
        <span class="social-share__link__label"><?php ask_e('Social share: Twitter'); ?></span>
      </a>

      <a class="social-share__link social-share__link--linkedin" href="<?php echo esc_url('https://www.linkedin.com/shareArticle?mini=true&title=' . $data['post_title'] . '&url=' . $data['permalink']); ?>" target="_blank">
        <?php X_SVG::render(['name' => 'linkedin']); ?>
        <span class="social-share__link__label"><?php ask_e('Social share: LinkedIn'); ?></span>
      </a>

      <a class="social-share__link social-share__link--whatsapp" href="<?php echo esc_url('https://api.whatsapp.com/send?text=' . $data['post_title'] . '%20-%20' . $data['permalink']); ?>" target="_blank" >
        <?php X_SVG::render(['name' => 'whatsapp']); ?>
        <span class="social-share__link__label"><?php ask_e('Social share: WhatsApp'); ?></span>
      </a>

    </div>
    <?php
  }

  public static function backend($args = []) {

    $placeholders = [

      // required (none)

      // optioal
      'attr'           => [],
      'post_title'     => '',
      'section_title'  => '',
      'permalink'      => '',

      // internal

    ];
    $args = wp_parse_args($args, $placeholders);

    if (!isset($args['attr']['class'])) {
      $args['attr']['class'] = [];
    }
    $args['attr']['class'][] = 'social-share';

    if (empty($args['post_title'])) {
      $args['post_title'] = get_the_title();
    }
    if (empty($args['permalink'])) {
      $args['permalink'] = (!is_tax()) ? get_permalink() : get_term_link(get_queried_object()->term_id);
    }
    if (empty($args['section_title'])) {
      $args['section_title'] = ask__('Social share: Title');
    }
    $args['attr']['aria-label'] = $args['section_title'];

    return $args;

  }

}
