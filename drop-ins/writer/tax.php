<?php
/**
 * Register writer taxonomy
 *
 * @see https://codex.wordpress.org/Function_Reference/register_taxonomy
 * @see https://generatewp.com/taxonomy/
 */

add_action('init', function() {

  $post_types = array(
    'post',
  );

  $labels = array(
    'name'                       => _x('Kirjoittajat',                   'Taxonomy General Name', 'aucor_starter'),
    'singular_name'              => _x('Kirjoittaja',                   'Taxonomy Singular Name', 'aucor_starter'),
    'menu_name'                  => __('Kirjoittajat',                   'aucor_starter'),
    'all_items'                  => __('Kirjoittajat',                  'aucor_starter'),
    'parent_item'                => __('Parent Kirjoittaja',            'aucor_starter'),
    'parent_item_colon'          => __('Parent Kirjoittaja:',           'aucor_starter'),
    'new_item_name'              => __('Uusi kirjoittaja',              'aucor_starter'),
    'add_new_item'               => __('Lisää uusi kirjoittaja',        'aucor_starter'),
    'edit_item'                  => __('Muokkaa kirjoittajaa',          'aucor_starter'),
    'update_item'                => __('Päivitä kirjoittaja',           'aucor_starter'),
    'view_item'                  => __('Näytä kirjoittaja',             'aucor_starter'),
    'separate_items_with_commas' => __('Erottele pilkulla',             'aucor_starter'),
    'add_or_remove_items'        => __('Lisää tai poista kirjoittaja',  'aucor_starter'),
    'choose_from_most_used'      => __('Valitse eniten käytetyistä',    'aucor_starter'),
    'popular_items'              => __('Suositut kirjoittajat',         'aucor_starter'),
    'search_items'               => __('Etsi kirjoittajia',             'aucor_starter'),
    'not_found'                  => __('Ei löydetty',                   'aucor_starter'),
    'no_terms'                   => __('Ei kirjoittajia',               'aucor_starter'),
    'items_list'                 => __('Kirjoittajat lista',            'aucor_starter'),
    'items_list_navigation'      => __('Kirjoittajat listanavigaatio',  'aucor_starter'),
  );

  $args = array(
    'labels'              => $labels,
    'hierarchical'        => false,
    'public'              => true,
    'show_ui'             => true,
    'show_admin_column'   => true,
    'show_in_nav_menus'   => true,
    'show_tagcloud'       => true,
    'show_in_rest'        => true,
  );

  register_taxonomy('writer', $post_types, $args);

}, 0);
