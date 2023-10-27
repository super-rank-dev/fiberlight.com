<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
/*
* @package Dialogflow API V2 by QuantumCloud 
* @Since 9.1.2
*/


class Qcld_wpbot_dfv2
{
    public function __construct(){
        
        add_action('init', array($this, 'api'));
    }
    public function api(){

        if(isset($_GET['action']) && $_GET['action']=='qcld_dfv2_api'){
            $session_id = 'asd2342sde';
            $language = get_option('qlcd_wp_chatbot_dialogflow_agent_language');
            //project ID
            $project_ID = get_option('qlcd_wp_chatbot_dialogflow_project_id');
            // Service Account Key json file
            $JsonFileContents = get_option('qlcd_wp_chatbot_dialogflow_project_key');
            if($project_ID==''){
                echo json_encode(array('error'=>'Project ID is empty'));exit;
            }
            if($JsonFileContents==''){
                echo json_encode(array('error'=>'Key is empty'));exit;
            }
            if(!isset($_POST['dfquery']) || $_POST['dfquery']==''){
                echo json_encode(array('error'=>'Query text is not added!'));exit;
            }
            $query = sanitize_text_field($_POST['dfquery']);
            if(isset($_POST['sessionid']) && $_POST['sessionid']!=''){
                $session_id = sanitize_text_field($_POST['sessionid']);
            }
            

            if(file_exists(QCLD_wpCHATBOT_GC_DIRNAME.'/autoload.php')){

                require(QCLD_wpCHATBOT_GC_DIRNAME.'/autoload.php');

                $client = new \Google_Client();
                $client->useApplicationDefaultCredentials();
                $client->setScopes (['https://www.googleapis.com/auth/dialogflow']);
                // Convert to array 
                $array = json_decode($JsonFileContents, true);
                $client->setAuthConfig($array);
    
                try {
                    $httpClient = $client->authorize();
                    $apiUrl = "https://dialogflow.googleapis.com/v2/projects/{$project_ID}/agent/sessions/{$session_id}:detectIntent";
    
                    $response = $httpClient->request('POST', $apiUrl, [
                        'json' => ['queryInput' => ['text' => ['text' => $query, 'languageCode' => $language]],
                            'queryParams' => ['timeZone' => '']]
                    ]);
                    
                    $contents = $response->getBody()->getContents();
                    echo $contents;exit;
    
                }catch(Exception $e) {
                    echo json_encode(array('error'=>$e->getMessage()));exit;
                }

            }else{
                echo json_encode(array('error'=>'API client not found'));exit;
            }

        }

    }
}
new Qcld_wpbot_dfv2();


add_action( 'rest_api_init', function () {
    register_rest_route( 'wpbot/v1', '/dialogflow_api/', array(
      'methods' => 'POST',
      'callback' => 'qc_wpbot_dfcallback',
      'permission_callback' => '__return_true'
    ) );
  } );

  function qc_wpbot_dfcallback($request){


    $postdata = $request->get_body_params();


    $session_id = 'asd2342sde';
    $language = get_option('qlcd_wp_chatbot_dialogflow_agent_language');
    //project ID
    $project_ID = get_option('qlcd_wp_chatbot_dialogflow_project_id');
    // Service Account Key json file
    $JsonFileContents = get_option('qlcd_wp_chatbot_dialogflow_project_key');
    if($project_ID==''){
        echo json_encode(array('error'=>'Project ID is empty'));exit;
    }
    if($JsonFileContents==''){
        echo json_encode(array('error'=>'Key is empty'));exit;
    }
    if(!isset($postdata['dfquery']) || $postdata['dfquery']==''){
        echo json_encode(array('error'=>'Query text is not added!'));exit;
    }
    $query = sanitize_text_field($postdata['dfquery']);
    if(isset($postdata['sessionid']) && $postdata['sessionid']!=''){
        $session_id = sanitize_text_field($postdata['sessionid']);
    }
    

    if(file_exists(QCLD_wpCHATBOT_GC_DIRNAME.'/autoload.php')){

        require(QCLD_wpCHATBOT_GC_DIRNAME.'/autoload.php');

        $client = new \Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->setScopes (['https://www.googleapis.com/auth/dialogflow']);
        // Convert to array 
        $array = json_decode($JsonFileContents, true);
        $client->setAuthConfig($array);

        try {
            $httpClient = $client->authorize();
            $apiUrl = "https://dialogflow.googleapis.com/v2/projects/{$project_ID}/agent/sessions/{$session_id}:detectIntent";

            $response = $httpClient->request('POST', $apiUrl, [
                'json' => ['queryInput' => ['text' => ['text' => $query, 'languageCode' => $language]],
                    'queryParams' => ['timeZone' => '']]
            ]);
            
            $contents = $response->getBody()->getContents();
            echo $contents;exit;

        }catch(Exception $e) {
            echo json_encode(array('error'=>$e->getMessage()));exit;
        }

    }else{
        echo json_encode(array('error'=>'API client not found'));exit;
    }
  }

add_action('wp_ajax_qcld_wp_df_api_call', 'qcld_wp_df_api_call');
add_action('wp_ajax_nopriv_qcld_wp_df_api_call', 'qcld_wp_df_api_call');
function qcld_wp_df_api_call(){
    $session_id = 'asd2342sde';
    
    if(isset($_POST['language']) && $_POST['language']!='' ){
        $lang = $_POST['language'];
    }else{
        $lang = get_wpbot_locale();
    }

    $language = get_option('qlcd_wp_chatbot_dialogflow_agent_language');
    if( $language && is_array( $language ) && array_key_exists( $lang, $language ) ){
        $language = $language[$lang];
    }
    //project ID
    $project_ID = get_option('qlcd_wp_chatbot_dialogflow_project_id');
    if( $project_ID && is_array( $project_ID ) && array_key_exists( $lang, $project_ID ) ){
        $project_ID = $project_ID[$lang];
    }
    // Service Account Key json file
    $JsonFileContents = get_option('qlcd_wp_chatbot_dialogflow_project_key');
    if( $JsonFileContents && is_array( $JsonFileContents ) && array_key_exists( $lang, $JsonFileContents ) ){
        $JsonFileContents = $JsonFileContents[$lang];
    }

    if($project_ID==''){
        echo json_encode(array('error'=>'Project ID is empty'));exit;
    }
    if($JsonFileContents==''){
        echo json_encode(array('error'=>'Key is empty'));exit;
    }
    if(!isset($_POST['dfquery']) || $_POST['dfquery']==''){
        echo json_encode(array('error'=>'Query text is not added!'));exit;
    }
    $query = sanitize_text_field($_POST['dfquery']);

    if(isset($_POST['sessionid']) && $_POST['sessionid']!=''){
        $session_id = sanitize_text_field($_POST['sessionid']);
    }
    
    if(file_exists(QCLD_wpCHATBOT_GC_DIRNAME.'/autoload.php')){

        require(QCLD_wpCHATBOT_GC_DIRNAME.'/autoload.php');

        $client = new \Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->setScopes (['https://www.googleapis.com/auth/dialogflow']);
        // Convert to array 
        $array = json_decode($JsonFileContents, true);
        $client->setAuthConfig($array);

        try {
            $httpClient = $client->authorize();
            $apiUrl = "https://dialogflow.googleapis.com/v2beta1/projects/{$project_ID}/agent/sessions/{$session_id}:detectIntent";

			$kbUrl = "https://dialogflow.googleapis.com/v2beta1/projects/{$project_ID}/knowledgeBases";
			$bkresponse = $httpClient->request('GET', $kbUrl);
			$kbcontents = $bkresponse->getBody()->getContents();
			$datakb = json_decode($kbcontents, true);
			$kbs = array();
			if(isset($datakb['knowledgeBases']) && ! empty($datakb['knowledgeBases'])){
				foreach($datakb['knowledgeBases'] as $kb){
					$kbs[] = $kb['name'];
				}
			}
			
			$query = [
                'json' => [
					'queryInput' => [
						'text' => [
							'text' 			=> $query, 
							'languageCode' 	=> $language
						],
					],
                    'queryParams' => [
						'timeZone' 				=> '',
						'knowledgeBaseNames'	=> $kbs
					]
				]
            ];
			
            $response = $httpClient->request('POST', $apiUrl, $query);
            
            $contents = $response->getBody()->getContents();
            $conver_array = json_decode( $contents, true );
            if ( isset( $conver_array['error'] ) ) {
                $dialogflow_cx = maybe_unserialize(get_option( 'qlcd_wp_chatbot_dialogflow_cx' ));
                if( $dialogflow_cx && is_array( $dialogflow_cx ) && array_key_exists( $lang, $dialogflow_cx ) ){
                    echo json_encode(qcld_wpbot_df_cx_agent( true, $lang ));exit;
                } else {
                    echo $contents;exit;
                }
            } else {
                echo $contents;exit;
            }
            

        }catch(Exception $e) {

            $dialogflow_cx = maybe_unserialize(get_option( 'qlcd_wp_chatbot_dialogflow_cx' ));
            if( $dialogflow_cx && is_array( $dialogflow_cx ) && array_key_exists( $lang, $dialogflow_cx ) ){
                echo json_encode(qcld_wpbot_df_cx_agent( true, $lang ));exit;
            } else {
                echo json_encode(array('error'=>$e->getMessage()));exit;
            }
        }

    }else{
        echo json_encode(array('error'=>'API client not found'));exit;
    }
	die();
}

function qcld_wpbot_df_cx_agent( $force, $lang ){

    $session_id = 'asd2342sde';
    $language = get_option('qlcd_wp_chatbot_dialogflow_agent_language');
    if( $language && is_array( $language ) && array_key_exists( $lang, $language ) ){
        $language = $language[$lang];
    }
    //project ID
    $project_ID = get_option('qlcd_wp_chatbot_dialogflow_project_id');
    if( $project_ID && is_array( $project_ID ) && array_key_exists( $lang, $project_ID ) ){
        $project_ID = $project_ID[$lang];
    }
    // Service Account Key json file
    $JsonFileContents = get_option('qlcd_wp_chatbot_dialogflow_project_key');
    if( $JsonFileContents && is_array( $JsonFileContents ) && array_key_exists( $lang, $JsonFileContents ) ){
        $JsonFileContents = $JsonFileContents[$lang];
    }

    if($project_ID==''){
        return (array('error'=>'Project ID is empty'));
    }
    if($JsonFileContents==''){
        return (array('error'=>'Key is empty'));
    }

    if(isset($_POST['sessionid']) && $_POST['sessionid']!=''){
        $session_id = sanitize_text_field($_POST['sessionid']);
    }

    if( !$force && get_transient( 'dialogflow_cx_agents_'.$lang ) ){
        return get_transient('dialogflow_cx_agents_'.$lang );
    }
    if(file_exists(QCLD_wpCHATBOT_GC_DIRNAME.'/autoload.php')){

        require(QCLD_wpCHATBOT_GC_DIRNAME.'/autoload.php');

        $client = new \Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->setScopes (['https://www.googleapis.com/auth/dialogflow']);
        // Convert to array 
        $array = json_decode($JsonFileContents, true);
        $client->setAuthConfig($array);

        try {
            $httpClient = $client->authorize();
            $apiUrl = "https://dialogflow.googleapis.com/v3beta1/projects/{$project_ID}/locations/global/agents";

            $response = $httpClient->request('GET', $apiUrl);
            
            $contents = $response->getBody()->getContents();
            set_transient( 'dialogflow_cx_agents_'.$lang, json_decode( $contents, true ), 12 * HOUR_IN_SECONDS );
            return json_decode( $contents, true );
            
        }catch(Exception $e) {
            return (array('error'=>$e->getMessage()));
        }
    }
}

add_action('wp_ajax_qcld_wp_df_api_cx', 'qcld_wp_df_api_cx');
add_action('wp_ajax_nopriv_qcld_wp_df_api_cx', 'qcld_wp_df_api_cx');
function qcld_wp_df_api_cx(){

    $session_id = 'asd2342sde';


    if(isset($_POST['language']) && $_POST['language']!='' ){
        $lang = $_POST['language'];
    }else{
        $lang = get_wpbot_locale();
    }

    $name = sanitize_text_field($_POST['name']);
    $timezone = sanitize_text_field($_POST['timezone']);
    $defaultlangaugecode = sanitize_text_field($_POST['defaultlanguageCode']);

    $language = get_option('qlcd_wp_chatbot_dialogflow_agent_language');
    if( $language && is_array( $language ) && array_key_exists( $lang, $language ) ){
        $language = $language[$lang];
    }
    //project ID
    $project_ID = get_option('qlcd_wp_chatbot_dialogflow_project_id');
    if( $project_ID && is_array( $project_ID ) && array_key_exists( $lang, $project_ID ) ){
        $project_ID = $project_ID[$lang];
    }
    // Service Account Key json file
    $JsonFileContents = get_option('qlcd_wp_chatbot_dialogflow_project_key');
    if( $JsonFileContents && is_array( $JsonFileContents ) && array_key_exists( $lang, $JsonFileContents ) ){
        $JsonFileContents = $JsonFileContents[$lang];
    }

    if($project_ID==''){
        echo json_encode(array('error'=>'Project ID is empty'));exit;
    }
    if($JsonFileContents==''){
        echo json_encode(array('error'=>'Key is empty'));exit;
    }
    if(!isset($_POST['dfquery']) || $_POST['dfquery']==''){
        echo json_encode(array('error'=>'Query text is not added!'));exit;
    }
    $query = sanitize_text_field($_POST['dfquery']);

    if(isset($_POST['sessionid']) && $_POST['sessionid']!=''){
        $session_id = sanitize_text_field($_POST['sessionid']);
    }


    if(file_exists(QCLD_wpCHATBOT_GC_DIRNAME.'/autoload.php')){

        require(QCLD_wpCHATBOT_GC_DIRNAME.'/autoload.php');

        $client = new \Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->setScopes (['https://www.googleapis.com/auth/dialogflow']);
        // Convert to array 
        $array = json_decode($JsonFileContents, true);
        $client->setAuthConfig($array);

        try {
            $httpClient = $client->authorize();
            $apiUrl = "https://dialogflow.googleapis.com/v3beta1/{$name}/sessions/{$session_id}:detectIntent";
            $query = [
                'json' => [
					'queryInput' => [
						'text' => [
							'text' 			=> $query, 
                        ],
                        'languageCode' 	=> $language
					],
                    'queryParams' => [
						'timeZone' 				=> $timezone,
					]
				]
            ];
            $response = $httpClient->request('POST', $apiUrl, $query);
            
            $contents = $response->getBody()->getContents();
            
            echo $contents;exit;
            
        }catch(Exception $e) {
            echo json_encode(array('error'=>$e->getMessage()));exit;
        }
    }else{
        echo json_encode(array('error'=>'API client not found'));exit;
    }
	die();
}