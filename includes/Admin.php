<?php
namespace WpSpotlight;

class Admin {
	public function __construct() {
		$this->load_admin_options();
	}

	public function load_admin_options() {
		require __DIR__. '/Admin/Settings/options/opt-config.php';
	}
}