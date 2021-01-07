<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Expo
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Configuration arguments.
 * @return array
 */
function expo_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'expo_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function expo_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}
	// Adds a class of post-archive-open to home page if page greater then 1.
	if ( is_paged() || is_archive() || isset( $_GET['prevlink'] ) || is_search() || ( ( isset( $_GET['page'] )  && ! ( 'page' == get_option('show_on_front') ) ) ) ) {
		$classes[] = 'container-open';
	}

	global $post, $header_image;

	if ( is_singular() ) {
		if ( has_post_thumbnail( $post->ID ) ) {
			$classes[] = 'has-header-image';
		}
	} else if ( ! empty( $header_image ) ) {
		$classes[] = 'has-header-image';
	}

	return $classes;
}
add_filter( 'body_class', 'expo_body_classes' );

/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function expo_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}
add_action( 'wp', 'expo_setup_author' );

/**
 * Header image
 */
function expo_header_image() {
	$header_image = get_header_image();

	if ( ! empty( $header_image ) && ( is_home() || is_archive() || is_search() ) ) {
		echo 'style="background-image:url(' . $header_image . ');"';
	} else {
		expo_featured_image();
	}
}

function expo_featured_image( $post = NULL ) {
	$format = get_post_format( $post );
	$header_image = get_header_image();

	// check if featured image exists
	if ( has_post_thumbnail( $post ) ) {
		// get the featured image source
		$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post ), 'large' );
		$img_src = esc_url( $featured_image[0] );
		if ( $featured_image[2] > $featured_image[1] ) {
			$orientation = "vertical-image";
		} else {
			$orientation = "horizontal-image";
		}
		echo 'style="background-image:url(' . $img_src . ');"';
	} else {
		echo 'style="background-image:url(' . $header_image . ');"';
	}

}