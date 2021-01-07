<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Expo
 */
?>

    </div><!-- #content-main -->
</div><!-- #page -->

<div class="menu-sidebar">

    <nav id="site-navigation" class="main-navigation" role="navigation">
        <?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
    </nav><!-- #site-navigation -->

    <div id="secondary" class="widget-area" role="complementary">
        <?php dynamic_sidebar( 'expo-sidebar-1' ); ?>
    </div><!-- #secondary -->

    <div class="social-menu">
        <?php if ( has_nav_menu( 'social' ) ) {
            wp_nav_menu( array( 'theme_location' => 'social', 'container' => 'false', 'menu_class' => 'menu-social' ));
        } ?>
    </div><!-- .social-menu -->

    <div class="site-info">
        <span><?php printf( __( '&#169 Freddy Waff | 2021', 'expo' ) ); ?></span>
    </div><!-- .site-info -->

</div><!-- .menu-sidebar -->

<?php wp_footer(); ?>

</body>
</html>
