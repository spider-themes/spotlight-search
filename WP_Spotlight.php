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

/**
 * The Main Plugin Class
 */
final class WP_Spotlight {

	const VERSION = '1.0.0';

	private function __construct() {
		$this->define_constants();
		$this->search_ajax();
		$this->spotlight_includes();

		register_activation_hook( __FILE__, [ $this, 'activate' ] );

		add_action( 'wp_enqueue_scripts', [ $this, 'load_assets' ], 11 );

		// popup search
		add_action( 'wp_enqueue_scripts', [ $this, 'popup_search_assets' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'popup_search_assets' ] );

		add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
	}


	/**
	 *  Initializing wp_spotlight class
	 *
	 * @return /Wp_spotlight
	 */
	public static function init() {
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
	public function define_constants() {
		define( 'WP_SPOTLIGHT_VERSION', self::VERSION );
		define( 'WP_SPOTLIGHT_FILE', __FILE__ );
		define( 'WP_SPOTLIGHT_DIR', __DIR__ );
		define( 'WP_SPOTLIGHT_URL', plugins_url( '', WP_SPOTLIGHT_FILE ) );
		define( 'WP_SPOTLIGHT_ASSETS', WP_SPOTLIGHT_URL . '/assets' );
	}

	/**
	 * Input plugin version and date time on database
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

	/**
	 * Include important files necessary for this plugin
	 *
	 * @return void
	 */
	public function spotlight_includes() {
		include WP_SPOTLIGHT_DIR . '/includes/functions.php';
		include WP_SPOTLIGHT_DIR . '/includes/codestar-framework/codestar-framework.php';
		include WP_SPOTLIGHT_DIR . '/includes/spotlight_widget.php';

	}

	/**
	 * Load necessary assets required
	 *
	 * @return void
	 */
	public function load_assets() {
		wp_enqueue_style( 'dashicons' );

		wp_enqueue_style( 'wp-spotlight-assistant', WP_SPOTLIGHT_ASSETS . '/css/assistant.css', WP_SPOTLIGHT_VERSION );

		wp_enqueue_script( 'wp-spotlightf-assistant', WP_SPOTLIGHT_ASSETS . '/js/assistant.js', [ 'jquery' ], WP_SPOTLIGHT_VERSION );

		wp_enqueue_script( 'wp-spotlight-ajax', WP_SPOTLIGHT_ASSETS . '/js/ajax.js' );

		$localized_settings = [
			'ajax_url'           => admin_url( 'admin-ajax.php' ),
			'wp_spotlight_nonce' => wp_create_nonce( 'wp_spotlight_nonce' ),
		];

		wp_localize_script( 'wp-spotlight-ajax', 'wp_spotlight_search', $localized_settings );
	}

	/**
	 * Load popup search scripts
	 */
	public function popup_search_assets() {
		$opt             = get_option( 'wp-spotlight_opt' );
		$is_popup_search = $opt['is_popup_search'] ?? true;

		if ( $is_popup_search ) {
			wp_enqueue_style( 'wp-spotlight-popup-search', WP_SPOTLIGHT_ASSETS . '/popup-search/popup-search.css', WP_SPOTLIGHT_VERSION );
			wp_enqueue_script( 'wp-spotlight-popup-search', WP_SPOTLIGHT_ASSETS . '/popup-search/popup-search.js', [ 'jquery' ], WP_SPOTLIGHT_VERSION, true );
		}
		wp_enqueue_script( 'wp-spotlight-ajax-global', WP_SPOTLIGHT_ASSETS . '/js/global-ajax.js', [], true );

		$localized_settingsd = [
			'global_ajax_url'           => admin_url( 'admin-ajax.php' ),
			'wp_spotlight_nonce_global' => wp_create_nonce( 'wp_spotlight_nonce_global' ),
		];

		wp_localize_script( 'wp-spotlight-ajax-global', 'wp_spotlight_search_global', $localized_settingsd );
	}

	public function init_plugin() {
		if ( is_admin() ) {
			include WP_SPOTLIGHT_DIR . '/classes/Admin.php';

			new \classes\Admin();
		} else {
			include WP_SPOTLIGHT_DIR . '/classes/Frontend.php';

			new \classes\Frontend();
		}

		include WP_SPOTLIGHT_DIR . '/classes/Globals.php';
		new \classes\Globals();
	}

	public function search_ajax() {
		include WP_SPOTLIGHT_DIR . '/classes/frontend/Search.php';
		include WP_SPOTLIGHT_DIR . '/classes/frontend/Global_Search.php';

		new \classes\frontend\Search();
		new \classes\frontend\Global_Search();
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

//TODO: Option to disable post type from front end.
//TODO: SHow display names for post type
