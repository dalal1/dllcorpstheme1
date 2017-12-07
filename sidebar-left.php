<?php
/**
 * The left sidebar widget area.
 *
 * @package dllcorpstheme1pack
 * @subpackage dllcorpstheme1
 * @since dllcorpstheme1 1.0
 */
?>

<div id="secondary">
	<?php do_action( 'dllcorpstheme1_before_sidebar' ); ?>
		<?php
			if( is_page_template( 'page-templates/contact.php' ) ) {
				$sidebar = 'dllcorpstheme1_contact_page_sidebar';
			}
			else {
				$sidebar = 'dllcorpstheme1_left_sidebar';
			}
		?>

		<?php if ( ! dynamic_sidebar( $sidebar ) ) :
         if ( $sidebar == 'dllcorpstheme1_contact_page_sidebar' ) {
            $sidebar_display = __('Contact Page', 'dllcorpstheme1');
         } else {
            $sidebar_display = __('Left', 'dllcorpstheme1');
         }
         the_widget( 'WP_Widget_Text',
            array(
               'title'  => __( 'Example Widget', 'dllcorpstheme1' ),
               'text'   => sprintf( __( 'This is an example widget to show how the %s Sidebar looks by default. You can add custom widgets from the %swidgets screen%s in the admin. If custom widgets are added then this will be replaced by those widgets.', 'dllcorpstheme1' ), $sidebar_display, current_user_can( 'edit_theme_options' ) ? '<a href="' . admin_url( 'widgets.php' ) . '">' : '', current_user_can( 'edit_theme_options' ) ? '</a>' : '' ),
               'filter' => true,
            ),
            array(
               'before_widget' => '<aside class="widget widget_text clearfix">',
               'after_widget'  => '</aside>',
               'before_title'  => '<h3 class="widget-title"><span>',
               'after_title'   => '</span></h3>'
            )
         );
      endif; ?>

	<?php do_action( 'dllcorpstheme1_after_sidebar' ); ?>
</div>