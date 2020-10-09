<?php

add_action('init', function() {

    $labels = array(
      'name'                  => _x( 'Huomiopalkit',                    'Post Type General Name', 'aucor_plugin' ),
      'singular_name'         => _x( 'Huomiopalkki',                    'Post Type Singular Name', 'aucor_plugin' ),
      'menu_name'             => __( 'Huomiopalkit',                    'aucor_plugin' ),
      'name_admin_bar'        => __( 'Huomiopalkit',                    'aucor_plugin' ),
      'archives'              => __( 'Arkisto',                         'aucor_plugin' ),
      'parent_item_colon'     => __( 'Ylempi huomiopalkki:',            'aucor_plugin' ),
      'all_items'             => __( 'Kaikki huomiopalkit',             'aucor_plugin' ),
      'add_new_item'          => __( 'Lisää uusi huomiopalkki',         'aucor_plugin' ),
      'add_new'               => __( 'Lisää uusi',                      'aucor_plugin' ),
      'new_item'              => __( 'Uusi huomiopalkki',               'aucor_plugin' ),
      'edit_item'             => __( 'Muokkaa huomiopalkkia',           'aucor_plugin' ),
      'update_item'           => __( 'Päivitä huomiopalkki',            'aucor_plugin' ),
      'view_item'             => __( 'Näytä huomiopalkki',              'aucor_plugin' ),
      'search_items'          => __( 'Etsi huomiopalkkia',              'aucor_plugin' ),

    );

    $args = array(
      'label'                 => __( 'Huomiopalkit', 'aucor_plugin' ),
      'labels'                => $labels,
      'supports'              => array('title'),
      'hierarchical'          => false,
      'public'                => false,
      'show_ui'               => true,
      'show_in_menu'          => true,
      'menu_position'         => 58.58,
      'menu_icon'             => 'dashicons-warning',
      'show_in_admin_bar'     => true,
      'show_in_nav_menus'     => false,
      'can_export'            => true,
      'has_archive'           => false,
      'exclude_from_search'   => false,
      'publicly_queryable'    => false,
      'capability_type'       => 'post',
    );

    register_post_type('notification', $args);

  }, 0 );
