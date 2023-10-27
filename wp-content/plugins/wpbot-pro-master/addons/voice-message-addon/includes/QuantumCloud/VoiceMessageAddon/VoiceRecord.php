<?php
namespace QuantumCloud\VoiceMessageAddon;

use Exception;
use QuantumCloud\wpbotvoicemessage;
use WP_Post;
use WP_Query;

/** Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

/**
 * SINGLETON: Class used to add qcldwpbot_record post type.
 *
 * @since 1.0.0
 **/
final class VoiceRecord {

	/**
	 * qcldwpbot_record Post Type name.
	 *
	 * @const POST_TYPE
	 * @since 1.0.0
	 **/
	const POST_TYPE = 'qcldwpbot_record';

	/**
	 * The one true VoiceRecord.
	 *
	 * @var VoiceRecord
	 * @since 1.0.0
	 **/
	private static $instance;

	/**
	 * Sets up a new instance.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	private function __construct() {

		/** Fire meta box setup on the post editor screen. */
		add_action( 'load-post.php', [ $this, 'meta_boxes_setup' ] );
		add_action( 'load-post-new.php', [ $this, 'meta_boxes_setup' ] );

		/** Add Transcription and Form columns to VoiceMessageAddon Form list. */
		add_filter( 'manage_' . self::POST_TYPE . '_posts_columns', [$this, 'columns_head'], 10 );
		add_action( 'manage_' . self::POST_TYPE . '_posts_custom_column', [$this, 'columns_body'], 10, 2 );

        /** Rename Publish button to Update. */
		add_filter( 'gettext', [$this, 'change_publish_button'], 10, 2 );

		/** Add new records notification. */
		add_action( 'admin_menu', [$this, 'add_notification'] );

		/** Create filter by Form dropdown. */
		add_action( 'restrict_manage_posts', [$this, 'create_filter_by_form']  );

		/** Filter by Form function. */
		add_filter( 'parse_query', [$this, 'filter_by_form'] );

		/** Remove audio files on remove qcldwpbot_record. */
		add_action( 'before_delete_post', [$this, 'before_delete_post'] );

	}

	/**
	 * Remove old audio on remove qcldwpbot_record.
	 *
	 * @param $post_id - The post id that is being deleted.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public function before_delete_post( $post_id ) {

		/** Process only qcldwpbot_record posts. */
		if ( VoiceRecord::POST_TYPE !== get_post_type( $post_id ) ) { return; }

		/** Get audio file. */
		$audio_file_path = get_post_meta( $post_id, 'qcld_wpvm_vmwbmdp_contacter_audio', true );

		/** Remove audio file. */
		if ( $audio_file_path ) {
			wp_delete_file( $audio_file_path );
		}

        /** Fire event to send email notification on delete. */
		do_action( 'qcldwpbot_record_removed', $post_id );

	}

	/**
	 * If submitted filter by Form.
	 *
	 * @param $query
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return void
	 **/
	public function filter_by_form( $query ) {
		global $pagenow;

		/** Work only for qcldwpbot_record post type. */
		$type = self::POST_TYPE;
		if ( isset( $_GET['post_type'] ) ) {
			$type = $_GET['post_type'];
		}

		/** Modify query to filter records. */
		if (
			self::POST_TYPE === $type &&
			is_admin() &&
			$pagenow ==='edit.php' &&
			isset( $_GET['vmwbmdp-wpbotvoicemessage-filter-by-form'] ) &&
			$_GET['vmwbmdp-wpbotvoicemessage-filter-by-form'] !== ''
		) {
			$query->query_vars['meta_key'] = 'vmwbmdp_cform_id';
			$query->query_vars['meta_value'] = $_GET['vmwbmdp-wpbotvoicemessage-filter-by-form'];
		}

	}

	/**
	 * Create filter by Form dropdown.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return void
	 **/
	public function create_filter_by_form() {

		/** Work only for qcldwpbot_records post type. */
		$type = self::POST_TYPE;
		if ( isset( $_GET['post_type'] ) ) {
			$type = $_GET['post_type'];
		}

		if ( self::POST_TYPE !== $type ) { return; }

		/** Get all VoiceMessageAddon forms. */
		$wp_query = new WP_Query;
		$query = [
			'post_type' => VoiceForm::POST_TYPE,
			'post_status' => ['publish']
		];
		$c_forms = $wp_query->query( $query );

		$values = [];
		foreach ( $c_forms as $c_form ) {
			$values[$c_form->ID] = $c_form->post_title;
		}

		?>
        <!--suppress HtmlFormInputWithoutLabel -->
		<select name="vmwbmdp-wpbotvoicemessage-filter-by-form">
            <option value=""><?php esc_html_e( 'Filter By Form', 'wpbotvoicemessage' ); ?></option>
			<?php
			$current_v = isset( $_GET['vmwbmdp-wpbotvoicemessage-filter-by-form'] ) ? $_GET['vmwbmdp-wpbotvoicemessage-filter-by-form'] : '';
			foreach ( $values as $cform_id => $title ) {
				?>
                <option value="<?php esc_attr_e( $cform_id ); ?>" <?php echo ( $cform_id === $current_v ) ? ' selected' : '' ?>>
					<?php esc_html_e( $title ); ?>
                </option>
				<?php
			}
			?>
        </select>
		<?php
	}

	/**
	 * Add content for Transcription and Form columns.
	 *
	 * @param $column_name
	 * @param $record_id
	 *
	 * @throws Exception
	 * @since  1.0.0
	 * @access public
	 **/
	public function columns_body( $column_name, $record_id ) {

		/** Transcription column. */
		if ( 'vmwbmdp_qcldwpbot_record_transcription' === $column_name ) {

			/** Get VoiceMessageAddon Record Transcription. */
			$transcription = get_post_meta( $record_id, 'vmwbmdp_transcription_txt', true );
            echo wp_kses_post( $transcription );

		}

		/** Form column. */
		if ( 'vmwbmdp_qcldwpbot_record_form' === $column_name ) {

			/** Get VoiceMessageAddon Form ID. */
			$cform_id = get_post_meta( $record_id, 'vmwbmdp_cform_id', true );
			$cform = get_post( $cform_id );
			if ( $cform === null ) { return; }

			?><a class="vmwbmdp-wpbotvoicemessage-record-form" href="<?php echo admin_url( 'post.php?post=' . $cform->ID . '&action=edit&classic-editor' ); ?>"><?php echo esc_html_e( $cform->post_title ); ?></a><?php

		}

	}

	/**
	 * Add Transcription and Form columns.
	 *
	 * @param array $columns
	 *
	 * @return array
	 * @since 1.0.0
	 * @access public
	 **/
	public function columns_head( $columns ) {

		/** Add new column key to the existing columns. */
		//$columns['vmwbmdp_qcldwpbot_record_transcription'] = esc_html__( 'Transcription', 'wpbotvoicemessage' );
		$columns['vmwbmdp_qcldwpbot_record_form'] = esc_html__( 'Form', 'wpbotvoicemessage' );

		/** Define a new order. (•̀o•́)ง */
		$new_order = ['cb', 'title', 'vmwbmdp_qcldwpbot_record_transcription', 'vmwbmdp_qcldwpbot_record_form', 'date'];

		/** Order columns like set in $new_order. */
		$new = [];
		foreach ( $new_order as $col_name ) {
			$new[ $col_name ] = $columns[ $col_name ];
		}

		/** Return a new column array to WordPress. */
		return $new;
	}

	/**
	 * Add new qcldwpbot_record notification.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 **/
	public function add_notification() {
		global $menu;

		/** Count qcldwpbot_records posts. */
		$count = wp_count_posts( self::POST_TYPE );
		$count = $count->pending;

		if ( $count > 0 ) {
			$menu_item = wp_list_filter(
				$menu,
				[2 => 'edit.php?post_type=qcldwpbot_record'] // 2 is the position of an array item which contains URL, it will always be 2!
			);

			if ( ! empty( $menu_item )  ) {
				$menu_item_position = key( $menu_item ); // get the array key (position) of the element
				$menu[ $menu_item_position ][0] .= ' <span class="awaiting-mod">' . $count . '</span>';
			}
        }
	}

	/**
	 * Rename Publish button to Update for VoiceMessageAddon Record.
	 *
	 * @param string $translation - Translated text.
	 * @param string $text - Text to translate.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 **/
	public function change_publish_button( $translation, $text ) {

	    /** Work only with qcldwpbot_record. */
		if ( self::POST_TYPE !== get_post_type() ) { return $translation; }

		if ( $text == 'Publish' ) {
			return 'Update';
        }

		return $translation;
    }

	/**
	 * Meta box setup function.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public function meta_boxes_setup() {

		/** Add meta boxes on the 'add_meta_boxes' hook. */
		add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );

		/** Save meta box values on the 'save_post' hook. */
		add_action( 'save_post', [ $this, 'save_meta_boxes' ], 1, 2 );

	}

	/**
	 * Save meta box values.
	 *
	 * @param $post_id
	 * @param $post
	 *
	 * @return void
	 * @since 1.0.0
	 * @access public
	 **/
	public function save_meta_boxes( $post_id, $post ) {

		/** Work only with contacter_form post type. */
		if ( 'qcldwpbot_record' !== $post->post_type ) { return; }

		/** Verify the nonce before proceeding. */
		if (
			! isset( $_POST['options_metabox_fields_nonce'] ) ||
			! wp_verify_nonce( $_POST['options_metabox_fields_nonce'], wpbotvoicemessage::$basename )
		) {
			return;
		}

		/** Get the post type object. */
		$post_type = get_post_type_object( $post->post_type );

		/** Check if the current user has permission to edit the post. */
		if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) ) { return; }

		/** Save metaboxes with all fields. */
		CROptionsMetaBox::get_instance()->save_metabox( $post_id );

	}

	/**
	 * Create Options, Shortcode and Messages meta boxes to be displayed on VoiceMessageAddon Form editor screen.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public function add_meta_boxes() {

		/** Options metabox. */
		add_meta_box( 'vmwbmdp-options-mbox', esc_html__( 'Record Options', 'wpbotvoicemessage' ), [$this, 'options_metabox'], self::POST_TYPE, 'normal', 'default' );

		/** Notes metabox. */
		add_meta_box( 'vmwbmdp-notes-mbox', esc_html__( 'Private Notes', 'wpbotvoicemessage' ), [$this, 'notes_metabox' ], self::POST_TYPE, 'normal', 'default' );

		/** Form Settings metabox. */
		add_meta_box( 'vmwbmdp-form-settings-mbox', esc_html__( 'Form Settings', 'wpbotvoicemessage' ), [$this, 'form_settings_metabox'], self::POST_TYPE, 'side', 'default' );

	}

	/**
	 * Display Options meta box.
	 *
	 * @param WP_Post $qcldwpbot_record
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 **/
	public function options_metabox( $qcldwpbot_record ) {

		/** Render "Options" metabox with all fields. */
		CROptionsMetaBox::get_instance()->render_metabox( $qcldwpbot_record );

	}

	/**
	 * Display Form Settings meta box.
	 *
	 * @param WP_Post $qcldwpbot_record
	 **/
	public function form_settings_metabox( $qcldwpbot_record ) {

		/** Get VoiceMessageAddon Form for current Record. */
		$cform_id = get_post_meta( $qcldwpbot_record->ID, 'vmwbmdp_cform_id', true );

		?><p><a href="<?php echo admin_url( 'post.php?post=' . $cform_id . '&action=edit&classic-editor' ); ?>"><?php esc_html_e( 'Go to Form Settings', 'wpbotvoicemessage' ); ?></a></p><?php

	}

	/**
	 * Display Notice meta box.
	 *
	 * @param WP_Post $qcldwpbot_record
	 **/
	public function notes_metabox( $qcldwpbot_record ) {

		/** Get Notes Text field value from meta if it's already been entered. */
		$notes = get_post_meta( $qcldwpbot_record->ID, 'vmwbmdp_notes_txt', true );

		/** Default value. */
		if ( empty( $notes ) ) { $notes = ''; }

		wp_editor( $notes, 'vmwbmdpnotestxt', [
			'media_buttons' => 0,
			'teeny' => 1,
			'textarea_rows' => 5,
			'textarea_name' => 'vmwbmdp_notes_txt'
		] );

	}

	/**
	 * Register post type.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public function register_post_type() {

		register_post_type( self::POST_TYPE, [
			'public'              => false,
			'labels'              => [
				'name'                  => esc_html__( 'WPBot Voice Message Records', 'wpbotvoicemessage' ),
				'singular_name'         => esc_html__( 'WPBot Voice Message Records', 'wpbotvoicemessage' ),
				'add_new'               => esc_html__( 'Add New', 'wpbotvoicemessage' ),
				'add_new_item'          => esc_html__( 'Add New', 'wpbotvoicemessage' ),
				'new_item'              => esc_html__( 'New WPBot Voice Message Record', 'wpbotvoicemessage' ),
				'edit_item'             => esc_html__( 'Edit WPBot Voice Message Record', 'wpbotvoicemessage' ),
				'view_item'             => esc_html__( 'View WPBot Voice Message Record', 'wpbotvoicemessage' ),
				'view_items'            => esc_html__( 'View WPBot Voice Message Record', 'wpbotvoicemessage' ),
				'search_items'          => esc_html__( 'Search WPBot Voice Message Records', 'wpbotvoicemessage' ),
				'not_found'             => esc_html__( 'No WPBot Voice Message Records found', 'wpbotvoicemessage' ),
				'not_found_in_trash'    => esc_html__( 'No WPBot Voice Message Records found in Trash', 'wpbotvoicemessage' ),
				'all_items'             => esc_html__( 'Records', 'wpbotvoicemessage' ),
				'archives'              => esc_html__( 'WPBot Voice Message Records Archives', 'wpbotvoicemessage' ),
				'attributes'            => esc_html__( 'WPBot Voice Message Record Attributes', 'wpbotvoicemessage' ),
				'insert_into_item'      => esc_html__( 'Insert to WPBot Voice Message Record', 'wpbotvoicemessage' ),
				'uploaded_to_this_item' => esc_html__( 'Uploaded to this WPBot Voice Message Record', 'wpbotvoicemessage' ),
				'menu_name'             => esc_html__( 'Bot - Voice Messages', 'wpbotvoicemessage' ),
			],
			'menu_icon'             => $this->get_svg_icon(),
			'exclude_from_search'   => true,
			'publicly_queryable'    => false,
			'menu_position'         => false,
			'show_in_rest'          => false,
			'rest_base'             => self::POST_TYPE,
			'supports'              => [ 'title' ],
			'capabilities'          => [ 'create_posts' => false ],
			'map_meta_cap'          => true,
			'show_ui'               => true,
		] );

	}

	/**
	 * Return base64 encoded SVG icon.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public function get_svg_icon() {

		$svg = file_get_contents( wpbotvoicemessage::$path . 'images/logo-menu.svg' );

		return 'data:image/svg+xml;base64,' . base64_encode( $svg );
	}

	/**
	 * Main VoiceRecord Instance.
	 *
	 * Insures that only one instance of VoiceRecord exists in memory at any one time.
	 *
	 * @static
	 * @return VoiceRecord
	 * @since 1.0.0
	 **/
	public static function get_instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof VoiceRecord ) ) {
			self::$instance = new VoiceRecord;
		}

		return self::$instance;
	}

} // End Class VoiceRecord.
