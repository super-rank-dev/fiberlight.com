<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Mailchimp API
 */
if( !class_exists('QCLD_MAILING_LIST_INTEGRATION_MAILCHIMP_API') ){
    class QCLD_MAILING_LIST_INTEGRATION_MAILCHIMP_API
    {

        /**
         * Empty Construct
         */
    	function __construct(){ }

    	/**
         * Get lists
         * @param  string $api_key
         * @return array
         */
        public function get_lists( $api_key ) {

            $api_url = $this->get_api_url($api_key);

            $method = 'lists/?count=100';
            $url = $api_url . $method;

            $list_args = array(
                    'headers' => array(
                        'Content-Type' => 'application/json',
                        'Authorization' => 'apikey ' . $api_key
                    ),
                    'body' => array()
             );

            $response = wp_remote_get( $url, $list_args );

            // test for wp errors
            if( is_wp_error( $response ) ) {

                $request = array(
                            'status' => "error",
                            'message' => "HTTP Error: " . $response->get_error_message()
                         );
                return $request;
            }

            $body = wp_remote_retrieve_body( $response );
            $request = json_decode( $body );

            return $request;
        }

        /**
         * Add or Update List Member
         * @param  string $api_key
         * @param  string $list_id
         * @param  string $user_status
         * @param  array $user_data
         * @return array
         */
        public function update_list_member( $api_key, $list_id, $user_status, $user_data ){
            $api_url = $this->get_api_url($api_key);

            $method = 'lists/'.$list_id.'/members/'.md5($user_data['email']);
            $url = $api_url . $method;

            $body_args = array(
                            'email_address' =>  $user_data['email'],
                            'status_if_new' =>  $user_status,
                            'status'        =>  $user_status,
                            'merge_fields'  => [
                                'FNAME'     => $user_data['name'],
                                'LNAME'     => ''
                            ]
                        );
            $list_args = array(
                    'headers' => array(
                        'Content-Type' => 'application/json',
                        'Authorization' => 'apikey ' . $api_key
                    ),
                    'body'  => json_encode($body_args),
                    'method'=> 'PUT'
             );

            $response = wp_remote_request( $url, $list_args );

            // test for wp errors
            if( is_wp_error( $response ) ) {

                $request = array(
                            'status' => "error",
                            'message' => "HTTP Error: " . $response->get_error_message()
                        );
                return $request;
            }

            $body = wp_remote_retrieve_body( $response );
            $request = json_decode( $body );

            return $request;

        }

        /**
         * Delete List Member
         * @param  string $api_key
         * @param  string $list_id
         * @param  array $user_status
         * @param  array $user_email
         * @return array
         */
        public function unsubscribe_list_member( $api_key, $list_id, $user_status, $user_email ){
            $api_url = $this->get_api_url($api_key);

            $method = 'lists/'.$list_id.'/members/'.md5($user_email);
            $url = $api_url . $method;

            $body_args = array(
                            'email_address' =>  $user_email,
                            'status_if_new' =>  $user_status,
                            'status'        =>  $user_status,
                        );

            $list_args = array(
                    'headers' => array(
                        'Content-Type' => 'application/json',
                        'Authorization' => 'apikey ' . $api_key
                    ),
                    'body'  => json_encode($body_args),
                    'method'=> 'PUT'
             );

            $response = wp_remote_request( $url, $list_args );

            // test for wp errors
            if( is_wp_error( $response ) ) {

                $request = array(
                    'status' => "error",
                    'message' => "HTTP Error: " . $response->get_error_message()
                );
                return $request;
            }

            $body = wp_remote_retrieve_body( $response );
            $request = json_decode( $body );

            return $request;
        }

        public function get_api_url($api_key){
            $api_url = '';
            $dash_position = strpos( $api_key, '-' );
            if( $dash_position !== false ) {
                $api_url = 'https://' . substr( $api_key, $dash_position + 1 ) . '.api.mailchimp.com/3.0/';
            } else {
                $api_url = '';
            }
            return $api_url;
        }
    }
}