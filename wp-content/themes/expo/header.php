<?php
/**
 * The header for our theme.
 * original design by http://www.ballisticdigitalstudios.com
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Expo
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

    <?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

    <div id="page" class="hfeed site">

        <header id="masthead">

            <span id="menu-trigger" title="<?php esc_attr_e( 'Menu', 'expo' ); ?>" class="genericon genericon-menu menu-trigger"></span>
            <?php if ( is_home() ) : ?><span class="genericon genericon-close-alt"></span><?php endif; ?>

            <div class="site-branding">

                <div class="site-title-container">

                    <h1 class="site-title">
                        <a href="<?php echo home_url( '/?page=1' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
                            <?php global $theme_options; if ( ! empty( $theme_options['logo'] ) ) : ?>
                                <img class="sitetitle" src="<?php echo esc_url( $theme_options['logo'] ); ?>" alt="<?php bloginfo( 'name' ); ?>" />
                            <?php else : ?>
                                <?php bloginfo( 'name' ); ?>
                            <?php endif; ?>
                        </a>
                    </h1>

                </div>
            </div>

            <?php if ( is_home() ) : ?>
            <div class="site-description-container">
                <h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
                <div id="post-trigger" title="<?php esc_attr_e( 'Enter', 'expo' ); ?>" class="post-trigger diamond"><span class="show-posts"><?php _e( 'Enter', 'expo' ); ?></span></div>
            </div>
            <?php endif; ?>

            <div class="intro" <?php expo_header_image(); ?>>
                <?php if ( is_single() || is_page() ) : ?>
                    <a class="genericon genericon-expand" href="#content-main"></a>
                <?php endif; ?>
            </div>
        </header>

        <div id="content-main" class="site-content<?php if ( is_home() || is_archive() || is_search() ) { ?> items-wrap<?php } ?>">