<?php
CSF::createSection(
	$prefix,
	[
		'title'  => esc_html__( 'Search', 'wp-spotlight' ),
		'fields' => [

			[
				'id'       => 'is_popup_search',
				'type'     => 'switcher',
				'title'    => __( 'Show popup search on pressing shortcut Ctrl + Shift + Space Bar', 'wp-spotlight' ),
				'text_on'  => __( 'Yes', 'wp-spotlight' ),
				'text_off' => __( 'No', 'spotlight' ),
				'default'  => true,
			],

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
