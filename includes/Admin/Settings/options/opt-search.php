<?php
CSF::createSection( $prefix, array(
	'title'  => esc_html__( 'Search', 'wp-spotlight' ),
	'fields' => array(
		array(
			'id'         => 'wp-spotlight_post_types',
			'type'       => 'checkbox',
			'title'      => esc_html__('Post Types to show in search results', 'wp-spotlight'),
			'options' => 'wp-spotlight_post_types',
			'default' => array( 'post' )
		),
	),
) );

