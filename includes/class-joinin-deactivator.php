<?php
/**
 * Fired during plugin deactivation
 *
 * @link       https://faryan.cloud/joinin
 * @since      3.0.0
 *
 * @package    JoinIN
 * @subpackage JoinIN/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      3.0.0
 * @package    JoinIN
 * @subpackage JoinIN/includes
 * @author     FaryanI.C.  <support@faryan.cloud>
 */
class JoinIN_Deactivator {

	/**
	 * Placeholder for deactivating plugin.
	 */
	public static function deactivate() {
        flush_rewrite_rules();
        wp_cache_delete( 'alloptions', 'options' );
	}

}
