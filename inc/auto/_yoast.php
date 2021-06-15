<?php

use sd\School;
use Yoast\WP\SEO\Generators\Schema\Organization;


// pretty print Schema
add_filter('yoast_seo_development_mode', '__return_true');

add_filter('wpseo_schema_webpage_type', function($type) {
  //return [0 => 'WebPage', 1 => 'ItemPage'];

  return $type;
});

// use schema type article

add_filter('wpseo_schema_article_post_types', function($post_types) {
  // ['post']
  //$post_types = ['my-post-type', 'my-other-post-type', 'post'];
  return $post_types;
});




add_filter('wpseo_schema_graph_pieces',
  /**
   * Adds Schema pieces to our output.
   *
   * @param array                 $pieces  Graph pieces to output.
   * @param \WPSEO_Schema_Context $context Object with context variables.
   *
   * @return array $pieces Graph pieces to output.
   */
  function($pieces, $context) {

    //$pieces = array_filter($pieces, function($piece) {
    //  return !$piece instanceof \Yoast\WP\SEO\Generators\Schema\Breadcrumb;
    //});
    //$pieces[] = new Schema_School($context);

    return $pieces;
  }, 11, 2);

class Schema_School extends Organization {
  /**
   * A value object with context variables.
   *
   * @var WPSEO_Schema_Context
   */
  private $context;

  /**
   * Schema_Event constructor.
   *
   * @param WPSEO_Schema_Context $context Value object with context variables.
   */
  public function __construct(WPSEO_Schema_Context $context) {
    $this->context = $context;
  }

  /**
   * Determines whether or not a piece should be added to the graph.
   *
   * @return bool
   */
  public function is_needed() {
    if (is_singular(School::POST_TYPE)) {
      return true;
    }

    return false;
  }

  /**
   * Adds our Event piece of the graph.
   *
   * @return array|bool $graph Event Schema markup
   */
  public function generate() {
    $data          = parent::generate();
    $data['@type'] = 'EducationalOrganization';

    return $data;
  }
}
