<?php
/**
 * Template Name: Contact Page Template
 *
 * Displays the Contact Page Template of the theme.
 *
 * @package dllcorpstheme1pack
 * @subpackage dllcorpstheme1
 * @since dllcorpstheme1 1.0
 */
?>

<?php get_header(); ?>

	<?php do_action( 'dllcorpstheme1_before_body_content' ); ?>

	<div id="primary">
		<div id="content" class="clearfix">
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

			<?php endwhile; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

	<?php dllcorpstheme1_sidebar_select(); ?>

	<?php do_action( 'dllcorpstheme1_after_body_content' ); ?>

<?php get_footer(); ?>