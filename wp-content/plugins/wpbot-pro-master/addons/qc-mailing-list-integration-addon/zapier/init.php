<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Zapier Class
 */
if( !class_exists('QCLD_MAILING_LIST_INTEGRATION_ZAPIER') ){
	class QCLD_MAILING_LIST_INTEGRATION_ZAPIER
	{
		function __construct(){
			add_action('qcld_mailing_list_subscription_success', array($this, 'send_data_to_zapier_webhook'), 10, 2 );

			add_action( 'init', array($this, 'qcld_mailing_list_integration_zapier_post_type') );
			add_action( 'add_meta_boxes', array($this,'qc_mailing_list_zapier_metaboxes'), 10 );
			add_action('save_post', array($this, 'qc_mailing_list_zapier_meta_save'));
		}

		public function send_data_to_zapier_webhook( $name, $email ){
			$body_args = array(
                            'name' =>  $name,
                            'email' =>  $email,
                        );
            $args = array(
                    'headers' => array(
                        'Content-Type' => 'application/json',
                    ),
                    'body'  => json_encode($body_args),
            );

            $zaps = new WP_Query(array(
				'post_type'	=> 'qc_mlist_zapier'
			));

			if($zaps->have_posts()){
				while( $zaps->have_posts() ){
					$zaps->the_post();
					$zap_url = get_post_meta(get_the_ID(), 'qc_mailing_list_zapier_webhook_url', true);
					if( isset($zap_url) && !empty( $zap_url ) ){
            			$response = wp_remote_post( $zap_url, $args );
					}
				}
				wp_reset_postdata();
			}

		}

		/**
		 * Register new custom post type - qcichart
		 *
		 * @param void
		 *
		 * @return null
		 */
		function qcld_mailing_list_integration_zapier_post_type(){
			$zapier_integration_labels = array(
				'name'               => _x( 'Manage Zapier Integrations', 'qc-mailing-list-integration' ),
				'singular_name'      => _x( 'Manage Zapier Integration', 'qc-mailing-list-integration' ),
				'add_new'            => _x( 'New Zapier Integration', 'qc-mailing-list-integration' ),
				'add_new_item'       => __( 'Add New Zapier Integration','qc-mailing-list-integration' ),
				'edit_item'          => __( 'Edit Zapier Integration','qc-mailing-list-integration' ),
				'new_item'           => __( 'New Zapier Integration','qc-mailing-list-integration' ),
				'all_items'          => __( 'Manage Zapier Integration','qc-mailing-list-integration' ),
				'view_item'          => __( 'View Zapier Integration','qc-mailing-list-integration' ),
				'search_items'       => __( 'Search Zapier Integration','qc-mailing-list-integration' ),
				'not_found'          => __( 'No Zapier Integration found','qc-mailing-list-integration' ),
				'not_found_in_trash' => __( 'No Zapier Integration found in the Trash','qc-mailing-list-integration' ), 
				'parent_item_colon'  => '',
				'menu_name'          => __('Zapier Integrations','qc-mailing-list-integration')
			);

			$zapier_integration_args = array(
				'labels'        => $zapier_integration_labels,
				'description'   => __('You can see all of your Zapier Integration here','qc-mailing-list-integration'),
				'public'        => true,
				'menu_position' => 25,
				'exclude_from_search' => true,
				'show_in_nav_menus' => false,
				'show_in_menu' => 'qc-mailing-list-integration',
				'supports'      => array( 'title' ),
				'has_archive'   => true,
				'menu_icon' 	=> 'dashicons-chart-area',
			);

			register_post_type( 'qc_mlist_zapier', $zapier_integration_args );	
		}

		/**
		 * Add Metabox to Zapier Integration Post Type
		 */
		public function qc_mailing_list_zapier_metaboxes(){
			add_meta_box(
				'qcld_mailing_list_zapier_info_metaboxes',
				esc_html__('Configure', 'qc-mailing-list-integration'),
				array($this, 'qcld_mailing_list_zapier_info_metaboxes_func'),
				'qc_mlist_zapier',
				'normal',
				'high'
			);
		}

		/**
		 * Callback Function for Metabox of zapier Campaign
		 */
		public function qcld_mailing_list_zapier_info_metaboxes_func($post){
			$post_id = absint($post->ID);
			$zapier_webhook_url = get_post_meta( $post_id, 'qc_mailing_list_zapier_webhook_url', true );
			require_once( QCLD_MAILING_LIST_INTEGRATION_ADDON_DIR.'/zapier/metaboxes/zapier-integration-info.php' );
			wp_nonce_field( 'qc_mailing_list_zapier_info_nonce', 'qc_mailing_list_zapier_info' );
		}

		/**
		 * Metabox Save Function for zapier Campaign
		 */
		public function qc_mailing_list_zapier_meta_save( $post_id ){
			if ( !isset($_POST['qc_mailing_list_zapier_info']) || !wp_verify_nonce( $_POST['qc_mailing_list_zapier_info'], 'qc_mailing_list_zapier_info_nonce' ) ){
				return;
			}

			if ( !current_user_can('edit_post', $post_id) ){
				return $post_id;
			}

			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
				return;
			}

			if( isset($_POST['qc_mailing_list_zapier_webhook_url']) ) {
				update_post_meta( $post_id, 'qc_mailing_list_zapier_webhook_url', sanitize_text_field($_POST['qc_mailing_list_zapier_webhook_url']) );
			}

		}
	}
}