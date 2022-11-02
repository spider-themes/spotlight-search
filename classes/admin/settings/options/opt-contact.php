<?php
// Create a section
CSF::createSection(
	$prefix,
	[
		'title'  => esc_html__( 'Contact', 'spotlight-search' ),
		'fields' => [
			[
				'id'       => 'spotlight-search_contact_mail',
				'type'     => 'text',
				'title'    => esc_html__( 'Email to send spotlight-search form message to.', 'spotlight-search' ),
				'default'  => get_option( 'admin_email' ),
				'validate' => 'csf_validate_email',
			],
		],
	]
);
