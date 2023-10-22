<?php
/**
 * The shortcode for the plugin.
 *
 * @link       https://faryan.cloud/joinin
 * @since      3.0.0
 *
 * @package    JoinIN
 * @subpackage JoinIN/public
 */

/**
 * The shortcode for the plugin.
 *
 * Registers the shortcode and handles displaying the shortcode.
 *
 * @package    JoinIN
 * @subpackage JoinIN/public
 * @author     FaryanI.C.  <support@faryan.cloud>
 */
class JoinIN_Public_Shortcode {

	/**
	 * Register joinin shortcodes.
	 *
	 * @since   3.0.0
	 */
	public function register_shortcodes() {
		add_shortcode( 'joinin', array( $this, 'display_joinin_shortcode' ) );
		add_shortcode( 'joinin_recordings', array( $this, 'display_joinin_old_recordings_shortcode' ) );
	}

	/**
	 * Handle shortcode attributes.
	 *
	 * @since   3.0.0
	 *
	 * @param   Array  $atts       Parameters in the shortcode.
	 * @param   String $content    Content of the shortcode.
	 *
	 * @return  String $content    Content of the shortcode with rooms and recordings.
	 */
	public function display_joinin_shortcode( $atts = [], $content = null ) {
		global $pagenow;
		$type           = 'room';
		$author         = (int) get_the_author_meta( 'ID' );
		$display_helper = new JoinIN_Display_Helper( plugin_dir_path( __FILE__ ) );

		if ( ! JoinIN_Tokens_Helper::can_display_room_on_page() ) {
			return $content;
		}

		if ( array_key_exists( 'type', $atts ) && 'recording' == $atts['type'] ) {
			$type = 'recording';
			unset( $atts['type'] );
		}

		$tokens_string = JoinIN_Tokens_Helper::get_token_string_from_atts( $atts );

		if ( 'room' == $type ) {
			$content .= JoinIN_Tokens_Helper::join_form_from_tokens_string( $display_helper, $tokens_string, $author );
		} elseif ( 'recording' == $type ) {
			$content .= JoinIN_Tokens_Helper::recordings_table_from_tokens_string( $display_helper, $tokens_string, $author );
		}
		return $content;
	}

	/**
	 * Shows recordings for the old recordings shortcode format.
	 *
	 * @since   3.0.0
	 * @param   Array  $atts       Parameters in the shortcode.
	 * @param   String $content    Content of the shortcode.
	 *
	 * @return  String $content    Content of the shortcode with recordings.
	 */
	public function display_joinin_old_recordings_shortcode( $atts = [], $content = null ) {
		$atts['type'] = 'recording';
		return $this->display_joinin_shortcode( $atts, $content );
	}
}
