<?php
/**
 * Component: File
 *
 * @package axio
 */
class X_File extends X_Component {

  public static function frontend($data) {
    ?>
    <div <?php parent::render_attributes($data['attr']); ?>>
      <a <?php parent::render_attributes($data['link_attr']); ?>>
        <span class="module-file__icon">
          <?php X_SVG::render(['name' => 'file']); ?>
        </span>
        <span class="module-file__title">
          <?php echo $data['title']; ?>
        </span>
      </a>
    </div>

    <?php
  }

  public static function backend($args = []) {

    $placeholders = [

      // required
      'id'            => '',

      // optional
      'title'         => '',
      'attr'          => [],
      'link_attr'     => [],

    ];

    $args = wp_parse_args($args, $placeholders);

    // check for missing button title
    if (empty($args['id'])) {
      return parent::error('Missing file id ($args[\'id\'])');
    }

    $url = wp_get_attachment_url($args['id']);

    if ($url === false) {
      return parent::error('Invalid file by ID ($args[\'id\'])');
    }

    if (!isset($args['attr']['class'])) {
      $args['attr']['class'] = [];
    }
    $args['attr']['class'][] = 'module-file';

    if (!isset($args['link_attr']['class'])) {
      $args['link_attr']['class'] = [];
    }
    $args['link_attr']['class'][] = 'module-file__link';
    $args['link_attr']['download'] = null;
    $args['link_attr']['href'] = $url;

    if (empty($args['title'])) {
      $args['title'] = get_the_title($args['id']);
    }

    // prepend a11y context
    $args['title'] = '<span class="screen-reader-text">' . ask__('Files: Accessability download') . '</span>' . $args['title'];

    // append extension
    $args['title'] .= ' (.' . pathinfo($url, PATHINFO_EXTENSION) . ')';

    return $args;
  }
}
