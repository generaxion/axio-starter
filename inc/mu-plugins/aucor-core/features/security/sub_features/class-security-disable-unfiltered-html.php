<?php
/**
 * Class Security_Disable_Unfiltered_Html
 */
class Aucor_Core_Security_Disable_Unfiltered_Html extends Aucor_Core_Sub_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'aucor_core_security_disable_unfiltered_html');

    // var: name
    $this->set('name', 'Restricts unfiltered HTML to be entered in the texteditors');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Run feature
   */
  public function run() {
    if (!defined('DISALLOW_UNFILTERED_HTML')) {
      define('DISALLOW_UNFILTERED_HTML', true);
    }
  }

}
