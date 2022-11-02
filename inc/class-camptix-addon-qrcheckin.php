<?php
/**
 * CampTix QR Checkin
 *
 * This class handles QR Checkin Addon for CampTix
 *
 * @since		0.1.0
 * @package		CampTix
 * @category	Class
 * @author 		Vachan Kudmule <vachan@kdc.in>
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class CampTix_Addon_QrCheckin extends CampTix_Addon {

	/**
	 * Init
	 */
	public function camptix_init() {
		
		add_action( 'tix_qrcheckin_attendance', array( $this, 'camptix_qrcheckin_attendance' ), 10, 2 );
		
		add_shortcode( 'qr_checkin', array( $this, 'camptix_qrcheckin_shortcode' ) );

		if ( ! empty( $_GET['camptix-qrcheckin'] ) ) {
			add_filter( 'template_include', array( $this, 'camptix_qrcheckin_attended' ) );
		}

	}	

	/**
	 * Mark Attendence
	 */
	public function camptix_qrcheckin_attended() {

		/**
		 * Check if Volunteer
		 * 
		 * Verify if logged in & has valid Capabilities
		 * to check-in the attendee.
		 */
		if ( ! current_user_can( 'edit_others_posts' ) ) 
				return;

		 /**
		 * Check if valid Access Token
		 * 
		 * Camptix generates an Access Token which will be a value
		 * in the QR Code.
		 * 
		 * If accesss token not valid, display ERROR
		 */

		 /**
		 * Mark as attendeed
		 * 
		 * Using the meta_key
		 */

	}

	/**
	 * Callback for the [qr_checkin] shortcode.
	 */
	public function camptix_qrcheckin_shortcode( $atts ) {
        
		$attendee = get_post( $attendee_id );
		$edit_token = get_post_meta( $this->tmp( 'attendee_id' ), 'tix_edit_token', true );
		$ticket_url = $this->get_edit_attendee_link( $this->tmp( 'attendee_id' ), $edit_token );

		$atts = shortcode_atts( array(
			'width' => '300',
			'height' => '300',
			'url' => plugin_dir_path( __FILE__ ) . 'public/checkin.php',
			'params' => ''
		), $atts, 'tix_qrcheckin' );
	
		$qr_code_html = '<a href="##tix_url_access##">
			<img id="camptix-qr-attendee-" class="camptix-qr-attendee" src="http://chart.apis.google.com/chart
			?cht=qr
			&chs=' . $atts['width'] . 'x' . $atts['height'] . '
			&chld=H|0
			&chl=' . $ticket_url . '"
			width="' . $atts['width'] . '" 
			height="' . $atts['height'] . '" />
		</a>';

		return $qr_code_html;

	}

	/**
	 * Temporary storage (non-persistent)
	 *
	 * Use this function to access the CampTix temporary storage for things like attendee_id
	 * for notify shortcodes, and receipt for e-mail templates, etc. You can also use it to
	 * store your own stuff, but don't forget to cleanup when you're done.
	 *
	 * @param $key string The key to access/store the value with.
	 * @param $value mixed An optional value when storing things.
	 */
	public function tmp( $key, $value = null ) {
		if ( null !== $value )
			$this->tmp[ $key ] = $value;

		if ( isset( $this->tmp[ $key ] ) )
			$value = $this->tmp[ $key ];

		return $value;
	}

}