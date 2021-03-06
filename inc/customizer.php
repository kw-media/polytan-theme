<?php
/**
 * Polytan Theme Customizer
 *
 * @package polytan
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
if ( ! function_exists( 'polytan_customize_register' ) ) {
	/**
	 * Register basic customizer support.
	 *
	 * @param object $wp_customize Customizer reference.
	 */
	function polytan_customize_register( $wp_customize ) {
		$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	}
}
add_action( 'customize_register', 'polytan_customize_register' );

if ( ! function_exists( 'polytan_theme_customize_register' ) ) {
	/**
	 * Register individual settings through customizer's API.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer reference.
	 */
	function polytan_theme_customize_register( $wp_customize ) {

		// Theme layout settings.
		$wp_customize->add_section( 'polytan_theme_layout_options', array(
			'title'       => __( 'Theme Layout Settings', 'polytan' ),
			'capability'  => 'edit_theme_options',
			'description' => __( 'Container width and sidebar defaults', 'polytan' ),
			'priority'    => 160,
		) );

		 //select sanitization function
        function polytan_theme_slug_sanitize_select( $input, $setting ){
         
            //input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
            $input = sanitize_key($input);
 
            //get the list of possible select options 
            $choices = $setting->manager->get_control( $setting->id )->choices;
                             
            //return input if valid or return default option
            return ( array_key_exists( $input, $choices ) ? $input : $setting->default );                
             
        }

		$wp_customize->add_setting( 'polytan_container_type', array(
			'default'           => 'container',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'polytan_theme_slug_sanitize_select',
			'capability'        => 'edit_theme_options',
		) );

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'polytan_container_type', array(
					'label'       => __( 'Container Width', 'polytan' ),
					'description' => __( "Choose between Bootstrap's container and container-fluid", 'polytan' ),
					'section'     => 'polytan_theme_layout_options',
					'settings'    => 'polytan_container_type',
					'type'        => 'select',
					'choices'     => array(
						'container'       => __( 'Fixed width container', 'polytan' ),
						'container-fluid' => __( 'Full width container', 'polytan' ),
					),
					'priority'    => '10',
				)
			) );

		$wp_customize->add_setting( 'polytan_sidebar_position', array(
			'default'           => 'right',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'capability'        => 'edit_theme_options',
		) );

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'polytan_sidebar_position', array(
					'label'       => __( 'Sidebar Positioning', 'polytan' ),
					'description' => __( "Set sidebar's default position. Can either be: right, left, both or none. Note: this can be overridden on individual pages.",
					'polytan' ),
					'section'     => 'polytan_theme_layout_options',
					'settings'    => 'polytan_sidebar_position',
					'type'        => 'select',
					'sanitize_callback' => 'polytan_theme_slug_sanitize_select',
					'choices'     => array(
						'right' => __( 'Right sidebar', 'polytan' ),
						'left'  => __( 'Left sidebar', 'polytan' ),
						'both'  => __( 'Left & Right sidebars', 'polytan' ),
						'none'  => __( 'No sidebar', 'polytan' ),
					),
					'priority'    => '20',
				)
			) );
	}
} // endif function_exists( 'polytan_theme_customize_register' ).
add_action( 'customize_register', 'polytan_theme_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
if ( ! function_exists( 'polytan_customize_preview_js' ) ) {
	/**
	 * Setup JS integration for live previewing.
	 */
	function polytan_customize_preview_js() {
		wp_enqueue_script( 'polytan_customizer', get_template_directory_uri() . '/js/customizer.js',
			array( 'customize-preview' ), '20130508', true );
	}
}
add_action( 'customize_preview_init', 'polytan_customize_preview_js' );
