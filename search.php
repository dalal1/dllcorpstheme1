<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package dllcorpstheme1pack
 * @subpackage dllcorpstheme1
 * @since dllcorpstheme1 1.0
 */
get_header(); ?>

	<?php do_action( 'dllcorpstheme1_before_body_content' ); ?>

	<div id="primary">
		<div id="content" class="clearfix">
			<?php if ( have_posts() ) : ?>

            <header class="page-header">
               <h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'dllcorpstheme1' ), get_search_query() ); ?></h1>
            </header><!-- .page-header -->

				<div class="article-container">

               <?php global $post_i; $post_i = 1; ?>

               <?php while ( have_posts() ) : the_post(); ?>

                  <?php get_template_part( 'content', 'archive' ); ?>

               <?php endwhile; ?>

            </div>

            <?php get_template_part( 'navigation', 'archive' ); ?>

         <?php else : ?>

            <?php get_template_part( 'no-results', 'archive' ); ?>

         <?php endif; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

	<?php dllcorpstheme1_sidebar_select(); ?>

	<?php do_action( 'dllcorpstheme1_after_body_content' ); ?>

<?php get_footer(); ?>