<?php
/**
 * Abstract Class Sub_Feature
 *
 * Structure and required functionality for each sub_feature.
 * Every sub_feature should inherit this class.
 */
abstract class Aucor_Core_Sub_Feature {

  /* ===================================================================
  01. Things to implement
  =================================================================== */

  // var: key - string
  private $key;

  // var: name - string
  private $name;

  // var: description - string, not used in version 1
  private $description;

  // var: is the sub_feature active or inactive (disabled) - boolean
  private $is_active;

  // function: setup feature
  abstract public function setup();

  // function: run feature
  abstract public function run();

  /* ===================================================================
  02. Things to inherit
  =================================================================== */

  /**
   * Construct
   */
  public function __construct() {
    $this->setup();
    if ($this->is_active()) {
      $this->run();
    }
  }

  /**
   * Check if feature is active
   *
   * @return bool
   */
  public function is_active() {
    return apply_filters($this->key, $this->is_active);
  }

  /**
   * Set function
   */
  public function set($key, $value) {
    if (property_exists($this, $key)) {
      $this->$key = $value;
    }
  }

  /**
   * Get functions
   */
  public function get_key() {
    return $this->key;
  }

  public function get_name() {
    return $this->name;
  }

  public function get_description() {
    return $this->description;
  }

}
