<?php
/**
 * Class Dashboard
 */
class Aucor_Core_Dashboard extends Aucor_Core_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'aucor_core_dashboard');

    // var: name
    $this->set('name', 'Dashboard');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Initialize and add the sub_features to the $sub_features array
   */
  public function sub_features_init() {

    // var: sub_features
    $this->set('sub_features', array(
      'aucor_core_dashboard_cleanup'       => new Aucor_Core_Dashboard_Cleanup,
      'aucor_core_dashboard_recent_widget' => new Aucor_Core_Dashboard_Recent_Widget,
      'aucor_core_dashboard_remove_panels' => new Aucor_Core_Dashboard_Remove_Panels,
    ));

  }

}
