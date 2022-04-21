<?php
namespace classes;

class Frontend {
	public function __construct() {
		add_action( 'wp_footer', [ $this, 'render_assistant' ] );
		$this->contact_support();
	}

	public function contact_support() {
		new \classes\frontend\Mailer();
	}

	public function render_assistant() {
		$opt        = get_option( 'wp-spotlight_opt' );
		$post_types = ! empty( $opt['wp-spotlight_post_types'] ) ? $opt['wp-spotlight_post_types'] : 'post';
		?>
        <div class="chatbox-wrapper">
        <div class="chatbox-header">
            <div class="chatbox-tab">
                <a href="#" tab-link="kbase" class="chatbox-kbase active"><?php _e( 'Knowledge Base', 'wp-spotlight' ) ?></a>
                <a href="#" tab-link="contact" class="chatbox-contact"><?php _e( 'Contact', 'wp-spotlight' ) ?></a>
            </div>

            <div class="search-box">
                <form action="#">
                    <input type="search" name="s" id="wp-spotlight-chat-search" placeholder="Search..">
                </form>
            </div>
        </div>

        <div class="chatbox-body">
        <div id="chatbox-search-results">
        <div class="chatbox-posts" tab-data="post">
		<?php
		$query = new \WP_Query( [
				'post_type'      => $post_types,
				'posts_per_page' => 12,
				'order'          => 'random',
			]
		);

		if ( $query->have_posts() ):
			while ( $query->have_posts() ):
				$query->the_post();
				?>
                <div class="post-item">
					<?php wp_spotlight_breadcrumb(); ?>
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <p><?php wp_spotlight_limit_letter( get_the_excerpt(), 80 ); ?></p>
                </div>
			<?php
			endwhile;
			wp_reset_postdata();
            else:
                _e( 'No Posts Found', 'wp-spotlight' );
            endif;
			?>
            </div>
            </div>

            <div class="chatbox-form" tab-data="contact">
                <div class="chatbox-form-wrapper">
                    <form action="#" method="post" class="chatbox-form">
                        <input type="text" name="wp-spotlight-name" id="chatc-name" placeholder="<?php _e( 'Full Name', 'wp-spotlight' ); ?>" required>
                        <input type="email" name="wp-spotlight-email" id="chatc-email" placeholder="<?php _e( 'name@example.com', 'wp-spotlight' ) ?>" required>
                        <input type="text" name="wp-spotlight-subject" id="chatc-subject" placeholder="<?php _e( 'Subject', 'wp-spotlight' ) ?>" required>
                        <textarea name="wp-spotlight-comment" id="comment" cols="30" rows="8" placeholder="<?php _e( 'Write Your Message', 'wp-spotlight' ) ?>"></textarea>
                        <input type="submit" name="wp-spotlight-form-submit" value="Send Message">
                    </form>
                </div>
            </div>
            </div>
            </div>

            <div class="chat-toggle">
                <a href="#">
                    <img class="wp-spotlight-chat" src="<?php echo WP_SPOTLIGHT_ASSETS . '/img/chat.svg' ?>" alt="<?php esc_html_e( 'Chat Icon', 'wp-spotlight' ) ?>">
                    <img class="wp-spotlight-hide" src="<?php echo WP_SPOTLIGHT_ASSETS . '/img/close.svg' ?>" alt="<?php esc_html_e( 'Chat Icon', 'wp-spotlight' ) ?>">
                </a>
            </div>
			<?php
		}
}
