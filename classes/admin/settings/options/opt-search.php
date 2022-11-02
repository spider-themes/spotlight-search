<?php
CSF::createSection(
	$prefix,
	[
		'title'  => esc_html__( 'Search', 'spotlight-search' ),
		'fields' => [

			[
				'id'       => 'is_popup_search',
				'type'     => 'switcher',
				'title'    => __( 'Show popup search on pressing shortcut Ctrl + Shift + Space Bar or, Command + Shift + Space bar', 'spotlight-search' ),
				'text_on'  => __( 'Yes', 'spotlight-search' ),
				'text_off' => __( 'No', 'spotlight' ),
				'default'  => true,
			],

			[
				'id'      => 'spotlight-search_post_types',
				'type'    => 'checkbox',
				'title'   => esc_html__( 'Post Types to show in search results', 'spotlight-search' ),
				'options' => 'spotlight_search_post_types',
				'default' => [ 'post' ],
			],
		],
	]
);
