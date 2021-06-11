<?php

//add_filter('acf/load_value/name=pw-ingredients', function($value, $post_id, $field) {
//  //dlog('$value');
//  if (empty($value)) return $value;
//  $order = [];
//
//  // populate order
//  foreach ($value as $i => $row) {
//    // this is not working because ingredient is an int not a string so sorting is sorting the ids
//    $order[$i] = $row['field_60907e5096cd1'];
//  }
//
//  // multisort
//  array_multisort($order, SORT_DESC, $value);
//
//  return $value;
//}, 10, 3);
