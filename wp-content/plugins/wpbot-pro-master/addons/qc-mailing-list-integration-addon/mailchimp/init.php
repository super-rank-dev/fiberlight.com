<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once( QCLD_MAILING_LIST_INTEGRATION_ADDON_DIR.'/mailchimp/classes/class-mailchimp-api.php' );
require_once( QCLD_MAILING_LIST_INTEGRATION_ADDON_DIR.'/mailchimp/classes/class-mailchimp-ajax.php' );

/**
 * MailChimp Class
 */
if( !class_exists('QCLD_MAILING_LIST_INTEGRATION_MAILCHIMP') ){
	class QCLD_MAILING_LIST_INTEGRATION_MAILCHIMP
	{
		public $Mailing_List_Mailchimp_API;

		function __construct()
		{
			$this->Mailing_List_Mailchimp_API = new QCLD_MAILING_LIST_INTEGRATION_MAILCHIMP_API();

			add_action('admin_enqueue_scripts', array($this, 'qcld_mailing_list_mailchimp_admin_script'));
			add_action('qcld_mailing_list_subscription_success', array($this, 'add_subscriber_to_mailchimp'), 10, 2 );
			add_action('qcld_mailing_list_unsubscription_by_user', array($this, 'unsubscribe_by_user'), 10, 1 );
			add_action('qcld_mailing_list_unsubscription_by_admin', array($this, 'unsubscribe_by_admin'), 10, 2 );

			add_action( 'init', array($this, 'qcld_mailing_list_integration_mailchimp_post_type') );
			add_action( 'add_meta_boxes', array($this,'qc_mailing_list_mailchimp_metaboxes'), 10 );
			add_action('save_post', array($this, 'qc_mailing_list_mailchimp_meta_save'));
		}

		/*
		 * Add Subscriber to mailchimp
		 */
		public function add_subscriber_to_mailchimp( $name, $email ){
			$lists = new WP_Query(array(
				'post_type'	=> 'qc_mlist_mailchimp'
			));

			$user_data = [];
			$user_data['name'] = $name;
			$user_data['email'] = $email;
			$user_status = 'subscribed';

			if($lists->have_posts()){
				while( $lists->have_posts() ){
					$lists->the_post();
					$list_id = get_post_meta(get_the_ID(), 'qc_mailing_list_mailchimp_list_id', true);
					$api_key = get_post_meta(get_the_ID(), 'qc_mailing_list_mailchimp_api_key', true);
					if( !empty( $api_key ) && !empty($list_id) ){
						$add_mailchimp_subscriber = $this->Mailing_List_Mailchimp_API->update_list_member( $api_key, $list_id, $user_status, $user_data );
					}
				}
				wp_reset_postdata();
			}
		}

		/**
		 * Unsubscribe from Mailchimp by user
		 */
		public function unsubscribe_by_user($user_email){
			$lists = new WP_Query(array(
				'post_type'	=> 'qc_mlist_mailchimp'
			));

			$user_status = 'unsubscribed';

			if($lists->have_posts()){
				while( $lists->have_posts() ){
					$lists->the_post();
					$list_id = get_post_meta(get_the_ID(), 'qc_mailing_list_mailchimp_list_id', true);
					$api_key = get_post_meta(get_the_ID(), 'qc_mailing_list_mailchimp_api_key', true);
					if( !empty( $api_key ) && !empty($list_id) ){
						$delete_mailchimp_subscriber = $this->Mailing_List_Mailchimp_API->unsubscribe_list_member( $api_key, $list_id, $user_status, $user_email );
					}
				}
				wp_reset_postdata();
			}
		}

		/**
		 * Unsubscribe from Mailchimp by Admin
		 */
		public function unsubscribe_by_admin( $id, $table ){
			$lists = new WP_Query(array(
				'post_type'	=> 'qc_mlist_mailchimp'
			));

			$user_status = 'unsubscribed';

			global $wpdb;

    		$user_info = $wpdb->get_results(
    						$wpdb->prepare(
    							"SELECT * FROM $table WHERE id=%d", $id
    						)
    					);
    		$user_email = '';
    		foreach ($user_info as $user_key => $user) {
    			$user_email = $user->email;
    		}

			if($lists->have_posts()){
				while( $lists->have_posts() ){
					$lists->the_post();
					$list_id = get_post_meta(get_the_ID(), 'qc_mailing_list_mailchimp_list_id', true);
					$api_key = get_post_meta(get_the_ID(), 'qc_mailing_list_mailchimp_api_key', true);
					if( !empty( $api_key ) && !empty($list_id) ){
						$delete_mailchimp_subscriber = $this->Mailing_List_Mailchimp_API->unsubscribe_list_member( $api_key, $list_id, $user_status, $user_email );
					}
				}
				wp_reset_postdata();
			}
		}

		/**
		 * Enqueue Admin Scripts for Mailchimp
		 */
		public function qcld_mailing_list_mailchimp_admin_script(){
			global $post;
			global $pagenow;
			if (( $pagenow == 'post.php' ) && (get_post_type() == 'qc_mlist_mailchimp')) {
				if( (isset($post->ID)) && (absint($post->ID) > 0) ){
					$postID = absint($post->ID);
				}else{
					$postID = '';
				}

				$ajax_nonce = wp_create_nonce( "qcld-mailing-list-mailchimp-ajax-nonce" );
				$selected_list_id = get_post_meta( $post->ID, 'qc_mailing_list_mailchimp_list_id', true );
				if( !$selected_list_id ){
					$selected_list_id = 0;
				}

				wp_enqueue_script( 'qcld_mailing_list_mailchimp_admin_script', QCLD_MAILING_LIST_INTEGRATION_ADDON_URL.'/mailchimp/assets/js/admin.js', array('jquery'), QCLD_MAILING_LIST_INTEGRATION_ADDON_VERSION, true );

				wp_localize_script( 'qcld_mailing_list_mailchimp_admin_script', 'qcld_mailing_list_mailchimp_admin_ajax_object', array(
						'ajax_url' => admin_url( 'admin-ajax.php' ),
						'post_id' => $postID,
						'selected_list_id' => $selected_list_id,
						'mailchimp_ajax_nonce'	=> $ajax_nonce
					)
				);
			}
		}

		/**
		 * Register new custom post type - qcichart
		 *
		 * @param void
		 *
		 * @return null
		 */
		public function qcld_mailing_list_integration_mailchimp_post_type(){
			$mailchimp_campaign_labels = array(
				'name'               => _x( 'Manage Mailchimp Campaigns', 'qc-mailing-list-integration' ),
				'singular_name'      => _x( 'Manage Mailchimp Campaign', 'qc-mailing-list-integration' ),
				'add_new'            => _x( 'New Mailchimp Campaign', 'qc-mailing-list-integration' ),
				'add_new_item'       => __( 'Add New Mailchimp Campaign','qc-mailing-list-integration' ),
				'edit_item'          => __( 'Edit Mailchimp Campaign','qc-mailing-list-integration' ),
				'new_item'           => __( 'New Mailchimp Campaign','qc-mailing-list-integration' ),
				'all_items'          => __( 'Manage Mailchimp Campaign','qc-mailing-list-integration' ),
				'view_item'          => __( 'View Mailchimp Campaign','qc-mailing-list-integration' ),
				'search_items'       => __( 'Search Mailchimp Campaign','qc-mailing-list-integration' ),
				'not_found'          => __( 'No Mailchimp Campaign found','qc-mailing-list-integration' ),
				'not_found_in_trash' => __( 'No Mailchimp Campaign found in the Trash','qc-mailing-list-integration' ), 
				'parent_item_colon'  => '',
				'menu_name'          => __('Mailchimp Campaigns','qc-mailing-list-integration')
			);

			$mailchimp_campaign_args = array(
				'labels'        => $mailchimp_campaign_labels,
				'description'   => __('You can see all of your Mailchimp Campaign here','qc-mailing-list-integration'),
				'public'        => true,
				'menu_position' => 25,
				'exclude_from_search' => true,
				'show_in_nav_menus' => false,
				'show_in_menu' => 'qc-mailing-list-integration',
				'supports'      => array( 'title' ),
				'has_archive'   => true,
				'menu_icon' 	=> 'dashicons-chart-area',
			);

			register_post_type( 'qc_mlist_mailchimp', $mailchimp_campaign_args );	
		}

		/**
		 * Add Metabox to Mailchimp Campaign Post Type
		 */
		public function qc_mailing_list_mailchimp_metaboxes(){
			add_meta_box(
				'qcld_mailing_list_mailchimp_campaign_info_metaboxes',
				esc_html__('Campaign Info', 'qc-mailing-list-integration'),
				array($this, 'qcld_mailing_list_mailchimp_campaign_info_metaboxes_func'),
				'qc_mlist_mailchimp',
				'normal',
				'high'
			);
		}

		/**
		 * Callback Function for Metabox of Mailchimp Campaign
		 */
		public function qcld_mailing_list_mailchimp_campaign_info_metaboxes_func($post){
			$post_id = absint($post->ID);
			$mailchimp_api_key = get_post_meta( $post_id, 'qc_mailing_list_mailchimp_api_key', true );
			require_once( QCLD_MAILING_LIST_INTEGRATION_ADDON_DIR.'/mailchimp/metaboxes/mailchimp-campaign-info.php' );
			wp_nonce_field( 'qc_mailing_list_mailchimp_campaign_info_nonce', 'qc_mailing_list_mailchimp_campaign_info' );
		}

		/**
		 * Metabox Save Function for Mailchimp Campaign
		 */
		public function qc_mailing_list_mailchimp_meta_save( $post_id ){
			if ( !isset($_POST['qc_mailing_list_mailchimp_campaign_info']) || !wp_verify_nonce( $_POST['qc_mailing_list_mailchimp_campaign_info'], 'qc_mailing_list_mailchimp_campaign_info_nonce' ) ){
				return;
			}

			if ( !current_user_can('edit_post', $post_id) ){
				return $post_id;
			}

			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
				return;
			}

			if( isset($_POST['qc_mailing_list_mailchimp_api_key']) ) {
				update_post_meta( $post_id, 'qc_mailing_list_mailchimp_api_key', sanitize_text_field($_POST['qc_mailing_list_mailchimp_api_key']) );
			}

			if( isset($_POST['qc_mailing_list_mailchimp_list_id']) ) {
				update_post_meta( $post_id, 'qc_mailing_list_mailchimp_list_id', sanitize_text_field($_POST['qc_mailing_list_mailchimp_list_id']) );
			}else{
				delete_post_meta( $post_id, 'qc_mailing_list_mailchimp_list_id' );
			}
		}
	}
}