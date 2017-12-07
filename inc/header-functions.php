<?php
/**
 * Contains all the fucntions and components related to header part.
 *
 * @package dllcorpstheme1pack
 * @subpackage dllcorpstheme1
 * @since dllcorpstheme1 1.0
 */
/* * ************************************************************************************* */

if ( ! function_exists( 'dllcorpstheme1_social_links' ) ) :

	/**
	 * This function is for social links display on header
	 *
	 * Get links through Theme Options
	 */
	function dllcorpstheme1_social_links() {

		$dllcorpstheme1_social_links = array(
			'dllcorpstheme1_social_facebook' => __( 'Facebook', 'dllcorpstheme1' ),
			'dllcorpstheme1_social_twitter' => __( 'Twitter', 'dllcorpstheme1' ),
			'dllcorpstheme1_social_googleplus' => __( 'Google-Plus', 'dllcorpstheme1' ),
			'dllcorpstheme1_social_instagram' => __( 'Instagram', 'dllcorpstheme1' ),
			'dllcorpstheme1_social_pinterest' => __( 'Pinterest', 'dllcorpstheme1' ),
			'dllcorpstheme1_social_youtube' => __( 'YouTube', 'dllcorpstheme1' )
		);
		?>
		<div class="social-links clearfix">
			<ul>
				<?php
				$i = 0;
				$dllcorpstheme1_links_output = '';
				foreach ( $dllcorpstheme1_social_links as $key => $value ) {
					$link = get_theme_mod( $key, '' );
					if ( ! empty( $link ) ) {
						if ( get_theme_mod( $key . '_checkbox', 0 ) == 1 ) {
							$new_tab = 'target="_blank"';
						} else {
							$new_tab = '';
						}
						$dllcorpstheme1_links_output .= '<li><a href="' . esc_url( $link ) . '" ' . $new_tab . '><i class="fa fa-' . strtolower( $value ) . '"></i></a></li>';
					}
					$i ++;
				}
				echo $dllcorpstheme1_links_output;
				?>
			</ul>
		</div><!-- .social-links -->
		<?php
	}

endif;

/* * ************************************************************************************* */

// Filter the get_header_image_tag() for option of adding the link back to home page option
function dllcorpstheme1_header_image_markup( $html, $header, $attr ) {
	$output = '';
	$header_image = get_header_image();

	if ( ! empty( $header_image ) ) {
		if ( get_theme_mod( 'dllcorpstheme1_header_image_link', 0 ) == 1 ) {
			$output .= '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" rel="home">';
		}

		$output .= '<div class="header-image-wrap"><img src="' . esc_url( $header_image ) . '" class="header-image" width="' . get_custom_header()->width . '" height="' . get_custom_header()->height . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '"></div>';

		if ( get_theme_mod( 'dllcorpstheme1_header_image_link', 0 ) == 1 ) {
			$output .= '</a>';
		}
	}

	return $output;
}

function dllcorpstheme1_header_image_markup_filter() {
	add_filter( 'get_header_image_tag', 'dllcorpstheme1_header_image_markup', 10, 3 );
}

add_action( 'dllcorpstheme1_header_image_markup_render', 'dllcorpstheme1_header_image_markup_filter' );

/* * ************************************************************************************* */

if ( ! function_exists( 'dllcorpstheme1_render_header_image' ) ) :

	/**
	 * Shows the small info text on top header part
	 */
	function dllcorpstheme1_render_header_image() {
		if ( function_exists( 'the_custom_header_markup' ) ) {
			do_action( 'dllcorpstheme1_header_image_markup_render' );
			the_custom_header_markup();
		} else {
			$header_image = get_header_image();
			if ( ! empty( $header_image ) ) {
				if ( get_theme_mod( 'dllcorpstheme1_header_image_link', 0 ) == 1 ) {
					?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
					<?php } ?>
					<div class="header-image-wrap"><img src="<?php echo esc_url( $header_image ); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></div>
					<?php if ( get_theme_mod( 'dllcorpstheme1_header_image_link', 0 ) == 1 ) { ?>
					</a>
					<?php
				}
			}
		}
	}

endif;

if ( ! function_exists( 'dllcorpstheme1_top_header_bar_display' ) ) :

	/**
	 * Function to display the top header bar
	 *
	 * @since dllcorpstheme1 1.2.2
	 */
	function dllcorpstheme1_top_header_bar_display() {
		if ( get_theme_mod( 'dllcorpstheme1_breaking_news', 0 ) == 1 || get_theme_mod( 'dllcorpstheme1_date_display', 0 ) == 1 || get_theme_mod( 'dllcorpstheme1_social_link_activate', 0 ) == 1 ) :
			?>
			<div class="news-bar">
				<div class="inner-wrap clearfix">
					<?php
					if ( get_theme_mod( 'dllcorpstheme1_date_display', 0 ) == 1 )
						dllcorpstheme1_date_display();
					?>

					<?php
					if ( get_theme_mod( 'dllcorpstheme1_breaking_news', 0 ) == 1 )
						dllcorpstheme1_breaking_news();
					?>

					<?php
					if ( get_theme_mod( 'dllcorpstheme1_social_link_activate', 0 ) == 1 ) {
						dllcorpstheme1_social_links();
					}
					?>
				</div>
			</div>
			<?php
		endif;
	}

endif;

if ( ! function_exists( 'dllcorpstheme1_middle_header_bar_display' ) ) :

	/**
	 * Function to display the middle header bar
	 *
	 * @since dllcorpstheme1 1.2.2
	 */
	function dllcorpstheme1_middle_header_bar_display() {
		?>

		<div class="inner-wrap">

			<div id="header-text-nav-wrap" class="clearfix">
				<div id="header-left-section">
					<?php
					if ( (get_theme_mod( 'dllcorpstheme1_header_logo_placement', 'header_text_only' ) == 'show_both' || get_theme_mod( 'dllcorpstheme1_header_logo_placement', 'header_text_only' ) == 'header_logo_only' ) ) {
						?>
						<div id="header-logo-image">
							<?php if ( get_theme_mod( 'dllcorpstheme1_logo', '' ) != '' ) { ?>
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo esc_url( get_theme_mod( 'dllcorpstheme1_logo' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></a>
							<?php } ?>

							<?php
							if ( function_exists( 'the_custom_logo' ) && has_custom_logo( $blog_id = 0 ) ) {
								dllcorpstheme1_the_custom_logo();
							}
							?>
						</div><!-- #header-logo-image -->
						<?php
					}
					$screen_reader = '';
					if ( get_theme_mod( 'dllcorpstheme1_header_logo_placement', 'header_text_only' ) == 'header_logo_only' || (get_theme_mod( 'dllcorpstheme1_header_logo_placement', 'header_text_only' ) == 'disable' ) ) {
						$screen_reader = 'screen-reader-text';
					}
					?>
					<div id="header-text" class="<?php echo $screen_reader; ?>">
						<?php if ( is_front_page() || is_home() ) : ?>
							<h1 id="site-title">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
							</h1>
						<?php else : ?>
							<h3 id="site-title">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
							</h3>
						<?php endif; ?>
						<?php
						$description = get_bloginfo( 'description', 'display' );
						if ( $description || is_customize_preview() ) :
							?>
							<p id="site-description"><?php echo $description; ?></p>
						<?php endif; ?><!-- #site-description -->
					</div><!-- #header-text -->
				</div><!-- #header-left-section -->
				<div id="header-right-section">
					<?php
					if ( is_active_sidebar( 'dllcorpstheme1_header_sidebar' ) ) {
						?>
						<div id="header-right-sidebar" class="clearfix">
							<?php
							// Calling the header sidebar if it exists.
							if ( ! dynamic_sidebar( 'dllcorpstheme1_header_sidebar' ) ):
							endif;
							?>
						</div>
						<?php
					}
					?>
				</div><!-- #header-right-section -->

			</div><!-- #header-text-nav-wrap -->

		</div><!-- .inner-wrap -->

		<?php
	}

endif;

if ( ! function_exists( 'dllcorpstheme1_below_header_bar_display' ) ) :

	/**
	 * Function to display the middle header bar
	 *
	 * @since dllcorpstheme1 1.2.2
	 */
	function dllcorpstheme1_below_header_bar_display() {
		?>

		<nav id="site-navigation" class="main-navigation clearfix" role="navigation">
			<div class="inner-wrap clearfix">
				<?php
				if ( get_theme_mod( 'dllcorpstheme1_home_icon_display', 0 ) == 1 ) {
					if ( is_front_page() ) {
						$home_icon_class = 'home-icon front_page_on';
					} else {
						$home_icon_class = 'home-icon';
					}
					?>

					<div class="<?php echo $home_icon_class; ?>">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"><i class="fa fa-home"></i></a>
					</div>

					<?php
				}
				?>

				<h4 class="menu-toggle"></h4>
				<?php
				if ( has_nav_menu( 'primary' ) ) {
					wp_nav_menu( array( 'theme_location' => 'primary', 'container_class' => 'menu-primary-container', 'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>' ) );
				} else {
					wp_page_menu();
				}
				?>

				<?php if ( get_theme_mod( 'dllcorpstheme1_random_post_in_menu', 0 ) == 1 ) { ?>
					<?php dllcorpstheme1_random_post(); ?>
				<?php } ?>

				<?php if ( get_theme_mod( 'dllcorpstheme1_search_icon_in_menu', 0 ) == 1 ) { ?>
					<i class="fa fa-search search-top"></i>
					<div class="search-form-top">
						<?php get_search_form(); ?>
					</div>
				<?php } ?>
			</div>
		</nav>

		<?php
	}

endif;
