<?php
namespace classes\frontend;

class Mailer {
	public function __construct() {
		add_action( 'after_setup_theme', [ $this, 'feedback_mail' ] );
	}

	function feedback_mail() {
		$opt = get_option( 'wp-spotlight_opt' );

		$admin_email = ! empty( $opt['wp-spotlight_contact_mail'] ) ? $opt['wp-spotlight_contact_mail'] : '';

		if ( isset( $_POST['wp-spotlight-form-submit'] ) ) {
			$author  = ! empty( $_POST['wp-spotlight-name'] ) ? sanitize_text_field( $_POST['wp-spotlight-name'] ) : '';
			$subject = ! empty( $_POST['wp-spotlight-subject'] ) ? sanitize_text_field( $_POST['wp-spotlight-subject'] ) : '';
			$email   = ! empty( $_POST['wp-spotlight-email'] ) ? sanitize_email( $_POST['wp-spotlight-email'] ) : '';
			$message = ! empty( $_POST['wp-spotlight-comment'] ) ? sanitize_text_field( $_POST['wp-spotlight-comment'] ) : '';

			if ( ! is_user_logged_in() ) {
				$email = ! empty( $_POST['wp-spotlight-email'] ) ? sanitize_email( $_POST['wp-spotlight-email'] ) : '';

				if ( ! $email ) {
					wp_send_json_error( __( 'Please enter a valid email address.', 'wp-spotlight' ) );
				}
			} else {
				$email = wp_get_current_user()->user_email;
			}

			if ( empty( $subject ) ) {
				wp_send_json_error( __( 'Please provide a subject line.', 'wp-spotlight' ) );
			}

			if ( empty( $message ) ) {
				wp_send_json_error( __( 'Please provide the message details.', 'wp-spotlight' ) );
			}

			$wp_email = 'wordpress@' . preg_replace( '#^www\.#', '', strtolower( $_SERVER['SERVER_NAME'] ) );
			$blogname = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );

			$email_to = $admin_email;
			$subject  = sprintf( __( '[%1$s] New Wp-spotlight Query: "%2$s"', 'wp-spotlight' ), $blogname, $subject );

			$email_body  = sprintf( __( 'New Message From Wp-spotlight Plugin. Source: %s', 'wp-spotlight' ), $wp_email ) . "\r\n";
			$email_body .= sprintf( __( 'From: %s', 'wp-spotlight' ), $email ) . "\r\n";
			$email_body .= sprintf( __( 'Message: %s', 'wp-spotlight' ), "\r\n" . $message ) . "\r\n\r\n";

			$from     = "From: \"${author}\" <${wp_email}>";
			$reply_to = "Reply-To: \"${email}\" <${email}>";

			$message_headers  = "${from}\n" . 'Content-Type: text/plain; charset ="' . get_option( 'blog_charset' ) . "\"\n";
			$message_headers .= $reply_to . "\n";

			wp_mail( $email_to, wp_specialchars_decode( $subject ), $email_body, $message_headers );
		}
	}
}
