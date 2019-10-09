<?php
/**
 * Component: Search Form
 *
 * @example
 * Aucor_Search_Form::render();
 *
 * @example
 * Aucor_Search_Form::render([
 *   'section_title'  => 'Share this article',
 *   'post_title'     => 'Custom post title',
 *   'permalink'      => get_permalink(),
 * ]);
 *
 * @package aucor_starter
 */
class Aucor_Search_Form extends Aucor_Component {

  public static function frontend($data) {
    ?>

    <form <?php parent::render_attributes($data['attr']); ?>>

      <label for="<?php echo esc_attr('search-form-input-' . $data['id']); ?>" class="search-form__label screen-reader-text">
        <?php echo esc_attr($data['screen-reader-text']); ?>
      </label>

      <input
        type="search"
        class="search-form__input"
        id="<?php echo esc_attr('search-form-input-' . $data['id']); ?>"
        name="<?php echo esc_attr($data['name']); ?>"
        value="<?php echo esc_attr($data['value']); ?>"
        placeholder="<?php echo esc_attr($data['placeholder']); ?>"
      />

      <button type="submit" class="search-form__submit">
        <?php echo $data['submit']; ?>
      </button>

    </form>

    <?php
  }

  public static function backend($args = []) {

    $placeholders = [

      // required (none)

      // optioal
      'action'             => home_url('/'),
      'attr'               => [],
      'value'              => get_search_query(),
      'name'               => 's',
      'submit'             => ask__('Search: Submit'), // can be HTML, icons etc
      'placeholder'        => ask__('Search: Placeholder'),
      'screen-reader-text' => ask__('Search: Screen reader label'),

      // internal
      'id'                => '',

    ];
    $args = wp_parse_args($args, $placeholders);

    if (!isset($args['attr']['class'])) {
      $args['attr']['class'] = [];
    }
    $args['attr']['class'][] = 'search-form';

    // unique ID
    $args['id'] = wp_unique_id();

    // form attributes
    $args['attr']['id']     = 'search-form-' . $args['id'];
    $args['attr']['role']   = 'search';
    $args['attr']['method'] = 'get';
    $args['attr']['action'] = $args['action'];

    // a11y
    $args['attr']['aria-expanded'] = 'false';

    return $args;

  }

}
