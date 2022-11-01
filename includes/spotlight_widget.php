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
			esc_html__( 'WP Spotlight Search', 'wp-spotlight' ), // Name
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

		$placeholder = ! empty( $instance['placeholder'] ) ? sanitize_text_field( $instance['placeholder'] ) : '';

		?>
		<form class="wp-spotlight-search-widget" action="<?php echo home_url( '/' ); ?>" method="get">
			<div id="wp-spotlight-widget-search">
				<div class="widget-search-icon">
					<span class="dashicons dashicons-search"></span>
				</div>
				<input type="search" name="s" id="search" placeholder="<?php echo esc_attr( $placeholder ); ?>" value="<?php the_search_query(); ?>" />
			</div>
		</form>
		<div id="wp-spotlight-widget-result">

		</div>
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
		$title       = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'New title', 'wp-spotlight' );
		$placeholder = ! empty( $instance['placeholder'] ) ? $instance['placeholder'] : esc_html__( 'Type to search', 'wp-spotlight' );
		$cancel      = ! empty( $instance['cancel'] ) ? $instance['cancel'] : esc_html__( 'Cancel', 'wp-spotlight' );
		?>

		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'wp-spotlight' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" placeholder="<?php echo esc_attr( $placeholder ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		<br/>

		<label for="<?php echo esc_attr( $this->get_field_id( 'placeholder' ) ); ?>"><?php esc_html_e( 'Placeholder:', 'wp-spotlight' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'placeholder' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'placeholder' ) ); ?>" type="text" value="<?php echo esc_attr( $placeholder ); ?>">
		<br/>
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
		$instance                = [];
		$instance['title']       = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['placeholder'] = ( ! empty( $new_instance['placeholder'] ) ) ? sanitize_text_field( $new_instance['placeholder'] ) : '';

		return $instance;
	}

} // class WP_Spotlight_Widget
