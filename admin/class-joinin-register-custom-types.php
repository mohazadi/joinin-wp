<?php
/**
 * Registration of necessary components for the plugin.
 *
 * @link       https://faryan.cloud/joinin
 * @since      3.0.0
 *
 * @package    JoinIN
 * @subpackage JoinIN/admin
 */

/**
 * Registration of necessary components for the plugin.
 *
 * Registers rooms, room categories, and metaboxes for the rooms.
 *
 * @package    JoinIN
 * @subpackage JoinIN/admin
 * @author     FaryanI.C.  <support@faryan.cloud>
 */
class JoinIN_Register_Custom_Types {

	/**
	 * Register room as custom post.
	 *
	 * @since   3.0.0
	 */
	public function bbb_room_as_post_type() {
		register_post_type(
			'bbb-room',
			array(
				'public'          => true,
				'show_ui'         => true,
				'labels'          => array(
					'name'                     => __( 'Rooms', 'joinin' ),
					'add_new'                  => __( 'Add New', 'joinin' ),
					'add_new_item'             => __( 'Add New Room', 'joinin' ),
					'edit_item'                => __( 'Edit Room', 'joinin' ),
					'new_item'                 => __( 'New Room', 'joinin' ),
					'view_item'                => __( 'View Room', 'joinin' ),
					'view_items'               => __( 'View Rooms', 'joinin' ),
					'search_items'             => __( 'Search Rooms', 'joinin' ),
					'not_found'                => __( 'No rooms found', 'joinin' ),
					'not_found_in_trash'       => __( 'No rooms found in trash', 'joinin' ),
					'all_items'                => __( 'All Rooms', 'joinin' ),
					'archives'                 => __( 'Room Archives', 'joinin' ),
					'attributes'               => __( 'Room Attributes', 'joinin' ),
					'insert_into_item'         => __( 'Insert into room', 'joinin' ),
					'uploaded_to_this_item'    => __( 'Uploaded to this room', 'joinin' ),
					'filter_items_list'        => __( 'Filter rooms list', 'joinin' ),
					'items_list_navigation'    => __( 'Rooms list navigation', 'joinin' ),
					'items_list'               => __( 'Rooms list', 'joinin' ),
					'item_published'           => __( 'Room published', 'joinin' ),
					'item_published_privately' => __( 'Room published privately', 'joinin' ),
					'item_reverted_to_draft'   => __( 'Room reverted to draft', 'joinin' ),
					'item_scheduled'           => __( 'Room scheduled', 'joinin' ),
					'item_updated'             => __( 'Room updated', 'joinin' ),
				),
				'taxonomies'      => array( 'bbb-room-category' ),
				'capability_type' => 'bbb_room',
				'has_archive'     => true,
				'supports'        => array( 'title', 'editor' ),
				'rewrite'         => array( 'slug' => 'bbb-room' ),
				'show_in_menu'    => 'bbb_room',
				'map_meta_cap'    => true,
				// Enables block editing in the rooms editor.
				'show_in_rest'    => true,
				'supports'        => array( 'title', 'editor', 'author', 'thumbnail', 'permalink' ),
			)
		);
	}

	/**
	 * Register category as custom taxonomy.
	 *
	 * @since   3.0.0
	 */
	public function bbb_room_category_as_taxonomy_type() {
		register_taxonomy(
			'bbb-room-category',
			array( 'bbb-room' ),
			array(
				'labels'       => array(
					'name'          => __( 'Categories' ),
					'singular_name' => __( 'Category' ),
				),
				'hierarchical' => true,
				'query_var'    => true,
				'show_in_ui'   => true,
				'show_in_menu' => 'bbb_room',
				'show_in_rest' => true,
			)
		);
	}

	/**
	 * Create moderator and viewer code metaboxes on room creation and edit.
	 *
	 * @since   3.0.0
	 */
	public function register_room_code_metaboxes() {
		add_meta_box( 'bbb-moderator-code', __( 'Moderator Code', 'joinin' ), array( $this, 'display_moderator_code_metabox' ), 'bbb-room' );
		add_meta_box( 'bbb-viewer-code', __( 'Viewer Code', 'joinin' ), array( $this, 'display_viewer_code_metabox' ), 'bbb-room' );
	}

	/**
	 * Show recordable option in room creation to users who have the corresponding capability.
	 *
	 * @since   3.0.0
	 */
	public function register_record_room_metabox() {
		if ( current_user_can( 'create_recordable_bbb_room' ) ) {
			add_meta_box( 'bbb-room-recordable', __( 'Recordable', 'joinin' ), array( $this, 'display_allow_record_metabox' ), 'bbb-room' );
		}
	}

	/**
	 * Show wait for moderator option in room creation.
	 *
	 * @since   3.0.0
	 */
	public function register_wait_for_moderator_metabox() {
		add_meta_box( 'bbb-room-wait-for-moderator', __( 'Wait for Moderator', 'joinin' ), array( $this, 'display_wait_for_mod_metabox' ), 'bbb-room' );
	}

	/**
	 * Display moderator code metabox.
	 *
	 * @since   3.0.0
	 *
	 * @param   Object $object     The object that has the room ID.
	 */
	public function display_moderator_code_metabox( $object ) {
		$entry_code       = JoinIN_Admin_Helper::generate_random_code();
		$entry_code_label = __( 'Moderator Code', 'joinin' );
		$entry_code_name  = 'bbb-moderator-code';
		$existing_value   = get_post_meta( $object->ID, 'bbb-room-moderator-code', true );
		wp_nonce_field( 'bbb-room-moderator-code-nonce', 'bbb-room-moderator-code-nonce' );
		require 'partials/joinin-room-code-metabox-display.php';
	}

	/**
	 * Display viewer code metabox.
	 *
	 * @since   3.0.0
	 *
	 * @param   Object $object     The object that has the room ID.
	 */
	public function display_viewer_code_metabox( $object ) {
		$entry_code       = JoinIN_Admin_Helper::generate_random_code();
		$entry_code_label = __( 'Viewer Code', 'joinin' );
		$entry_code_name  = 'bbb-viewer-code';
		$existing_value   = get_post_meta( $object->ID, 'bbb-room-viewer-code', true );
		wp_nonce_field( 'bbb-room-viewer-code-nonce', 'bbb-room-viewer-code-nonce' );
		require 'partials/joinin-room-code-metabox-display.php';
	}

	/**
	 * Display wait for moderator metabox.
	 *
	 * @since   3.0.0
	 *
	 * @param   Object $object     The object that has the room ID.
	 */
	public function display_wait_for_mod_metabox( $object ) {
		$existing_value = get_post_meta( $object->ID, 'bbb-room-wait-for-moderator', true );
		wp_nonce_field( 'bbb-room-wait-for-moderator-nonce', 'bbb-room-wait-for-moderator-nonce' );
		require 'partials/joinin-wait-for-mod-metabox-display.php';
	}

	/**
	 * Display recordable metabox.
	 *
	 * @since   3.0.0
	 *
	 * @param   Object $object     The object that has the room ID.
	 */
	public function display_allow_record_metabox( $object ) {
		$existing_value = get_post_meta( $object->ID, 'bbb-room-recordable', true );

		wp_nonce_field( 'bbb-room-recordable-nonce', 'bbb-room-recordable-nonce' );
		require 'partials/joinin-recordable-metabox-display.php';
	}
}
