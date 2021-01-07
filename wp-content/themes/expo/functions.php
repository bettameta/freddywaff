<?php
/**
 * Expo functions and definitions
 *
 * @package Expo
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
    $content_width = 1440; /* pixels */
}

/**
 * Theme Options
 */

$defaults = array (
        'font'      => 'Ovo',
        'font_alt'  => 'Lato:300',
        'css'       => '',
        'logo'      => ''
    );

$theme_options  = get_theme_mod( 'expo_options', $defaults );

if ( ! function_exists( 'expo_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function expo_setup() {

    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     * If you're building a theme based on Expo, use a find and replace
     * to change 'expo' to the name of your theme in all the template files
     */
    load_theme_textdomain( 'expo', get_template_directory() . '/languages' );

    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    /*
     * Enable support for Post Thumbnails on posts and pages.
     * WP.com scanner checks for featured-images usage.
     *
     * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
     *
     */
    add_theme_support( 'post-thumbnails' );
    add_image_size( 'featured-image', '', 800, false );
    add_image_size('expo_logo_size', '', 200, false );


    // This theme uses wp_nav_menu() in one location.
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'expo' ),
        'social' => __( 'Social Menu', 'expo' )
    ) );

    /*
     * Add support for Title Tag
     */
    add_theme_support( 'title-tag' );

    /*
     * Add support for Custom Logo
     */
    add_theme_support( 'site-logo', array(
        'header-text' => array(
            'sitetitle',
            'tagline',
        ),
        'size' => 'expo_logo_size',
    ) );

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support( 'html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
    ) );

    /*
     * Enable support for Gallery Post Format.
     * See http://codex.wordpress.org/Post_Formats
     */
    add_theme_support( 'post-formats', array(
        'gallery'
    ) );

}
endif; // expo_setup
add_action( 'after_setup_theme', 'expo_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function expo_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Expo Sidebar', 'expo' ),
        'id'            => 'expo-sidebar-1',
        'description'   => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'expo_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function expo_scripts() {
    // Add Genericons font, used in the main stylesheet.
    wp_enqueue_style( 'expo-genericons', get_template_directory_uri() . '/images/genericons/genericons.css', array(), '3.0.3' );

    // Load our main stylesheet.
    wp_enqueue_style( 'expo-style', get_stylesheet_uri() );
    wp_enqueue_script( 'expo-fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array( 'jquery' ), '1.1', true );
    wp_enqueue_script( 'expo-mousewheel', get_template_directory_uri() . '/js/jquery.mousewheel.js', array( 'jquery' ), '3.1.12', true );
    wp_enqueue_script( 'expo-letteringjs', get_template_directory_uri() . '/js/jquery.lettering.js', array( 'jquery' ), '0.7.0', true );
    wp_enqueue_script( 'expo-main', get_template_directory_uri() . '/js/main.js', array( 'jquery' ), '20120206', true );
    wp_enqueue_script( 'jquery-effects-core' );

    wp_enqueue_script( 'expo-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'expo_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Load fonts.
 */
require get_template_directory() . '/inc/fonts.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


/**
 * Inline CSS
 */
function expo_inline_style() {
 
    global $theme_options;
    $css = null;
 
    // Custom CSS
    if ( ! empty( $theme_options['css'] ) ) {
        $css .= wp_filter_nohtml_kses( $theme_options['css'] );
    }
 
    // Font
    if ( ! empty( $theme_options['font'] ) ) {
        $font = explode( ':', $theme_options['font'] );
        $font_name = str_replace('+', ' ', $font[0] );
        $font_name = "'" . $font_name . "'";
 
        $css .= 'h1, h2, h3, h4, h5, h6, h1.page-title, h1.entry-title, .site-description, .navs a, #infinite-handle span { font-family: ' . $font_name .'; }' . "\n";
    }
 
    // Font Alt
    if ( ! empty( $theme_options['font_alt'] ) ) {
        $font_alt = explode( ':', $theme_options['font_alt'] );
        $font_alt_name = str_replace( '+', ' ', $font_alt[0] );
        $font_alt_name = "'" . $font_alt_name . "'";
 
        $css .= 'body, p, textarea, input, select, label, .menu li a, .site-title, .show-posts { font-family: ' . $font_alt_name .'; }' . "\n";
    }
 
    wp_add_inline_style( 'expo-style', $css );
}
add_action( 'wp_enqueue_scripts', 'expo_inline_style' );
 
/**
 * Enqueue Fonts
 */
function expo_enqueue_fonts() {
 
    global $theme_options;
 
    if ( ! empty( $theme_options['font'] ) || ! empty( $theme_options['font_alt'] ) ) {
        $protocol = is_ssl() ? 'https' : 'http';
 
        // Font Family
        $header = explode( ':', $theme_options['font'] );
        $header_name = str_replace(' ', '+', $header[0] );
 
        // Font Attributes
        $header_params = ( ! empty( $header[1] ) ) ? ':' . $header[1] : null;
 
        // Body Font Family
        $body = explode( ':', $theme_options['font_alt'] );
        $body_name = str_replace(' ', '+', $body[0] );
 
        // Body Font Attributes
        $body_params = ( ! empty( $body[1] ) ) ? ':' . $body[1] : null;
 
        // Font Separator
        $sep = ( ! empty( $theme_options['font'] ) && ! empty( $theme_options['font_alt'] ) ) ? '|' : '';
 
        // Final Fonts
        $fonts = ( $theme_options['font'] == $theme_options['font_alt'] ) ? rawurldecode( $header_name . $header_params ) : rawurldecode( $header_name . $header_params . $sep . $body_name . $body_params );
 
        wp_enqueue_style( 'expo-custom-fonts', "$protocol://fonts.googleapis.com/css?family={$fonts}", array(), null );
    }
}
 
add_action( 'wp_enqueue_scripts', 'expo_enqueue_fonts' );
