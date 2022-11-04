<?php
namespace SpotlightSearch\Frontend;

class Mailer {
	public function __construct() {
		add_action( 'after_setup_theme', [ $this, 'feedback_mail' ] );
	}

	function feedback_mail() {
		$opt = get_option( 'spotlight_search_opt' );

		$admin_email = ! empty( $opt['spotlight-search_contact_mail'] ) ? $opt['spotlight-search_contact_mail'] : '';

		if ( isset( $_POST['spotlight-search-form-submit'] ) ) {
			$author  = ! empty( $_POST['spotlight-search-name'] ) ? sanitize_text_field( $_POST['spotlight-search-name'] ) : '';
			$subject = ! empty( $_POST['spotlight-search-subject'] ) ? sanitize_text_field( $_POST['spotlight-search-subject'] ) : '';
			$email   = ! empty( $_POST['spotlight-search-email'] ) ? sanitize_email( $_POST['spotlight-search-email'] ) : '';
			$message = ! empty( $_POST['spotlight-search-comment'] ) ? sanitize_text_field( $_POST['spotlight-search-comment'] ) : '';

			if ( ! is_user_logged_in() ) {
				$email = ! empty( $_POST['spotlight-search-email'] ) ? sanitize_email( $_POST['spotlight-search-email'] ) : '';

				if ( ! $email ) {
					wp_send_json_error( __( 'Please enter a valid email address.', 'spotlight-search' ) );
				}
			} else {
				$email = wp_get_current_user()->user_email;
			}

			if ( empty( $subject ) ) {
				wp_send_json_error( __( 'Please provide a subject line.', 'spotlight-search' ) );
			}

			if ( empty( $message ) ) {
				wp_send_json_error( __( 'Please provide the message details.', 'spotlight-search' ) );
			}

			$wp_email = 'wordpress@' . preg_replace( '#^www\.#', '', strtolower( sanitize_text_field( $_SERVER['SERVER_NAME'] ) ) );
			$blogname = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );

			$email_to = $admin_email;
			$subject  = sprintf( __( '[%1$s] New Spotlight-search Query: "%2$s"', 'spotlight-search' ), $blogname, $subject );

			$email_body  = sprintf( __( 'New Message From Spotlight-search Plugin. Source: %s', 'spotlight-search' ), $wp_email ) . "\r\n";
			$email_body .= sprintf( __( 'From: %s', 'spotlight-search' ), $email ) . "\r\n";
			$email_body .= sprintf( __( 'Message: %s', 'spotlight-search' ), "\r\n" . $message ) . "\r\n\r\n";

			$from     = "From: \"${author}\" <${wp_email}>";
			$reply_to = "Reply-To: \"${email}\" <${email}>";

			$message_headers  = "${from}\n" . 'Content-Type: text/plain; charset ="' . get_option( 'blog_charset' ) . "\"\n";
			$message_headers .= $reply_to . "\n";

			wp_mail( $email_to, wp_specialchars_decode( $subject ), $email_body, $message_headers );
		}
	}
}
