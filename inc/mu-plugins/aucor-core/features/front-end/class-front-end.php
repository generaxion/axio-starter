<?php
/**
 * Class Front_End
 */
class Aucor_Core_Front_End extends Aucor_Core_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'aucor_core_front_end');

    // var: name
    $this->set('name', 'Front End');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Initialize and add the sub_features to the $sub_features array
   */
  public function sub_features_init() {

    // var: sub_features
    $this->set('sub_features', array(
      'aucor_core_front_end_excerpt'    => new Aucor_Core_Front_End_Excerpt,
      'aucor_core_front_end_html_fixes' => new Aucor_Core_Front_End_Html_Fixes,
    ));

  }

}
