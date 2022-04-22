<?php
namespace classes;

class Admin {
	public function __construct() {
		$this->load_admin_options();
	}

	public function load_admin_options() {
		require plugin_dir_path( '/'). 'admin/settings/options/opt-config.php';
	}
}