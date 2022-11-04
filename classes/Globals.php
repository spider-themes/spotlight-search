<?php
namespace SpotlightSearch;

/**
 * Class Globals
 * @package classes
 */
class Globals {

	/**
	 * Globals constructor.
	 */
	public function __construct() {
		add_action( 'wp_footer', [ $this, 'render_assistant' ] );
		add_action( 'admin_footer', [ $this, 'render_assistant' ] );
	}

	public function render_assistant() {
		?>
		<div id="spotlight_popup_search_wrapper">
			<div id="spotlight_popup_search">
				<div class="chatbox-header">
					<div class="search-box">
						<form action="#">
							<input type="search" name="s" id="spotlight-search-chat-search-global" placeholder="<?php esc_attr_e( 'Search for content', 'spotlight-search' ); ?>">
							<span class="cancel-search-box"><?php esc_html_e( 'Cancel', 'spotlight-search' ); ?></span>
						</form>
					</div>
				</div>
				<div class="chatbox-body">
					<div id="chatbox-search-results-global"></div>
				</div>
			</div>
		</div>
		<?php
	}
}
