<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

if(!class_exists('qcld_wpopenai_addons')){


    /**
     * Main Class.
     */
    final class qcld_wpopenai_addons
    {
        private $id = 'Open AI';

        /**
         * WPBot Pro version.
         *
         * @var string
         */
        public $version = '1.0.6';
        
        /**
         * WPBot Pro helper.
         *
         * @var object
         */
        public $helper;

        /**
         * The single instance of the class.
         *
         * @var qcld_wb_Chatbot
         * @since 1.0.0
         */
        protected static $_instance = null;
        
        /**
         * Main wpbot Instance.
         *
         * Ensures only one instance of wpbot is loaded or can be loaded.
         *
         * @return qcld_wb_Chatbot - Main instance.
         * @since 1.0.0
         * @static
         */
        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        public $response_list;

        /**
         *  Constructor
         */
        public function __construct()
        {
            $this->define_constants();
            $this->includes();
            add_action('wp_ajax_openai_settings_option', [$this, 'openai_settings_option_callback']);
            add_action('wp_ajax_openai_file_upload', [$this, 'openai_file_upload_callback']);
            add_action('wp_ajax_openai_response',[$this,'openai_response_callback']);
            add_action('wp_ajax_openai_file_list',[$this,'openai_file_list_callback']);
            add_action('wp_ajax_openai_finetune_list', [$this,'openai_finetune_list']);
            add_action('wp_ajax_openai_file_delete',[$this,'openai_file_delete_callback']);
            add_action('wp_ajax_nopriv_openai_response', [$this, 'openai_response_callback']);
            add_action('wp_ajax_openai_ft_model_create', [$this, 'openai_ft_model_create']);
            add_action('wp_ajax_openai_ft_model_delete', [$this, 'openai_ft_model_delete']);
            add_action('wp_ajax_qcld_openai_post_data_converter_count', [$this,'qcld_openai_post_data_converter_count']);
            add_action('wp_ajax_qcld_openai_post_data_converter', [$this,'qcld_openai_post_data_converter']);
            add_action('wp_ajax_qcld_openai_upload_pagetraining_file',[$this, 'qcld_openai_upload_pagetraining_file']);
            add_action('wp_ajax_qcld_openai_image_generate',[$this, 'qcld_openai_image_generate']);
            add_action('wp_ajax_openai_keyword_suggestion_content',[$this,'openai_keyword_suggestion_content']);
            add_action('wp_ajax_qcld_openai_image_generate_url',[$this,'qcld_seo_image_generate_url_functions']);
            add_action('wp_ajax_qcld_openai_file_dowload',[$this,'qcld_openai_file_dowload']);
            add_action('wp_ajax_qcld_openai_delete_training_file',[$this,'qcld_openai_delete_training_file']);
            
            if (is_admin() && !empty($_GET["page"]) && (($_GET["page"] == "openai-panel_dashboard") || ($_GET["page"] == "openai-panel_file") || ($_GET["page"] == "openai-panel_help"))) {
                add_action('admin_enqueue_scripts', array($this, 'qcld_wb_chatbot_admin_scripts'));
            }
    
     
        }

        
        /**
         * Define wpbot Constants.
         *
         * @return void
         * @since 1.0.0
         */
        public function define_constants() {
            if( ! defined( 'QCLD_openai_addon_VERSION' ) ){
                define('QCLD_openai_addon_VERSION', $this->version);
            }
           //define('QCLD_openai_addon_REQUIRED_wpCOMMERCE_VERSION', 2.2);

            if( ! defined( 'QCLD_openai_addon_PLUGIN_DIR_PATH' ) ){
                define('QCLD_openai_addon_PLUGIN_DIR_PATH', plugin_dir_path(__FILE__));
            }
            if( ! defined( 'QCLD_openai_addon_PLUGIN_URL' ) ){
                define('QCLD_openai_addon_PLUGIN_URL', plugin_dir_url(__FILE__));
            }
            if( ! defined( 'QCLD_openai_addon_IMG_URL' ) ){
                define('QCLD_openai_addon_IMG_URL', QCLD_openai_addon_PLUGIN_URL . "images/");
            }
            if( ! defined( 'QCLD_openai_addon_IMG_ABSOLUTE_PATH' ) ){
                define('QCLD_openai_addon_IMG_ABSOLUTE_PATH', plugin_dir_path(__FILE__) . "images");
            }

        }


        public function qcld_wb_chatbot_admin_scripts(){
            // wp_register_style('qlcd-open-ai-bootstap', QCLD_openai_addon_PLUGIN_URL . 'css/openai-bootstrap.css', '', QCLD_openai_addon_VERSION, 'screen');
            // wp_enqueue_style('qlcd-open-ai-bootstap');
            // wp_register_style('qlcd-open-ai-admin-style', QCLD_openai_addon_PLUGIN_URL . 'css/openai-admin-style.css', '', QCLD_openai_addon_VERSION, 'screen');
            // wp_enqueue_style('qlcd-open-ai-admin-style');
            // wp_register_script('qlcd-openai_collapse', QCLD_openai_addon_PLUGIN_URL . 'js/collapse.js', array('jquery'),'',QCLD_openai_addon_VERSION,true);
            // wp_enqueue_script('qlcd-openai_collapse');
            // wp_register_script('qlcd-openai_settings', QCLD_openai_addon_PLUGIN_URL . 'js/openai_settings.js', array('jquery'),'',QCLD_openai_addon_VERSION,true);
            // wp_enqueue_script('qlcd-openai_settings');
            
            // wp_localize_script( 'qlcd-openai_settings', 'openai_ajax', array(
            //     'url' => admin_url( 'admin-ajax.php' ),
            // ) );
            
        }
        /**
         * Include all required files
         *
         * since 1.0.0
         *
         * @return void
         */
        public function includes() {
            require_once( QCLD_wpCHATBOT_PLUGIN_DIR_PATH . "includes/openai/qcld_wp_OpenAI.php" );
            require_once( QCLD_wpCHATBOT_PLUGIN_DIR_PATH . "includes/openai/OpenAi_WPBot_Menu.php" );
          
        }
        public function openai_file_delete_callback(){
            $file_id = sanitize_text_field($_POST['file_id']);
            $url = 'https://api.openai.com/v1/files/'. $file_id;
            $apt_key = "Authorization: Bearer ". get_option('open_ai_api_key');
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            $headers = array(
                $apt_key,
            );
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
           wp_send_json( json_decode($result));
		   wp_die();
        }
        public function openai_ft_model_create(){
            $file_id = sanitize_text_field($_POST['file_id']);
            $ft_suffix = sanitize_text_field($_POST['ft_suffix']);
            $ft_engines = sanitize_text_field($_POST['ft_engines']);
            $rel = $this->openai_finetune_create($file_id,$ft_suffix,$ft_engines);
           // print_r(wp_send_json([$rel]));wp_die();
            echo wp_send_json([$rel]);
            wp_die();
        }
        public function qcld_openai_file_dowload(){

            //   -H "Authorization: Bearer $OPENAI_API_KEY" > results.csv
            
            $file_id = sanitize_text_field($_POST['file_id']);
            $url =  'https://api.openai.com/v1/files/'.$file_id;
            $url1 =  'https://api.openai.com/v1/files/'.$file_id. '/content';
            $apt_key = "Authorization: Bearer ". get_option('open_ai_api_key');
            $headers = array(
                "Content-Type: application/json",
                $apt_key,
            );
            $headers1 = array(
                "Content-Type:  file.jsonl",
                $apt_key,
            );
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $result = json_decode(curl_exec($curl));
            curl_close($curl);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            //curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $res = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
          //  var_dump($res);
            if(!empty($result)){
                $response['status'] = 'success';
                $response['fileinfo'] =  $result; 
                $response['filedata'] = $res;
                
            }
            echo wp_send_json([$response]);
            wp_die();

        }
        public function buildFormBody( $fields, $boundary )
        {
            $body = '';
            foreach ( $fields as $name => $value ) {
            if ( $name == 'data' ) {
                continue;
            }
            $body .= "--$boundary\r\n";
            $body .= "Content-Disposition: form-data; name=\"$name\"";
            if ( $name == 'file' ) {
                $body .= "; filename=\"{$value}\"\r\n";
                $body .= "Content-Type: application/json\r\n\r\n";
                $body .= $fields['data'] . "\r\n";
            }else {
                $body .= "\r\n\r\n$value\r\n";
            }
            }
            $body .= "--$boundary--\r\n";
            return $body;
        }

        public function openai_file_list_callback(){
            $url = 'https://api.openai.com/v1/files';
            $apt_key = "Authorization: Bearer ". get_option('open_ai_api_key');
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            $headers = array(
                "Content-Type: application/json",
                $apt_key,
            );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($curl);
            curl_close($curl);
            wp_send_json( json_decode($response));
		    wp_die();
        }
        public function qcld_sanitize_text_or_array_field($array_or_string) {
            if( is_string($array_or_string) ){
                $array_or_string = sanitize_text_field($array_or_string);
            }elseif( is_array($array_or_string) ){
                foreach ( $array_or_string as $key => &$value ) {
                    if ( is_array( $value ) ) {
                        $value = $this->sanitize_text_or_array_field($value);
                    }
                    else {
                        $value = sanitize_text_field( $value );
                    }
                }
            }

            return $array_or_string;
        }
        public function qcld_openai_post_data_converter_count()
        {
            global $wpdb;
            $qcldopenai_result = array('status' => 'error');
            if(isset($_POST['data']) && is_array($_POST['data'])){
                $types = Self::qcld_sanitize_text_or_array_field($_POST['data']);
                $sql = "SELECT COUNT(*) FROM ".$wpdb->posts." WHERE post_status='publish' AND post_type IN ('".implode("','",$types)."')";
                $qcldopenai_result['count'] = $wpdb->get_var($sql);
                $qcldopenai_result['status'] = 'success';
                $qcldopenai_result['types'] = $types;
            }
            else $qcldopenai_result['msg'] = 'Please select least one data to convert';
           
            $this->qcld_openai_post_data_converter($qcldopenai_result);
        }

        public function qcld_openai_post_data_converter($result)
        {
            $qcldopenai_result = array('status' => 'error','msg' => 'Something went wrong');
            global $wpdb;
            if(
                isset($result['types'])
                && is_array($result['types'])
            ){
                $types = Self::qcld_sanitize_text_or_array_field($result['types']);
               
                $qcldopenai_total = sanitize_text_field($_POST['total']);
                $qcldopenai_per_page = sanitize_text_field($_POST['per_page']);
                $qcldopenai_page = isset($_POST['page']) && !empty($_POST['page']) ? sanitize_text_field($_POST['page']) : 1;
                if(isset($_POST['file']) && !empty($_POST['file'])){
                    $qcldopenai_file = sanitize_text_field($_POST['file']);
                }else{
                    $qcldopenai_file = md5(time()).'.jsonl';
                }
                if(isset($_POST['id']) && !empty($_POST['id'])){
                    $qcldopenai_convert_id = sanitize_text_field($_POST['id']);
                }else{
                    $qcldopenai_convert_id = wp_insert_post(array(
                        'post_title' => $qcldopenai_file,
                        'post_type' => 'qcldopenai_convert',
                        'post_status' => 'publish'
                    ));
                } try {
                    $upload  = wp_upload_dir(); 
                    $upload_dir = $upload['basedir'] . '/' . 'qcldopenai_site_training';
                    $permissions = 0755;
                    $oldmask = umask(0);
                    if (!is_dir($upload_dir)){
                        mkdir($upload_dir, $permissions);
                        $umask = umask($oldmask);
                        $chmod = chmod($upload_dir, $permissions);
                    } 
                    $gcdirpath = WP_CONTENT_DIR.'/qcldopenai_site_training';
                    $qcldopenai_json_file = fopen(wp_upload_dir()['basedir'] .'/qcldopenai_site_training/'.basename($qcldopenai_file), "w");
                    $qcldopenai_content = '';
                    $sql = "SELECT post_title, post_content FROM ".$wpdb->posts." WHERE post_status='publish' AND post_type IN ('".implode("','",$types)."') ORDER BY post_date";                  
                    $qcldopenai_data = $wpdb->get_results($sql);
                    if($qcldopenai_data && is_array($qcldopenai_data) && count($qcldopenai_data)){
                        foreach($qcldopenai_data as $item){
                           $tag_less_content =  wp_strip_all_tags($item->post_content);
                           $vc_tag_less = preg_replace("/\[(\/*)?vc_(.*?)\]/", '', $tag_less_content);
                           $clean_html_body = preg_replace('/\xc2\xa0/', '', $vc_tag_less);
                           $completion_string = str_replace(array("\n","\r","\t","&nbsp;"), ' ', $clean_html_body);
                           $completion_string = wp_trim_words( $completion_string,500);

                           $tag_less_title =  wp_strip_all_tags($item->post_title);
                           $clean_html_title = preg_replace('/\xc2\xa0/', '', $tag_less_title);
                           $title_string = str_replace(array("\n","\r","\t","&nbsp;"), ' ', $clean_html_title);
                           $title_string = wp_trim_words( $title_string,50);
                            $data = array(
                                "prompt" => $title_string.' ->',
                                "completion" => $completion_string
                            );
                            fwrite($qcldopenai_json_file, json_encode($data) . PHP_EOL);
                        }
                    }
                    fclose($qcldopenai_json_file);
                    $qcldopenai_result['file'] = $qcldopenai_file;
                    $qcldopenai_result['id'] = $qcldopenai_convert_id;
                    $qcldopenai_result['status'] = 'success';
                } catch (\Exception $exception){
                    $qcldopenai_result['msg'] = $exception->getMessage();
                }
            }
            else $qcldopenai_result['msg'] = 'Please select least one data to convert';
            wp_send_json($qcldopenai_result);
        }

        public function openai_ft_model_delete(){
            $ft_id = sanitize_text_field($_POST['ft_id']);
            $url = 'https://api.openai.com/v1/models/' . $ft_id;
            $apt_key = "Authorization: Bearer ". get_option('open_ai_api_key');
            $curl = curl_init();
            $headers = array(
                "Content-Type: multipart/form-data",
                $apt_key,
            );
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
            curl_setopt($curl, CURLOPT_POST, true);
            $res = json_decode(curl_exec ($curl));
            curl_close ($curl);
            echo wp_send_json([$rel]);
            wp_die();

        }
        public function qcld_openai_upload_pagetraining_file(){
          
            if(
                isset($_POST['filename'])
                && !empty($_POST['filename'])
            ){
                $filename = sanitize_text_field($_POST['filename']);
                $line = isset($_POST['line']) && !empty($_POST['line']) ? sanitize_text_field($_POST['line']) : 0;
                $file =   wp_upload_dir()['basedir'].'/qcldopenai_site_training/'.$filename;
                if(file_exists($file)){
                    $qcld_openai_lines = file($file);
                    $fileo =  '@'. wp_upload_dir()['basedir'].'/qcldopenai_site_training/'.$filename;
                    $split_file = wp_upload_dir()['basedir'].'/qcldopenai_site_training/'.$filename;
                    $qcld_openai_json_file = fopen($split_file, "a");
                    $qcld_openai_content = '';
                    for($i = $line; $i <= count($qcld_openai_lines);$i++){
                        if($i == count($qcld_openai_lines)){
                            $qcld_openai_content .= $qcld_openai_lines[$i];
                            $qcld_openai_result['next'] = 'DONE';
                        }
                        else{
                            if(mb_strlen($qcld_openai_content, '8bit') > $this->wpaicg_max_file_size){
                                $qcld_openai_result['next'] = $i+1;
                                break;
                            }
                            else{
                                $qcld_openai_content .= $qcld_openai_lines[$i];
                            }
                        }
                    }
                    fwrite($qcld_openai_json_file,$qcld_openai_content);
                    fclose($qcld_openai_json_file);
                    $url = 'https://api.openai.com/v1/files';
                    $apt_key = "Authorization: Bearer ". get_option('open_ai_api_key');
                    $curl = curl_init($url);
                    $c_file = curl_file_create($split_file, mime_content_type($split_file),basename($split_file));
                    $data = array(
                        'purpose' => 'fine-tune',
                        'file' => $c_file,
                    );
                    curl_setopt($curl, CURLOPT_URL, $url);
                    curl_setopt($curl, CURLOPT_POST, true);
                    $headers = array(
                        "Content-Type: multipart/form-data",
                        $apt_key,
                    );
                    $init = curl_init();
                    curl_setopt($init, CURLOPT_URL,$url);
                    curl_setopt($init, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($init, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($init, CURLOPT_RETURNTRANSFER, true);
                    $res = json_decode(curl_exec ($init));
                    
                    curl_close ($init);
                    if(!empty($res->error)){
                        $response['status'] = 'error';
                        $response['message'] = $res->error->message;
                    }
                    
                    if(!empty($res->status)){
                        $response['status'] = 'success';
                        $response['message'] = 'Successfully Created file' . $res->id ; 
                        
                    }
                    echo wp_send_json([$response]);
                    wp_die();
                } else {
                    if(!empty($res->status)){
                        $response['status'] = 'error';
                        $response['message'] = 'The file has been removed from wp-uploads';
                    }
                }
            }
        }
        public function openai_file_upload_callback(){
            $uploadedfile = $_FILES['file'];
            $url = 'https://api.openai.com/v1/files';
            $apt_key = "Authorization: Bearer ". get_option('open_ai_api_key');
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, true);
            $headers = array(
                "Content-Type: multipart/form-data",
                $apt_key,
            );
            if (function_exists('curl_file_create')) { 
                $tmp_file = curl_file_create($uploadedfile['tmp_name'], 'jsonl', $uploadedfile['name']);
            } else { 
                $tmp_file = open($uploadedfile['tmp_name']);
            }
               
            $data = array('file'=> $tmp_file,'purpose'=> 'fine-tune');
            $init = curl_init();
            //function parameteres
            curl_setopt($init, CURLOPT_URL,$url);
            curl_setopt($init, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($init, CURLOPT_POSTFIELDS, $data);
            curl_setopt($init, CURLOPT_RETURNTRANSFER, true);
            $res = json_decode(curl_exec ($init));
            
            curl_close ($init);
            if(!empty($res->error)){
                $response['status'] = 'error';
                $response['message'] = $res->error->message;
            }
            
            if(!empty($res->status)){
                $response['status'] = 'success';
                $response['message'] = 'Successfully Created file' . $res->id ; 
                
            }
            echo wp_send_json([$response]);
            wp_die();
        }
        public function qcld_openai_image_generate(){

            $qcld_seo_result = array(
                'status' => 'error',
                'msg'    => 'Something went wrong',
            );
            $OPENAI_API_KEY = get_option('open_ai_api_key');
            $qcld_seo_prompt                = isset( $_POST['qcld_seo_prompt'] )                ? sanitize_text_field( $_POST['qcld_seo_prompt'] )              : '';
            $qcld_seo_artist                = isset( $_POST['qcld_seo_artist'] )                ? sanitize_text_field( $_POST['qcld_seo_artist'] )              : 'Painter';
            $qcld_seo_art_style             = isset( $_POST['qcld_seo_art_style'] )             ? sanitize_text_field( $_POST['qcld_seo_art_style'] )           : 'Style';
            $qcld_seo_photography_style     = isset( $_POST['qcld_seo_photography_style'] )     ? sanitize_text_field( $_POST['qcld_seo_photography_style'] )   : 'Photography Style';
            $qcld_seo_lighting              = isset( $_POST['qcld_seo_lighting'] )              ? sanitize_text_field( $_POST['qcld_seo_lighting'] )            : 'Lighting';
            $qcld_seo_subject               = isset( $_POST['qcld_seo_subject'] )               ? sanitize_text_field( $_POST['qcld_seo_subject'] )             : 'Subject';
            $qcld_seo_camera_settings       = isset( $_POST['qcld_seo_camera_settings'] )       ? sanitize_text_field( $_POST['qcld_seo_camera_settings'] )     : 'Camera Settings';
            $qcld_seo_composition           = isset( $_POST['qcld_seo_composition'] )           ? sanitize_text_field( $_POST['qcld_seo_composition'] )         : 'Composition';
            $qcld_seo_resolution            = isset( $_POST['qcld_seo_resolution'] )            ? sanitize_text_field( $_POST['qcld_seo_resolution'] )          : 'Resolution';
            $qcld_seo_color                 = isset( $_POST['qcld_seo_color'] )                 ? sanitize_text_field( $_POST['qcld_seo_color'] )               : 'Color';
            $qcld_seo_special_effects       = isset( $_POST['qcld_seo_special_effects'] )       ? sanitize_text_field( $_POST['qcld_seo_special_effects'] )     : 'Special Effects';
            $qcld_seo_img_size              = isset( $_POST['qcld_seo_img_size'] )              ? sanitize_text_field( $_POST['qcld_seo_img_size'] )            : '512x512';
            $qcld_seo_num_images            = isset( $_POST['qcld_seo_num_images'] )            ? sanitize_text_field( $_POST['qcld_seo_num_images'] )          : 1;
            $qcld_seo_num_images            = isset( $qcld_seo_num_images )                     ? (int) $qcld_seo_num_images                                    : 6;
            if (!empty($qcld_seo_prompt)) {
                // Get the prompt from the form
                $prompt         = $qcld_seo_prompt;
                $img_size       = $qcld_seo_img_size;
                $num_images     = $qcld_seo_num_images;
                // convert num_images to an integer
                $num_images     = (int) $num_images;
                $prompt_elements = array(
                    'artist'            => $qcld_seo_artist,
                    'art_style'         => $qcld_seo_art_style,
                    'photography_style' => $qcld_seo_photography_style,
                    'composition'       => $qcld_seo_composition,
                    'resolution'        => $qcld_seo_resolution,
                    'color'             => $qcld_seo_color,
                    'special_effects'   => $qcld_seo_special_effects,
                    'lighting'          => $qcld_seo_lighting,
                    'subject'           => $qcld_seo_subject,
                    'camera_settings'   => $qcld_seo_camera_settings,
                );
                foreach ($prompt_elements as $key => $value) {
                    if ($_POST[$key] != "None") {
                        $prompt = $prompt . ". " . $value . ": " . $_POST[$key];
                    }
                }
                // Send the request to OpenAI
                $request_body = [
                    "prompt"            => $prompt,
                    "n"                 => $num_images,
                    "size"              => $img_size,
                    "response_format"   => "url",
                ];
                $data    = json_encode($request_body);
                $url     = "https://api.openai.com/v1/images/generations";
                $apt_key = "Authorization: Bearer ". $OPENAI_API_KEY;
                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $headers    = array(
                   "Content-Type: application/json",
                   $apt_key ,
                );
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                $result     = curl_exec($curl);
                curl_close($curl);
    
                // we need to catch the error here
                $img_result = json_decode( $result );
    
                $image_grid = '<div class="qcld_image_grid">';
                for ($i = 0; $i < $num_images; $i++) {
                    $image_grid .= '<div class="qcld_image-grid_wrap qcld_botopenai_generate_image_download"> ';
                    $image_grid .= '<img class="qcld_image-item" src=' . esc_html($img_result->data[$i]->url) . '>';
                    $image_grid .= '<div class="qcld_seo_download" data-img="' . esc_html($img_result->data[$i]->url) . '"><button class="btn btn-success">Add to media libary</button></div>';
                    $image_grid .= '</div>';
                }
                $image_grid .= '</div>';
                $qcld_seo_result['status'] = 'success';
                $qcld_seo_result['html'] = $image_grid;
    
            }
            
            wp_send_json( $qcld_seo_result );
        }
        public function qcld_openai_delete_training_file(){
            $file = sanitize_text_field($_POST['file']);
            $qcld_seo_result = array(
                'status' => 'error',
                'msg'    => 'Something went wrong',
            );
            if (is_file($file)) {

                chmod($file, 0777);
             
                if (unlink($file)) {
                   $result = 'File deleted';
                   $qcld_seo_result['html'] = $result;
                } else {
                   $result = 'Cannot remove that file';
                   $qcld_seo_result['html'] = $result;
                }
             
             } else {
               $result = 'File does not exist';
               $qcld_seo_result['html'] = $result;
            }
            
            wp_send_json( $qcld_seo_result );
            wp_die();

        }
        public function openai_finetune_create($file_id,$ft_suffix,$ft_engines){
            $apt_key = "Authorization: Bearer ". get_option('open_ai_api_key');
            $headers = array(
                "Content-Type: application/json",
                $apt_key,
            );
            $curl = curl_init();
            $qcld_openai_suffix = isset($ft_suffix) ? $ft_suffix : get_option('qcld_openai_suffix');
            $openai_engines = isset($ft_engines) ? $ft_engines : get_option('openai_engines');
            $base_engine = explode('-',$openai_engines);
            $data = json_encode(array('training_file'=>$file_id,'model' => $base_engine[1], 'suffix' => $qcld_openai_suffix ));
            $url = "https://api.openai.com/v1/fine-tunes";
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            $result = json_decode(curl_exec($curl));
            curl_close($curl);
            return $result;  
        }
        public function openai_finetune_list(){
            
            $apt_key = "Authorization: Bearer ". get_option('open_ai_api_key');
            $headers = array(
                "Content-Type: application/json",
                $apt_key,
            );
            $curl_ft = curl_init();
            //$data = json_encode(array('training_file'=>$file_id));
            
            $url = "https://api.openai.com/v1/fine-tunes";
            curl_setopt($curl_ft, CURLOPT_URL, $url);
            curl_setopt($curl_ft, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl_ft, CURLOPT_RETURNTRANSFER, true);
            $result = json_decode(curl_exec($curl_ft));
            $ft_arry = [];  
            foreach($result->data as $value ){
              if(($value->training_files[0]->status != 'deleted') && ($value->result_files[0]->status != 'deleted') ){
                    $ft_arry[] = [$value->id,$value->fine_tuned_model,$value->status,$value->training_files[0]->filename,$value->training_files[0]->id];
              }
            }
            curl_close($curl_ft);
            wp_send_json( $ft_arry);
		    wp_die();
         
          
        }
        public function openai_retrive_fine_tune($keyword){
           
            $apt_key = "Authorization: Bearer ". get_option('open_ai_api_key');
            $headers = array(
                "Content-Type: application/json",
                $apt_key,
            );
            $curl = curl_init();
            $max_tokens =  (int)get_option( 'openai_max_tokens');
            $temp = (float)get_option( 'openai_temperature');
            $frequency_penalty = (float)get_option( 'frequency_penalty');
            $presence_penalty = (float)get_option( 'presence_penalty');
            $engines = explode('-',get_option( 'openai_engines'));
         
            $data = json_encode(array(
                'prompt'=>$keyword,
                'model'=> get_option( 'qcld_openai_custom_model'),
                "max_tokens" => $max_tokens,
                "temperature" => $temp,
                "top_p" => 1,
                "presence_penalty" => $frequency_penalty,
                "frequency_penalty"=> $presence_penalty,
                "best_of"=> 1,
             ));
            $url = "https://api.openai.com/v1/completions";

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/completions');
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            // curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

            $result = (curl_exec($ch));
            $result = str_replace("#","",$result );
            return $result; 
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
            
        }
        public function response_form_file($keyword){
            $max_tokens =  (int)get_option( 'openai_max_tokens');
            $temp = (float)get_option( 'openai_temperature');
            $frequency_penalty = (float)get_option( 'frequency_penalty');
            $presence_penalty = (float)get_option( 'presence_penalty');
            $engines = explode('-',get_option( 'openai_engines'));
            if($engines[0] != 'gpt'){
                $prompts = $this->get_prompt($keyword);
            }
         
            $request_body = [
                "prompt" =>   $keyword,
                "model" => get_option( 'qcld_openai_custom_model'),
                "max_tokens" => $max_tokens,
                "temperature" => 0,
                "top_p" => 1,
                "stop" => [], 
                "presence_penalty" => 0,
                "frequency_penalty"=> 0,
                "best_of"=> 1,
            ];
            $postFields = json_encode($request_body);
            $OpenAI =  new qcld_wp_OpenAI();
            $result = $OpenAI->get_response($postFields);

            return $result;
        }
        public function get_prompt($keyword){
          $qcld_openai_prompt = get_option('qcld_openai_prompt',true);
          switch ($qcld_openai_prompt) {
            case "q_and_a":
                if(get_option('conversation_continuity') == 1){
                    if(empty($_COOKIE["last_five_prompt"])){
                        setcookie("last_five_prompt", "Q:".$keyword."\nA:", time() + (60000), "/");
                        return "Q:".$keyword."\nA:";
                    }else{
                        $last_five = $_COOKIE["last_five_prompt"];
                        setcookie("last_five_prompt",  $last_five. "\nQ:".$keyword."\nA:", time() + (60000), "/");
                         return  $last_five . "Q:".$keyword."\nA:";
                    }
                }else{
                    return  "Q:".$keyword."\nA:";
                }
            case "chat":
                if(get_option('conversation_continuity') == 1){
                    if(empty($_COOKIE["last_five_prompt"])){
                        setcookie("last_five_prompt", "Human:".$keyword."\nAI:", time() + (60000), "/");
                        return "Human:".$keyword."\nAI:";
                    }else{
                        $last_five = $_COOKIE["last_five_prompt"];
                        setcookie("last_five_prompt",  $last_five. "\nQ:".$keyword."\nA:", time() + (60000), "/");
                         return  $last_five . "\nHuman:".$keyword."\nAI:";
                    }
                }else{
                    return "\nHuman:".$keyword."\nAI:";
                }
                
            case "friend_chat":
                if(get_option('conversation_continuity') == 1){
                    if(empty($_COOKIE["last_five_prompt"])){
                        setcookie("last_five_prompt", "You:".$keyword."\nFriend:", time() + (60000), "/");
                        return "You:".$keyword."\nFriend:";
                    }else{
                        $last_five = $_COOKIE["last_five_prompt"];
                        setcookie("last_five_prompt",  $last_five. "\nQ:".$keyword."\nA:", time() + (60000), "/");
                         return  $last_five . "\nYou:".$keyword."\nFriend:";
                    }
                }else{
                    return "You:".$keyword."\nFriend:";
                }
            case "grammar_correction":
                return "Correct this to standard English:\n\n ".$keyword." " ;
            case "marv_sarcastic_chatbot" :
                return "Marv is a chatbot that reluctantly answers questions with sarcastic responses:\n\nYou: ".$keyword." \nMarv:";
            case "micro_horror":
                return "\nTopic:  ".$keyword."\n\nTwo-Sentence Horror Story:";
            case "any_command":
                return $keyword;
            case "write_poem":
                return "write a poem about". $keyword;
            case "custom_prompt": 
                return  get_option('qcld_openai_prompt_custom') ."\n" . $keyword;
            default:
                return "Q:".$keyword."\nA:";
          }
        }
        public function openai_response_callback() {
            $response['status'] = 'success';
            $response['message'] ='A preset message';
            $OpenAI =  new qcld_wp_OpenAI();
            $gptkeyword = [];
            $keyword = sanitize_text_field($_POST['keyword']);
          //  $response_files = $this->response_form_file($keyword);
            $response_files = $this->openai_retrive_fine_tune($keyword);
            $response_file = json_decode($response_files, true);
            $gptkeywords = [];
            if(empty($response_file['choices'][0]["text"])){
              
                $engines = explode('-',get_option( 'openai_engines'));
                if($engines[0] == 'gpt'){
                    if(empty($_COOKIE["last_five_prompt"])){
                        array_push($gptkeyword, array(
                            "role" => "user",
                            "content" =>  $keyword
                         ));
                         setcookie('last_five_prompt', base64_encode(maybe_serialize($gptkeyword)) , time() + (60000), "/");
                     }else{
                         $data = ($_COOKIE['last_five_prompt']);
                         $data = (base64_decode($data));
                         $gptkeyword =  maybe_unserialize($data);
                         if(is_array($gptkeyword)){
                             array_push( $gptkeyword, array(
                                 "role" => "user",
                                 "content" => $keyword
                             ));
                             setcookie('last_five_prompt', base64_encode(maybe_serialize($gptkeyword)) , time() + (60000), "/");
                         }
                     }
                     
                     $res = $OpenAI->gptcomplete(
                         $gptkeyword
                     );   
                     $mess = json_decode($res); 
                     $response['message'] = $mess->choices[0]->message->content;
                     if(get_option('conversation_continuity') == 1){
                         $data = ($_COOKIE['last_five_prompt']);
                         $data = (base64_decode($data));
                         $gptkeywords =  maybe_unserialize($data);
                         if(is_array($gptkeywords)){
                             array_push( $gptkeywords, array(
                                 "role" => "assistant",
                                 "content" =>  $response['message']
                             ));
                             setcookie('last_five_prompt', base64_encode(maybe_serialize($gptkeywords)) , time() + (60000), "/");
                         }
                     }
 
                }else{
                    $prompts = $this->get_prompt($keyword);
                    $prompt =$prompts;
                    $res = $OpenAI->complete(
                        $prompt
                    );
                    $mess = json_decode($res); 
                    $response['message'] = $mess->choices[0]->text;
                    if(get_option('conversation_continuity') == 1){
                        $lasfivecookie = $_COOKIE["last_five_prompt"] . $response['message'] . '###';
                        $response['cookie'] =  $_COOKIE["last_five_prompt"];
                    }
                }
            }else{
                $response['message'] = $response_file['choices'][0]["text"];
            }
            echo json_encode($response);
	        wp_die();
        }
        public function openai_settings_option_callback() {
           
		    $nonce =  sanitize_text_field($_POST['nonce']);
            if (! wp_verify_nonce($nonce,'wp_chatbot')) {
                wp_send_json(array('success' => false, 'msg' => esc_html__('Failed in Security check', 'sm')));
                wp_die();

            }else{
                $api_key = sanitize_text_field($_POST['api_key']);
                $openai_engines = sanitize_text_field($_POST['openai_engines']);
                $qcld_openai_prompt = sanitize_text_field($_POST['qcld_openai_prompt']);
                $max_tokens = sanitize_text_field($_POST['max_tokens']);
                $qcld_openai_suffix = sanitize_text_field($_POST['qcld_openai_suffix']);
                $qcld_openai_custom_model = sanitize_text_field($_POST['qcld_openai_custom_model']);
                $frequency_penalty = sanitize_text_field($_POST['frequency_penalty']);
                $presence_penalty = sanitize_text_field($_POST['presence_penalty']);
                $temperature = sanitize_text_field($_POST['temperature']);
                $ai_enabled = sanitize_text_field($_POST['ai_enabled']);
                $ai_only_mode =  sanitize_text_field($_POST['ai_only_mode']);
                $file_id = sanitize_text_field($_POST['file_id']);
                $qcld_openai_prompt_custom = sanitize_text_field($_POST['qcld_openai_prompt_custom']);
                $conversation_continuity = sanitize_text_field($_POST['conversation_continuity']);
                if($api_key  != ''){
                    update_option( 'open_ai_api_key', $api_key );
                }
                if($openai_engines  != ''){
                    update_option( 'openai_engines', $openai_engines );
                }
                if($conversation_continuity  != ''){
                    update_option( 'conversation_continuity', $conversation_continuity );
                }
                update_option( 'openai_max_tokens', $max_tokens );
                
                if($qcld_openai_suffix != ''){
                update_option('qcld_openai_suffix', $qcld_openai_suffix);
                }
                if($frequency_penalty  != ''){
                update_option( 'frequency_penalty', $frequency_penalty );
                }
                if($presence_penalty  != ''){
                    update_option( 'presence_penalty', $presence_penalty );
                }
                if($temperature  != ''){
                update_option( 'openai_temperature', $temperature );
                }
                if($qcld_openai_prompt_custom  != ''){
                    update_option('qcld_openai_prompt_custom', $qcld_openai_prompt_custom );
                }
                update_option('qcld_openai_custom_model',$qcld_openai_custom_model);
                if($max_tokens  != ''){
                    update_option('ai_enabled',$ai_enabled);
                }
                if($file_id  != ''){
                    update_option('file_id',$file_id);
                }
                if(($ai_only_mode != '') && ($ai_only_mode == 0)){
                    update_option('ai_only_mode', $ai_only_mode);
                    update_option('enable_wp_chatbot_disable_allicon', 0);
                    update_option('qcld_disable_start_menu', 0);
                    update_option('show_menu_after_greetings', 0);
                    update_option('skip_wp_greetings', 0);
                    update_option('disable_wp_chatbot_site_search',0);
                    update_option('disable_wp_chatbot_call_gen',0);
                    update_option('disable_wp_chatbot_feedback',0);
                    update_option('disable_wp_chatbot_faq',0);
                    update_option('disable_email_subscription',0);
                    update_option('disable_str_categories',0);
                    update_option('disable_good_bye',0);

                }else if(($ai_only_mode != '') && ($ai_only_mode == 1)){
                    update_option('ai_only_mode', $ai_only_mode);
                    update_option('enable_wp_chatbot_disable_allicon', 1);
                    update_option('qcld_disable_start_menu', 1);
                    update_option('show_menu_after_greetings', 1);
                    update_option('skip_wp_greetings', 1);
                    update_option('disable_wp_chatbot_site_search',1);
                    update_option('disable_wp_chatbot_call_gen',1);
                    update_option('disable_wp_chatbot_feedback',1);
                    update_option('disable_wp_chatbot_faq',1);
                    update_option('disable_email_subscription',1);
                    update_option('disable_str_categories',1);
                    update_option('disable_good_bye',1);
                }
                
                if($qcld_openai_prompt != ''){
                    update_option('qcld_openai_prompt', $qcld_openai_prompt);
                }
                $tem = get_option( 'openai_temperature', $temperature );
            
                echo json_encode($ai_enabled);wp_die();
            }
        }
        public function openai_keyword_suggestion_content(){

            $OPENAI_API_KEY                     = get_option('open_ai_api_key');
            $ai_engines                         = get_option('openai_engines');
            $max_token                          = get_option('openai_max_tokens');
          //  var_dump($max_token);wp_die();
            $temperature                        = get_option('openai_temperature');
            $ppenalty                           = get_option('presence_penalty');
            $fpenalty                           = get_option('frequency_penalty');
    
            $qcld_article_text                  = isset($_POST['keyword'])                          ? sanitize_text_field( $_POST['keyword'] ) : '';
            $keyword_number                     = isset( $_POST['keyword_number'] )                 ? sanitize_text_field( $_POST['keyword_number'] ) : '';
            $qcld_article_language              = isset($_POST['qcld_article_language'])            ? sanitize_text_field( $_POST['qcld_article_language'] ) : '';
            $qcld_article_number_of_heading     = isset($_POST['qcld_article_number_of_heading'])   ? sanitize_text_field( $_POST['qcld_article_number_of_heading'] ) : '';
            $qcld_article_heading_tag           = isset($_POST['qcld_article_heading_tag'])         ? sanitize_text_field( $_POST['qcld_article_heading_tag'] ) : '';
            $qcld_article_heading_style         = isset($_POST['qcld_article_heading_style'])       ? sanitize_text_field( $_POST['qcld_article_heading_style'] ) : '';
            $qcld_article_heading_tone          = isset($_POST['qcld_article_heading_tone'])        ? sanitize_text_field( $_POST['qcld_article_heading_tone'] ) : '';
            $qcld_article_heading_img           = isset($_POST['qcld_article_heading_img'])         ? sanitize_text_field( $_POST['qcld_article_heading_img'] ) : '';
            $qcld_article_heading_tagline       = isset($_POST['qcld_article_heading_tagline'])     ? sanitize_text_field( $_POST['qcld_article_heading_tagline'] ) : '';
            $qcld_article_heading_intro         = isset($_POST['qcld_article_heading_intro'])       ? sanitize_text_field( $_POST['qcld_article_heading_intro'] ) : '';
            $qcld_article_heading_conclusion    = isset($_POST['qcld_article_heading_conclusion'])  ? sanitize_text_field( $_POST['qcld_article_heading_conclusion'] ) : '';
            $qcld_article_label_anchor_text     = isset($_POST['qcld_article_label_anchor_text'])   ? sanitize_text_field( $_POST['qcld_article_label_anchor_text'] ) : '';
            $qcld_article_target_url            = isset($_POST['qcld_article_target_url'])          ? sanitize_text_field( $_POST['qcld_article_target_url'] ) : '';
            $qcld_article_target_label_cta      = isset($_POST['qcld_article_target_label_cta'])    ? sanitize_text_field( $_POST['qcld_article_target_label_cta'] ) : '';
            $qcld_article_cta_pos               = isset($_POST['qcld_article_cta_pos'])             ? sanitize_text_field( $_POST['qcld_article_cta_pos'] ) : '';
            $qcld_article_label_keywords        = isset($_POST['qcld_article_label_keywords'])      ? sanitize_text_field( $_POST['qcld_article_label_keywords'] ) : '';
            $qcld_article_label_word_to_avoid   = isset($_POST['qcld_article_label_word_to_avoid']) ? sanitize_text_field( $_POST['qcld_article_label_word_to_avoid'] ) : '';
            $qcld_article_label_keywords_bold   = isset($_POST['qcld_article_label_keywords_bold']) ? intval( $_POST['qcld_article_label_keywords_bold'] ) : '';
            $qcld_article_heading_faq           = isset($_POST['qcld_article_heading_faq'])         ? intval( $_POST['qcld_article_heading_faq'] ) : '';
    
            $img_size                           = isset($_POST['qcld_article_img_size'])            ? sanitize_text_field( $_POST['qcld_article_img_size'] ) : '';
            //$img_size = "512x512";
          
            if ( empty($qcld_article_language) ) {
                $qcld_article_language = "en";
            }
            // if number of heading is not set, set it to 5
            if ( empty($qcld_article_number_of_heading) ) {
                $qcld_article_number_of_heading = 5;
            }
            // if writing style is not set, set it to descriptive
            if ( empty($qcld_article_heading_style) ) {
                $qcld_article_heading_style = "infor";
            }
            // if writing tone is not set, set it to assertive
            if ( empty($qcld_article_heading_tone) ) {
                $qcld_article_heading_tone = "formal";
            }
            // if heading tag is not set, set it to h2
            if ( empty($qcld_article_heading_tag) ) {
                $qcld_article_heading_tag = "h2";
            }
    
            $writing_style  = apply_filters('qcld_seo_openai_filter_for_style', $qcld_article_heading_style, $qcld_article_language );
            $tone_text      = apply_filters('qcld_seo_openai_filter_for_tone', $qcld_article_heading_tone, $qcld_article_language );
    
            if ( $qcld_article_language == "en" ) {
    
                
                if ( $qcld_article_number_of_heading == 1 ) {
                    $prompt_text = " blog topic about ";
                } else {
                    $prompt_text = " blog topics about ";
                }
                
                $intro_text = "Write an introduction about ";
                $conclusion_text = "Write a conclusion about ";
                $tagline_text = "Write a tagline about ";
                $introduction = "Introduction";
                $conclusion = "Conclusion";
                $faq_text = strval( $qcld_article_number_of_heading ) . " questions and answers about " . $qcld_article_text . ".";
                $faq_heading = "Q&A";
                $style_text = "Writing style: " . $writing_style . ".";
                
                if ( empty($qcld_article_label_keywords) ) {
                    $myprompt = strval( $qcld_article_number_of_heading ) . $prompt_text . $qcld_article_text . ".";
                } else {
                    $keyword_text = ". Keywords: " . $qcld_article_label_keywords . ".";
                    $myprompt = strval( $qcld_article_number_of_heading ) . $prompt_text . $qcld_article_text . $keyword_text;
                }
                
                // if $qcld_article_label_word_to_avoid is not empty, add it to the prompt
                
                if ( !empty($qcld_article_label_word_to_avoid) ) {
                    $avoid_text = " Exclude following keywords: " . $qcld_article_label_word_to_avoid . ".";
                    $myprompt = $myprompt . $avoid_text;
                }
                
                $myintro = $intro_text . $qcld_article_text;
                $myconclusion = $conclusion_text . $qcld_article_text;
                $mytagline = $tagline_text . $qcld_article_text;
                $mycta = "Write a Call to action about: " . $qcld_article_text . " and create a href tag link to: " . $qcld_article_target_label_cta . ".";
                
            } else if ( $qcld_article_language == "de" ) {
                $prompt_text = " blog-Themen über ";
                $intro_text = "Schreiben Sie eine Einführung über ";
                $conclusion_text = "Schreiben Sie ein Fazit über ";
                $tagline_text = "Schreiben Sie eine Tagline über ";
                $introduction = "Einführung";
                $conclusion = "Fazit";
                $faq_text = strval( $qcld_article_number_of_heading ) . " Fragen und Antworten über " . $qcld_article_text . ".";
                $faq_heading = "Fragen und Antworten";
                $style_text = "Schreibstil: " . $writing_style . ".";
                
                if ( empty($qcld_article_label_keywords) ) {
                    $myprompt = strval( $qcld_article_number_of_heading ) . $prompt_text . $qcld_article_text . ".";
                } else {
                    $keyword_text = ". Schlüsselwörter: " . $qcld_article_label_keywords . ".";
                    $myprompt = strval( $qcld_article_number_of_heading ) . $prompt_text . $qcld_article_text . $keyword_text;
                }
                
                // if $qcld_article_label_word_to_avoid is not empty, add it to the prompt
                
                if ( !empty($qcld_article_label_word_to_avoid) ) {
                    $avoid_text = " Ausschließen folgende Schlüsselwörter: " . $qcld_article_label_word_to_avoid . ".";
                    $myprompt = $myprompt . $avoid_text;
                }
                
                $myintro = $intro_text . $qcld_article_text;
                $myconclusion = $conclusion_text . $qcld_article_text;
                $mytagline = $tagline_text . $qcld_article_text;
                $mycta = "Schreiben Sie eine Call to action über: " . $qcld_article_text . " und erstellen Sie einen href-Tag-Link zu: " . $qcld_article_target_label_cta . ".";
            } else  if ( $qcld_article_language == "fr" ) {
                $prompt_text = " sujets de blog sur ";
                $intro_text = "Écrivez une introduction sur ";
                $conclusion_text = "Écrivez une conclusion sur ";
                $tagline_text = "Rédigez un slogan sur ";
                $introduction = "Introduction";
                $conclusion = "Conclusion";
                $faq_text = strval( $qcld_article_number_of_heading ) . " questions et réponses sur " . $qcld_article_text . ".";
                $faq_heading = "Questions et réponses";
                $style_text = "Style d'écriture: " . $writing_style . ".";
                
                if ( empty($qcld_article_label_keywords) ) {
                    $myprompt = strval( $qcld_article_number_of_heading ) . $prompt_text . $qcld_article_text . ".";
                } else {
                    $keyword_text = ". Mots clés: " . $qcld_article_label_keywords . ".";
                    $myprompt = strval( $qcld_article_number_of_heading ) . $prompt_text . $qcld_article_text . $keyword_text;
                }
                
                // if $qcld_article_label_word_to_avoid is not empty, add it to the prompt
                
                if ( !empty($qcld_article_label_word_to_avoid) ) {
                    $avoid_text = " Exclure les mots-clés suivants: " . $qcld_article_label_word_to_avoid . ".";
                    $myprompt = $myprompt . $avoid_text;
                }
                
                $myintro = $intro_text . $qcld_article_text;
                $myconclusion = $conclusion_text . $qcld_article_text;
                $mytagline = $tagline_text . $qcld_article_text;
                $mycta = "Écrivez un appel à l'action sur: " . $qcld_article_text . " et créez un lien href tag vers: " . $qcld_article_target_label_cta . ".";
    
            } else if ( $qcld_article_language == "es" ) {
                $prompt_text = " temas de blog sobre ";
                $intro_text = "Escribe una introducción sobre ";
                $conclusion_text = "Escribe una conclusión sobre ";
                $tagline_text = "Escribe una eslogan sobre ";
                $introduction = "Introducción";
                $conclusion = "Conclusión";
                $faq_text = strval( $qcld_article_number_of_heading ) . " preguntas y respuestas sobre " . $qcld_article_text . ".";
                $faq_heading = "Preguntas y respuestas";
                $style_text = "Estilo de escritura: " . $writing_style . ".";
                
                if ( empty($qcld_article_label_keywords) ) {
                    $myprompt = strval( $qcld_article_number_of_heading ) . $prompt_text . $qcld_article_text . ".";
                } else {
                    $keyword_text = ". Palabras clave: " . $qcld_article_label_keywords . ".";
                    $myprompt = strval( $qcld_article_number_of_heading ) . $prompt_text . $qcld_article_text . $keyword_text;
                }
                
                // if $qcld_article_label_word_to_avoid is not empty, add it to the prompt
                
                if ( !empty($qcld_article_label_word_to_avoid) ) {
                    $avoid_text = " Excluir las siguientes palabras clave: " . $qcld_article_label_word_to_avoid . ".";
                    $myprompt = $myprompt . $avoid_text;
                }
                
                $myintro = $intro_text . $qcld_article_text;
                $myconclusion = $conclusion_text . $qcld_article_text;
                $mytagline = $tagline_text . $qcld_article_text;
                $mycta = "Escribe una llamada a la acción sobre: " . $qcld_article_text . " y cree un enlace de etiqueta html <a href> para: " . $qcld_article_target_label_cta . ".";
    
            } else if ( $qcld_article_language == "it" ) {
                $prompt_text = " argomenti di blog su ";
                $intro_text = "Scrivi un'introduzione su ";
                $conclusion_text = "Scrivi una conclusione su ";
                $tagline_text = "Scrivi un slogan su ";
                $introduction = "Introduzione";
                $conclusion = "Conclusione";
                $faq_text = strval( $qcld_article_number_of_heading ) . " domande e risposte su " . $qcld_article_text . ".";
                $faq_heading = "Domande e risposte";
                $style_text = "Stile di scrittura: " . $writing_style . ".";
                
                if ( empty($qcld_article_label_keywords) ) {
                    $myprompt = strval( $qcld_article_number_of_heading ) . $prompt_text . $qcld_article_text . ".";
                } else {
                    $keyword_text = ". Parole chiave: " . $qcld_article_label_keywords . ".";
                    $myprompt = strval( $qcld_article_number_of_heading ) . $prompt_text . $qcld_article_text . $keyword_text;
                }
                
                // if $qcld_article_label_word_to_avoid is not empty, add it to the prompt
                
                if ( !empty($qcld_article_label_word_to_avoid) ) {
                    $avoid_text = " Escludere le seguenti parole chiave: " . $qcld_article_label_word_to_avoid . ".";
                    $myprompt = $myprompt . $avoid_text;
                }
                
                $myintro = $intro_text . $qcld_article_text;
                $myconclusion = $conclusion_text . $qcld_article_text;
                $mytagline = $tagline_text . $qcld_article_text;
                $mycta = "Scrivi un call to action su: " . $qcld_article_text . " e crea un href tag link a: " . $qcld_article_target_label_cta . ".";
    
            } else if ( $qcld_article_language == "pt" ) {
                $prompt_text = " tópicos de blog sobre ";
                $intro_text = "Escreva uma introdução sobre ";
                $conclusion_text = "Escreva uma conclusão sobre ";
                $tagline_text = "Escreva um slogan sobre ";
                $introduction = "Introdução";
                $conclusion = "Conclusão";
                $faq_text = strval( $qcld_article_number_of_heading ) . " perguntas e respostas sobre " . $qcld_article_text . ".";
                $faq_heading = "Perguntas e respostas";
                $style_text = "Estilo de escrita: " . $writing_style . ".";
                
                if ( empty($qcld_article_label_keywords) ) {
                    $myprompt = strval( $qcld_article_number_of_heading ) . $prompt_text . $qcld_article_text . ".";
                } else {
                    $keyword_text = ". Palavras-chave: " . $qcld_article_label_keywords . ".";
                    $myprompt = strval( $qcld_article_number_of_heading ) . $prompt_text . $qcld_article_text . $keyword_text;
                }
                
                // if $qcld_article_label_word_to_avoid is not empty, add it to the prompt
                
                if ( !empty($qcld_article_label_word_to_avoid) ) {
                    $avoid_text = " Excluir as seguintes palavras-chave: " . $qcld_article_label_word_to_avoid . ".";
                    $myprompt = $myprompt . $avoid_text;
                }
                
                $myintro = $intro_text . $qcld_article_text;
                $myconclusion = $conclusion_text . $qcld_article_text;
                $mytagline = $tagline_text . $qcld_article_text;
                $mycta = "Escreva um call to action sobre: " . $qcld_article_text . " e crie um href tag link para: " . $qcld_article_target_label_cta . ".";
    
            } else if ( $qcld_article_language == "nl" ) {
                $prompt_text = " blogonderwerpen over ";
                $intro_text = "Schrijf een inleiding over ";
                $conclusion_text = "Schrijf een conclusie over ";
                $tagline_text = "Schrijf een slogan over ";
                $introduction = "Inleiding";
                $conclusion = "Conclusie";
                $faq_text = strval( $qcld_article_number_of_heading ) . " vragen en antwoorden over " . $qcld_article_text . ".";
                $faq_heading = "Vragen en antwoorden";
                $style_text = "Schrijfstijl: " . $writing_style . ".";
                
                if ( empty($qcld_article_label_keywords) ) {
                    $myprompt = strval( $qcld_article_number_of_heading ) . $prompt_text . $qcld_article_text . ".";
                } else {
                    $keyword_text = ". Trefwoorden: " . $qcld_article_label_keywords . ".";
                    $myprompt = strval( $qcld_article_number_of_heading ) . $prompt_text . $qcld_article_text . $keyword_text;
                }
                
                // if $qcld_article_label_word_to_avoid is not empty, add it to the prompt
                
                if ( !empty($qcld_article_label_word_to_avoid) ) {
                    $avoid_text = " Sluit de volgende trefwoorden uit: " . $qcld_article_label_word_to_avoid . ".";
                    $myprompt = $myprompt . $avoid_text;
                }
                
                $myintro = $intro_text . $qcld_article_text;
                $myconclusion = $conclusion_text . $qcld_article_text;
                $mytagline = $tagline_text . $qcld_article_text;
                $mycta = "Schrijf een call to action over: " . $qcld_article_text . " en maak een href tag link naar: " . $qcld_article_target_label_cta . ".";
    
            } else if ( $qcld_article_language == "ru" ) {
                $prompt_text = "Перечислите ";
                $prompt_last = " идей блога о ";
                $intro_text = "Напишите введение о ";
                $conclusion_text = "Напишите заключение о ";
                $tagline_text = "Напишите слоган о ";
                $introduction = "Введение";
                $conclusion = "Заключение";
                $faq_text = strval( $qcld_article_number_of_heading ) . " вопросов и ответов о " . $qcld_article_text . ".";
                $faq_heading = "Вопросы и ответы";
                $style_text = "Стиль написания: " . $writing_style . ".";
                
                if ( empty($qcld_article_label_keywords) ) {
                    $myprompt = $prompt_text . strval( $qcld_article_number_of_heading ) . $prompt_last . $qcld_article_text . ".";
                } else {
                    $keyword_text = ". Ключевые слова: " . $qcld_article_label_keywords . ".";
                    $myprompt = $prompt_text . strval( $qcld_article_number_of_heading ) . $prompt_last . $qcld_article_text . $keyword_text;
                }
                
                // if $qcld_article_label_word_to_avoid is not empty, add it to the prompt
                
                if ( !empty($qcld_article_label_word_to_avoid) ) {
                    $avoid_text = " Исключите следующие ключевые слова: " . $qcld_article_label_word_to_avoid . ".";
                    $myprompt = $myprompt . $avoid_text;
                }
                
                $myintro = $intro_text . $qcld_article_text;
                $myconclusion = $conclusion_text . $qcld_article_text;
                $mytagline = $tagline_text . $qcld_article_text;
                $mycta = "Напишите call to action о: " . $qcld_article_text . " и сделайте href tag link на: " . $qcld_article_target_label_cta . ".";
    
            } else if ( $qcld_article_language == "ja" ) {
                $prompt_text = " に関するブログのアイデアを ";
                $prompt_last = " つ挙げてください";
                $intro_text = " について紹介文を書く";
                $conclusion_text = " についての結論を書く";
                $tagline_text = " についてのスローガンを書く";
                $introduction = "序章";
                $conclusion = "結論";
                $faq_text = $qcld_article_text . " に関する " . strval( $qcld_article_number_of_heading ) . " の質問と回答.";
                $faq_heading = "よくある質問";
                $style_text = "書き方: " . $writing_style . ".";
                
                if ( empty($qcld_article_label_keywords) ) {
                    $myprompt = $qcld_article_text . $prompt_text . strval( $qcld_article_number_of_heading ) . $prompt_last . ".";
                } else {
                    $keyword_text = ". キーワード: " . $qcld_article_label_keywords . ".";
                    $myprompt = $qcld_article_text . $prompt_text . strval( $qcld_article_number_of_heading ) . $prompt_last . $keyword_text;
                }
                
                // if $qcld_article_label_word_to_avoid is not empty, add it to the prompt
                
                if ( !empty($qcld_article_label_word_to_avoid) ) {
                    $avoid_text = " 次のキーワードを除外します。 " . $qcld_article_label_word_to_avoid . ".";
                    $myprompt = $myprompt . $avoid_text;
                }
                
                $myintro = $qcld_article_text . $intro_text;
                $myconclusion = $qcld_article_text . $conclusion_text;
                $mytagline = $qcld_article_text . $tagline_text;
                // Write a call to action about $qcld_article_text and create a href tag link to: $qcld_article_target_label_cta.
                $mycta = $qcld_article_text . " についてのコール・トゥ・アクションを書き、hrefタグリンクを作成します。 " . $qcld_article_target_label_cta . ".";
    
            } else if ( $qcld_article_language == "zh" ) {
                $prompt_text = " 关于 ";
                $of_text = " 的 ";
                $piece_text = " 个博客创意";
                $intro_text = "写一篇关于 ";
                $intro_last = " 的介绍";
                $conclusion_text = "写一篇关于 ";
                // write a tagline about
                $tagline_text = "写一个标语关于 ";
                $conclusion_last = " 的结论";
                $introduction = "介绍";
                $conclusion = "结论";
                $faq_text = $qcld_article_text . " 的 " . strval( $qcld_article_number_of_heading ) . " 个问题和答案.";
                $faq_heading = "常见问题";
                $style_text = "写作风格: " . $writing_style . ".";
                
                if ( empty($qcld_article_label_keywords) ) {
                    $myprompt = $prompt_text . $qcld_article_text . $of_text . strval( $qcld_article_number_of_heading ) . $piece_text . ".";
                } else {
                    $keyword_text = ". 关键字: " . $qcld_article_label_keywords . ".";
                    $myprompt = $prompt_text . $qcld_article_text . $of_text . strval( $qcld_article_number_of_heading ) . $piece_text . $keyword_text;
                }
                
                // if $qcld_article_label_word_to_avoid is not empty, add it to the prompt
                
                if ( !empty($qcld_article_label_word_to_avoid) ) {
                    $avoid_text = " 排除以下关键字：" . $qcld_article_label_word_to_avoid . ".";
                    $myprompt = $myprompt . $avoid_text;
                }
                
                $myintro = $intro_text . $qcld_article_text . $intro_last;
                $myconclusion = $conclusion_text . $qcld_article_text . $conclusion_last;
                $mytagline = $tagline_text . $qcld_article_text;
                // 写一个关于 123 的号召性用语并创建一个 <a href> html 标签链接到：
                $mycta = "写一个关于 " . $qcld_article_text . " 的号召性用语并创建一个 <a href> html 标签链接到： " . $qcld_article_target_label_cta . ".";
    
            } else if ( $qcld_article_language == "ko" ) {
                $prompt_text = " 다음과 관련된 ";
                $prompt_last = "가지 블로그 아이디어: ";
                $intro_text = "블로그 토픽에 대한 소개를 작성하십시오 ";
                $conclusion_text = "블로그 토픽에 대한 결론을 작성하십시오 ";
                $introduction = "소개";
                $conclusion = "결론";
                $faq_text = $qcld_article_text . "에 대한 " . strval( $qcld_article_number_of_heading ) . "개의 질문과 답변.";
                $faq_heading = "자주 묻는 질문";
                // write a tagline about
                $tagline_text = "에 대한 태그라인 작성 ";
                $style_text = "작성 스타일: " . $writing_style . ".";
                
                if ( empty($qcld_article_label_keywords) ) {
                    $myprompt = $prompt_text . strval( $qcld_article_number_of_heading ) . $prompt_last . $qcld_article_text . ".";
                } else {
                    $keyword_text = ". 키워드: " . $qcld_article_label_keywords . ".";
                    $myprompt = $prompt_text . strval( $qcld_article_number_of_heading ) . $prompt_last . $qcld_article_text . $keyword_text;
                }
                
                // if $qcld_article_label_word_to_avoid is not empty, add it to the prompt
                
                if ( !empty($qcld_article_label_word_to_avoid) ) {
                    $avoid_text = " 다음 키워드를 제외하십시오. " . $qcld_article_label_word_to_avoid . ".";
                    $myprompt = $myprompt . $avoid_text;
                }
                
                $myintro = $intro_text . $qcld_article_text;
                $myconclusion = $conclusion_text . $qcld_article_text;
                $mytagline = $qcld_article_text . $tagline_text;
                // Write a call to action about $qcld_article_text and create a href tag link to: $qcld_article_target_label_cta.
                $mycta = $qcld_article_text . "에 대한 호출 행동을 작성하고 href 태그 링크를 만듭니다. " . $qcld_article_target_label_cta . ".";
    
            } else if ( $qcld_article_language == "id" ) {
                $prompt_text = " topik blog tentang ";
                $intro_text = "Tulis pengantar tentang ";
                $conclusion_text = "Tulis kesimpulan tentang ";
                $introduction = "Pengantar";
                $conclusion = "Kesimpulan";
                $faq_text = strval( $qcld_article_number_of_heading ) . " pertanyaan dan jawaban tentang " . $qcld_article_text . ".";
                $faq_heading = "Pertanyaan dan jawaban";
                // write a tagline about
                $tagline_text = "Tulis tagline tentang ";
                $style_text = "Gaya penulisan: " . $writing_style . ".";
                
                if ( empty($qcld_article_label_keywords) ) {
                    $myprompt = strval( $qcld_article_number_of_heading ) . $prompt_text . $qcld_article_text . ".";
                } else {
                    $keyword_text = ". Kata kunci: " . $qcld_article_label_keywords . ".";
                    $myprompt = strval( $qcld_article_number_of_heading ) . $prompt_text . $qcld_article_text . $keyword_text;
                }
                
                // if $qcld_article_label_word_to_avoid is not empty, add it to the prompt
                
                if ( !empty($qcld_article_label_word_to_avoid) ) {
                    $avoid_text = " Hindari kata kunci berikut: " . $qcld_article_label_word_to_avoid . ".";
                    $myprompt = $myprompt . $avoid_text;
                }
                
                $myintro = $intro_text . $qcld_article_text;
                $myconclusion = $conclusion_text . $qcld_article_text;
                $mytagline = $tagline_text . $qcld_article_text;
                // Write a call to action about $qcld_article_text and create a href tag link to: $qcld_article_target_label_cta.
                $mycta = "Tulis panggilan tindakan tentang " . $qcld_article_text . " dan buat tautan tag href ke: " . $qcld_article_target_label_cta . ".";
    
            } else if ( $qcld_article_language == "tr" ) {
                $prompt_text = " hakkında ";
                $prompt_last = " blog başlığı listele.";
                $intro_text = " ile ilgili bir giriş yazısı yaz.";
                $conclusion_text = " ile ilgili bir sonuç yazısı yaz.";
                $introduction = "Giriş";
                $conclusion = "Sonuç";
                $faq_text = $qcld_article_text . " hakkında " . strval( $qcld_article_number_of_heading ) . " soru ve cevap.";
                $faq_heading = "SSS";
                // write a tagline about
                $tagline_text = " ile ilgili bir slogan yaz.";
                $style_text = "Yazı stili: " . $writing_style . ".";
                
                if ( empty($qcld_article_label_keywords) ) {
                    $myprompt = $qcld_article_text . $prompt_text . strval( $qcld_article_number_of_heading ) . $prompt_last . ".";
                } else {
                    $keyword_text = ". Anahtar kelimeler: " . $qcld_article_label_keywords . ".";
                    $myprompt = $qcld_article_text . $prompt_text . strval( $qcld_article_number_of_heading ) . $prompt_last . $keyword_text;
                }
                
                // if $qcld_article_label_word_to_avoid is not empty, add it to the prompt
                
                if ( !empty($qcld_article_label_word_to_avoid) ) {
                    $avoid_text = " Bu anahtar kelimeleri kullanma: " . $qcld_article_label_word_to_avoid . ".";
                    $myprompt = $myprompt . $avoid_text;
                }
                
                $myintro = $qcld_article_text . $intro_text;
                $myconclusion = $qcld_article_text . $conclusion_text;
                $mytagline = $qcld_article_text . $tagline_text;
                // Write a call to action about $qcld_article_text and create a href tag link to: $qcld_article_target_label_cta.
                $mycta = $qcld_article_text . " hakkında bir çağrıyı harekete geçir ve bir href etiketi bağlantısı oluştur: " . $qcld_article_target_label_cta . ".";
    
            } else if ( $qcld_article_language == "hi" ) {
                $prompt_text = " के बारे में ";
                $prompt_last = " ब्लॉग विषय सूचीबद्ध करें.";
                $intro_text = "का परिचय लिखिए ";
                $conclusion_text = "के बारे में निष्कर्ष लिखिए ";
                $introduction = "प्रस्तावना";
                $conclusion = "निष्कर्ष";
                $faq_text = $qcld_article_text . " के बारे में " . strval( $qcld_article_number_of_heading ) . " प्रश्न और उत्तर.";
                $faq_heading = "सामान्य प्रश्न";
                // write a tagline about
                $tagline_text = " के बारे में एक नारा लिखिए";
                $style_text = "लेखन शैली: " . $writing_style . ".";
                
                if ( empty($qcld_article_label_keywords) ) {
                    $myprompt = $qcld_article_text . $prompt_text . strval( $qcld_article_number_of_heading ) . $prompt_last . ".";
                } else {
                    $keyword_text = ". कीवर्ड: " . $qcld_article_label_keywords . ".";
                    $myprompt = $qcld_article_text . $prompt_text . strval( $qcld_article_number_of_heading ) . $prompt_last . $keyword_text;
                }
                
                // if $qcld_article_label_word_to_avoid is not empty, add it to the prompt
                
                if ( !empty($qcld_article_label_word_to_avoid) ) {
                    $avoid_text = " निम्नलिखित खोजशब्दों को बाहर करें: " . $qcld_article_label_word_to_avoid . ".";
                    $myprompt = $myprompt . $avoid_text;
                }
                
                $myintro = $intro_text . $qcld_article_text;
                $myconclusion = $conclusion_text . $qcld_article_text;
                $mytagline = $qcld_article_text . $tagline_text;
                // Write a call to action about $qcld_article_text and create a href tag link to: $qcld_article_target_label_cta.
                $mycta = $qcld_article_text . " के बारे में कोई कॉल एक्शन लिखें और एक href टैग लिंक बनाएं: " . $qcld_article_target_label_cta . ".";
    
            } else if ( $qcld_article_language == "pl" ) {
                $prompt_text = " tematów blogów o ";
                $intro_text = "Napisz wprowadzenie o ";
                $conclusion_text = "Napisz konkluzja o ";
                $introduction = "Wstęp";
                $conclusion = "Konkluzja";
                $faq_text = "Napisz " . strval( $qcld_article_number_of_heading ) . " pytania i odpowiedzi o " . $qcld_article_text . ".";
                $faq_heading = "Pytania i odpowiedzi";
                // write a tagline about
                $tagline_text = "Napisz slogan o ";
                $style_text = "Styl pisania: " . $writing_style . ".";
                
                if ( empty($qcld_article_label_keywords) ) {
                    $myprompt = strval( $qcld_article_number_of_heading ) . $prompt_text . $qcld_article_text . ".";
                } else {
                    $keyword_text = ". Słowa kluczowe:: " . $qcld_article_label_keywords . ".";
                    $myprompt = strval( $qcld_article_number_of_heading ) . $prompt_text . $qcld_article_text . $keyword_text . ".";
                }
                
                // if $qcld_article_label_word_to_avoid is not empty, add it to the prompt
                
                if ( !empty($qcld_article_label_word_to_avoid) ) {
                    $avoid_text = " Wyklucz następujące słowa kluczowe: " . $qcld_article_label_word_to_avoid . ".";
                    $myprompt = $myprompt . $avoid_text;
                }
                
                $myintro = $intro_text . $qcld_article_text;
                $myconclusion = $conclusion_text . $qcld_article_text;
                $mytagline = $tagline_text . $qcld_article_text;
                $mycta = "Napisz wezwanie do działania dotyczące " . $qcld_article_text . " i utwórz link tagu HTML <a href> do: " . $qcld_article_target_label_cta . ".";
    
            } else if ( $qcld_article_language == "uk" ) {
                $prompt_text = " теми блогів про ";
                $intro_text = "Напишіть вступ про ";
                $conclusion_text = "Напишіть висновок про ";
                $introduction = "Вступ";
                $conclusion = "Висновок";
                $faq_text = "Напишіть " . strval( $qcld_article_number_of_heading ) . " питання та відповіді про " . $qcld_article_text . ".";
                $faq_heading = "Питання та відповіді";
                // write a tagline about
                $tagline_text = "Напишіть слоган про ";
                $style_text = "Стиль письма: " . $writing_style . ".";
                
                if ( empty($qcld_article_label_keywords) ) {
                    $myprompt = strval( $qcld_article_number_of_heading ) . $prompt_text . $qcld_article_text . ".";
                } else {
                    $keyword_text = ". Ключові слова: " . $qcld_article_label_keywords . ".";
                    $myprompt = strval( $qcld_article_number_of_heading ) . $prompt_text . $qcld_article_text . $keyword_text;
                }
                // if $qcld_article_label_word_to_avoid is not empty, add it to the prompt
                
                if ( !empty($qcld_article_label_word_to_avoid) ) {
                    $avoid_text = " Виключіть такі ключові слова: " . $qcld_article_label_word_to_avoid . ".";
                    $myprompt = $myprompt . $avoid_text;
                }
                $myintro = $intro_text . $qcld_article_text;
                $myconclusion = $conclusion_text . $qcld_article_text;
                $mytagline = $tagline_text . $qcld_article_text;
                // Напишіть заклик до дії про Google і створіть посилання на тег html <a href> для:
                $mycta = "Напишіть заклик до дії про " . $qcld_article_text . " і створіть посилання на тег html <a href> для: " . $qcld_article_target_label_cta . ".";
    
            } else if ( $qcld_article_language == "ar" ) {
                $prompt_text = " موضوعات المدونات على ";
                $intro_text = "اكتب مقدمة عن: ";
                $conclusion_text = "اكتب استنتاجًا عن: ";
                $introduction = "مقدمة";
                $conclusion = "استنتاج";
                $faq_text = "اكتب " . strval( $qcld_article_number_of_heading ) . " أسئلة وأجوبة عن " . $qcld_article_text . ".";
                $faq_heading = "الأسئلة الشائعة";
                // write a tagline about اكتب شعارًا عن
                $tagline_text = " اكتب شعارًا عن ";
                $style_text = "نمط الكتابة: " . $writing_style . ".";
                
                if ( empty($qcld_article_label_keywords) ) {
                    $myprompt = strval( $qcld_article_number_of_heading ) . $prompt_text . $qcld_article_text . ".";
                } else {
                    $keyword_text = ". الكلمات الدالة: " . $qcld_article_label_keywords . ".";
                    $myprompt = strval( $qcld_article_number_of_heading ) . $prompt_text . $qcld_article_text . $keyword_text;
                }
                
                // if $qcld_article_label_word_to_avoid is not empty, add it to the prompt
                
                if ( !empty($qcld_article_label_word_to_avoid) ) {
                    $avoid_text = " تجنب الكلمات التالية: " . $qcld_article_label_word_to_avoid . ".";
                    $myprompt = $myprompt . $avoid_text;
                }
                
                $myintro = $intro_text . $qcld_article_text;
                $myconclusion = $conclusion_text . $qcld_article_text;
                $mytagline = $qcld_article_text . $tagline_text;
                $mycta = "اكتب عبارة تحث المستخدم على اتخاذ إجراء بشأن " . $qcld_article_text . " وأنشئ <a href> رابط وسم html من أجل: " . $qcld_article_target_label_cta . ".";
    
            } else if ( $qcld_article_language == "ro" ) {
                $prompt_text = " subiecte de blog despre ";
                $intro_text = "Scrieți o introducere despre ";
                $conclusion_text = "Scrieți o concluzie despre ";
                $introduction = "Introducere";
                $conclusion = "Concluzie";
                $faq_text = "Scrieți " . strval( $qcld_article_number_of_heading ) . " întrebări și răspunsuri despre " . $qcld_article_text . ".";
                $faq_heading = "Întrebări și răspunsuri";
                // write a tagline about
                $tagline_text = "Scrieți un slogan despre ";
                $style_text = "Stilul de scriere: " . $writing_style . ".";
                
                if ( empty($qcld_article_label_keywords) ) {
                    $myprompt = strval( $qcld_article_number_of_heading ) . $prompt_text . $qcld_article_text . ".";
                } else {
                    $keyword_text = ". Cuvinte cheie: " . $qcld_article_label_keywords . ".";
                    $myprompt = strval( $qcld_article_number_of_heading ) . $prompt_text . $qcld_article_text . $keyword_text;
                }
                
                // if $qcld_article_label_word_to_avoid is not empty, add it to the prompt
                
                if ( !empty($qcld_article_label_word_to_avoid) ) {
                    $avoid_text = " Evitați cuvintele: " . $qcld_article_label_word_to_avoid . ".";
                    $myprompt = $myprompt . $avoid_text;
                }
                
                $myintro = $intro_text . $qcld_article_text;
                $myconclusion = $conclusion_text . $qcld_article_text;
                $mytagline = $tagline_text . $qcld_article_text;
                // Scrieți un îndemn despre Google și creați o etichetă html <a href> link către:
                $mycta = "Scrieți un îndemn despre " . $qcld_article_text . " și creați o etichetă html <a href> link către: " . $qcld_article_target_label_cta . ".";
    
            } else if ( $qcld_article_language == "hu" ) {
                // Írj 5 blogtémát a Google-ról
                $prompt_text = " blog témákat a következő témában: ";
                $intro_text = "Írj bevezetést ";
                $conclusion_text = "Írj következtetést ";
                $introduction = "Bevezetés";
                $conclusion = "Következtetés";
                $faq_text = "Írj " . strval( $qcld_article_number_of_heading ) . " kérdést és választ a következő témában: " . $qcld_article_text . ".";
                $faq_heading = "GYIK";
                // write a tagline about
                $tagline_text = "Írj egy tagline-t ";
                $style_text = "Írásmód: " . $writing_style . ".";
                
                if ( empty($qcld_article_label_keywords) ) {
                    $myprompt = strval( $qcld_article_number_of_heading ) . $prompt_text . $qcld_article_text . ".";
                } else {
                    $keyword_text = ". Kulcsszavak: " . $qcld_article_label_keywords . ".";
                    $myprompt = strval( $qcld_article_number_of_heading ) . $prompt_text . $qcld_article_text . $keyword_text;
                }
                
                // if $qcld_article_label_word_to_avoid is not empty, add it to the prompt
                
                if ( !empty($qcld_article_label_word_to_avoid) ) {
                    $avoid_text = " Kerülje a következő szavakat: " . $qcld_article_label_word_to_avoid . ".";
                    $myprompt = $myprompt . $avoid_text;
                }
                
                $myintro = $intro_text . $qcld_article_text;
                $myconclusion = $conclusion_text . $qcld_article_text;
                $mytagline = $tagline_text . $qcld_article_text;
                // Írjon cselekvésre ösztönzést a 123-ról, és hozzon létre egy <a href> html címke hivatkozást:
                $mycta = "Írjon cselekvésre ösztönzést a  " . $qcld_article_text . "-rol, témában, és hozzon létre egy <a href> html címke hivatkozást: " . $qcld_article_target_label_cta . ".";
    
            } else if ( $qcld_article_language == "cs" ) {
                $prompt_text = " blog témata o ";
                $intro_text = "Napi úvodní zprávy o ";
                $conclusion_text = "Napi závěrečná zpráva o ";
                $introduction = "Úvodní zpráva";
                $conclusion = "Závěrečná zpráva";
                $faq_text = "Napi " . strval( $qcld_article_number_of_heading ) . " otázky a odpovědi o " . $qcld_article_text . ".";
                $faq_heading = "Často kladené otázky";
                // write a tagline about
                $tagline_text = "Napi tagline o ";
                $style_text = "Styl psaní: " . $writing_style . ".";               
                if ( empty($qcld_article_label_keywords) ) {
                    $myprompt = strval( $qcld_article_number_of_heading ) . $prompt_text . $qcld_article_text . ".";
                } else {
                    $keyword_text = ". Klíčová slova: " . $qcld_article_label_keywords . ".";
                    $myprompt = strval( $qcld_article_number_of_heading ) . $prompt_text . $qcld_article_text . $keyword_text;
                }                
                // if $qcld_article_label_word_to_avoid is not empty, add it to the prompt                
                if ( !empty($qcld_article_label_word_to_avoid) ) {
                    $avoid_text = " Vyhněte se slovům: " . $qcld_article_label_word_to_avoid . ".";
                    $myprompt = $myprompt . $avoid_text;
                }
                $myintro = $intro_text . $qcld_article_text;
                $myconclusion = $conclusion_text . $qcld_article_text;
                $mytagline = $tagline_text . $qcld_article_text;
                // Write a call to action about $qcld_article_text and create a href tag link to: $qcld_article_target_label_cta.
                $mycta = "Napi hovor k akci o " . $qcld_article_text . " a vytvořte href tag link na: " . $qcld_article_target_label_cta . ".";
    
            } else if ( $qcld_article_language == "el" ) {
                $prompt_text = " θέματα ιστολογίου για ";
                $intro_text = "Γράψτε μια εισαγωγή για ";
                $conclusion_text = "Γράψτε μια συμπέραση για ";
                $introduction = "Εισαγωγή";
                $conclusion = "Συμπέραση";
                $faq_text = "Γράψτε " . strval( $qcld_article_number_of_heading ) . " ερωτήσεις και απαντήσεις για " . $qcld_article_text . ".";
                $faq_heading = "Συχνές ερωτήσεις";
                // write a tagline about
                $tagline_text = "Γράψτε μια tagline για ";
                $style_text = "Στυλ συγγραφής: " . $writing_style . ".";
                
                if ( empty($qcld_article_label_keywords) ) {
                    $myprompt = strval( $qcld_article_number_of_heading ) . $prompt_text . $qcld_article_text . ".";
                } else {
                    $keyword_text = ". Λέξεις-κλειδιά: " . $qcld_article_label_keywords . ".";
                    $myprompt = strval( $qcld_article_number_of_heading ) . $prompt_text . $qcld_article_text . $keyword_text;
                }
                
                // if $qcld_article_label_word_to_avoid is not empty, add it to the prompt
                
                if ( !empty($qcld_article_label_word_to_avoid) ) {
                    $avoid_text = " Αποφύγετε τις εξής λέξεις: " . $qcld_article_label_word_to_avoid . ".";
                    $myprompt = $myprompt . $avoid_text;
                }
                
                $myintro = $intro_text . $qcld_article_text;
                $myconclusion = $conclusion_text . $qcld_article_text;
                $mytagline = $tagline_text . $qcld_article_text;
                // Write a call to action about $qcld_article_text and create a href tag link to: $qcld_article_target_label_cta.
                $mycta = "Γράψτε μια κλήση σε ενέργεια για " . $qcld_article_text . " και δημιουργήστε έναν σύνδεσμο href tag στο: " . $qcld_article_target_label_cta . ".";
    
            } else if ( $qcld_article_language == "bg" ) {
                $prompt_text = " блог теми за ";
                $intro_text = "Напишете въведение за ";
                $conclusion_text = "Напишете заключение за ";
                $introduction = "Въведение";
                $conclusion = "Заключение";
                $faq_text = "Напишете " . strval( $qcld_article_number_of_heading ) . " въпроси и отговори за " . $qcld_article_text . ".";
                $faq_heading = "Често задавани въпроси";
                // write a tagline about
                $tagline_text = "Напишете tagline за ";
                $style_text = "Стил на писане: " . $writing_style . ".";
                
                if ( empty($qcld_article_label_keywords) ) {
                    $myprompt = strval( $qcld_article_number_of_heading ) . $prompt_text . $qcld_article_text . ".";
                } else {
                    $keyword_text = ". Ключови думи: " . $qcld_article_label_keywords . ".";
                    $myprompt = strval( $qcld_article_number_of_heading ) . $prompt_text . $qcld_article_text . $keyword_text;
                }                
                // if $qcld_article_label_word_to_avoid is not empty, add it to the prompt                
                if ( !empty($qcld_article_label_word_to_avoid) ) {
                    $avoid_text = " Избягвайте думите: " . $qcld_article_label_word_to_avoid . ".";
                    $myprompt = $myprompt . $avoid_text;
                }
                
                $myintro = $intro_text . $qcld_article_text;
                $myconclusion = $conclusion_text . $qcld_article_text;
                $mytagline = $tagline_text . $qcld_article_text;
                // Write a call to action about $qcld_article_text and create a href tag link to: $qcld_article_target_label_cta.
                $mycta = "Напишете действие за " . $qcld_article_text . " и създайте връзка href tag към: " . $qcld_article_target_label_cta . ".";
    
            } else if ( $qcld_article_language == "sv" ) {
                $prompt_text = " bloggämnen om ";
                $intro_text = "Skriv en introduktion om ";
                $conclusion_text = "Skriv en slutsats om ";
                $introduction = "Introduktion";
                $conclusion = "Slutsats";
                $faq_text = "Skriv " . strval( $qcld_article_number_of_heading ) . " frågor och svar om " . $qcld_article_text . ".";
                $faq_heading = "FAQ";
                // write a tagline about
                $tagline_text = "Skriv en tagline om ";
                $style_text = "Skrivstil: " . $writing_style . ".";
                
                if ( empty($qcld_article_label_keywords) ) {
                    $myprompt = strval( $qcld_article_number_of_heading ) . $prompt_text . $qcld_article_text . ".";
                } else {
                    $keyword_text = ". Nyckelord: " . $qcld_article_label_keywords . ".";
                    $myprompt = strval( $qcld_article_number_of_heading ) . $prompt_text . $qcld_article_text . $keyword_text;
                }               
                // if $qcld_article_label_word_to_avoid is not empty, add it to the prompt               
                if ( !empty($qcld_article_label_word_to_avoid) ) {
                    $avoid_text = " Undvik ord: " . $qcld_article_label_word_to_avoid . ".";
                    $myprompt = $myprompt . $avoid_text;
                }
                
                $myintro = $intro_text . $qcld_article_text;
                $myconclusion = $conclusion_text . $qcld_article_text;
                $mytagline = $tagline_text . $qcld_article_text;
                // Write a call to action about $qcld_article_text and create a href tag link to: $qcld_article_target_label_cta.
                $mycta = "Skriv ett åtgärdsförslag om " . $qcld_article_text . " och skapa en href tag-länk till: " . $qcld_article_target_label_cta . ".";
    
            } else {
                $prompt_text = " blog topics about ";
                $intro_text = "Write an introduction about ";
                $conclusion_text = "Write a conclusion about ";
                $introduction = "Introduction";
                $conclusion = "Conclusion";
                $faq_text = "Write " . strval( $qcld_article_number_of_heading ) . " questions and answers about " . $qcld_article_text . ".";
                $faq_heading = "Q&A";
                // write a tagline about
                $tagline_text = "Write a tagline about ";
                $style_text = "Writing style: " . $writing_style . ".";
                
                if ( empty($qcld_article_label_keywords) ) {
                    $myprompt = strval( $qcld_article_number_of_heading ) . $prompt_text . $qcld_article_text . ".";
                } else {
                    $keyword_text = ". Keywords: " . $qcld_article_label_keywords . ".";
                    $myprompt = strval( $qcld_article_number_of_heading ) . $prompt_text . $qcld_article_text . $keyword_text;
                }
                // if $qcld_article_label_word_to_avoid is not empty, add it to the prompt
                if ( !empty($qcld_article_label_word_to_avoid) ) {
                    $avoid_text = " Exclude the following keywords: " . $qcld_article_label_word_to_avoid . ".";
                    $myprompt = $myprompt . $avoid_text;
                }
                $myintro = $intro_text . $qcld_article_text;
                $myconclusion = $conclusion_text . $qcld_article_text;
                $mytagline = $tagline_text . $qcld_article_text;
                // Write a call to action about $qcld_article_text and create a href tag link to: $qcld_article_target_label_cta.
                $mycta = "Write a call to action about " . $qcld_article_text . " and create a href tag link to: " . $qcld_article_target_label_cta . ".";
                
            }
           
            $result_data = '';
            if(!empty($qcld_article_text)){
                $request_body = [
                    "prompt"            => $myprompt,
                    "model"             => $ai_engines,
                    "max_tokens"        => (int)$max_token,
                    "temperature"       => (float)$temperature,
                    "presence_penalty"  => (float)$ppenalty,
                    "frequency_penalty" => (float)$fpenalty,
                    "top_p"             => 1,
                    "best_of"           => 1,
                ];
                
                $data    = json_encode($request_body);
                $url     = "https://api.openai.com/v1/completions";
                $apt_key = "Authorization: Bearer ". $OPENAI_API_KEY;
    
                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $headers    = array(
                   "Content-Type: application/json",
                   $apt_key ,
                );
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                $result     = curl_exec($curl);
                curl_close($curl);
               // $results    = json_decode($result);
               // $result_data = isset( $results->choices[0]->text ) ? trim( $results->choices[0]->text ) : '';
                $complete = json_decode( $result );
                // we need to catch the error here
                if ( isset( $complete->error ) ) {
                    $complete = $complete->error->message;
                    // exit
                    echo  esc_html( $complete ) ;
                    exit;
                } else {
                    $complete = $complete->choices[0]->text;
                }
                // trim the text
                $complete = trim( $complete );
                $mylist = array();
                $mylist = preg_split( "/\r\n|\n|\r/", $complete );
                // delete 1. 2. 3. etc from beginning of the line
                $mylist = preg_replace( '/^\\d+\\.\\s/', '', $mylist );
                $allresults = "";
                $qcld_article_heading_tag = sanitize_text_field( $_REQUEST["qcld_article_heading_tag"] );
                foreach ( $mylist as $key => $value ) {
                    $withstyle = $value . '. ' . $style_text . ', ' . $tone_text . '.';
                    // if avoid is not empty add it to the prompt
                    if ( !empty(${$wpai_words_to_avoid}) ) {
                        $withstyle = $value . '. ' . $style_text . ', ' . $tone_text . ', ' . $avoid_text . '.';
                    }
    
                    $request_body = [
                        "prompt"            => $myprompt,
                        "model"             => $ai_engines,
                        "max_tokens"        => (int)$max_token,
                        "temperature"       => (float)$temperature,
                        "presence_penalty"  => (float)$ppenalty,
                        "frequency_penalty" => (float)$fpenalty,
                        "top_p"             => 1,
                        "best_of"           => 1,
                    ];
                    $data    = json_encode($request_body);
                    $url     = "https://api.openai.com/v1/completions";
                    $apt_key = "Authorization: Bearer ". $OPENAI_API_KEY;
    
                    $curl = curl_init($url);
                    curl_setopt($curl, CURLOPT_URL, $url);
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    $headers    = array(
                       "Content-Type: application/json",
                       $apt_key ,
                    );
                    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                    $result     = curl_exec($curl);
                    curl_close($curl);
    
                    $complete = json_decode( $result );
                    $complete = isset($complete->choices[0]->text) ? $complete->choices[0]->text : '';
                    // trim the text
                    $complete = trim( $complete );
                    $value = str_replace( '\\/', '', $value );
                    $value = str_replace( '\\', '', $value );
                    // trim value
                    $value = trim( $value );
                    // we will add h tag if the user wants to
    
                    if ( $qcld_article_heading_tag == "h1" ) {
                        $result = "\n"."<h1>" . $value . "</h1>" ."\n". $complete;
                    } elseif ( $qcld_article_heading_tag == "h2" ) {
                        $result = "\n"."<h2>" . $value . "</h2>" ."\n". $complete;
                    } elseif ( $qcld_article_heading_tag == "h3" ) {
                        $result = "\n"."<h3>" . $value . "</h3>" ."\n". $complete;
                    } elseif ( $qcld_article_heading_tag == "h4" ) {
                        $result = "\n"."<h4>" . $value . "</h4>" ."\n". $complete;
                    } elseif ( $qcld_article_heading_tag == "h5" ) {
                        $result = "\n"."<h5>" . $value . "</h5>" ."\n". $complete;
                    } elseif ( $qcld_article_heading_tag == "h6" ) {
                        $result = "\n"."<h6>" . $value . "</h6>" ."\n". $complete;
                    } else {
                        $result = "\n"."<h2>" . $value . "</h2>" ."\n". $complete;
                    }
                    
                    $allresults = $allresults . $result;
                }
    
    
    
                
                if ( $qcld_article_heading_intro == "1" ) {
                    // we need to catch the error here
                    $request_body = [
                        "prompt"            => $myintro,
                        "model"             => $ai_engines,
                        "max_tokens"        => (int)$max_token,
                        "temperature"       => (float)$temperature,
                        "presence_penalty"  => (float)$ppenalty,
                        "frequency_penalty" => (float)$fpenalty,
                        "top_p"             => 1,
                        "best_of"           => 1,
                    ];
                    $data    = json_encode($request_body);
                    $url     = "https://api.openai.com/v1/completions";
                    $apt_key = "Authorization: Bearer ". $OPENAI_API_KEY;
    
                    $curl = curl_init($url);
                    curl_setopt($curl, CURLOPT_URL, $url);
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    $headers    = array(
                       "Content-Type: application/json",
                       $apt_key ,
                    );
                    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                    $result     = curl_exec($curl);
                    curl_close($curl);
    
                    $completeintro = json_decode( $result );
                    
                    if ( isset( $completeintro->error ) ) {
                        $completeintro = $completeintro->error->message;
                        // exit
                        echo  esc_html( $completeintro ) ;
                        exit;
                    } else {
                        $completeintro = $completeintro->choices[0]->text;
                        // trim the text
                        $completeintro = trim( $completeintro );
                        // add <h1>Introuction</h1> to the beginning of the text
                        $completeintro = "\n"."<h1>" . $introduction . "</h1>" ."\n". $completeintro;
                        // add intro to the beginning of the text
                        $allresults = $completeintro . $allresults;
                    }
                
                }
                
                // if wpai_add_faq is checked then call api with faq prompt
                
                if ( $qcld_article_heading_faq == "1" ) {
                    // we need to catch the error here
                    $request_body = [
                        "prompt"            => $faq_text,
                        "model"             => $ai_engines,
                        "max_tokens"        => (int)$max_token,
                        "temperature"       => (float)$temperature,
                        "presence_penalty"  => (float)$ppenalty,
                        "frequency_penalty" => (float)$fpenalty,
                        "top_p"             => 1,
                        "best_of"           => 1,
                    ];
                    $data    = json_encode($request_body);
                    $url     = "https://api.openai.com/v1/completions";
                    $apt_key = "Authorization: Bearer ". $OPENAI_API_KEY;
    
                    $curl = curl_init($url);
                    curl_setopt($curl, CURLOPT_URL, $url);
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    $headers    = array(
                       "Content-Type: application/json",
                       $apt_key ,
                    );
                    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                    $result     = curl_exec($curl);
                    curl_close($curl);
    
                    $completefaq = json_decode( $result );
                    
                    if ( isset( $completefaq->error ) ) {
                        $completefaq = $completefaq->error->message;
                        // exit
                        echo  esc_html( $completefaq ) ;
                        exit;
                    } else {
                        $completefaq = $completefaq->choices[0]->text;
                        // trim the text
                        $completefaq = trim( $completefaq );
                        // add <h1>FAQ</h1> to the beginning of the text
                        $completefaq = "\n"."<h2>" . $faq_heading . "</h2>" ."\n". $completefaq;
                        // add intro to the beginning of the text
                        $allresults = $allresults . $completefaq;
                    }
                
                }
                
                //if myconclusion is not empty,calls the openai api
                
                if ( $qcld_article_heading_conclusion == "1" ) {
             
                    // we need to catch the error here
                    $request_body = [
                        "prompt"            => $myconclusion,
                        "model"             => $ai_engines,
                        "max_tokens"        => (int)$max_token,
                        "temperature"       => (float)$temperature,
                        "presence_penalty"  => (float)$ppenalty,
                        "frequency_penalty" => (float)$fpenalty,
                        "top_p"             => 1,
                        "best_of"           => 1,
                    ];
                    $data    = json_encode($request_body);
                    $url     = "https://api.openai.com/v1/completions";
                    $apt_key = "Authorization: Bearer ". $OPENAI_API_KEY;
    
                    $curl = curl_init($url);
                    curl_setopt($curl, CURLOPT_URL, $url);
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    $headers    = array(
                       "Content-Type: application/json",
                       $apt_key ,
                    );
                    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                    $result     = curl_exec($curl);
                    curl_close($curl);
    
                    $completeconclusion = json_decode( $result );
                    
                    if ( isset( $completeconclusion->error ) ) {
                        $completeconclusion = $completeconclusion->error->message;
                        // exit
                        echo  esc_html( $completeconclusion ) ;
                        exit;
                    } else {
                        $completeconclusion = $completeconclusion->choices[0]->text;
                        // trim the text
                        $completeconclusion = trim( $completeconclusion );
                        // add <h1>Conclusion</h1> to the beginning of the text
                        $completeconclusion = "\n"."<h1>" . $conclusion . "</h1>" ."\n". $completeconclusion;
                        // add intro to the beginning of the text
                        $allresults = $allresults . $completeconclusion;
                    }
                
                }
                
                // qcld_article_heading_tagline is checked then call the openai api
                
                if ( $qcld_article_heading_tagline == "1" ) {
                    // we need to catch the error here
                    $request_body = [
                        "prompt"            => $mytagline,
                        "model"             => $ai_engines,
                        "max_tokens"        => (int)$max_token,
                        "temperature"       => (float)$temperature,
                        "presence_penalty"  => (float)$ppenalty,
                        "frequency_penalty" => (float)$fpenalty,
                        "top_p"             => 1,
                        "best_of"           => 1,
                    ];
                    $data    = json_encode($request_body);
                    $url     = "https://api.openai.com/v1/completions";
                    $apt_key = "Authorization: Bearer ". $OPENAI_API_KEY;
    
                    $curl = curl_init($url);
                    curl_setopt($curl, CURLOPT_URL, $url);
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    $headers    = array(
                       "Content-Type: application/json",
                       $apt_key ,
                    );
                    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                    $result     = curl_exec($curl);
                    curl_close($curl);
    
                    $completetagline = json_decode( $result );
                    
                    if ( isset( $completetagline->error ) ) {
                        $completetagline = $completetagline->error->message;
                        // exit
                        echo  esc_html( $completetagline ) ;
                        exit;
                    } else {
                        $completetagline = $completetagline->choices[0]->text;
                        // trim the text
                        $completetagline = trim( $completetagline );
                        // add <p> to the beginning of the text
                        $completetagline = "\n"."<p>" . $completetagline . "</p>"."\n";
                        // add intro to the beginning of the text
                        $allresults = $completetagline . $allresults;
                    }
                
                }
                
                // if qcld_article_label_keywords_bold is checked then then find all keywords and bold them. keywords are separated by comma
                if ( $qcld_article_label_keywords_bold == "1" ) {
                    // check to see at least one keyword is entered
                    
                    if ( $qcld_article_label_keywords != "" ) {
                        // split keywords by comma if there are more than one but if there is only one then it will not split
                        
                        if ( strpos( $qcld_article_label_keywords, ',' ) !== false ) {
                            $keywords = explode( ",", $qcld_article_label_keywords );
                        } else {
                            $keywords = array( $qcld_article_label_keywords );
                        }
                        
                        // loop through keywords and bold them
                        foreach ( $keywords as $keyword ) {
                            $keyword = trim( $keyword );
                            // replace keyword with bold keyword but make sure exact match is found. for example if the keyword is "the" then it should not replace "there" with "there".. capital dont matter
                            $allresults = preg_replace( '/\\b' . $keyword . '\\b/', '<strong>' . $keyword . '</strong>', $allresults );
                        }
                    }
                
                }
                // if qcld_article_target_url and qcld_article_label_anchor_text is not empty then find qcld_article_label_anchor_text in the text and create a link using qcld_article_target_url
                if ( $qcld_article_target_url != "" && $qcld_article_label_anchor_text != "" ) {
                    // create a link if anchor text found.. rules: 1. only for first occurance 2. exact match 3. case insensitive 4. if anchor text found inside any h1,h2,h3,h4,h5,h6, a then skip it. 5. use anchor text to create link dont replace it with existing text
                    $allresults = preg_replace(
                        '/(?<!<h[1-6]><a href=")(?<!<a href=")(?<!<h[1-6]>)(?<!<h[1-6]><strong>)(?<!<strong>)(?<!<h[1-6]><em>)(?<!<em>)(?<!<h[1-6]><strong><em>)(?<!<strong><em>)(?<!<h[1-6]><em><strong>)(?<!<em><strong>)\\b' . $qcld_article_label_anchor_text . '\\b(?![^<]*<\\/a>)(?![^<]*<\\/h[1-6]>)(?![^<]*<\\/strong>)(?![^<]*<\\/em>)(?![^<]*<\\/strong><\\/em>)(?![^<]*<\\/em><\\/strong>)/i',
                        '<a href="' . $qcld_article_target_url . '">' . $qcld_article_label_anchor_text . '</a>',
                        $allresults,
                        1
                    );
                }
                // if qcld_article_target_label_cta is not empty then call api to get cta text and create a link using qcld_article_target_label_cta
                
                if ( $qcld_article_target_label_cta != "" ) {
                    // call api to get cta text
                    $request_body = [
                        "prompt"            => $mycta,
                        "model"             => $ai_engines,
                        "max_tokens"        => (int)$max_token,
                        "temperature"       => (float)$temperature,
                        "presence_penalty"  => (float)$ppenalty,
                        "frequency_penalty" => (float)$fpenalty,
                        "top_p"             => 1,
                        "best_of"           => 1,
                    ];
                    $data    = json_encode($request_body);
                    $url     = "https://api.openai.com/v1/completions";
                    $apt_key = "Authorization: Bearer ". $OPENAI_API_KEY;
    
                    $curl = curl_init($url);
                    curl_setopt($curl, CURLOPT_URL, $url);
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    $headers    = array(
                       "Content-Type: application/json",
                       $apt_key ,
                    );
                    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                    $result     = curl_exec($curl);
                    curl_close($curl);
    
                    // we need to catch the error here
                    $completecta = json_decode( $result );
                    
                    if ( isset( $completecta->error ) ) {
                        $completecta = $completecta->error->message;
                        // exit
                        echo  esc_html( $completecta ) ;
                        exit;
                    } else {
                        $completecta = $completecta->choices[0]->text;
                        // trim the text
                        $completecta = trim( $completecta );
                        // add <p> to the beginning of the text
                        $completecta = "<p>" . $completecta . "</p>"."\n";
                        
                        if ( $wpai_cta_pos == "beg" ) {
                            $allresults = preg_replace(
                                '/(<h[1-6]>)/',
                                $completecta . ' $1',
                                $allresults,
                                1
                            );
                        } else {
                            $allresults = $allresults . $completecta;
                        }
                    
                    }
                
                }
                
                // if add image is checked then we should send api request to get image
                if ( $qcld_article_heading_img == "1" ) {
                    $request_body = [
                        "prompt"            => $qcld_article_text,
                        "n"                 => 1,
                        "size"              => $img_size,
                        "response_format"   => "url",
                    ];
                    $data    = json_encode($request_body);
                    $url     = "https://api.openai.com/v1/images/generations";
                    $apt_key = "Authorization: Bearer ". $OPENAI_API_KEY;
                    $curl = curl_init($url);
                    curl_setopt($curl, CURLOPT_URL, $url);
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    $headers    = array(
                       "Content-Type: application/json",
                       $apt_key ,
                    );
                    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                    $result     = curl_exec($curl);
                    curl_close($curl);
    
                    // we need to catch the error here
                    $imgresult = json_decode( $result );
    
    
                    $imgresult = $imgresult->data[0]->url;
    
    
                    $array              = explode('/', getimagesize($imgresult)['mime']);
                    $imagetype          = end($array);
                    $uniq_name          = md5($imgresult);
                    $filename           = $uniq_name . '.' . $imagetype;
    
                    $uploaddir          = wp_upload_dir();
                    $target_file_name   = $uploaddir['path'] . '/' . $filename;
    
                    $contents           = file_get_contents( $imgresult );
                    $savefile           = fopen($target_file_name, 'w');
                    fwrite($savefile, $contents);
                    fclose($savefile);
    
                    /* add the image title */
                    $image_title        = ucwords( $uniq_name );
    
                    $qcld_seo_openai_images_attribution = 'gpt openai';
    
                    /* add the caption */
                    $attachment_caption = '';
                    if (! isset($qcld_seo_openai_images_attribution['attribution']) | isset($qcld_seo_openai_images_attribution['attribution']) == 'true')
                        $attachment_caption = '<a href="' . esc_url( $imgresult ) . '" target="_blank" rel="noopener">' . esc_attr( $filename ) . '</a>';
                    unset($imgresult);
                    /* insert the attachment */
                    $wp_filetype = wp_check_filetype(basename($target_file_name), null);
                    $attachment  = array(
                        'guid'              => $uploaddir['url'] . '/' . basename($target_file_name),
                        'post_mime_type'    => $wp_filetype['type'],
                        'post_title'        => $image_title,
                        'post_status'       => 'inherit'
                    );
                    $post_id     = isset($_REQUEST['post_id']) ? absint($_REQUEST['post_id']): '';
                    $attach_id   = wp_insert_attachment($attachment, $target_file_name, $post_id);
                    if ($attach_id == 0)
                        die('Error: File attachment error');
                    $attach_data = wp_generate_attachment_metadata($attach_id, $target_file_name);
                    $result      = wp_update_attachment_metadata($attach_id, $attach_data);
                    $image_data                 = array();
                    $image_data['ID']           = $attach_id;
                    $image_data['post_excerpt'] = $attachment_caption;
                    wp_update_post($image_data);
                    $parsed = wp_get_attachment_image_src( $attach_id, 'medium' )[0];
                    if(!empty($parsed)){
                        $attach_id = $parsed;
                    }
                    $imgresult = "\n"."<img src='" . $attach_id . "' alt='" . $qcld_article_text . "' />"."\n";
                    // get half of qcld_article_number_of_heading and insert image in the middle
                    $half = intval( $qcld_article_number_of_heading ) / 2;
                    $half = round( $half );
                    $half = $half - 1;
                    // use qcld_article_heading_tag to add heading tag to image
                    $allresults = explode( "</" . $qcld_article_heading_tag . ">", $allresults );
                    $allresults[$half] = $allresults[$half] . $imgresult;
                    $allresults = implode( "</" . $qcld_article_heading_tag . ">", $allresults );
                    wp_send_json( [ 'status' => 'success', 'keywords' => $allresults ] );
                    wp_die();
                } else {
                    wp_send_json( [ 'status' => 'success', 'keywords' => $allresults ] );
                    wp_die();
                }
            }
            wp_send_json( [ 'status' => 'success', 'keywords' => $result_data ] );
            wp_die();
    
        }

        public function qcld_seo_image_generate_url_functions() {

            $qcld_seo_result = array(
                'status' => 'error',
                'msg'    => esc_html('Something went wrong'),
            );
    
            /* Download and upload the chosen image */
            if (isset($_POST['qcld_seo_openai_images_upload'])) {
                // "pluggable.php" is required for wp_verify_nonce() and other upload related helpers
                if (!function_exists('wp_verify_nonce'))
                    require_once(ABSPATH . 'wp-includes/pluggable.php');
                if(!function_exists('wp_generate_attachment_metadata')){
                    include_once( ABSPATH . 'wp-admin/includes/image.php' );
                }
                if(!function_exists('download_url')){
                    include_once( ABSPATH . 'wp-admin/includes/file.php' );
                }
                if(!function_exists('media_handle_sideload')){
                    include_once( ABSPATH . 'wp-admin/includes/media.php' );
                }
    
                $post_id                            = isset($_REQUEST['post_id']) ? absint($_REQUEST['post_id']): '';
                $imageurl                           = isset($_POST['image_url']) ? sanitize_url( $_POST['image_url'] ) : '';
                $image_user                         = isset($_POST['image_user']) ? sanitize_url( $_POST['image_user'] ) : '';
                $image_src_page                     = isset($_POST['image_src_page']) ? esc_url( $_POST['image_src_page'] ) : '';
                $qcld_seo_openai_images_attribution = 'gpt openai';
    
                $array              = explode('/', getimagesize($imageurl)['mime']);
                $imagetype          = end($array);
                $uniq_name          = md5($imageurl);
                $filename           = $uniq_name . '.' . $imagetype;
    
                $uploaddir          = wp_upload_dir();
                $target_file_name   = $uploaddir['path'] . '/' . $filename;
    
                $contents           = file_get_contents( $imageurl );
                $savefile           = fopen($target_file_name, 'w');
                fwrite($savefile, $contents);
                fclose($savefile);
                unset($imageurl);
    
                /* add the image title */
                $image_title        = ucwords( $uniq_name );
    
                /* add the caption */
                $attachment_caption = '';
                if (! isset($qcld_seo_openai_images_attribution['attribution']) | isset($qcld_seo_openai_images_attribution['attribution']) == 'true')
                    $attachment_caption = '<a href="' . esc_url( $image_src_page ) . '" target="_blank" rel="noopener">' . esc_attr( $image_user ) . '</a>';
    
                /* insert the attachment */
                $wp_filetype = wp_check_filetype(basename($target_file_name), null);
                $attachment  = array(
                    'guid'              => $uploaddir['url'] . '/' . basename($target_file_name),
                    'post_mime_type'    => $wp_filetype['type'],
                    'post_title'        => $image_title,
                    'post_status'       => 'inherit'
                );
    
                $attach_id   = wp_insert_attachment($attachment, $target_file_name, $post_id);
                if ($attach_id == 0)
                    die('Error: File attachment error');
    
                $attach_data = wp_generate_attachment_metadata($attach_id, $target_file_name);
                $result      = wp_update_attachment_metadata($attach_id, $attach_data);
    
                $image_data                 = array();
                $image_data['ID']           = $attach_id;
                $image_data['post_excerpt'] = $attachment_caption;
                wp_update_post($image_data);
    
               // $parsed = wp_get_attachment_image_src( $attach_id, 'medium' )[0];
    
                /*if(!empty($parsed)){
                    $attach_id = $parsed;
                }*/
    
                $size           = 'large';
                $attachment_id  = $attach_id;
    
                list( $url, $width, $height ) = wp_get_attachment_image_src( $attachment_id, $size );
                //$url = wp_get_attachment_image_url( $attachment_id );
                //var_dump( wp_get_attachment_image_url( $attachment_id ) );
                //wp_die();
                $qcld_seo_result['status']  = 'success';
                $html                       = esc_html('Image Successfully Added to  Media Library');
    
                wp_send_json_success( compact( 'attachment_id', 'url', 'width', 'height', 'size', 'html' ) );
                exit;
    
    
    
              
            }
    
            wp_send_json( $qcld_seo_result );
            exit;
    
    
        }
    }

    /**
     * @return qcld_wpopenai_addon
     */
    if(!function_exists('qcld_wpopenai_addons')){
        function qcld_openais() {
            $qcld_wpopenai_addon = new qcld_wpopenai_addons();
            return $qcld_wpopenai_addon->instance();
        
        }
    }
  
    //fire off the plugin
    qcld_openais();

}