<?php
/**
 * Render a breadcrumb for the posts
 *
 * @return void
 */
function wp_spotlight_breadcrumb() {
	?>
    <ol class="chatbox-breadcrumb <?php echo get_post_type( get_the_ID() ) ?>">
		<?php
		if ( 'topic' == get_post_type() || 'reply' == get_post_type() ) {
			$parent_forum = bbp_get_forum_parent_id( get_the_ID() );
			?>
            <li class="breadcrumb-item">
                <a href="<?php echo bbp_get_forums_url( '/' ) ?>"> <?php esc_html_e( 'Forums', 'wp_spotlight' ); ?> </a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?php echo get_the_permalink( $parent_forum ) ?>">
					<?php bbp_forum_title( $parent_forum ); ?>
                </a>
            </li>
			<?php
		}
		?>

        <li class="breadcrumb-item active">
	            <?php
	            if ( 'post' == get_post_type() ) {
		            esc_html_e( 'Blog', 'wp_spotlight' );
	            } else {
		            echo ucwords( get_post_type() );
	            }
	            ?>
        </li>
    </ol>
	<?php
}

/**
 * Limit latter
 *
 * @param $string
 * @param $limit_length
 * @param string $suffix
 */
function wp_spotlight_limit_letter( $string, $limit_length, $suffix = '...' ) {
	if ( strlen( $string ) > $limit_length ) {
		echo strip_shortcodes( substr( $string, 0, $limit_length ) . $suffix );
	} else {
		echo strip_shortcodes( esc_html( $string ) );
	}
}

function wp_spotlight_post_types() {
	$post_types = get_post_types( array(
		'public' => true,
	) );

	$post_types = array_diff( $post_types, array( 'attachment', 'page' ) );

	return $post_types;
}
