<?php

namespace Railyard;

class Theme {
	use Singleton;

	public function init() {
		add_action( 'admin_bar_menu', [ $this, 'remove_wp_logo' ], 999 );
		add_action( 'admin_head', [ $this, 'railyard_favicon' ] );
		add_action( 'admin_init', [ $this, 'remove_wp_news_widget' ] );
		add_action( 'login_enqueue_scripts', [ $this, 'railyard_login_logo' ] );
		add_action( 'login_head', [ $this, 'railyard_favicon' ] );
		add_filter( 'admin_bar_menu', [ $this, 'replace_howdy' ],25 );
		add_filter( 'admin_footer_text', [ $this, 'railyard_footer_text' ] );
		add_filter( 'login_headertitle', [ $this, 'railyard_logo_url_title' ] );
		add_filter( 'login_headerurl', [ $this, 'railyard_logo_url' ] );
		add_filter( 'max_srcset_image_width', '__return_true' );
		remove_action( 'welcome_panel', [ $this, 'wp_welcome_panel' ] );

		add_action( 'wp_head', function() {
			echo '<meta name="twitter:dnt" content="on">';
		});
	}

	function railyard_login_logo() {
		?>
		<style type="text/css">
			body.login div#login h1 a {
				background-image: url(/wp-content/mu-plugins/custom/railyard/static/railyard-logo.png);
			}
		</style>
	<?php
	}

	function railyard_logo_url() {
		return home_url();
	}

	function railyard_logo_url_title() {
		return 'Another Philly Publishing Site';
	}

	function railyard_favicon() {
		echo '<link rel="shortcut icon" href="/wp-content/mu-plugins/custom/railyard/static/favicon.ico" />';
	}

	function remove_wp_news_widget() {
		remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
	}

	function remove_wp_logo( $wp_admin_bar ) {
		$wp_admin_bar->remove_node( 'wp-logo' );
	}

	function replace_howdy( $wp_admin_bar ) {
			$my_account = $wp_admin_bar->get_node( 'my-account' );
			$yo         = str_replace( 'Howdy,', 'Yo,', $my_account->title );
			$wp_admin_bar->add_node( array(
				'id' => 'my-account',
				'title' => $yo,
			) );
	}

	function railyard_footer_text() {
		return '<em>Thanks for using this jawn.</em>';
	}
}