<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Expo
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function expo_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'primary',
		'footer'    => 'page',
		'type'           => 'scroll',
		'wrapper'        => false,
	) );
}
add_action( 'after_setup_theme', 'expo_jetpack_setup' );

/**
* Add theme support for Responsive Videos.
*/
function expo_responsive_videos_setup() {
    add_theme_support( 'jetpack-responsive-videos' );
}
add_action( 'after_setup_theme', 'expo_responsive_videos_setup' );
