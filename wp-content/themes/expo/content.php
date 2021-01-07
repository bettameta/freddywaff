<?php
/**
 * @package Expo
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="entry-content zoom-effect">

        <a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
            <?php if ( has_post_thumbnail( $post->ID ) ) {
                    the_post_thumbnail( 'featured-image' );
            } else { ?>
                <img class="attachment-featured-image" src="<?php echo get_stylesheet_directory_uri(); ?>/images/placeholder.png" alt="" height="400" width="600">
            <?php } ?>
        </a>

        <?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

    </div><!-- .entry-content -->
</article><!-- #post-## -->