<?php
/**
 * Debugging functions
 *
 * @package aucor_starter
 */

/**
 * Send debugging messages when WP_DEBUG is enbaled
 *
 * @param string $msg the message for error
 * @param array  $functions the functions used
 */
function aucor_starter_debug($msg, $functions) {

  if (WP_DEBUG === true) {

    // init warning to get source
    $e = new Exception($msg);

    // find file and line for problem
    $trace_line ='';
    foreach ($e->getTrace() as $trace) {
      if (in_array($trace['function'], $functions)) {
        $trace_line = ' in ' . $trace['file'] . ':' . $trace['line'];
      }
    }

    // compose error message
    $error_msg = $e->getMessage() . $trace_line;

    // trigger errors
    trigger_error($error_msg, E_USER_WARNING);
    error_log($error_msg);

  }

}
