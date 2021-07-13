<?php
/**
 * Class Plugins_Gravityforms
 */
class Aucor_Core_Plugins_Gravityforms extends Aucor_Core_Sub_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'aucor_core_plugins_gravityforms');

    // var: name
    $this->set('name', 'Settings for the Gravity Forms plugin');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Run feature
   */
  public function run() {

    /**
     * Reset Gravity Forms tabindex (a11y)
     */
    add_filter('gform_tabindex', '__return_false');

    /**
     * Move Gravity Forms script to footer
     */
    add_filter('gform_init_scripts_footer', '__return_true');

  }

}
