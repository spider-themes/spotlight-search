<?php
namespace classes;

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
							<input type="search" name="s" id="spotlight-search-chat-search-global" placeholder="Search for concepts">
							<span class="cancel-search-box">Cancel</span>
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
