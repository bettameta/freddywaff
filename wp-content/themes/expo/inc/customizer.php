<?php
/**
 * Expo Theme Customizer
 *
 * @package Expo
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function expo_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

    $wp_customize->add_section( 'theme_options', array(
        'title' => __( 'Theme Options', 'expo' ),
        'priority' => 99
    ) );

    // Logo Setting
    $wp_customize->add_setting( 'expo_options[logo]', array(
        'default'       => '',
        'type'          => 'theme_mod',
        'transport'     => 'postMessage'
    ) );
 
    // Logo Control
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'expo_logo', array(
        'label'         => __( 'Logo', 'expo' ),
        'section'       => 'theme_options',
        'settings'      => 'expo_options[logo]'
    ) ) );
 
    // Font Setting
    $wp_customize->add_setting( 'expo_options[font]', array(
        'default'       => '',
        'type'          => 'theme_mod',
        'transport'     => 'postMessage'
    ) );
 
    // Font Control
    $wp_customize->add_control( 'expo_font', array(
        'label'         => __( 'Headline Font', 'expo' ),
        'section'       => 'theme_options',
        'settings'      => 'expo_options[font]',
        'type'          => 'select',
        'choices'       => expo_extract_valid_options( expo_font_array() )
    ) );
 
    // Font Alt Setting
    $wp_customize->add_setting( 'expo_options[font_alt]', array(
        'default'       => '',
        'type'          => 'theme_mod',
        'transport'     => 'postMessage'
    ) );
 
    // Font Alt Control
    $wp_customize->add_control( 'expo_font_alt', array(
        'label'         => __( 'Body Font', 'expo' ),
        'section'       => 'theme_options',
        'settings'      => 'expo_options[font_alt]',
        'type'          => 'select',
        'choices'       => expo_extract_valid_options( expo_font_array() )
    ) );
 
    // Custom CSS Setting
    $wp_customize->add_setting( 'expo_options[css]', array(
        'default'       => '',
        'type'          => 'theme_mod',
        'transport'     => 'postMessage'
    ) );
 
    // Custom CSS Control
    $wp_customize->add_control( 'expo_css', array(
        'label'         => __( 'CSS', 'expo' ),
        'section'       => 'theme_options',
        'settings'      => 'expo_options[css]',
        'type'          => 'textarea',
    ) );
}
add_action( 'customize_register', 'expo_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function expo_customize_preview_js() {
	wp_enqueue_script( 'expo_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20150123', true );
}
add_action( 'customize_preview_init', 'expo_customize_preview_js' );


/**
 * Validates theme customizer options
 */
function expo_extract_valid_options( $options ) {
    $new_options = array();
    foreach( $options as $option ) {
        if ( isset( $option['variants'] ) && '' != $option['variants'] ) {
            $variants = implode( ',', $option['variants'] );
            $opt =  $option['label'] . ':' . $variants;
        } else {
            $opt = $option['name'];
        }
        if ( isset ( $option['label'] ) ) {
            $new_options[ $opt ] = $option['label'];
        } else {
            $new_options[ $opt ] = $option['title'];
        }
    }
    return $new_options;
}
