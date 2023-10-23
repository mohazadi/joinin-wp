<?php

/**
 * The widget for the plugin.
 *
 * @link       https://faryan.cloud/joinin
 * @since      3.0.0
 *
 * @package    JoinIN
 * @subpackage JoinIN/public
 */

/**
 * The widget for the plugin.
 *
 * Extends the core widget class for the plugin's custom widget.
 *
 * @package    JoinIN
 * @subpackage JoinIN/public
 * @author     FaryanI.C.  <support@faryan.cloud>
 */
class JoinIN_Public_Widget extends WP_Widget {

	/**
	 * Construct widget.
	 *
	 * @since   3.0.0
	 */
	public function __construct() {
		parent::__construct(
			'joininwidget',
			__( 'Rooms', 'joinin' ),
			array(
				'customize_selective_refresh' => true,
				'description'                 => __( 'Displays a JoinIN login form.', 'joinin' ),
				'panels_icon'                 => 'dashicons dashicons-video-alt2',
			)
		);
	}

	/**
	 * Display the widget.
	 *
	 * @param   Array      $args      List of default values stored for the widget.
	 * @param   Array      $instance  List of custom values store for the widget.
	 */
	public function widget( $args, $instance ) {
		$tokens_string  = isset( $instance['text'] ) ? $instance['text'] : '';
		$author         = isset( $instance['author'] ) ? $instance['author'] : 0;
		$display_helper = new JoinIN_Display_Helper( plugin_dir_path( __FILE__ ) );

		echo $args['before_widget'] . $args['before_title'] . $args['widget_name'] . $args['after_title'];

		echo JoinIN_Tokens_Helper::join_form_from_tokens_string( $display_helper, $tokens_string, $author );

		echo $args['after_widget'];
	}

	/**
	 * Create widget form (for the admin panel).
	 *
	 * @since   3.0.0
	 *
	 * @param   Array   $instance   Existing widget values to show in the widget form.
	 */
	public function form( $instance ) {
		$text_id   = $this->get_field_id( 'text' );
		$text_name = $this->get_field_name( 'text' );

		$text_value = isset( $instance['text'] ) ? $instance['text'] : '';

		include 'partials/joinin-create-widget-display.php';
	}

	/**
	 * Update widget settings.
	 *
	 * @since   3.0.0
	 *
	 * @param   Array   $new_instance  New values for widget.
	 * @param   Array   $old_instance  Previous values for widget.
	 *
	 * @return  Array   $instance      Kept values for widget.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance           = $old_instance;
		$instance['text']   = isset( $new_instance['text'] ) ? wp_strip_all_tags( $new_instance['text'] ) : '';
		$instance['author'] = isset( $old_instance['author'] ) ? $old_instance['author'] : get_current_user_id();
		return $instance;
	}

}
