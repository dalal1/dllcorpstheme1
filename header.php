<?php
/**
 * Theme Header Section for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main" class="clearfix"> <div class="inner-wrap">
 *
 * @package dllcorpstheme1pack
 * @subpackage dllcorpstheme1
 * @since dllcorpstheme1 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<?php
		/**
		 * This hook is important for wordpress plugins and other many things
		 */
		wp_head();
		?>
	</head>

	<body <?php body_class(); ?>>
		<?php do_action( 'dllcorpstheme1_before' ); ?>
		<div id="page" class="hfeed site">
			<?php do_action( 'dllcorpstheme1_before_header' ); ?>

			<?php
			// Add the main total header area display type dynamic class
			$main_total_header_option_layout_class = get_theme_mod( 'dllcorpstheme1_main_total_header_area_display_type', 'type_one' );

			$class_name = '';
			if ( $main_total_header_option_layout_class == 'type_two' ) {
				$class_name = 'dllcorpstheme1-header-clean';
			} elseif ( $main_total_header_option_layout_class == 'type_three' ) {
				$class_name = 'dllcorpstheme1-header-classic';
			}
			?>

			<header id="masthead" class="site-header clearfix <?php echo esc_attr( $class_name ); ?>">
				<div id="header-text-nav-container" class="clearfix">

					<?php dllcorpstheme1_top_header_bar_display(); // Display the top header bar ?>

					<?php
					if ( get_theme_mod( 'dllcorpstheme1_header_image_position', 'position_two' ) == 'position_one' ) {
						dllcorpstheme1_render_header_image();
					}
					?>

					<?php dllcorpstheme1_middle_header_bar_display(); // Display the middle header bar ?>

					<?php
					if ( get_theme_mod( 'dllcorpstheme1_header_image_position', 'position_two' ) == 'position_two' ) {
						dllcorpstheme1_render_header_image();
					}
					?>

					<?php dllcorpstheme1_below_header_bar_display(); // Display the below header bar  ?>

				</div><!-- #header-text-nav-container -->

				<?php
				if ( get_theme_mod( 'dllcorpstheme1_header_image_position', 'position_two' ) == 'position_three' ) {
					dllcorpstheme1_render_header_image();
				}
				?>

			</header>
			<?php do_action( 'dllcorpstheme1_after_header' ); ?>
			<?php do_action( 'dllcorpstheme1_before_main' ); ?>
			<div id="main" class="clearfix">
				<div class="inner-wrap clearfix">