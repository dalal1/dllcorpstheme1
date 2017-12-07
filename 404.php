<?php
/**
 * The template for displaying 404 pages (Page Not Found).
 *
 * @package dllcorpstheme1pack
 * @subpackage dllcorpstheme1
 * @since dllcorpstheme1 1.0
 */

get_header(); ?>

	<?php do_action( 'dllcorpstheme1_before_body_content' ); ?>

	<div id="primary">
		<div id="content" class="clearfix">
			<section class="error-404 not-found">
				<div class="page-content">

					<?php if ( ! dynamic_sidebar( 'dllcorpstheme1_error_404_page_sidebar' ) ) : ?>
						<header class="page-header">
							<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'dllcorpstheme1' ); ?></h1>
						</header>
						<p><?php _e( 'It looks like nothing was found at this location. Try the search below.', 'dllcorpstheme1' ); ?></p>
						<?php get_search_form(); ?>
					<?php endif; ?>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->
		</div><!-- #content -->
	</div><!-- #primary -->

	<?php dllcorpstheme1_sidebar_select(); ?>

	<?php do_action( 'dllcorpstheme1_after_body_content' ); ?>

<?php get_footer(); ?>
