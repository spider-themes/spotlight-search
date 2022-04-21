<?php
// Create a section
CSF::createSection( $prefix, array(
	'title'  => esc_html__( 'Contact', 'wp-spotlight' ),
	'fields' => array(
		array(
			'id'       => 'wp-spotlight_contact_mail',
			'type'     => 'text',
			'title'    => esc_html__( 'Email to send wp-spotlight form message to.', 'wp-spotlight' ),
			'default'  => get_option( 'admin_email' ),
			'validate' => 'csf_validate_email',
		),
	),
) );
