<?php
/**
 * V1.3 SD
 */

/**
 * Trigger gulp watch php files
 */
if ( ! class_exists( 'SD_Debug' ) ) {
  if ( WP_DEBUG ) {
    add_action( 'wp_update_nav_menu', function() {
      touch( get_template_directory() . '\temp.php' );
      touch( get_stylesheet_directory() . '\temp.php' );
    } );
    add_action( 'save_post', function() {
      touch( get_template_directory() . '\temp.php' );
      touch( get_stylesheet_directory() . '\temp.php' );
    } );
  }
  if ( ! function_exists( 'd' ) ) {
    /**
     * Example
     * global $_wp_additional_image_sizes;
     * dd( $_wp_additional_image_sizes );
     *
     * @param mixed $obj
     * @param bool  $print
     *
     * @return  mixed
     */
    function d( $obj, $print = true ) {
      if ( WP_DEBUG ) {
        $obj = '<pre style="position: absolute; z-index: 9999999999999; background:#000;color:#fff; padding:40px;">' .
               preg_replace( '(\d+\s=>)', "", var_export( $obj, true ) ) .
               '</pre>';
        if ( $print ) {
          echo $obj;
        }

        return $obj;
      }

      return '';

    }
  }

  if ( ! function_exists( 'dd' ) ) {
    /**
     * @param mixed $obj
     */
    function dd( ...$obj ) {
      if ( WP_DEBUG ) {
        if ( count( $obj ) == 1 ) {
          $obj = $obj[0];
        }
        die( d( $obj, true ) );
      }
    }
  }

  if ( ! function_exists( 'dlog' ) ) {
    /**
     * @param array $obj
     */
    function dlog( ...$obj ) {
      if ( WP_DEBUG ) {
        if ( count( $obj ) == 1 ) {
          $obj = $obj[0];
        }
        SD_Debug::instance()->log( $obj );
      }
    }
  }

  class SD_Debug {

    private static $instance;
    public         $debug_obj;

    /**
     * Optional Global instance
     *
     * @return SD_Debug
     */
    public static function instance() {
      if ( ! self::$instance ) {
        self::$instance = new self();
      }

      return self::$instance;
    }

    /**
     * Debug constructor.
     *
     */
    public function __construct() {
      $this->init();
    }

    /**
     * @param $obj - add item to the debug log
     */
    public function log( $obj ) {
      //$this->check();
      $this->debug_obj[] = $obj;
    }

    private function init() {
      $this->debug_obj = [];
      add_action( 'wp_footer', function() {
        if ( $this->debug_obj ) {
          foreach ( $this->debug_obj as $obj ) {
            echo '<script>console.log(' . json_encode( $obj ) . ')</script>';
          }
        }
      }, 99999 );
    }
  }
}
