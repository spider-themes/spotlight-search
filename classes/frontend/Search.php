<?php
namespace SpotlightSearch\Frontend;

class Search {
	public function __construct() {
		// feedback
		add_action( 'wp_ajax_spotlight_search_search_result', [ $this, 'fetch_posts' ] );
		add_action( 'wp_ajax_nopriv_spotlight_search_search_result', [ $this, 'fetch_posts' ] );
	}

	/**
	 * Store feedback for an article.
	 * @return void
	 */
	public function fetch_posts() {
		$opt        = get_option( 'spotlight_search_opt' );
		$post_types = ! empty( $opt['spotlight-search_post_types'] ) ? $opt['spotlight-search_post_types'] : 'post';
		?>
		<div class="chatbox-posts" tab-data="post">
			<?php
			$posts = new \WP_Query(
				[
					'post_type' => $post_types,
					's'         => sanitize_text_field( $_POST['keyword'] ),
				]
			);

			if ( $posts->have_posts() ) :
				while ( $posts->have_posts() ) :
					$posts->the_post();
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
				?>
				<div class="post-item keyword-danger">
					<p><?php esc_html_e( 'No Results Found. Please Type a different keyword', 'spotlight-search' ); ?></p>
				</div>
				<?php

			endif;
			?>
		</div>
		<?php
		die();
	}
}
