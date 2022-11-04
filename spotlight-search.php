<?php
/**
 * Plugin Name:       Spotlight Search
 * Plugin URI:        https://helpdesk.spider-themes.net/spotlight-search
 * Description:       A shortcut for opening popup search to show AJAX search results. Also, there is an assistant button at the bottom, clicking the assistant icon will show a search section at the bottom, and a form to contact the client.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.4
 * Author:            spider-themes
 * Author URI:        https://profiles.wordpress.org/spiderdevs/
 * Text Domain:       spotlight-search
 * License:           GPL v3
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.txt
 */

defined( 'ABSPATH' ) || exit;

/**
 * The Main Plugin Class
 */
final class Spotlight_Search {

	const VERSION = '1.0.0';

	private function __construct() {
		$this->define_constants();
		$this->search_ajax();
		$this->spotlight_includes();

		register_activation_hook( __FILE__, [ $this, 'activate' ] );

		add_action( 'wp_enqueue_scripts', [ $this, 'load_assets' ], 11 );

		// Popup search.
		add_action( 'wp_enqueue_scripts', [ $this, 'popup_search_assets' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'popup_search_assets' ] );

		add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
	}


	/**
	 *  Initializing spotlight_search class.
	 *
	 * @return /Spotlight_Search
	 */
	public static function init() {
		static $instance = false;

		if ( ! $instance ) {
			$instance = new self();
		}

		return $instance;
	}

	/**
	 * Defining required plugin constants.
	 * 
	 * @return void
	 */
	public function define_constants() {
		define( 'SPOTLIGHT_SEARCH_VERSION', self::VERSION );
		define( 'SPOTLIGHT_SEARCH_FILE', __FILE__ );
		define( 'SPOTLIGHT_SEARCH_DIR', __DIR__ );
		define( 'SPOTLIGHT_SEARCH_URL', plugins_url( '', SPOTLIGHT_SEARCH_FILE ) );
		define( 'SPOTLIGHT_SEARCH_ASSETS', SPOTLIGHT_SEARCH_URL . '/assets' );
	}

	/**
	 * Input plugin version and date time on database.
	 *
	 * @return void
	 */
	public function activate() {
		$installed = get_option( 'spotlight_search_installed' );

		if ( ! $installed ) {
			update_option( 'spotlight_search_installed', time() );
		}

		update_option( 'spotlight_search_version', SPOTLIGHT_SEARCH_VERSION );
	}

	/**
	 * Include important files necessary for this plugin.
	 *
	 * @return void
	 */
	public function spotlight_includes() {
		include SPOTLIGHT_SEARCH_DIR . '/includes/functions.php';
		include SPOTLIGHT_SEARCH_DIR . '/includes/codestar-framework/codestar-framework.php';
		include SPOTLIGHT_SEARCH_DIR . '/includes/spotlight_widget.php';

	}

	/**
	 * Load necessary assets required.
	 *
	 * @return void
	 */
	public function load_assets() {
		wp_enqueue_style( 'dashicons' );

		wp_enqueue_style( 'spotlight-search-assistant', SPOTLIGHT_SEARCH_ASSETS . '/css/assistant.css', [], SPOTLIGHT_SEARCH_VERSION );

		wp_enqueue_script( 'spotlight-search-assistant', SPOTLIGHT_SEARCH_ASSETS . '/js/assistant.js', [ 'jquery' ], SPOTLIGHT_SEARCH_VERSION, true );

		wp_enqueue_script( 'spotlight-search-ajax', SPOTLIGHT_SEARCH_ASSETS . '/js/ajax.js', [ 'jquery' ], SPOTLIGHT_SEARCH_VERSION, true );

		$localized_settings = [
			'ajax_url'               => admin_url( 'admin-ajax.php' ),
			'spotlight_search_nonce' => wp_create_nonce( 'spotlight_search_nonce' ),
		];

		wp_localize_script( 'spotlight-search-ajax', 'spotlight_search_search', $localized_settings );
	}

	/**
	 * Load popup search scripts.
	 * 
	 * @return void
	 */
	public function popup_search_assets() {
		$opt             = get_option( 'spotlight_search_opt' );
		$is_popup_search = $opt['is_popup_search'] ?? true;

		if ( $is_popup_search ) {
			wp_enqueue_style( 'spotlight-search-popup-search', SPOTLIGHT_SEARCH_ASSETS . '/popup-search/popup-search.css', [], SPOTLIGHT_SEARCH_VERSION );
			wp_enqueue_script( 'spotlight-search-popup-search', SPOTLIGHT_SEARCH_ASSETS . '/popup-search/popup-search.js', [ 'jquery' ], SPOTLIGHT_SEARCH_VERSION, true );
		}

		wp_enqueue_script( 'spotlight-search-ajax-global', SPOTLIGHT_SEARCH_ASSETS . '/js/global-ajax.js', [], SPOTLIGHT_SEARCH_VERSION, true );

		$localized_settingsd = [
			'global_ajax_url'               => admin_url( 'admin-ajax.php' ),
			'spotlight_search_nonce_global' => wp_create_nonce( 'spotlight_search_nonce_global' ),
		];

		wp_localize_script( 'spotlight-search-ajax-global', 'spotlight_search_search_global', $localized_settingsd );
	}

	/**
	 * Initialize the Spotlight Search plugin.
	 *
	 * @return void
	 */
	public function init_plugin() {
		if ( is_admin() ) {
			require SPOTLIGHT_SEARCH_DIR . '/classes/Admin.php';

			new \SpotlightSearch\Admin();
		} else {
			require SPOTLIGHT_SEARCH_DIR . '/classes/Frontend.php';

			new \SpotlightSearch\Frontend();
		}

		require SPOTLIGHT_SEARCH_DIR . '/classes/Globals.php';
		new \SpotlightSearch\Globals();
	}

	/**
	 * Search using AJAX.
	 *
	 * @return void
	 */
	public function search_ajax() {
		include SPOTLIGHT_SEARCH_DIR . '/classes/frontend/Search.php';
		include SPOTLIGHT_SEARCH_DIR . '/classes/frontend/Global_Search.php';

		new \SpotlightSearch\Frontend\Search();
		new \SpotlightSearch\Frontend\Global_Search();
	}
}

/**
 * Function to initialize spotlight_search plugin.
 *
 * @return \Spotlight_Search
 */
function spotlight_search() {
	return Spotlight_Search::init();
}

// Kick off the plugin.
spotlight_search();
