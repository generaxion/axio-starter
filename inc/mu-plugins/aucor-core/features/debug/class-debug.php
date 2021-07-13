<?php
/**
 * Class Debug
 */
class Aucor_Core_Debug extends Aucor_Core_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'aucor_core_debug');

    // var: name
    $this->set('name', 'Debug');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Initialize and add the sub_features to the $sub_features array
   */
  public function sub_features_init() {

    // var: sub_features
    $this->set('sub_features', array(
      'aucor_core_debug_style_guide'   => new Aucor_Core_Debug_Style_Guide,
      'aucor_core_debug_wireframe'     => new Aucor_Core_Debug_Wireframe,
    ));

  }

}
