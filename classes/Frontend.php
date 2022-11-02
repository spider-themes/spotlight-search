<?php
namespace classes;

class Frontend {
	public function __construct() {
		add_action( 'wp_footer', [ $this, 'render_assistant' ] );
		$this->contact_support();
	}

	public function contact_support() {
		include SPOTLIGHT_SEARCH_DIR . '/classes/frontend/Mailer.php';
		new \classes\frontend\Mailer();
	}

	public function render_assistant() {
		$opt        = get_option( 'spotlight_search_opt' );
		$post_types = ! empty( $opt['spotlight-search_post_types'] ) ? $opt['spotlight-search_post_types'] : 'post';
		?>
		<div class="chatbox-wrapper">
			<div class="chatbox-header">
				<div class="chatbox-tab">
					<a href="#" tab-link="kbase" class="chatbox-kbase active"><?php _e( 'Knowledge Base', 'spotlight-search' ); ?></a>
					<a href="#" tab-link="contact" class="chatbox-contact"><?php _e( 'Contact', 'spotlight-search' ); ?></a>
				</div>

				<div class="search-box">
					<form action="#">
						<input type="search" name="s" id="spotlight-search-chat-search" placeholder="Search..">
					</form>
				</div>
			</div>

			<div class="chatbox-body">
				<div id="chatbox-search-results">
					<div class="chatbox-posts" tab-data="post">
						<?php
						$query = new \WP_Query(
							[
								'post_type'      => $post_types,
								'posts_per_page' => 12,
								'order'          => 'random',
							]
						);

						if ( $query->have_posts() ) :
							while ( $query->have_posts() ) :
								$query->the_post();
								?>
								<div class="post-item">
									<?php spotlight_search_breadcrumb(); ?>
									<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
									<p><?php spotlight_search_limit_letter( get_the_excerpt(), 80 ); ?></p>
								</div>
								<?php
							endwhile;
							wp_reset_postdata();
						else :
							_e( 'No Posts Found', 'spotlight-search' );
						endif;
						?>
					</div>
				</div>

				<div class="chatbox-form" tab-data="contact">
					<div class="chatbox-form-wrapper">
						<form action="#" method="post" class="chatbox-form">
							<input type="text" name="spotlight-search-name" id="chatc-name" placeholder="<?php _e( 'Full Name', 'spotlight-search' ); ?>" required>
							<input type="email" name="spotlight-search-email" id="chatc-email" placeholder="<?php _e( 'name@example.com', 'spotlight-search' ); ?>" required>
							<input type="text" name="spotlight-search-subject" id="chatc-subject" placeholder="<?php _e( 'Subject', 'spotlight-search' ); ?>" required>
							<textarea name="spotlight-search-comment" id="comment" cols="30" rows="8" placeholder="<?php _e( 'Write Your Message', 'spotlight-search' ); ?>"></textarea>
							<input type="submit" name="spotlight-search-form-submit" value="Send Message">
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="chat-toggle">
			<a href="#">
				<img class="spotlight-search-chat" src="<?php echo SPOTLIGHT_SEARCH_ASSETS . '/img/chat.svg'; ?>" alt="<?php esc_html_e( 'Chat Icon', 'spotlight-search' ); ?>">
				<img class="spotlight-search-hide" src="<?php echo SPOTLIGHT_SEARCH_ASSETS . '/img/close.svg'; ?>" alt="<?php esc_html_e( 'Chat Icon', 'spotlight-search' ); ?>">
			</a>
		</div>
		<?php
	}
}
