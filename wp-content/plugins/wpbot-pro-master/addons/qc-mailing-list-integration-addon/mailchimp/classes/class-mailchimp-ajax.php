<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * MailChimp Ajax Class
 */
if( !class_exists('QCLD_MAILING_LIST_MAILCHIMP_AJAX') ){
	class QCLD_MAILING_LIST_MAILCHIMP_AJAX
	{
		
		public $Mailing_List_Mailchimp_API;

		function __construct()
		{
			$this->Mailing_List_Mailchimp_API = new QCLD_MAILING_LIST_INTEGRATION_MAILCHIMP_API();
			add_action('wp_ajax_qcwbmc_subscription_mailchimp_get_lists', array( $this, 'get_lists') );
		}

		/**
		 * Get all Lists from mailchimp
		 */
		public function get_lists(){

			check_ajax_referer( 'qcld-mailing-list-mailchimp-ajax-nonce', 'ajax_nonce' );

			$mailchimp_api_key = sanitize_text_field($_POST['api_key']);
			$post_id = intval($_POST['post_id']);

			$lists = $this->Mailing_List_Mailchimp_API->get_lists($mailchimp_api_key);
			$mc_lists = [];

			if( count($lists->lists) > 0){
				foreach ( $lists->lists as $offset => $value) {
					$mc_lists[$value->id] = $value->name;
				}
			}
			echo wp_send_json($lists);
			wp_die();
		}
	}

	new QCLD_MAILING_LIST_MAILCHIMP_AJAX();
}