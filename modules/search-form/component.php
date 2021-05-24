<?php
/**
 * Component: Search Form
 *
 * @example
 * X_Search_Form::render();
 *
 * @package axio
 */
class X_Search_Form extends X_Component {

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
        autocomplete="off"
      />

      <button type="submit" class="search-form__submit">
        <?php X_SVG::render(['name' => 'search']); ?>
        <span class="screen-reader-text"><?php echo $data['submit']; ?></span>
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
      'submit'             => ask__('Search form: Submit'), // can be HTML, icons etc
      'placeholder'        => ask__('Search form: Placeholder'),
      'screen-reader-text' => ask__('Search form: Screen reader label'),

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
