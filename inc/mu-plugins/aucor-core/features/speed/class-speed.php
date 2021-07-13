<?php
/**
 * Class Speed
 */
class Aucor_Core_Speed extends Aucor_Core_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'aucor_core_speed');

    // var: name
    $this->set('name', 'Speed');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Initialize and add the sub_features to the $sub_features array
   */
  public function sub_features_init() {

    // var: sub_features
    $this->set('sub_features', array(
      'aucor_core_speed_limit_revisions'  => new Aucor_Core_Speed_Limit_Revisions,
      'aucor_core_speed_move_jquery'      => new Aucor_Core_Speed_Move_Jquery,
      'aucor_core_speed_remove_emojis'    => new Aucor_Core_Speed_Remove_Emojis,
      'aucor_core_speed_remove_metabox'   => new Aucor_Core_Speed_Remove_Metabox,
    ));

  }

}
