<?php
/**
 * Class Plugins
 */
class Aucor_Core_Plugins extends Aucor_Core_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'aucor_core_plugins');

    // var: name
    $this->set('name', 'Plugins');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Initialize and add the sub_features to the $sub_features array
   */
  public function sub_features_init() {

    // var: sub_features
    $this->set('sub_features', array(
      'aucor_core_plugins_acf'            => new Aucor_Core_Plugins_Acf,
      'aucor_core_plugins_gravityforms'   => new Aucor_Core_Plugins_Gravityforms,
      'aucor_core_plugins_redirection'    => new Aucor_Core_Plugins_Redirection,
      'aucor_core_plugins_seo'            => new Aucor_Core_Plugins_Seo,
      'aucor_core_plugins_yoast'          => new Aucor_Core_Plugins_Yoast,
    ));

  }

}
