<?php
/**
 * dllcorpstheme1 Admin Class.
 *
 * @author  dllcorpstheme1pack
 * @package dllcorpstheme1
 * @since   1.1.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'dllcorpstheme1_Admin' ) ) :

/**
 * dllcorpstheme1_Admin Class.
 */
class dllcorpstheme1_Admin {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'wp_loaded', array( __CLASS__, 'hide_notices' ) );
		add_action( 'load-themes.php', array( $this, 'admin_notice' ) );
	}

	/**
	 * Add admin menu.
	 */
	public function admin_menu() {
		$theme = wp_get_theme( get_template() );

		$page = add_theme_page( esc_html__( 'About', 'dllcorpstheme1' ) . ' ' . $theme->display( 'Name' ), esc_html__( 'About', 'dllcorpstheme1' ) . ' ' . $theme->display( 'Name' ), 'activate_plugins', 'dllcorpstheme1-welcome', array( $this, 'welcome_screen' ) );
		add_action( 'admin_print_styles-' . $page, array( $this, 'enqueue_styles' ) );
	}

	/**
	 * Enqueue styles.
	 */
	public function enqueue_styles() {
		global $dllcorpstheme1_version;

		wp_enqueue_style( 'dllcorpstheme1-welcome', get_template_directory_uri() . '/css/admin/welcome.css', array(), $dllcorpstheme1_version );
	}

	/**
	 * Add admin notice.
	 */
	public function admin_notice() {
		global $dllcorpstheme1_version, $pagenow;

		wp_enqueue_style( 'dllcorpstheme1-message', get_template_directory_uri() . '/css/admin/message.css', array(), $dllcorpstheme1_version );

		// Let's bail on theme activation.
		if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {
			add_action( 'admin_notices', array( $this, 'welcome_notice' ) );
			update_option( 'dllcorpstheme1_admin_notice_welcome', 1 );

		// No option? Let run the notice wizard again..
		} elseif( ! get_option( 'dllcorpstheme1_admin_notice_welcome' ) ) {
			add_action( 'admin_notices', array( $this, 'welcome_notice' ) );
		}
	}

	/**
	 * Hide a notice if the GET variable is set.
	 */
	public static function hide_notices() {
		if ( isset( $_GET['dllcorpstheme1-hide-notice'] ) && isset( $_GET['_dllcorpstheme1_notice_nonce'] ) ) {
			if ( ! wp_verify_nonce( $_GET['_dllcorpstheme1_notice_nonce'], 'dllcorpstheme1_hide_notices_nonce' ) ) {
				wp_die( __( 'Action failed. Please refresh the page and retry.', 'dllcorpstheme1' ) );
			}

			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( __( 'Cheatin&#8217; huh?', 'dllcorpstheme1' ) );
			}

			$hide_notice = sanitize_text_field( $_GET['dllcorpstheme1-hide-notice'] );
			update_option( 'dllcorpstheme1_admin_notice_' . $hide_notice, 1 );
		}
	}

	/**
	 * Show welcome notice.
	 */
	public function welcome_notice() {
		?>
		<div id="message" class="updated dllcorpstheme1-message">
			<a class="dllcorpstheme1-message-close notice-dismiss" href="<?php echo esc_url( wp_nonce_url( remove_query_arg( array( 'activated' ), add_query_arg( 'dllcorpstheme1-hide-notice', 'welcome' ) ), 'dllcorpstheme1_hide_notices_nonce', '_dllcorpstheme1_notice_nonce' ) ); ?>"><?php esc_html_e( 'Dismiss', 'dllcorpstheme1' ); ?></a>
			<p><?php printf( esc_html__( 'Welcome! Thank you for choosing dllcorpstheme1! To fully take advantage of the best our theme can offer please make sure you visit our %swelcome page%s.', 'dllcorpstheme1' ), '<a href="' . esc_url( admin_url( 'themes.php?page=dllcorpstheme1-welcome' ) ) . '">', '</a>' ); ?></p>
			<p class="submit">
				<a class="button-secondary" href="<?php echo esc_url( admin_url( 'themes.php?page=dllcorpstheme1-welcome' ) ); ?>"><?php esc_html_e( 'Get started with dllcorpstheme1', 'dllcorpstheme1' ); ?></a>
			</p>
		</div>
		<?php
	}

	/**
	 * Intro text/links shown to all about pages.
	 *
	 * @access private
	 */
	private function intro() {
		global $dllcorpstheme1_version;
		$theme = wp_get_theme( get_template() );

		// Drop minor version if 0
		$major_version = substr( $dllcorpstheme1_version, 0, 3 );
		?>
		<div class="dllcorpstheme1-theme-info">
				<h1>
					<?php esc_html_e('About', 'dllcorpstheme1'); ?>
					<?php echo $theme->display( 'Name' ); ?>
					<?php printf( '%s', $major_version ); ?>
				</h1>

			<div class="welcome-description-wrap">
				<div class="about-text"><?php echo $theme->display( 'Description' ); ?></div>

				<div class="dllcorpstheme1-screenshot">
					<img src="<?php echo esc_url( get_template_directory_uri() ) . '/screenshot.png'; ?>" />
				</div>
			</div>
		</div>

		<p class="dllcorpstheme1-actions">
			<a href="<?php echo esc_url( 'https://dllcorpstheme1pack.com/themes/dllcorpstheme1/' ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'Theme Info', 'dllcorpstheme1' ); ?></a>

			<a href="<?php echo esc_url( apply_filters( 'dllcorpstheme1_pro_theme_url', 'https://demo.dllcorpstheme1pack.com/dllcorpstheme1/' ) ); ?>" class="button button-secondary docs" target="_blank"><?php esc_html_e( 'View Demo', 'dllcorpstheme1' ); ?></a>

			<a href="<?php echo esc_url( apply_filters( 'dllcorpstheme1_pro_theme_url', 'https://dllcorpstheme1pack.com/themes/dllcorpstheme1-pro/' ) ); ?>" class="button button-primary docs" target="_blank"><?php esc_html_e( 'View PRO version', 'dllcorpstheme1' ); ?></a>

			<a href="<?php echo esc_url( apply_filters( 'dllcorpstheme1_pro_theme_url', 'https://wordpress.org/support/theme/dllcorpstheme1/reviews/?filter=5' ) ); ?>" class="button button-secondary docs" target="_blank"><?php esc_html_e( 'Rate this theme', 'dllcorpstheme1' ); ?></a>
		</p>

		<h2 class="nav-tab-wrapper">
			<a class="nav-tab <?php if ( empty( $_GET['tab'] ) && $_GET['page'] == 'dllcorpstheme1-welcome' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'dllcorpstheme1-welcome' ), 'themes.php' ) ) ); ?>">
				<?php echo $theme->display( 'Name' ); ?>
			</a>
			<a class="nav-tab <?php if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'supported_plugins' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'dllcorpstheme1-welcome', 'tab' => 'supported_plugins' ), 'themes.php' ) ) ); ?>">
				<?php esc_html_e( 'Supported Plugins', 'dllcorpstheme1' ); ?>
			</a>
			<a class="nav-tab <?php if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'free_vs_pro' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'dllcorpstheme1-welcome', 'tab' => 'free_vs_pro' ), 'themes.php' ) ) ); ?>">
				<?php esc_html_e( 'Free Vs Pro', 'dllcorpstheme1' ); ?>
			</a>
			<a class="nav-tab <?php if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'changelog' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'dllcorpstheme1-welcome', 'tab' => 'changelog' ), 'themes.php' ) ) ); ?>">
				<?php esc_html_e( 'Changelog', 'dllcorpstheme1' ); ?>
			</a>
		</h2>
		<?php
	}

	/**
	 * Welcome screen page.
	 */
	public function welcome_screen() {
		$current_tab = empty( $_GET['tab'] ) ? 'about' : sanitize_title( $_GET['tab'] );

		// Look for a {$current_tab}_screen method.
		if ( is_callable( array( $this, $current_tab . '_screen' ) ) ) {
			return $this->{ $current_tab . '_screen' }();
		}

		// Fallback to about screen.
		return $this->about_screen();
	}

	/**
	 * Output the about screen.
	 */
	public function about_screen() {
		$theme = wp_get_theme( get_template() );
		?>
		<div class="wrap about-wrap">

			<?php $this->intro(); ?>

			<div class="changelog point-releases">
				<div class="under-the-hood two-col">
               <div class="col">
                  <h3><?php esc_html_e( 'Import Demo', 'dllcorpstheme1' ); ?></h3>
                  <p><?php esc_html_e( 'Needs dllcorpstheme1pack Demo Importer plugin.', 'dllcorpstheme1' ) ?></p>
                  <p><a href="<?php echo esc_url( network_admin_url( 'plugin-install.php?tab=search&type=term&s=dllcorpstheme1pack-demo-importer' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Install', 'dllcorpstheme1' ); ?></a></p>
               </div>

					<div class="col">
						<h3><?php esc_html_e( 'Theme Customizer', 'dllcorpstheme1' ); ?></h3>
						<p><?php esc_html_e( 'All Theme Options are available via Customize screen.', 'dllcorpstheme1' ) ?></p>
						<p><a href="<?php echo admin_url( 'customize.php' ); ?>" class="button button-secondary"><?php esc_html_e( 'Customize', 'dllcorpstheme1' ); ?></a></p>
					</div>

					<div class="col">
						<h3><?php esc_html_e( 'Documentation', 'dllcorpstheme1' ); ?></h3>
						<p><?php esc_html_e( 'Please view our documentation page to setup the theme.', 'dllcorpstheme1' ) ?></p>
						<p><a href="<?php echo esc_url( 'https://dllcorpstheme1pack.com/theme-instruction/dllcorpstheme1/' ); ?>" class="button button-secondary"><?php esc_html_e( 'Documentation', 'dllcorpstheme1' ); ?></a></p>
					</div>

					<div class="col">
						<h3><?php esc_html_e( 'Got theme support question?', 'dllcorpstheme1' ); ?></h3>
						<p><?php esc_html_e( 'Please put it in our dedicated support forum.', 'dllcorpstheme1' ) ?></p>
						<p><a href="<?php echo esc_url( 'https://dllcorpstheme1pack.com/support-forum/' ); ?>" class="button button-secondary"><?php esc_html_e( 'Support', 'dllcorpstheme1' ); ?></a></p>
					</div>

					<div class="col">
						<h3><?php esc_html_e( 'Need more features?', 'dllcorpstheme1' ); ?></h3>
						<p><?php esc_html_e( 'Upgrade to PRO version for more exciting features.', 'dllcorpstheme1' ) ?></p>
						<p><a href="<?php echo esc_url( 'https://dllcorpstheme1pack.com/themes/dllcorpstheme1-pro/' ); ?>" class="button button-secondary"><?php esc_html_e( 'View PRO version', 'dllcorpstheme1' ); ?></a></p>
					</div>

					<div class="col">
						<h3><?php esc_html_e( 'Got sales related question?', 'dllcorpstheme1' ); ?></h3>
						<p><?php esc_html_e( 'Please send it via our sales contact page.', 'dllcorpstheme1' ) ?></p>
						<p><a href="<?php echo esc_url( 'https://dllcorpstheme1pack.com/contact/' ); ?>" class="button button-secondary"><?php esc_html_e( 'Contact Page', 'dllcorpstheme1' ); ?></a></p>
					</div>

					<div class="col">
						<h3>
							<?php
							esc_html_e( 'Translate', 'dllcorpstheme1' );
							echo ' ' . $theme->display( 'Name' );
							?>
						</h3>
						<p><?php esc_html_e( 'Click below to translate this theme into your own language.', 'dllcorpstheme1' ) ?></p>
						<p>
							<a href="<?php echo esc_url( 'https://translate.wordpress.org/projects/wp-themes/dllcorpstheme1' ); ?>" class="button button-secondary">
								<?php
								esc_html_e( 'Translate', 'dllcorpstheme1' );
								echo ' ' . $theme->display( 'Name' );
								?>
							</a>
						</p>
					</div>
				</div>
			</div>

			<div class="return-to-dashboard dllcorpstheme1">
				<?php if ( current_user_can( 'update_core' ) && isset( $_GET['updated'] ) ) : ?>
					<a href="<?php echo esc_url( self_admin_url( 'update-core.php' ) ); ?>">
						<?php is_multisite() ? esc_html_e( 'Return to Updates', 'dllcorpstheme1' ) : esc_html_e( 'Return to Dashboard &rarr; Updates', 'dllcorpstheme1' ); ?>
					</a> |
				<?php endif; ?>
				<a href="<?php echo esc_url( self_admin_url() ); ?>"><?php is_blog_admin() ? esc_html_e( 'Go to Dashboard &rarr; Home', 'dllcorpstheme1' ) : esc_html_e( 'Go to Dashboard', 'dllcorpstheme1' ); ?></a>
			</div>
		</div>
		<?php
	}

		/**
	 * Output the changelog screen.
	 */
	public function changelog_screen() {
		global $wp_filesystem;

		?>
		<div class="wrap about-wrap">

			<?php $this->intro(); ?>

			<p class="about-description"><?php esc_html_e( 'View changelog below:', 'dllcorpstheme1' ); ?></p>

			<?php
				$changelog_file = apply_filters( 'dllcorpstheme1_changelog_file', get_template_directory() . '/readme.txt' );

				// Check if the changelog file exists and is readable.
				if ( $changelog_file && is_readable( $changelog_file ) ) {
					WP_Filesystem();
					$changelog = $wp_filesystem->get_contents( $changelog_file );
					$changelog_list = $this->parse_changelog( $changelog );

					echo wp_kses_post( $changelog_list );
				}
			?>
		</div>
		<?php
	}

	/**
	 * Parse changelog from readme file.
	 * @param  string $content
	 * @return string
	 */
	private function parse_changelog( $content ) {
		$matches   = null;
		$regexp    = '~==\s*Changelog\s*==(.*)($)~Uis';
		$changelog = '';

		if ( preg_match( $regexp, $content, $matches ) ) {
			$changes = explode( '\r\n', trim( $matches[1] ) );

			$changelog .= '<pre class="changelog">';

			foreach ( $changes as $index => $line ) {
				$changelog .= wp_kses_post( preg_replace( '~(=\s*Version\s*(\d+(?:\.\d+)+)\s*=|$)~Uis', '<span class="title">${1}</span>', $line ) );
			}

			$changelog .= '</pre>';
		}

		return wp_kses_post( $changelog );
	}


	/**
	 * Output the supported plugins screen.
	 */
	public function supported_plugins_screen() {
		?>
		<div class="wrap about-wrap">

			<?php $this->intro(); ?>

			<p class="about-description"><?php esc_html_e( 'This theme recommends following plugins:', 'dllcorpstheme1' ); ?></p>
			<ol>
				<li><a href="<?php echo esc_url('https://wordpress.org/plugins/social-icons/'); ?>" target="_blank"><?php esc_html_e('Social Icons', 'dllcorpstheme1'); ?></a>
					<?php esc_html_e(' by dllcorpstheme1pack', 'dllcorpstheme1'); ?>
				</li>
				<li><a href="<?php echo esc_url('https://wordpress.org/plugins/easy-social-sharing/'); ?>" target="_blank"><?php esc_html_e('Easy Social Sharing', 'dllcorpstheme1' ); ?></a>
					<?php esc_html_e(' by dllcorpstheme1pack', 'dllcorpstheme1'); ?>
				</li>
				<li><a href="<?php echo esc_url('https://wordpress.org/plugins/contact-form-7/'); ?>" target="_blank"><?php esc_html_e('Contact Form 7', 'dllcorpstheme1'); ?></a></li>
				<li><a href="<?php echo esc_url('https://wordpress.org/plugins/wp-pagenavi/'); ?>" target="_blank"><?php esc_html_e('WP-PageNavi', 'dllcorpstheme1'); ?></a></li>
				<li><a href="<?php echo esc_url('https://wordpress.org/plugins/woocommerce/'); ?>" target="_blank"><?php esc_html_e('WooCommerce', 'dllcorpstheme1'); ?></a></li>
				<li>
					<a href="<?php echo esc_url('https://wordpress.org/plugins/polylang/'); ?>" target="_blank"><?php esc_html_e('Polylang', 'dllcorpstheme1'); ?></a>
					<?php esc_html_e('Fully Compatible in Pro Version', 'dllcorpstheme1'); ?>
				</li>
				<li>
					<a href="<?php echo esc_url('https://wpml.org/'); ?>" target="_blank"><?php esc_html_e('WPML', 'dllcorpstheme1'); ?></a>
					<?php esc_html_e('Fully Compatible in Pro Version', 'dllcorpstheme1'); ?>
				</li>
			</ol>

		</div>
		<?php
	}

	/**
	 * Output the free vs pro screen.
	 */
	public function free_vs_pro_screen() {
		?>
		<div class="wrap about-wrap">

			<?php $this->intro(); ?>

			<p class="about-description"><?php esc_html_e( 'Upgrade to PRO version for more exciting features.', 'dllcorpstheme1' ); ?></p>

			<table>
				<thead>
					<tr>
						<th class="table-feature-title"><h3><?php esc_html_e('Features', 'dllcorpstheme1'); ?></h3></th>
						<th><h3><?php esc_html_e('dllcorpstheme1', 'dllcorpstheme1'); ?></h3></th>
						<th><h3><?php esc_html_e('dllcorpstheme1 Pro', 'dllcorpstheme1'); ?></h3></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><h3><?php esc_html_e('Support', 'dllcorpstheme1'); ?></h3></td>
						<td><?php esc_html_e('Forum', 'dllcorpstheme1'); ?></td>
						<td><?php esc_html_e('Forum + Emails/Support Ticket', 'dllcorpstheme1'); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Color Options', 'dllcorpstheme1'); ?></h3></td>
						<td><?php esc_html_e('1', 'dllcorpstheme1'); ?></td>
						<td><?php esc_html_e('22', 'dllcorpstheme1'); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Primary color option', 'dllcorpstheme1'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Font Size Options', 'dllcorpstheme1'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Google Fonts Options', 'dllcorpstheme1'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><?php esc_html_e('600+', 'dllcorpstheme1'); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Custom Widgets', 'dllcorpstheme1'); ?></h3></td>
						<td><?php esc_html_e('7', 'dllcorpstheme1'); ?></td>
						<td><?php esc_html_e('16', 'dllcorpstheme1'); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Social Icons', 'dllcorpstheme1'); ?></h3></td>
						<td><?php esc_html_e('6', 'dllcorpstheme1'); ?></td>
						<td><?php esc_html_e('18 + 6 Custom', 'dllcorpstheme1'); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Social Sharing', 'dllcorpstheme1'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Custom Menu', 'dllcorpstheme1'); ?></h3></td>
						<td><?php esc_html_e('1', 'dllcorpstheme1'); ?></td>
						<td><?php esc_html_e('2', 'dllcorpstheme1'); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Footer Sidebar', 'dllcorpstheme1'); ?></h3></td>
						<td><?php esc_html_e('4', 'dllcorpstheme1'); ?></td>
						<td><?php esc_html_e('7', 'dllcorpstheme1'); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Site Layout Option', 'dllcorpstheme1'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Options in Breaking News', 'dllcorpstheme1'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Unique Post System', 'dllcorpstheme1'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Change Read More Text', 'dllcorpstheme1'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Related Posts', 'dllcorpstheme1'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Author Biography', 'dllcorpstheme1'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Author Biography with Social Icons', 'dllcorpstheme1'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Footer Copyright Editor', 'dllcorpstheme1'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('TG: 125x125 Advertisement', 'dllcorpstheme1'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('TG: 300x250 Advertisement', 'dllcorpstheme1'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('TG: 728x90 Advertisement', 'dllcorpstheme1'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('TG: Featured Category Slider', 'dllcorpstheme1'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('TG: Highlighted Posts', 'dllcorpstheme1'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('TG: Random Posts Widget', 'dllcorpstheme1'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('TG: Tabbed Widget', 'dllcorpstheme1'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('TG: Videos', 'dllcorpstheme1'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('TG: Featured Posts (Style 1)', 'dllcorpstheme1'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('TG: Featured Posts (Style 2)', 'dllcorpstheme1'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('TG: Featured Posts (Style 3)', 'dllcorpstheme1'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('TG: Featured Posts (Style 4)', 'dllcorpstheme1'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('TG: Featured Posts (Style 5)', 'dllcorpstheme1'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('TG: Featured Posts (Style 6)', 'dllcorpstheme1'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('TG: Featured Posts (Style 7)', 'dllcorpstheme1'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Category Color Options', 'dllcorpstheme1'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('WPML Compatible', 'dllcorpstheme1'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Polylang Compatible', 'dllcorpstheme1'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('WooCommerce Compatible', 'dllcorpstheme1'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td class="btn-wrapper">
							<a href="<?php echo esc_url( apply_filters( 'dllcorpstheme1_pro_theme_url', 'https://dllcorpstheme1pack.com/themes/dllcorpstheme1-pro/' ) ); ?>" class="button button-secondary docs" target="_blank"><?php esc_html_e( 'View Pro', 'dllcorpstheme1' ); ?></a>
						</td>
					</tr>
				</tbody>
			</table>

		</div>
		<?php
	}
}

endif;

return new dllcorpstheme1_Admin();
