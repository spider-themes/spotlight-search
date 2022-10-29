<?php
spl_autoload_register(
	function ( $class ) {
		$path = plugin_dir_path( __FILE__ ) . str_replace( '\\', '/', $class ) . '.php';
		if ( file_exists( $path ) ) {
			include_once $path;
		}
	}
);
