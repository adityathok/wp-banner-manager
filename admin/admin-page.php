<?php
/**
 * Register admin-page
 *
 */
class Wpbannerman_admin_page {

	/**
	 * Autoload method
	 * @return void
	 */
	public function __construct() {
		add_action( 'admin_menu', array(&$this, 'register_wpbannerman_admin_page') );
	}

	/**
	 * Register admin_page_overview
	 * @return void
	 */
	public function register_wpbannerman_admin_page() {
		add_submenu_page( 
			'edit.php?post_type=wpbannerman', 'Overview', 'Overview', 'manage_options', 'wpbannerman-overview', array(&$this, 'admin_page_overview_callback')
		);
	}

	/**
	 * Render wpbannerman_admin_page
	 * @return void
	 */
	public function admin_page_overview_callback() {
        require_once plugin_dir_path( __FILE__ ) . 'admin-page-overview.php';
	}

}

new Wpbannerman_admin_page();