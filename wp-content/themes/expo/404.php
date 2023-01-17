<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package Expo
 */

get_header(); ?>

	<div id="primary" class="content-area">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php _e( 'Error 404! That page can&rsquo;t be found.', 'expo' ); ?></h1>

				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php _e( 'Try searching the site.', 'expo' ); ?></p>
					<?php get_search_form(); ?>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

	</div><!-- #primary -->

<?php get_footer(); ?>
