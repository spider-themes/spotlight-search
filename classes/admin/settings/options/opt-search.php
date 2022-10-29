<?php
CSF::createSection(
	$prefix,
	[
		'title'  => esc_html__( 'Search', 'wp-spotlight' ),
		'fields' => [
			[
				'id'      => 'wp-spotlight_post_types',
				'type'    => 'checkbox',
				'title'   => esc_html__( 'Post Types to show in search results', 'wp-spotlight' ),
				'options' => 'wp_spotlight_post_types',
				'default' => [ 'post' ],
			],
		],
	]
);
