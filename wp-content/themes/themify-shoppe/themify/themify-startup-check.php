<?php
/**
 * Perform start up checks for Themify themes.
 * Disables the loading of the theme is requirements are not met.
 *
 * @package Themify
 */

function themify_startup_check() {

	$check = true;

	/* memory limit check */
	$tf_memory_limit = wp_convert_hr_to_bytes( ini_get( 'memory_limit' ) );
	if ( -1 !== $tf_memory_limit && $tf_memory_limit < 67108864 ) { // 64MB
		/* attempt to increase memory limit */
		if ( wp_is_ini_value_changeable( 'memory_limit' ) ) {
			ini_set( 'memory_limit', '64M' );
		} else {
			$check = new WP_Error( 'tf_memory_limit', __( 'Themify theme has been disabled due to low PHP memory limit. Please contact your host provider to increase PHP memory limit to minimum 64MB (128MB recommended).', 'themify' ) );
		}
	}

	/* PHP version check */
	if ( $check === true && version_compare( phpversion(), '5.6.20', '<' ) ) {
		$check = new WP_Error( 'tf_php', __( 'Please contact your host provider to upgrade PHP software. We recommend using PHP version 7.2 or above for greater performance and security.', 'themify' ) );
	}

	if ( is_wp_error( $check ) ) {

		if ( is_admin() ) {
			/* prevent the theme from loading */
			add_filter( 'themify_theme_includes', '__return_empty_array' );

			add_action( 'admin_notices', function() use( $check ) {
				echo '<div class="notice notice-error"><p>' . $check->get_error_message() . '</p></div>';
			} );
		}
	}

}
themify_startup_check();