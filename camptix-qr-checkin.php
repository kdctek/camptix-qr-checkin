<?php
/*
 * Plugin Name: CampTix QR Checkin
 * Plugin URI:  https://github.com/kdctek/camptix-qr-checkin
 * Description: Create a Shortcode for embeding QR Code and also enabling users with Editor Role to Checkin Attendee by scaning the QR Code.
 * Version:     0.1.0
 * Text Domain: tix_qrcheckin
 * Domain Path: /languages/
 *
 * Author:      Vachan Kudmule
 * Author URI:  https://dezine.ninja
 * License:     GPLv2
 */


class CampTix_Addon_QR_Checkin extends CampTix_Addon {

	/**
	 * Init
	 */
	public function camptix_init() {
		add_action( 'tix_qrcheckin_attendee',   array( $this, 'tix_qrcheckin_attendance' ), 10, 2 );
		add_shortcode( 'tix_qrcheckin',         array( $this, 'tix_qrcheckin_shortcode' ) );
	}

	/**
	 * Callback for the [camptix_attendees] shortcode.
	 */
	public function tix_qrcheckin_shortcode( $attr ) {
		$attendee_id = $attr['attendee_id'];
        $attendee = get_post( $attendee_id );

		$attr = $this->sanitize_attendees_atts( $attr );

		return $this->get_attendees_shortcode_content( $attr );
	}

}

// Register this class as a CampTix Addon.
camptix_register_addon( 'CampTix_Addon_QR_Checkin' );
 