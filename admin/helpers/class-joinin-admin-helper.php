<?php
/**
 * The admin helper class.
 *
 * @link       https://faryan.cloud/joinin
 * @since      3.0.0
 *
 * @package    JoinIN
 * @subpackage JoinIN/public/helpers
 */

/**
 * The admin helper class.
 *
 * A list of helper functions that is used across JoinIN admin classes..
 *
 * @package    JoinIN
 * @subpackage JoinIN/public/helpers
 * @author     FaryanI.C.  <support@faryan.cloud>
 */
class JoinIN_Admin_Helper {

	/**
	 * Generate random alphanumeric string.
	 *
	 * @since   3.0.0
	 *
	 * @param   Integer $length         Length of random string.
	 * @return  String  $default_code   The resulting random string.
	 */
	public static function generate_random_code( $length = 10 ) {
		$default_code = bin2hex( random_bytes( $length / 2 ) );
		return $default_code;
	}
}
