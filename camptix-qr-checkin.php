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

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

// Load Plugin Text Domain.
add_action( 'init', 'camptix_qrcheckin_load_init' );
function camptix_qrcheckin_load_init() {
	//Textdomain
	load_plugin_textdomain( 'camptix-kdcpay', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	//EP
	add_rewrite_endpoint( 'checkin', EP_PAGES );
}

// Load the KDCpay Payment Method
add_action( 'camptix_load_addons', 'camptix_qrcheckin_load_addon' );
function camptix_qrcheckin_load_payment_method() {
	if ( ! class_exists( 'CampTix_Addon_QrCheckin' ) )
		require_once plugin_dir_path( __FILE__ ) . 'inc/class-camptix-addon-qrcheckin.php';
	camptix_register_addon( 'CampTix_Addon_QrCheckin' );
}
