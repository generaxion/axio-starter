<?php

/**
 * Config Aucor Core
 * https://github.com/aucor/aucor-core
 */

/** Admin */
add_filter( 'aucor_core_admin_gallery', '__return_false' );
add_filter( 'aucor_core_admin_image_link', '__return_false' );
add_filter( 'aucor_core_admin_profile_cleanup', '__return_false' );
/** Dashboard */
add_filter( 'aucor_core_dashboard_cleanup', '__return_false' );
add_filter( 'aucor_core_dashboard_remove_panels', '__return_false' );
/** ront-end */
add_filter( 'aucor_core_front_end', '__return_false' );
/** security */
add_filter( 'aucor_core_security_disable_unfiltered_html', '__return_false' );
// add_filter( 'aucor_core_security_remove_comment_moderation', '__return_false' );
// add_filter( 'aucor_core_security_remove_commenting', '__return_false' );

require WPMU_PLUGIN_DIR . '/aucor-core/plugin.php';

/**
 * Site
 */
require WPMU_PLUGIN_DIR . '/site/plugin.php';


if ( WP_DEBUG ) {
	/**
	 * Basic Auth for Node/remote access
	 * https://github.com/WP-API/Basic-Auth
	 */
	//require __DIR__ . '/Basic-Auth/basic-auth.php';
}
