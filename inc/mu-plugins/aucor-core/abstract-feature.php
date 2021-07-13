<?php
/**
 * Abstract Class Feature
 *
 * Structure and required functionality for each feature.
 * Every feature should inherit this class.
 */
abstract class Aucor_Core_Feature {

  /* ===================================================================
  01. Things to implement
  =================================================================== */

  // var: key - string
  private $key;

  // var: name - string
  private $name;

  // var: description - string, not used in version 1
  private $description;

  // var: is the feature active or inactive (disabled) - boolean
  private $is_active;

  // var: list of sub_features in the feature - array
  private $sub_features;

  // function: setup feature
  abstract public function setup();

  // function: init sub_features
  abstract public function sub_features_init();

  /* ===================================================================
  02. Things to inherit
  =================================================================== */

  /**
   * Construct
   */
  public function __construct() {
    $this->setup();
    if ($this->is_active()) {
      $this->sub_features_init();
    }
  }

  /**
   * Check if the feature is active
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

  public function get_sub_features() {
    return $this->sub_features;
  }

}
