<?php
namespace classes;

class Admin {
	public function __construct() {
		$this->load_admin_menu();
		$this->load_admin_options();
	}

	public function load_admin_options() {
		require plugin_dir_path( __FILE__ ) . 'admin/settings/options/opt-config.php';
	}

	public function load_admin_menu() {
		$parent_slug = 'wp-spotlight';
		$capability = 'manage_options';

		add_menu_page( __( 'Wp-Spotlight', 'wp-spotlight' ), __( 'Wp-Spotlight', 'wp-spotlight' ), 'manage_options', $parent_slug, [ $this, 'wp_spotlight_menu' ], 'dashicons-screenoptions', 120 );
		// add_submenu_page( $parent_slug, __( 'Spotlight settings', 'wp-spotlight' ), __( 'Settings', 'wp-spotlight'), $capability, $parent_slug, [ $this, 'wp_spotlight_menu' ] );
	}

	function wp_spotlight_menu(){

	}

	function settings_page(){

	}
}
