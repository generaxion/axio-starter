<?php
/**
 * Class Debug_Wireframe
 */
class Aucor_Core_Debug_Wireframe extends Aucor_Core_Sub_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'aucor_core_debug_wireframe');

    // var: name
    $this->set('name', 'Adds outlines to all elements on page to help with visual debugging');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Run feature
   */
  public function run() {
    add_action('wp_head', array($this, 'aucor_core_wireframe'), 10);
  }

  /**
   * Adds outlines to all elements on page to help with visual debugging if the GET parameter "?ac-debug=wireframe" is present in the url.
   * Also append the parameter to the href value in anchor tags found on the page to keep the wireframe mode enabled during navigation
   */
  public static function aucor_core_wireframe() {
    if (isset($_GET['ac-debug']) && $_GET['ac-debug'] == 'wireframe') {
    ?>
    <style>
      * {
        outline: 1px solid !important;
      }
    </style>
    <script>
      document.addEventListener("DOMContentLoaded", function(event) {
        var links = document.getElementsByTagName('a');
        for(var i = 0; i < links.length; i++) {
          if (links[i].href.indexOf('?') == -1) { // The link doesn't contain other GET parameters
            links[i].href += '?ac-debug=wireframe';
          }
          else {
            links[i].href += '&ac-debug=wireframe';
          }
        }
      });
    </script>
      <?php
    }
  }
}
