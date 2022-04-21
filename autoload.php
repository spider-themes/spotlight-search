<?php
spl_autoload_register( function ( $class ) {
	$file = plugin_dir_path(__FILE__) . '\\' . str_replace( '/', '\\', $class ) . '.php';
	file_exists( $file ) &&	require $file;
} );


