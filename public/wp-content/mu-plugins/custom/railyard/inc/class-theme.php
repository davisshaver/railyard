<?php
/**
 * Main "theme" for Railyard-based sites.
 *
 * @package Terminal
 */

namespace Railyard;

/**
 * Theme class.
 */
class Theme {
	use Singleton;

	/**
	 * Setup.
	 */
	public function setup() {
		add_action( 'admin_bar_menu', [ $this, 'remove_wp_logo' ], 999 );
		add_action( 'admin_head', [ $this, 'railyard_favicon' ] );
		add_action( 'admin_init', [ $this, 'remove_wp_news_widget' ] );
		add_action( 'login_enqueue_scripts', [ $this, 'railyard_login_logo' ] );
		add_action( 'login_head', [ $this, 'railyard_favicon' ] );
		add_filter( 'admin_bar_menu', [ $this, 'replace_howdy' ], 25 );
		add_filter( 'admin_footer_text', [ $this, 'railyard_footer_text' ] );
		add_filter( 'login_headertitle', [ $this, 'railyard_logo_url_title' ] );
		add_filter( 'login_headerurl', [ $this, 'railyard_logo_url' ] );
		add_filter( 'max_srcset_image_width', '__return_true' );
		remove_action( 'welcome_panel', [ $this, 'wp_welcome_panel' ] );
		add_action( 'init', [ $this, 'remove_gutenberg_menu' ] );
		add_action( 'wp_head', function() {
			echo '<style> #wp-admin-bar-classic-edit > a.ab-item::before { content: "\f464"; } </style>';
		});
	}

	/**
	 * Remove Gutenberg from admin menu.
	 */
	public function remove_gutenberg_menu() {
		remove_action( 'admin_menu', 'gutenberg_menu' );
	}

	/**
	 * Print CSS for logo.
	 */
	public function railyard_login_logo() {
		?>
		<style type="text/css">
			body.login div#login h1 a {
				background-image: url(/wp-content/mu-plugins/custom/railyard/static/railyard-logo.png);
			}
		</style>
	<?php
	}

	/**
	 * URL for login.
	 *
	 * @return string URL
	 */
	public function railyard_logo_url() {
		return home_url();
	}

	/**
	 * URL Title.
	 *
	 * @return string URL Title for login.
	 */
	public function railyard_logo_url_title() {
		return 'Another Philly Publishing Site';
	}

	/**
	 * Print favicon on admin.
	 */
	public function railyard_favicon() {
		echo '<link rel="shortcut icon" href="/wp-content/mu-plugins/custom/railyard/static/favicon.ico" />';
	}

	/**
	 * Remove WP News widget.
	 */
	public function remove_wp_news_widget() {
		remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
	}

	/**
	 * Remove WP logo from admin bar.
	 *
	 * @param object $wp_admin_bar Admin bar object.
	 */
	public function remove_wp_logo( $wp_admin_bar ) {
		$wp_admin_bar->remove_node( 'wp-logo' );
		// if ( is_singular() && current_user_can( 'edit_post', get_the_id() ) ) {
		// 	$edit_post_link = get_edit_post_link( get_the_id() ) . '&classic-editor';
		// 	$wp_admin_bar->add_menu(
		// 		array(
		// 			'id'    => 'classic-edit',
		// 			'title' => __( 'Edit Post (Classic)', 'terminal' ),
		// 			'href'  => $edit_post_link,
		// 		)
		// 	);
		// }
	}

	/**
	 * Replace howdy with yo.
	 *
	 * @param object $wp_admin_bar Admin bar object.
	 */
	public function replace_howdy( $wp_admin_bar ) {
		$my_account = $wp_admin_bar->get_node( 'my-account' );
		$yo         = str_replace( 'Howdy,', 'Yo,', $my_account->title );
		$wp_admin_bar->add_node(
			array(
				'id'    => 'my-account',
				'title' => $yo,
			)
		);
	}

	/**
	 * Footer text.
	 *
	 * @return string Footer text.
	 */
	public function railyard_footer_text() {
		return '<em>Thanks for using this jawn.</em>';
	}
}
