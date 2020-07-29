<?php
/**
 * Post type: Person card
 *
 * @see https://codex.wordpress.org/Function_Reference/register_post_type
 * @see https://developer.wordpress.org/resource/dashicons/
 * @see https://generatewp.com/post-type/
 */

add_action('init', function() {

    $labels = array(
      'name'                  => _x( 'Yhteyshenkilöt',                   'Post Type General Name', 'aucor_plugin' ),
      'singular_name'         => _x( 'Yhteyshenkilö',                    'Post Type Singular Name', 'aucor_plugin' ),
      'menu_name'             => __( 'Yhteyshenkilöt',                   'aucor_plugin' ),
      'name_admin_bar'        => __( 'Yhteyshenkilö',                    'aucor_plugin' ),
      'archives'              => __( 'Yhteyshenkilö-arkisto',            'aucor_plugin' ),
      'parent_item_colon'     => __( 'Ylempi yhteyshenkilö:',            'aucor_plugin' ),
      'all_items'             => __( 'Kaikki yhteyshenkilöt',            'aucor_plugin' ),
      'add_new_item'          => __( 'Lisää uusi yhteyshenkilö',         'aucor_plugin' ),
      'add_new'               => __( 'Lisää uusi',                       'aucor_plugin' ),
      'new_item'              => __( 'Uusi yhteyshenkilö',               'aucor_plugin' ),
      'edit_item'             => __( 'Muokkaa yhteyshenkilöä',           'aucor_plugin' ),
      'update_item'           => __( 'Päivitä yhteyshenkilö',            'aucor_plugin' ),
      'view_item'             => __( 'Näytä yhteyshenkilö',              'aucor_plugin' ),
      'search_items'          => __( 'Etsi yhteyshenkilöitä',            'aucor_plugin' ),

    );

    $args = array(
      'label'                 => __( 'Person', 'aucor_plugin' ),
      'labels'                => $labels,
      'supports'              => array('title', 'thumbnail'),
      'hierarchical'          => false,
      'public'                => false,
      'show_ui'               => true,
      'show_in_menu'          => true,
      'menu_position'         => 10,
      'menu_icon'             => 'dashicons-phone',
      'show_in_admin_bar'     => true,
      'show_in_nav_menus'     => false,
      'can_export'            => true,
      'has_archive'           => false,
      'exclude_from_search'   => false,
      'publicly_queryable'    => false,
      'capability_type'       => 'post',
    );

    register_post_type('person', $args);

  }, 0 );
