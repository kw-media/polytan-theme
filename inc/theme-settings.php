<?php
/**
 * Check and setup theme's default settings
 *
 * @package polytan
 *
 */

if ( ! function_exists ( 'polytan_setup_theme_default_settings' ) ) {
	function polytan_setup_theme_default_settings() {

		// check if settings are set, if not set defaults.
		// Caution: DO NOT check existence using === always check with == .
		// Latest blog posts style.
		$polytan_posts_index_style = get_theme_mod( 'polytan_posts_index_style' );
		if ( '' == $polytan_posts_index_style ) {
			set_theme_mod( 'polytan_posts_index_style', 'default' );
		}

		// Sidebar position.
		$polytan_sidebar_position = get_theme_mod( 'polytan_sidebar_position' );
		if ( '' == $polytan_sidebar_position ) {
			set_theme_mod( 'polytan_sidebar_position', 'right' );
		}

		// Container width.
		$polytan_container_type = get_theme_mod( 'polytan_container_type' );
		if ( '' == $polytan_container_type ) {
			set_theme_mod( 'polytan_container_type', 'container' );
		}
	}
}