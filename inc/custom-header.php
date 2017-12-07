<?php
/**
 * Implements a custom header for dllcorpstheme1.
 * See http://codex.wordpress.org/Custom_Headers
 *
 * @package dllcorpstheme1pack
 * @subpackage dllcorpstheme1
 * @since dllcorpstheme1 1.0
 */

/**
 * Setup the WordPress core custom header feature.
 */
function dllcorpstheme1_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'dllcorpstheme1_custom_header_args', array(
		'default-image'				=> '',
		'header-text'				=> '',
		'default-text-color'		=> '',
		'width'						=> 1400,
		'height'					=> 400,
		'flex-width'				=> true,
		'flex-height'				=> true,
		'wp-head-callback'			=> '',
		'admin-head-callback'		=> '',
		'video'						=> true,
		'admin-preview-callback'	=> 'dllcorpstheme1_admin_header_image',
	) ) );
}
add_action( 'after_setup_theme', 'dllcorpstheme1_custom_header_setup' );

if ( ! function_exists( 'dllcorpstheme1_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 */
function dllcorpstheme1_admin_header_image() {
?>
	<div id="headimg">
		<?php if ( function_exists( 'the_custom_header_markup' ) ) {
			the_custom_header_markup();
		} else {
			if ( get_header_image() ) : ?>
				<img src="<?php header_image(); ?>" alt="<?php bloginfo( 'name' ); ?>">
			<?php endif;
		} ?>
	</div>
<?php
}
endif; // dllcorpstheme1_admin_header_image