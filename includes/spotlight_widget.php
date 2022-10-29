<?php
class spotlight_widget {
	function __construct() {
		add_action( 'widgets_init', [ __CLASS__, 'widgets_init' ] );
	}

	// Register the widget.
	static function widgets_init() {
		register_widget( 'WP_Spotlight_Widget' );
	}
}

// Create an object.
new spotlight_widget();

/**
 * Adds WP_Spotlight_Widget widget.
 */
class WP_Spotlight_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'wp_spotlight_widget', // Base ID
			esc_html__( 'WP Spotlight Search', 'text_domain' ), // Name
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		?>
		<form action="<?php echo home_url( '/' ); ?>" method="get">
			<div id="wp-shoplight-widget-search">
				<input type="text" name="s" id="search" placeholder="<?php esc_attr_e( 'Click to open popup', 'wp-spotlight' ); ?>" value="<?php the_search_query(); ?>" />
				<!-- <input type="submit" alt="Search" value="Search"/> -->
			</div>
		</form>
		<?php
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'New title', 'text_domain' );
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance          = [];
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';

		return $instance;
	}

} // class WP_Spotlight_Widget
