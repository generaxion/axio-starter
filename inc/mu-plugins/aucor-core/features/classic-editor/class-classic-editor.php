<?php
/**
 * Class Classic_Editor
 */
class Aucor_Core_Classic_Editor extends Aucor_Core_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'aucor_core_classic_editor');

    // var: name
    $this->set('name', 'Classic Editor');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Initialize and add the sub_features to the $sub_features array
   */
  public function sub_features_init() {

    // var: sub_features
    $this->set('sub_features', array(
      'aucor_core_classic_editor_tinymce' => new Aucor_Core_Classic_Editor_Tinymce,
    ));

  }

}
