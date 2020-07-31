<?php

add_action('init', function() {

    $labels = array(
      'name'                  => _x( 'Huomiopalkit',                    'Post Type General Name', 'seure_plugin' ),
      'singular_name'         => _x( 'Huomiopalkki',                    'Post Type Singular Name', 'seure_plugin' ),
      'menu_name'             => __( 'Huomiopalkit',                    'seure_plugin' ),
      'name_admin_bar'        => __( 'Huomiopalkit',                    'seure_plugin' ),
      'archives'              => __( 'Arkisto',                         'seure_plugin' ),
      'parent_item_colon'     => __( 'Ylempi huomiopalkki:',            'seure_plugin' ),
      'all_items'             => __( 'Kaikki huomiopalkit',             'seure_plugin' ),
      'add_new_item'          => __( 'LisÃ¤Ã¤ uusi huomiopalkki',         'seure_plugin' ),
      'add_new'               => __( 'LisÃ¤Ã¤ uusi',                      'seure_plugin' ),
      'new_item'              => __( 'Uusi huomiopalkki',               'seure_plugin' ),
      'edit_item'             => __( 'Muokkaa huomiopalkkia',           'seure_plugin' ),
      'update_item'           => __( 'PÃ¤ivitÃ¤ huomiopalkki',            'seure_plugin' ),
      'view_item'             => __( 'NÃ¤ytÃ¤ huomiopalkki',              'seure_plugin' ),
      'search_items'          => __( 'Etsi huomiopalkkia',              'seure_plugin' ),

    );

    $args = array(
      'label'                 => __( 'Huomiopalkit', 'seure_plugin' ),
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
