<?php
/**
 * Plugin Name:       WP Spotlight
 * Plugin URI:        https://helpdesk.spider-themes.net/wp_spotlight
 * Description:       This plugin will show up an icon on the right bottom corner of the webpage. Clicking the icon will show up assistant. Users will be able to search from the assistant search bar.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.4
 * Author:            spiderDevs
 * Author URI:        https://profiles.wordpress.org/spiderdevs/
 * Text Domain:       wp-spotlight
 * License:           GPL v3
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.txt
 */

defined( 'ABSPATH' ) || exit;

require_once __DIR__ . '/autoload.php';

/**
 * The Main Plugin Class
 */
final class WP_Spotlight {

	const VERSION = '1.0.0';

	private function __construct() {
		$this->define_constants();
		$this->search_ajax();
		$this->core_includes();

		register_activation_hook( __FILE__, [ $this, 'activate' ] );

		add_action( 'wp_enqueue_scripts', [ $this, 'load_assets' ], 11 );
		add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
	}


	/**
	 *  Initializing wp_spotlight class
	 *
	 * @return /Wp_spotlight
	 */
	static function init() {
		static $instance = false;

		if ( ! $instance ) {
			$instance = new self();
		}

		return $instance;
	}

	/**
	 * Defining required plugin constants
	 * @return void
	 */
	function define_constants() {
		define( 'WP_SPOTLIGHT_VERSION', self::VERSION );
		define( 'WP_SPOTLIGHT_FILE', __FILE__ );
		define( 'WP_SPOTLIGHT_DIR', __DIR__ );
		define( 'WP_SPOTLIGHT_URL', plugins_url( '', WP_SPOTLIGHT_FILE ) );
		define( 'WP_SPOTLIGHT_ASSETS', WP_SPOTLIGHT_URL . '/assets' );
	}

	/**
	 * Input plugin versino and date time on database
	 *
	 * @return void
	 */
	public function activate() {
		$installed = get_option( 'wp_spotlight_installed' );

		if ( ! $installed ) {
			update_option( 'wp_spotlight_installed', time() );
		}

		update_option( 'wp_spotlight_version', WP_SPOTLIGHT_VERSION );
	}

	public function core_includes() {
		include WP_SPOTLIGHT_DIR . '/includes/functions.php';
		include WP_SPOTLIGHT_DIR . '/includes/csf/codestar-framework.php';
	}

	public function load_assets() {
		wp_enqueue_style( 'wp_spotlight-assistant', WP_SPOTLIGHT_ASSETS . '/css/assistant.css', WP_SPOTLIGHT_VERSION );

		wp_enqueue_script( 'wp_spotlight-assistant', WP_SPOTLIGHT_ASSETS . '/js/assistant.js', array( 'jquery' ), WP_SPOTLIGHT_VERSION );
		wp_enqueue_script( 'wp_spotlight-ajax', WP_SPOTLIGHT_ASSETS . '/js/ajax.js' );

		$localized_settings = [
			'ajax_url'     => admin_url( 'admin-ajax.php' ),
			'wp_spotlight_nonce' => wp_create_nonce( 'wp_spotlight_nonce' ),
		];

		wp_localize_script( 'wp_spotlight-ajax', 'wp_spotlight_search', $localized_settings );
	}

	public function init_plugin() {
		if ( is_admin() ) {
			new \classes\Admin();
		} else {
			new \classes\Frontend();
		}
	}

	public function search_ajax() {
		new \classes\frontend\Search();
	}
}

/**
 * Function to initialize wp_spotlight plugin
 *
 * @return \WP_Spotlight
 */
function wp_spotlight() {
	return WP_Spotlight::init();
}

// Kick off the plugin
wp_spotlight();
