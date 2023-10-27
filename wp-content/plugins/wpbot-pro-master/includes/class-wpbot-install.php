<?php
if( ! class_exists( 'Qcld_WPBot_Install' ) ){
class Qcld_WPBot_Install
{

    public static function qcwp_isset_table_column($table_name, $column_name)
	{
		global $wpdb;
		$columns = $wpdb->get_results("SHOW COLUMNS FROM  " . $table_name, ARRAY_A);
		foreach ($columns as $column) {
			if ($column['Field'] == $column_name) {
				return true;
			}
		}
    }
    
    public static function qcldwpbot_update_option( $key, $value ){
        include plugin_dir_path(__FILE__) . '/admin/settings-fields.php';
    
        if (is_array( $wpbot_languages ) && in_array($key, $wpbot_languages) ){
            $value = maybe_unserialize( $value );
            $value = serialize( array( get_wpbot_locale() => $value ) );
            update_option( $key, $value );
        }else{
            update_option( $key, $value );
        }
    }

    public static function qldf_botwp_content($action){

        if(file_exists(QCLD_wpCHATBOT_PLUGIN_DIR_PATH. '/languages/' .$action.'.txt')){
    
            $myfile = fopen(QCLD_wpCHATBOT_PLUGIN_DIR_PATH. '/languages/' .$action.'.txt', "r");
            $data = '';
            if( $myfile ){
                $data = fread($myfile,filesize(QCLD_wpCHATBOT_PLUGIN_DIR_PATH. '/languages/' .$action.'.txt'));
            }
            fclose($myfile);
            if( $data != '' ){
                if($action=='themedata'){
                    $actionurl = QCLD_theme_BANNER_LANDING;
                }
                if($action=='customservicedata'){
                    $actionurl = QCLD_wpCHATBOT_ACTION;
                }
                if($action=='logodata'){
                    $actionurl = 'https://www.quantumcloud.com/products/';
                }
    
                return '<p class="'.QCLD_wpCHATBOT_ACTION_hook.'"><a target="_blank" href="'.$actionurl.'"><img src="'.$data.'" /></a></p>';
            }
            return '';
        }else{
            return '';
        }
    }

    /**
     * Create Necessary table during installation
     *
     * @return void
     */
    public static function install() {
        global $wpdb;

        $collate = '';
        if ( $wpdb->has_cap( 'collation' ) ) {
    
            if ( ! empty( $wpdb->charset ) ) {
    
                $collate .= "DEFAULT CHARACTER SET $wpdb->charset";
            }
            if ( ! empty( $wpdb->collate ) ) {
    
                $collate .= " COLLATE $wpdb->collate";
    
            }
        }

        $table    = $wpdb->prefix.'wpbot_subscription';
        if($wpdb->get_var("SHOW TABLES LIKE '$table'") != $table) {
            $sql_sliders_Table = "
                CREATE TABLE IF NOT EXISTS `$table` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(256) NOT NULL,
                `email` varchar(256) NOT NULL,
                `phone` varchar(256) NOT NULL,
                `url` text NOT NULL,
                `date` datetime NOT NULL,
                `user_agent` text NOT NULL,
                PRIMARY KEY (`id`)
                )  $collate AUTO_INCREMENT=1 ";
                
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql_sliders_Table );
        }


        
        if ( ! self::qcwp_isset_table_column( $table, 'phone' ) ) {
            $sql_wp_Table_update_1 = "ALTER TABLE `$table` ADD `phone` varchar(256) NOT NULL;";
            $wpdb->query( $sql_wp_Table_update_1 );
        }
    
        //Bot User Table
        $table1    = $wpdb->prefix.'wpbot_user';
        if($wpdb->get_var("SHOW TABLES LIKE '$table1'") != $table1) {
            $sql_sliders_Table1 = "
                CREATE TABLE IF NOT EXISTS `$table1` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `session_id` varchar(256) NOT NULL,
                `name` varchar(256) NOT NULL,
                `email` varchar(256) NOT NULL,
                `phone` varchar(256) NOT NULL,
                `date` datetime NOT NULL,
                `user_id` int(11) NOT NULL,
                PRIMARY KEY (`id`)
                )  $collate AUTO_INCREMENT=1 ";
                
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql_sliders_Table1 );
        }
    
        
        if ( ! self::qcwp_isset_table_column( $table1, 'phone' ) ) {
            $sql_wp_Table_update_1 = "ALTER TABLE `$table1` ADD `phone` varchar(256) NOT NULL;";
            $wpdb->query( $sql_wp_Table_update_1 );
        }
        if ( ! self::qcwp_isset_table_column( $table1, 'user_id' ) ) {
            $sql_wp_Table_update_1 = "ALTER TABLE `$table1` ADD `user_id` int(11) NOT NULL;";
            $wpdb->query( $sql_wp_Table_update_1 );
        }
        //Bot User Table
        $table1    = $wpdb->prefix.'wpbot_Conversation';
        if($wpdb->get_var("SHOW TABLES LIKE '$table1'") != strtolower($table1)) {
            $sql_sliders_Table1 = "
                CREATE TABLE IF NOT EXISTS `$table1` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `user_id` int(11) NOT NULL,
                `conversation` LONGTEXT NOT NULL,
                PRIMARY KEY (`id`)
                )  $collate AUTO_INCREMENT=1 ";
                
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql_sliders_Table1 );
        }
    
        //Bot Response Table
        $table1    = $wpdb->prefix.'wpbot_response';
        if($wpdb->get_var("SHOW TABLES LIKE '$table1'") != $table1) {
            $sql_sliders_Table1 = "
                CREATE TABLE IF NOT EXISTS `$table1` (
                `id` INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
                `query` TEXT NOT NULL,
                `keyword` TEXT NOT NULL,
                `response` TEXT NOT NULL,
                `category` varchar(256) NOT NULL,
                `intent` varchar(256) NOT NULL,
                `custom` TEXT NOT NULL,
                `lang` varchar(25) NOT NULL,
                `trigger_intent` varchar(100) NOT NULL,
                `users_answer` TEXT NOT NULL,
                `hidden` INT NOT NULL,
                FULLTEXT(`query`, `keyword`, `response`)
                )  $collate AUTO_INCREMENT=1 ENGINE=InnoDB";
                
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql_sliders_Table1 );
        }

        if ( ! self::qcwp_isset_table_column( $table1, 'lang' ) ) {
            $sql_wp_Table_update_1 = "ALTER TABLE `$table1` ADD `lang` varchar(25) NOT NULL;";
            $wpdb->query( $sql_wp_Table_update_1 );
        }

        if ( ! self::qcwp_isset_table_column( $table1, 'trigger_intent' ) ) {
            $sql_wp_Table_update_1 = "ALTER TABLE `$table1` ADD `trigger_intent` varchar(100) NOT NULL;";
            $wpdb->query( $sql_wp_Table_update_1 );
        }

        if ( ! self::qcwp_isset_table_column( $table1, 'users_answer' ) ) {
            $sql_wp_Table_update_1 = "ALTER TABLE `$table1` ADD `users_answer` TEXT NOT NULL;";
            $wpdb->query( $sql_wp_Table_update_1 );
        }

        if ( ! self::qcwp_isset_table_column( $table1, 'hidden' ) ) {
            $sql_wp_Table_update_1 = "ALTER TABLE `$table1` ADD `hidden` INT NOT NULL;";
            $wpdb->query( $sql_wp_Table_update_1 );
        }

        $sql_wp_Table_update_1 = "ALTER TABLE `$table1` CHANGE `custom` `custom` TEXT NOT NULL;";
        $wpdb->query( $sql_wp_Table_update_1 );

        $sqlqry = $wpdb->get_results("select * from $table1");
        if(empty($sqlqry)){
            $query = 'What Can WPBot do for you?';
            $response = 'WPBot can converse fluidly with users on website and FB messenger. It can search your website, send/collect eMails, user feedback & phone numbers . You can create Custom Intents from DialogFlow with Rich Messages & Card responses!';
    
            $data = array('query' => $query, 'keyword' => '', 'response'=> $response, 'intent'=> '');
            $format = array('%s','%s', '%s', '%s');
            $wpdb->insert($table1,$data,$format);
        }

        //Bot Response category Table
        $table1    = $wpdb->prefix.'wpbot_response_category';
        if($wpdb->get_var("SHOW TABLES LIKE '$table1'") != $table1) {
            $sql_sliders_Table1 = "
                CREATE TABLE IF NOT EXISTS `$table1` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(256) NOT NULL,
                `custom` varchar(256) NOT NULL,
                PRIMARY KEY (`id`)
                )  $collate AUTO_INCREMENT=1 ";
                
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql_sliders_Table1 );
        }

        //Bot Response entities Table
        $table1    = $wpdb->prefix.'wpbot_response_entities';
        if($wpdb->get_var("SHOW TABLES LIKE '$table1'") != $table1) {
            $sql_sliders_Table1 = "
                CREATE TABLE IF NOT EXISTS `$table1` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `entity_name` varchar(256) NOT NULL,
                `entity` varchar(256) NOT NULL,
                `synonyms` TEXT NOT NULL,
                PRIMARY KEY (`id`)
                )  $collate AUTO_INCREMENT=1 ";
                
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql_sliders_Table1 );
        }
	
        
        //Bot User Table
        $table1    = $wpdb->prefix.'wpbot_sessions';
        if($wpdb->get_var("SHOW TABLES LIKE '$table1'") != $table1) {
            $sql_sliders_Table1 = "
                CREATE TABLE IF NOT EXISTS `$table1` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `session` int(11) NOT NULL,
                PRIMARY KEY (`id`)
                )  $collate AUTO_INCREMENT=1 ";
                
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql_sliders_Table1 );
        }
        
    
        $url = get_site_url();
        $url = parse_url($url);
        $domain = $url['host'];
        
        $admin_email = get_option('admin_email');
    
        if(!get_option('wp_chatbot_position_x')) {
            self::qcldwpbot_update_option('wp_chatbot_position_x', 50);
        }
        if(!get_option('wp_chatbot_position_y')) {
            self::qcldwpbot_update_option('wp_chatbot_position_y', 50);
        }
        if(!get_option('wp_chatbot_position_in')) {
            self::qcldwpbot_update_option('wp_chatbot_position_in', 'px');
        }
        if(!get_option('wp_chatbot_position_mp_x')) {
            self::qcldwpbot_update_option('wp_chatbot_position_mp_x', 50);
        }
        if(!get_option('wp_chatbot_position_mp_y')) {
            self::qcldwpbot_update_option('wp_chatbot_position_mp_y', 50);
        }
        if(!get_option('wp_chatbot_position_mp_in')) {
            self::qcldwpbot_update_option('wp_chatbot_position_mp_in', 'px');
        }
        if(!get_option('disable_wp_chatbot')) {
            self::qcldwpbot_update_option('disable_wp_chatbot', '');
        }
        if(!get_option('disable_wp_chatbot_floating_icon')) {
            self::qcldwpbot_update_option('disable_wp_chatbot_floating_icon', '');
        }
    
        if(!get_option('delay_wp_chatbot_floating_icon')){
            self::qcldwpbot_update_option('delay_wp_chatbot_floating_icon','');
        }
        if(!get_option('delay_wp_chatbot_window_open')){
            self::qcldwpbot_update_option('delay_wp_chatbot_window_open','');
        }
        
        if(!get_option('delay_floating_notification_box')){
            self::qcldwpbot_update_option('delay_floating_notification_box','');
        }
        
        if(!get_option('skip_wp_greetings')) {
            self::qcldwpbot_update_option('skip_wp_greetings', '');
        }
    
        if(!get_option('skip_wp_greetings_trigger_intent')) {
            self::qcldwpbot_update_option('skip_wp_greetings_trigger_intent', '');
        }
        if(!get_option('qcld_disable_start_menu')) {
            self::qcldwpbot_update_option('qcld_disable_start_menu', '');
        }
      
        if(!get_option('show_menu_after_greetings')) {
            self::qcldwpbot_update_option('show_menu_after_greetings', '');
        }
    
        if(!get_option('show_intent_navigation_notification')) {
            self::qcldwpbot_update_option('show_intent_navigation_notification', '');
        }
    
        
    
        if(!get_option('enable_wp_chatbot_disable_producticon')) {
            self::qcldwpbot_update_option('enable_wp_chatbot_disable_producticon', '');
        }
        if(!get_option('enable_wp_chatbot_disable_carticon')) {
            self::qcldwpbot_update_option('enable_wp_chatbot_disable_carticon', '');
        }
    
        if(!get_option('disable_youtube_parse')) {
            self::qcldwpbot_update_option('disable_youtube_parse', '');
        }
        
    
        if(!get_option('wpbot_support_mail_to_crm_contact')) {
            self::qcldwpbot_update_option('wpbot_support_mail_to_crm_contact', 1);
        }
        
        if(!get_option('disable_first_msg')) {
            self::qcldwpbot_update_option('disable_first_msg', '');
        }
        if(!get_option('enable_reset_close_button')) {
            self::qcldwpbot_update_option('enable_reset_close_button', '');
        }
        if(!get_option('qc_auto_hide_floating_button')) {
            self::qcldwpbot_update_option('qc_auto_hide_floating_button', '');
        }
    
        
    
        if(!get_option('qlcd_wp_chatbot_reset_lan')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_reset_lan', 'Reset');
        }
    
        if(!get_option('qlcd_wp_chatbot_close_lan')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_close_lan', 'Close');
        }
    
        
        if(!get_option('ask_email_wp_greetings')) {
            self::qcldwpbot_update_option('ask_email_wp_greetings', '');
        }
        if(!get_option('ask_name_confirmation')) {
            self::qcldwpbot_update_option('ask_name_confirmation', '');
        }
        if(!get_option('ask_phone_wp_greetings')) {
            self::qcldwpbot_update_option('ask_phone_wp_greetings', '');
        }
        if(!get_option('disable_phone_validity')) {
            self::qcldwpbot_update_option('disable_phone_validity', '');
        }
        if(!get_option('qc_email_subscription_offer')) {
            self::qcldwpbot_update_option('qc_email_subscription_offer', '');
        }
        if(!get_option('qc_site_search_priority')) {
            self::qcldwpbot_update_option('qc_site_search_priority', '');
        }
        
        if(!get_option('enable_wp_chatbot_open_initial')) {
            self::qcldwpbot_update_option('enable_wp_chatbot_open_initial', '');
        }
        if(!get_option('wp_keep_chat_window_open')) {
            self::qcldwpbot_update_option('wp_keep_chat_window_open', '');
        }
        
        
    
        if(!get_option('disable_wp_chatbot_icon_animation')) {
            self::qcldwpbot_update_option('disable_wp_chatbot_icon_animation', '');
        }
        if(!get_option('enable_extended_header_animation')) {
            self::qcldwpbot_update_option('enable_extended_header_animation', '');
        }
        
        if(!get_option('disable_wp_agent_icon_animation')) {
            self::qcldwpbot_update_option('disable_wp_agent_icon_animation', '');
        }
    
        
    
        if(!get_option('disable_wp_chatbot_history')) {
            self::qcldwpbot_update_option('disable_wp_chatbot_history', '');
        }
        if(!get_option('always_scroll_to_bottom')) {
            self::qcldwpbot_update_option('always_scroll_to_bottom', '');
        }
        if(!get_option('disable_wp_chatbot_on_mobile')) {
            self::qcldwpbot_update_option('disable_wp_chatbot_on_mobile', '');
        }
    
        if(!get_option('disable_auto_focus_message_area')) {
            self::qcldwpbot_update_option('disable_auto_focus_message_area', '');
        }
        if(!get_option('open_ai_enable')) {
            self::qcldwpbot_update_option('open_ai_enable', '0');
        }
        if(!get_option('openai_max_tokens')){
            self::qcldwpbot_update_option('openai_max_tokens','200');
        }
        if(!get_option('qcld_openai_suffix')){
            self::qcldwpbot_update_option('qcld_openai_suffix','qcld');
        }
        if(!get_option('disable_livechat_operator_offline')) {
            self::qcldwpbot_update_option('disable_livechat_operator_offline', '');
        }
        if(!get_option('disable_wp_chatbot_product_search')) {
            self::qcldwpbot_update_option('disable_wp_chatbot_product_search', '');
        }
        if(!get_option('disable_wp_chatbot_catalog')) {
            self::qcldwpbot_update_option('disable_wp_chatbot_catalog', '');
        }
    
        if(!get_option('enable_wp_chatbot_disable_chaticon')) {
            self::qcldwpbot_update_option('enable_wp_chatbot_disable_chaticon', '');
        }
    
        if(!get_option('enable_wp_chatbot_disable_supporticon')) {
            self::qcldwpbot_update_option('enable_wp_chatbot_disable_supporticon', '');
        }
    
        if(!get_option('enable_wp_chatbot_disable_helpicon')) {
            self::qcldwpbot_update_option('enable_wp_chatbot_disable_helpicon', '');
        }
    
        if(!get_option('enable_wp_chatbot_disable_allicon')) {
            self::qcldwpbot_update_option('enable_wp_chatbot_disable_allicon', '');
        }
    
        if(!get_option('disable_wp_chatbot_order_status')) {
            self::qcldwpbot_update_option('disable_wp_chatbot_order_status', '');
        }
        if(!get_option('enable_wp_chatbot_rtl')) {
            self::qcldwpbot_update_option('enable_wp_chatbot_rtl', '');
        }
        if(!get_option('enable_wp_chatbot_mobile_full_screen')) {
            self::qcldwpbot_update_option('enable_wp_chatbot_mobile_full_screen', '');
        }
        if(!get_option('chatbot_content_max_height')) {
            self::qcldwpbot_update_option('chatbot_content_max_height', '');
        }
        
        if(!get_option('enable_wp_chatbot_gdpr_compliance')) {
            self::qcldwpbot_update_option('enable_wp_chatbot_gdpr_compliance', '');
        }
        if(!get_option('wpbot_search_result_new_window')) {
            self::qcldwpbot_update_option('wpbot_search_result_new_window', '');
        }
    
        if(!get_option('wpbot_card_response_same_window')) {
            self::qcldwpbot_update_option('wpbot_card_response_same_window', '');
        }
    
        
    
        if(!get_option('wpbot_search_image_size')) {
            self::qcldwpbot_update_option('wpbot_search_image_size', 'thumbnail');
        }
    
        
        if(!get_option('wpbot_disable_repeatative')) {
            self::qcldwpbot_update_option('wpbot_disable_repeatative', '');
        }
        if(!get_option('qc_display_for_loggedin_users')) {
            self::qcldwpbot_update_option('qc_display_for_loggedin_users', '');
        }
    
        if(!get_option('wpbot_preloading_time')) {
            self::qcldwpbot_update_option('wpbot_preloading_time', '0');
        }
    
        
    
        if(!get_option('qlcd_wp_chatbot_cart_total')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_cart_total', serialize(array('Total')));
        }
        
    
        if(!get_option('wpbot_search_result_number')) {
            self::qcldwpbot_update_option('wpbot_search_result_number', '');
        }
    
        if(!get_option('wpbot_gdpr_text')) {
            self::qcldwpbot_update_option('wpbot_gdpr_text', 'We will never spam you! You can read our <a href="#" target="_blank">Privacy Policy here.</a>');
        }

        if(!get_option('no_result_attempt_message')) {
            self::qcldwpbot_update_option('no_result_attempt_message', '');
        }
        
    
        if(!get_option('no_result_attempt_count')) {
            self::qcldwpbot_update_option('no_result_attempt_count', 3);
        }
    
         if(!get_option('disable_wp_chatbot_notification')) {
            self::qcldwpbot_update_option('disable_wp_chatbot_notification', '0');
        }
        if(!get_option('disable_wp_chatbot_notification_mobile')) {
            self::qcldwpbot_update_option('disable_wp_chatbot_notification_mobile', '0');
        }
    
        if(!get_option('wp_chatbot_exclude_post_list')) {
            self::qcldwpbot_update_option('wp_chatbot_exclude_post_list', serialize(array()));
        }
    
        if(!get_option('wp_chatbot_exclude_pages_list')) {
            self::qcldwpbot_update_option('wp_chatbot_exclude_pages_list', serialize(array()));
        }
    
        if(!get_option('wpbot_click_chat_text')) {
            self::qcldwpbot_update_option('wpbot_click_chat_text', 'Click to Chat');
        }
        if(!get_option('qc_wpbot_menu_order')) {
            self::qcldwpbot_update_option('qc_wpbot_menu_order', '');
        }
    
        
    
        if(!get_option('disable_wp_chatbot_cart_item_number')) {
            self::qcldwpbot_update_option('disable_wp_chatbot_cart_item_number', '');
        }
        if(!get_option('disable_wp_chatbot_featured_product')) {
            self::qcldwpbot_update_option('disable_wp_chatbot_featured_product', '');
        }
        if(!get_option('disable_wp_chatbot_sale_product')) {
            self::qcldwpbot_update_option('disable_wp_chatbot_sale_product', '');
        }
         if(!get_option('wp_chatbot_open_product_detail')) {
            self::qcldwpbot_update_option('wp_chatbot_open_product_detail', '');
        }
        if(!get_option('qlcd_woo_chatbot_product_orderby')) {
            self::qcldwpbot_update_option('qlcd_woo_chatbot_product_orderby', sanitize_text_field('title'));
        }
    
        if(!get_option('wp_chatbot_exitintent_show_pages')){
            self::qcldwpbot_update_option('wp_chatbot_exitintent_show_pages', 'on');
        }
    
        if(!get_option('wp_chatbot_scrollintent_show_pages')){
            self::qcldwpbot_update_option('wp_chatbot_scrollintent_show_pages', 'on');
        }
    
        if(!get_option('wp_chatbot_autointent_show_pages')){
            self::qcldwpbot_update_option('wp_chatbot_autointent_show_pages', 'on');
        }
    
        if(!get_option('wp_chatbot_exitintent_show_pages_list')) {
            self::qcldwpbot_update_option('wp_chatbot_exitintent_show_pages_list', serialize(array()));
        }
        if(!get_option('wpbot_notification_navigations')) {
            self::qcldwpbot_update_option('wpbot_notification_navigations', serialize(array()));
        }
    
    
        if(!get_option('qlcd_woo_chatbot_product_order')) {
            self::qcldwpbot_update_option('qlcd_woo_chatbot_product_order', sanitize_text_field('ASC'));
        }
        if(!get_option('qlcd_wp_chatbot_ppp')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_ppp', intval(6));
        }
        if(!get_option('wp_chatbot_exclude_stock_out_product')) {
            self::qcldwpbot_update_option('wp_chatbot_exclude_stock_out_product', '');
        }
        if(!get_option('wp_chatbot_show_sub_category')) {
            self::qcldwpbot_update_option('wp_chatbot_show_sub_category', '');
        }
        if(!get_option('wp_chatbot_vertical_custom')){
            self::qcldwpbot_update_option('wp_chatbot_vertical_custom', 'Go To');
        }
        if(!get_option('wp_chatbot_show_home_page')) {
            self::qcldwpbot_update_option('wp_chatbot_show_home_page', 'on');
        }
        if(!get_option('wp_chatbot_show_posts')) {
            self::qcldwpbot_update_option('wp_chatbot_show_posts', 'on');
        }
        if(!get_option('wp_chatbot_show_pages')){
            self::qcldwpbot_update_option('wp_chatbot_show_pages', 'on');
        }
        if(!get_option('wp_chatbot_show_pages_list')) {
            self::qcldwpbot_update_option('wp_chatbot_show_pages_list', serialize(array()));
        }
        if(!get_option('wp_chatbot_show_woocommerce')) {
            self::qcldwpbot_update_option('wp_chatbot_show_woocommerce', 'on');
        }
        if(!get_option('qlcd_wp_chatbot_stop_words_name')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_stop_words_name', 'english');
        }
        if(!get_option('qlcd_wp_chatbot_stop_words')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_stop_words', "a,able,about,above,abst,accordance,according,accordingly,across,act,actually,added,adj,affected,affecting,affects,after,afterwards,again,against,ah,all,almost,alone,along,already,also,although,always,am,among,amongst,an,and,announce,another,any,anybody,anyhow,anymore,anyone,anything,anyway,anyways,anywhere,apparently,approximately,are,aren,arent,arise,around,as,aside,ask,asking,at,auth,available,away,awfully,b,back,be,became,because,become,becomes,becoming,been,before,beforehand,begin,beginning,beginnings,begins,behind,being,believe,below,beside,besides,between,beyond,biol,both,brief,briefly,but,by,c,ca,came,can,cannot,can't,cause,causes,certain,certainly,co,com,come,comes,contain,containing,contains,could,couldnt,d,date,did,didn't,different,do,does,doesn't,doing,done,don't,down,downwards,due,during,e,each,ed,edu,effect,eg,eight,eighty,either,else,elsewhere,end,ending,enough,especially,et,et-al,etc,even,ever,every,everybody,everyone,everything,everywhere,ex,except,f,far,few,ff,fifth,first,five,fix,followed,following,follows,for,former,formerly,forth,found,four,from,further,furthermore,g,gave,get,gets,getting,give,given,gives,giving,go,goes,gone,got,gotten,h,had,happens,hardly,has,hasn't,have,haven't,having,he,hed,hence,her,here,hereafter,hereby,herein,heres,hereupon,hers,herself,hes,hi,hid,him,himself,his,hither,home,how,howbeit,however,hundred,i,id,ie,if,i'll,im,immediate,immediately,importance,important,in,inc,indeed,index,information,instead,into,invention,inward,is,isn't,it,itd,it'll,its,itself,i've,j,just,k,keep,keeps,kept,kg,km,know,known,knows,l,largely,last,lately,later,latter,latterly,least,less,lest,let,lets,like,liked,likely,line,little,'ll,look,looking,looks,ltd,m,made,mainly,make,makes,many,may,maybe,me,mean,means,meantime,meanwhile,merely,mg,might,million,miss,ml,more,moreover,most,mostly,mr,mrs,much,mug,must,my,myself,n,na,name,namely,nay,nd,near,nearly,necessarily,necessary,need,needs,neither,never,nevertheless,new,next,nine,ninety,no,nobody,non,none,nonetheless,noone,nor,normally,nos,not,noted,nothing,now,nowhere,o,obtain,obtained,obviously,of,off,often,oh,ok,okay,old,omitted,on,once,one,ones,only,onto,or,ord,other,others,otherwise,ought,our,ours,ourselves,out,outside,over,overall,owing,own,p,page,pages,part,particular,particularly,past,per,perhaps,placed,please,plus,poorly,possible,possibly,potentially,pp,predominantly,present,previously,primarily,probably,promptly,proud,provides,put,q,que,quickly,quite,qv,r,ran,rather,rd,re,readily,really,recent,recently,ref,refs,regarding,regardless,regards,related,relatively,research,respectively,resulted,resulting,results,right,run,s,said,same,saw,say,saying,says,sec,section,see,seeing,seem,seemed,seeming,seems,seen,self,selves,sent,seven,several,shall,she,shed,she'll,shes,should,shouldn't,show,showed,shown,showns,shows,significant,significantly,similar,similarly,since,six,slightly,so,some,somebody,somehow,someone,somethan,something,sometime,sometimes,somewhat,somewhere,soon,sorry,specifically,specified,specify,specifying,still,stop,strongly,sub,substantially,successfully,such,sufficiently,suggest,sup,sure,t,take,taken,taking,tell,tends,th,than,thank,thanks,thanx,that,that'll,thats,that've,the,their,theirs,them,themselves,then,thence,there,thereafter,thereby,thered,therefore,therein,there'll,thereof,therere,theres,thereto,thereupon,there've,these,they,theyd,they'll,theyre,they've,think,this,those,thou,though,thoughh,thousand,throug,through,throughout,thru,thus,til,tip,to,together,too,took,toward,towards,tried,tries,truly,try,trying,ts,twice,two,u,un,under,unfortunately,unless,unlike,unlikely,until,unto,up,upon,ups,us,use,used,useful,usefully,usefulness,uses,using,usually,v,value,various,'ve,very,via,viz,vol,vols,vs,w,want,wants,was,wasnt,way,we,wed,welcome,we'll,went,were,werent,we've,what,whatever,what'll,whats,when,whence,whenever,where,whereafter,whereas,whereby,wherein,wheres,whereupon,wherever,whether,which,while,whim,whither,who,whod,whoever,whole,who'll,whom,whomever,whos,whose,why,widely,willing,wish,with,within,without,wont,words,world,would,wouldnt,www,x,y,yes,yet,you,youd,you'll,your,youre,yours,yourself,yourselves,you've,z,zero");
        }
        if(!get_option('qlcd_wp_chatbot_order_user')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_order_user', sanitize_text_field('login'));
        }
        if(!get_option('wp_chatbot_custom_agent_path')) {
            self::qcldwpbot_update_option('wp_chatbot_custom_agent_path', '');
        }
        if(!get_option('wp_chatbot_custom_icon_path')) {
            self::qcldwpbot_update_option('wp_chatbot_custom_icon_path', '');
        }
    
        if(!get_option('wp_chatbot_icon') || get_option('wp_chatbot_icon')=='icon-13.png') {
            self::qcldwpbot_update_option('wp_chatbot_icon', sanitize_text_field('icon-0.png'));
        }
        if(!get_option('wp_chatbot_agent_image')){
            self::qcldwpbot_update_option('wp_chatbot_agent_image',sanitize_text_field('agent-0.png'));
        }
        if(!get_option('qcld_wb_chatbot_theme')) {
            self::qcldwpbot_update_option('qcld_wb_chatbot_theme', sanitize_text_field('template-01'));
        }
        if(!get_option('qcld_wb_chatbot_change_bg')) {
            self::qcldwpbot_update_option('qcld_wb_chatbot_change_bg', '');
        }
        if(!get_option('wp_chatbot_custom_css')) {
            self::qcldwpbot_update_option('wp_chatbot_custom_css', '');
        }
        if(!get_option('qlcd_wp_chatbot_host')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_host', sanitize_text_field('Our Website'));
        }
        if(!get_option('qlcd_wp_chatbot_agent')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_agent', sanitize_text_field('Carrie'));
        }
        if(!get_option('qlcd_wp_chatbot_host')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_host', sanitize_text_field('Our Website'));
        }
        if(!get_option('qlcd_wp_chatbot_shopper_demo_name')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_shopper_demo_name', sanitize_text_field('Amigo'));
        }
        if(!get_option('qlcd_wp_chatbot_shopper_call_you')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_shopper_call_you', sanitize_text_field('Ok, I will just call you'));
        }
        if(!get_option('qlcd_wp_chatbot_yes')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_yes', sanitize_text_field('YES'));
        }
        if(!get_option('qlcd_wp_chatbot_no')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_no', sanitize_text_field('NO'));
        }
        if(!get_option('qlcd_wp_chatbot_or')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_or', sanitize_text_field('OR'));
        }
        if(!get_option('qlcd_wp_chatbot_sorry')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_sorry', sanitize_text_field('Sorry'));
        }
        if(!get_option('qlcd_wp_chatbot_hello')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_hello', sanitize_text_field('Hello'));
        }
    
        if(!get_option('qlcd_wp_chatbot_chat_with_us')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_chat_with_us', sanitize_text_field('Chat with us!'));
        }
        
        if(!get_option('qlcd_wp_chatbot_help')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_help', sanitize_text_field('Help'));
        }
        
        if(!get_option('qlcd_wp_chatbot_support')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_support', sanitize_text_field('Support'));
        }
    
        
        if(!get_option('qlcd_wp_chatbot_agent_join')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_agent_join', serialize(array('has joined the conversation')));
        }
        if(!get_option('qlcd_wp_chatbot_welcome')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_welcome', serialize(array('Welcome to', 'Glad to have you at')));
        }
        if(!get_option('qlcd_wp_chatbot_back_to_start')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_back_to_start', serialize(array('Back to Start')));
        }
        if(!get_option('qlcd_wp_chatbot_hi_there')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_hi_there', serialize(array('Hi There!')));
        }
        if(!get_option('qlcd_wp_chatbot_welcome_back')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_welcome_back', serialize(array('Welcome back', 'Good to see your again')));
        }
        if(!get_option('qlcd_wp_chatbot_asking_name')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_asking_name', serialize(array('May I know your name?', 'What should I call you?')));
        }
        if(!get_option('qlcd_wp_chatbot_asking_emailaddress')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_asking_emailaddress', serialize(array('May i know your email %%username%%? so i can get back to you if needed.')));
        }
    
        if(!get_option('qlcd_wp_chatbot_got_email')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_got_email', serialize(array('Thanks for sharing your email %%username%%!')));
        }
        if(!get_option('qlcd_wp_chatbot_email_ignore')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_email_ignore', serialize(array('No problem %%username%%, if you do not want to share your email address!')));
        }
    
        if(!get_option('qlcd_wp_chatbot_asking_phone_gt')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_asking_phone_gt', serialize(array('May i know your phone number %%username%%? so i can get back to you if needed.')));
        }
    
        if(!get_option('qlcd_wp_chatbot_got_phone')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_got_phone', serialize(array('Thanks for sharing your phone number %%username%%!')));
        }
        if(!get_option('qlcd_wp_chatbot_phone_ignore')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_phone_ignore', serialize(array('No problem %%username%%, if you do not want to share your phone number!')));
        }
        if(!get_option('qlcd_wp_i_understand')) {
            self::qcldwpbot_update_option('qlcd_wp_i_understand', serialize(array('I understand that your name is %%username%%. Is that correct?')));
        }
    
        if(!get_option('qlcd_wp_chatbot_valid_phone_number')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_valid_phone_number', serialize(array('Please provide a valid phone number')));
        }
    
        
        if(!get_option('qlcd_wp_chatbot_name_greeting')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_name_greeting', serialize(array('Nice to meet you, %%username%%!')));
        }
        if(!get_option('qlcd_wp_chatbot_i_am')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_i_am', serialize(array('I am', 'This is')));
        }
        if(!get_option('qlcd_wp_chatbot_is_typing')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_is_typing', serialize(array('is typing...')));
        }
        if(!get_option('qlcd_wp_chatbot_send_a_msg')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_send_a_msg', serialize(array('Send a message.')));
        }
        if(!get_option('qlcd_wp_chatbot_choose_option')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_choose_option', serialize(array('Choose an option.')));
        }
        if(!get_option('qlcd_wp_chatbot_viewed_products')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_viewed_products', serialize(array('Recently viewed products')));
        }
        if(!get_option('qlcd_wp_chatbot_add_to_cart')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_add_to_cart', serialize(array('Add to Cart')));
        }
        if(!get_option('qlcd_wp_chatbot_cart_link')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_cart_link', serialize(array('Cart')));
        }
        if(!get_option('qlcd_wp_chatbot_checkout_link')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_checkout_link', serialize(array('Checkout')));
        }
        if(!get_option('qlcd_wp_chatbot_featured_product_welcome')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_featured_product_welcome', serialize(array('I have found following featured products')));
        }
        if(!get_option('qlcd_wp_chatbot_viewed_product_welcome')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_viewed_product_welcome', serialize(array('I have found following recently viewed products')));
        }
        if(!get_option('qlcd_wp_chatbot_latest_product_welcome')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_latest_product_welcome', serialize(array('I have found following latest products')));
        }
        if(!get_option('qlcd_wp_chatbot_cart_welcome')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_cart_welcome', serialize(array('I have found following items from Shopping Cart.')));
        }
        if(!get_option('qlcd_wp_chatbot_cart_title')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_cart_title', serialize(array('Title')));
        }
        if(!get_option('qlcd_wp_chatbot_cart_quantity')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_cart_quantity', serialize(array('Qty')));
        }
        if(!get_option('qlcd_wp_chatbot_cart_price')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_cart_price', serialize(array('Price')));
        }
        if(!get_option('qlcd_wp_chatbot_no_cart_items')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_no_cart_items', serialize(array('No items in the cart')));
        }
        if(!get_option('qlcd_wp_chatbot_cart_updating')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_cart_updating', serialize(array('Updating cart items ...')));
        }
        if(!get_option('qlcd_wp_chatbot_cart_removing')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_cart_removing', serialize(array('Removing cart items ...')));
        }
        if(!get_option('qlcd_wp_chatbot_wildcard_msg')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_wildcard_msg', serialize(array('Hi %%username%%. I am here to find what you need. What are you looking for?')));
        }
        if(!get_option('qlcd_wp_chatbot_empty_filter_msg')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_empty_filter_msg', serialize(array('Sorry, I did not understand you.')));
        }
        if(!get_option('do_you_want_to_subscribe')) {
            self::qcldwpbot_update_option('do_you_want_to_subscribe', serialize(array('Do you want to subscribe to our newsletter?')));
        }
        if(!get_option('qlcd_wp_chatbot_file_upload_succ')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_file_upload_succ', 'File has been uploaded successfully!');
        }
        if(!get_option('qlcd_wp_chatbot_good_bye_text')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_good_bye_text', 'Ok Bye, See you soon!');
        }
        if(!get_option('qlcd_wp_chatbot_transcript_emailed')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_transcript_emailed', 'Do you want the chat transcript to be emailed?');
        }
        
        
        if(!get_option('qlcd_wp_chatbot_file_upload_fail')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_file_upload_fail', 'Failed to upload the file.');
        }
        if(!get_option('qlcd_wp_chatbot_file_size_excd')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_file_size_excd', 'Max file upload size exceed.');
        }
        if(!get_option('qlcd_wp_chatbot_ext_not_allowed')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_ext_not_allowed', 'Extension not allowed, please choose a valid file.');
        }
        if(!get_option('do_you_want_to_unsubscribe')) {
            self::qcldwpbot_update_option('do_you_want_to_unsubscribe', serialize(array('Do you want to unsubscribe from our newsletter?')));
        }
    
        if(!get_option('we_do_not_have_your_email')) {
            self::qcldwpbot_update_option('we_do_not_have_your_email', serialize(array('We do not have your email in the ChatBot database.')));
        }
    
        if(!get_option('you_have_successfully_unsubscribe')) {
            self::qcldwpbot_update_option('you_have_successfully_unsubscribe', serialize(array('You have successfully unsubscribed from our newsletter!')));
        }
    
        if(!get_option('qlcd_wp_chatbot_sys_key_help')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_sys_key_help', 'start');
        }
        if(!get_option('qlcd_wp_chatbot_sys_key_product')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_sys_key_product', 'product');
        }
        if(!get_option('qlcd_wp_chatbot_sys_key_catalog')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_sys_key_catalog', 'catalog');
        }
        if(!get_option('qlcd_wp_chatbot_sys_key_order')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_sys_key_order', 'order');
        }
        if(!get_option('qlcd_wp_chatbot_sys_key_support')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_sys_key_support', 'faq');
        }
        if(!get_option('qlcd_wp_chatbot_sys_key_reset')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_sys_key_reset', 'reset');
        }
        if(!get_option('qlcd_wp_chatbot_sys_goodbye_keywords')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_sys_goodbye_keywords', 'goodbye, bye, see you soon, bye-bye, adieu, quit, stop chat, abort, stop, abort, so long');
        }
        
        if(!get_option('qlcd_wp_chatbot_sys_key_livechat')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_sys_key_livechat', 'livechat');
        }
        if(!get_option('qlcd_wp_chatbot_help_welcome')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_help_welcome', serialize(array('Welcome to Help Section.')));
        }
        if(!get_option('qlcd_wp_chatbot_tag_search_intent')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_tag_search_intent', serialize(array('ChooseCoffee')));
        }
        if(!get_option('qlcd_wp_chatbot_help_msg')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_help_msg', serialize(array('<h3>Type and Hit Enter</h3>  1. <b>start</b> Get back to the main menu. <br> 2. <b>faq</b> for  FAQ. <br> 3. <b>reset</b> To clear chat history and start from the beginning.  4. <b>livechat</b>  To navigating into the livechat window. 5. <b>unsubscribe</b> to remove your email from our newsletter.')));
         }
        if(!get_option('qlcd_wp_chatbot_reset')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_reset', serialize(array('Do you want to clear our chat history and start over?')));
        }
        if(!get_option('qlcd_wp_chatbot_wildcard_product')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_wildcard_product', serialize(array('Product Search')));
        }
        if(!get_option('qlcd_wp_chatbot_wildcard_catalog')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_wildcard_catalog', serialize(array('Catalog')));
        }
        if(!get_option('qlcd_wp_chatbot_featured_products')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_featured_products', serialize(array('Featured Products')));
        }
        if(!get_option('qlcd_wp_chatbot_no_result')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_no_result', serialize(array('Sorry, No result found!')));
        }
    
        if(!get_option('qlcd_wp_chatbot_did_you_mean')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_did_you_mean', serialize(array('Did you mean?')));
        }
    
        
        if(!get_option('qlcd_wp_email_subscription_success')) {
            self::qcldwpbot_update_option('qlcd_wp_email_subscription_success', serialize(array('You have successfully subscribed to our newsletter. Thank you.')));
        }
        if(!get_option('qlcd_wp_email_already_subscribe')) {
            self::qcldwpbot_update_option('qlcd_wp_email_already_subscribe', serialize(array('You have already subscribed to our newsletter.')));
        }
    
        if(!get_option('qlcd_wp_email_subscription_offer')) {
            self::qcldwpbot_update_option('qlcd_wp_email_subscription_offer', serialize(array('')));
        }
        if(!get_option('qlcd_wp_email_subscription_offer_subject')) {
            self::qcldwpbot_update_option('qlcd_wp_email_subscription_offer_subject', serialize(array('Email Subscription Offer')));
        }
    
    
        if(!get_option('enable_wp_chatbot_custom_color')) {
            self::qcldwpbot_update_option('enable_wp_chatbot_custom_color', '');
        }
        if(!get_option('wp_chatbot_text_color')) {
            self::qcldwpbot_update_option('wp_chatbot_text_color', '#37424c');
        }
        if(!get_option('wp_chatbot_floatingiconbg_color')) {
            self::qcldwpbot_update_option('wp_chatbot_floatingiconbg_color', '#fff');
        }
        if(!get_option('wp_chatbot_link_color')) {
            self::qcldwpbot_update_option('wp_chatbot_link_color', '#1f8ceb');
        }
        if(!get_option('wp_chatbot_link_hover_color')) {
            self::qcldwpbot_update_option('wp_chatbot_link_hover_color', '#65b6fd');
        }
        if(!get_option('wp_chatbot_bot_msg_bg_color')) {
            self::qcldwpbot_update_option('wp_chatbot_bot_msg_bg_color', '#1f8ceb');
        }
        if(!get_option('wp_chatbot_bot_msg_text_color')) {
            self::qcldwpbot_update_option('wp_chatbot_bot_msg_text_color', '#ffffff');
        }
        if(!get_option('wp_chatbot_user_msg_text_color')) {
            self::qcldwpbot_update_option('wp_chatbot_user_msg_text_color', '#ffffff');
        }
        if(!get_option('wp_chatbot_user_msg_bg_color')) {
            self::qcldwpbot_update_option('wp_chatbot_user_msg_bg_color', '#ffffff');
        }
        
        
        if(!get_option('wp_chatbot_user_msg_text_color')) {
            self::qcldwpbot_update_option('wp_chatbot_user_msg_text_color', '#ffffff');
        }
        if(!get_option('wp_chatbot_user_msg_bg_color')) {
            self::qcldwpbot_update_option('wp_chatbot_user_msg_bg_color', '#ffffff');
        }
        
        if(!get_option('qlcd_wp_chatbot_sale_products')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_sale_products', serialize(array('Products on  Sale')));
        }
        if(!get_option('qlcd_wp_chatbot_wildcard_support')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_wildcard_support', 'faq');
        }
        if(!get_option('qlcd_wp_chatbot_messenger_label')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_messenger_label', serialize(array('Chat with Us on Facebook Messenger')));
        }
        if(!get_option('qlcd_wp_chatbot_product_success')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_product_success', serialize(array('Great! We have these products for', 'Found these products for')));
        }
        if(!get_option('qlcd_wp_chatbot_product_fail')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_product_fail', serialize(array('Oops! Nothing matches your criteria', 'Sorry, I found nothing')));
        }
        if(!get_option('qlcd_wp_chatbot_product_asking')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_product_asking', serialize(array('What are you shopping for?')));
        }
        if(!get_option('qlcd_wp_chatbot_product_suggest')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_product_suggest', serialize(array('You can browse our extensive catalog. Just pick a category from below:')));
        }
        if(!get_option('qlcd_wp_chatbot_product_infinite')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_product_infinite', serialize(array('Too many choices? Let\'s try another search term', 'I may have something else for you. Why not search again?')));
        }
        if(!get_option('qlcd_wp_chatbot_load_more')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_load_more', serialize(array('Load More')));
        }
        if(!get_option('qlcd_wp_chatbot_wildcard_order')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_wildcard_order', serialize(array('Order Status')));
        }
        if(!get_option('qlcd_wp_chatbot_order_welcome')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_order_welcome', serialize(array('Welcome to Order status section!')));
        }
        if(!get_option('qlcd_wp_chatbot_order_username_asking')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_order_username_asking', serialize(array('Please type your username?')));
        }
        if(!get_option('qlcd_wp_chatbot_order_username_password')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_order_username_password', serialize(array('Please type your password')));
        }
        if(!get_option('qlcd_wp_chatbot_order_username_not_exist')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_order_username_not_exist', serialize(array('This username does not exist.')));
        }
        if(!get_option('qlcd_wp_chatbot_order_username_thanks')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_order_username_thanks', serialize(array('Thank you for the username')));
        }
        if(!get_option('qlcd_wp_chatbot_order_password_incorrect')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_order_password_incorrect', serialize(array('Sorry Password is not correct!')));
        }
        if(!get_option('qlcd_wp_chatbot_asking_email')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_asking_email', serialize(array('Please provide your email address')));
        }
        if(!get_option('qlcd_wp_chatbot_search_keyword')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_search_keyword', serialize(array('Hello #name!, Please enter your keyword for searching')));
        }
        if(!get_option('qlcd_wp_chatbot_order_not_found')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_order_not_found', serialize(array('I did not find any order by you')));
        }
         if(!get_option('qlcd_wp_chatbot_order_found')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_order_found', serialize(array('I have found the following orders')));
        }
        if(!get_option('qlcd_wp_chatbot_order_email_support')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_order_email_support', serialize(array('Email our support center about your order.')));
        }
        if(!get_option('qlcd_wp_chatbot_support_welcome')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_support_welcome', serialize(array('Welcome to FAQ Section')));
        }
        if(!get_option('qlcd_wp_chatbot_go_back_tooltip')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_go_back_tooltip', serialize(array('click to go back.')));
        }
        if(!get_option('qlcd_wp_chatbot_support_email')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_support_email', serialize(array('Click me if you want to send us a email.')));
        }
        if(!get_option('qlcd_wp_chatbot_asking_msg')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_asking_msg', serialize(array('Thank you for email address. Please write your message now.')));
        }
        if(!get_option('qlcd_wp_chatbot_invalid_email')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_invalid_email', serialize(array('Sorry, Email address is not valid! Please provide a valid email.')));
        }
        if(!get_option('qlcd_wp_chatbot_support_phone')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_support_phone', 'Leave your number. We will call you back!');
        }
        if(!get_option('qlcd_wp_chatbot_asking_phone')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_asking_phone', serialize(array('Please provide your Phone number')));
        }
        if(!get_option('qlcd_wp_chatbot_thank_for_phone')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_thank_for_phone', serialize(array('Thank you for Phone number')));
        }
        if(!get_option('qlcd_wp_chatbot_support_option_again')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_support_option_again', serialize(array('You may choose an option from below.')));
        }
        if(!get_option('qlcd_wp_chatbot_admin_email')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_admin_email', $admin_email);
        }
    
        if(!get_option('qlcd_wp_chatbot_from_email')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_from_email', '');
        }
        if(!get_option('qlcd_wp_chatbot_from_name')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_from_name', 'Wordpress');
        }
        if(!get_option('qlcd_wp_chatbot_reply_to_email')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_reply_to_email', '');
        }
    
        if(!get_option('qlcd_wp_chatbot_email_sub')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_email_sub', sanitize_text_field('Support Request from WPBOT'));
        }
    
        if(!get_option('qlcd_wp_chatbot_callback_email_sub')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_callback_email_sub', sanitize_text_field('WPBot Support Mail Request for Callback'));
        }
    
        
        if(!get_option('qlcd_wp_chatbot_we_have_found')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_we_have_found', sanitize_text_field('We have found these results'));
        }
        if(!get_option('qlcd_wp_chatbot_email_sent')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_email_sent', sanitize_text_field('Your email was sent successfully.Thanks!'));
        }
        if(!get_option('qlcd_wp_site_search')) {
            self::qcldwpbot_update_option('qlcd_wp_site_search', sanitize_text_field('Site Search'));
        }
        if(!get_option('qlcd_wp_livechat')) {
            self::qcldwpbot_update_option('qlcd_wp_livechat', sanitize_text_field('Livechat'));
        }
        
        if(!get_option('qlcd_wp_email_subscription')) {
            self::qcldwpbot_update_option('qlcd_wp_email_subscription', sanitize_text_field('Email Subscription'));
        }
        
        if(!get_option('qlcd_wp_str_category')) {
            self::qcldwpbot_update_option('qlcd_wp_str_category', sanitize_text_field('STR Categories'));
        }
        if(!get_option('qlcd_open_ticket_label')) {
            self::qcldwpbot_update_option('qlcd_open_ticket_label', sanitize_text_field('Open a Ticket'));
        }
        if(!get_option('qlcd_wp_email_unsubscription')) {
            self::qcldwpbot_update_option('qlcd_wp_email_unsubscription', sanitize_text_field('Unsubscribe'));
        }
        if(!get_option('qlcd_wp_send_us_email')) {
            self::qcldwpbot_update_option('qlcd_wp_send_us_email', sanitize_text_field('Send Us Email'));
        }
        if(!get_option('qlcd_wp_leave_feedback')) {
            self::qcldwpbot_update_option('qlcd_wp_leave_feedback', sanitize_text_field('Leave a Feedback'));
        }
        if(!get_option('qlcd_wp_good_bye')) {
            self::qcldwpbot_update_option('qlcd_wp_good_bye', sanitize_text_field('GoodBye'));
        }
        if(!get_option('qlcd_wp_chatbot_email_fail')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_email_fail', sanitize_text_field('Sorry! I could not send your mail! Please contact the webmaster.'));
        }
        if(!get_option('qlcd_wp_chatbot_notification_interval')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_notification_interval', sanitize_text_field(5));
        }
        if(!get_option('qlcd_wp_chatbot_notifications')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_notifications', serialize(array('Welcome to WPBot')));
        }
        if(!get_option('qcld_exit_pagewise')) {
            self::qcldwpbot_update_option('qcld_exit_pagewise', '');
        }
        
        if(!get_option('qlcd_wp_chatbot_notifications_intent')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_notifications_intent', serialize(array('')));
        }
        
        if(!get_option('support_query')) {
            self::qcldwpbot_update_option('support_query', serialize(array('What is WPBot?')));
        }
        if(!get_option('qlcd_wp_custon_intent')) {
            self::qcldwpbot_update_option('qlcd_wp_custon_intent', '');
        }
        if(!get_option('qlcd_wp_custon_intent_label')) {
            self::qcldwpbot_update_option('qlcd_wp_custon_intent_label', '');
        }
        if(!get_option('qlcd_wp_custon_intent_checkbox')) {
            self::qcldwpbot_update_option('qlcd_wp_custon_intent_checkbox', '');
        }
    
        if(!get_option('qlcd_wp_custon_menu')) {
            self::qcldwpbot_update_option('qlcd_wp_custon_menu', '');
        }
        if(!get_option('qlcd_wp_custon_menu_link')) {
            self::qcldwpbot_update_option('qlcd_wp_custon_menu_link', '');
        }
        if(!get_option('qlcd_wp_custon_menu_checkbox')) {
            self::qcldwpbot_update_option('qlcd_wp_custon_menu_checkbox', '');
        }

        if(!get_option('support_ans')) {
            self::qcldwpbot_update_option('support_ans', serialize(array('WPBot is a stand alone Chat Bot with zero configuration or bot training required. This plug and play chatbot also does not require any 3rd party service integration like Facebook. This chat bot helps shoppers find the products they are looking for easily and increase store sales! WPBot is a must have plugin for trending conversational commerce or conversational shopping.')));
        }
        if(!get_option('qlcd_wp_chatbot_search_option')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_search_option', 'standard');
        }
        if(!get_option('wp_chatbot_index_count')) {
            self::qcldwpbot_update_option('wp_chatbot_index_count', 0);
        }
        if(!get_option('wp_chatbot_app_pages')) {
            self::qcldwpbot_update_option('wp_chatbot_app_pages', 0);
        }
        //messenger options.
        if(!get_option('enable_wp_chatbot_messenger')) {
            self::qcldwpbot_update_option('enable_wp_chatbot_messenger', '');
        }
        if(!get_option('enable_wp_chatbot_messenger_floating_icon')) {
            self::qcldwpbot_update_option('enable_wp_chatbot_messenger_floating_icon', '');
        }
        if(!get_option('qlcd_wp_chatbot_fb_app_id')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_fb_app_id', '');
        }
        if(!get_option('qlcd_wp_chatbot_fb_page_id')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_fb_page_id', '');
        }
        if(!get_option('qlcd_wp_chatbot_fb_color')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_fb_color', '#0084ff');
        }
        if(!get_option('qlcd_wp_chatbot_fb_in_msg')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_fb_in_msg', 'Welcome to WPBot!');
        }
        if(!get_option('qlcd_wp_chatbot_fb_out_msg')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_fb_out_msg', 'You are not logged in');
        }
        //Skype option
        if(!get_option('enable_wp_chatbot_skype_floating_icon')) {
            self::qcldwpbot_update_option('enable_wp_chatbot_skype_floating_icon', '');
        }
        if(!get_option('enable_wp_chatbot_skype_id')) {
            self::qcldwpbot_update_option('enable_wp_chatbot_skype_id', '');
        }
         //Whats App
        if(!get_option('enable_wp_chatbot_whats')) {
            self::qcldwpbot_update_option('enable_wp_chatbot_whats', '');
        }
        if(!get_option('qlcd_wp_chatbot_whats_label')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_whats_label', serialize(array('Chat with Us on WhatsApp')));
        }
        if(!get_option('enable_wp_chatbot_floating_whats')) {
                self::qcldwpbot_update_option('enable_wp_chatbot_floating_whats', '');
            }
         if(!get_option('qlcd_wp_chatbot_whats_num')) {
                self::qcldwpbot_update_option('qlcd_wp_chatbot_whats_num', '');
            }
        //Viber
         if(!get_option('enable_wp_chatbot_floating_viber')) {
                self::qcldwpbot_update_option('enable_wp_chatbot_floating_viber', '');
            }
         if(!get_option('qlcd_wp_chatbot_viber_acc')) {
                self::qcldwpbot_update_option('qlcd_wp_chatbot_viber_acc', '');
            }
        //Integration others
        if(!get_option('enable_wp_chatbot_floating_phone')) {
            self::qcldwpbot_update_option('enable_wp_chatbot_floating_phone', '');
        }
        if(!get_option('enable_wp_chatbot_floating_livechat')) {
            self::qcldwpbot_update_option('enable_wp_chatbot_floating_livechat', '');
        }
        if(!get_option('enable_wp_custom_intent_livechat_button')) {
            self::qcldwpbot_update_option('enable_wp_custom_intent_livechat_button', '');
        }
        if(!get_option('qlcd_wp_chatbot_phone')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_phone', '');
        }
        if(!get_option('qlcd_wp_chatbot_livechatlink')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_livechatlink', '');
        }
        if(!get_option('qlcd_wp_livechat_button_label')) {
            self::qcldwpbot_update_option('qlcd_wp_livechat_button_label', 'Live Chat');
        }
        if(!get_option('wp_custom_icon_livechat')) {
            self::qcldwpbot_update_option('wp_custom_icon_livechat', '');
        }
        if(!get_option('wp_custom_help_icon')) {
            self::qcldwpbot_update_option('wp_custom_help_icon', '');
        }
        if(!get_option('wp_custom_client_icon')) {
            self::qcldwpbot_update_option('wp_custom_client_icon', '');
        }
        if(!get_option('wp_custom_support_icon')) {
            self::qcldwpbot_update_option('wp_custom_support_icon', '');
        }
        if(!get_option('wp_custom_chat_icon')) {
            self::qcldwpbot_update_option('wp_custom_chat_icon', '');
        }
        if(!get_option('wp_custom_typing_icon')) {
            self::qcldwpbot_update_option('wp_custom_typing_icon', '');
        }
        
        if(!get_option('enable_wp_chatbot_floating_link')) {
            self::qcldwpbot_update_option('enable_wp_chatbot_floating_link', '');
        }
    
        if(!get_option('qlcd_wp_chatbot_weblink')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_weblink', '');
        }
        //Re-Tagetting
        if(!get_option('qlcd_wp_chatbot_ret_greet')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_ret_greet', 'Hello');
        }
        if(!get_option('enable_wp_chatbot_exit_intent')) {
            self::qcldwpbot_update_option('enable_wp_chatbot_exit_intent', '');
        }
        if(!get_option('wp_chatbot_exit_intent_msg')) {
            self::qcldwpbot_update_option('wp_chatbot_exit_intent_msg', '');
        }
        if(!get_option('wp_chatbot_exit_intent_custom')) {
            self::qcldwpbot_update_option('wp_chatbot_exit_intent_custom', '');
        }
        if(!get_option('wp_chatbot_exit_intent_bargain_pro_single_page')) {
            self::qcldwpbot_update_option('wp_chatbot_exit_intent_bargain_pro_single_page', '');
        }
        
        if(!get_option('wp_chatbot_exit_intent_email')) {
            self::qcldwpbot_update_option('wp_chatbot_exit_intent_email', '');
        }
        if(!get_option('wp_chatbot_exit_intent_once')) {
            self::qcldwpbot_update_option('wp_chatbot_exit_intent_once', '');
        }
    
        if(!get_option('enable_wp_chatbot_scroll_open')) {
            self::qcldwpbot_update_option('enable_wp_chatbot_scroll_open', '');
        }
        if(!get_option('wp_chatbot_scroll_open_msg')) {
            self::qcldwpbot_update_option('wp_chatbot_scroll_open_msg', '');
        }
        if(!get_option('wp_chatbot_exit_intent_bargain_msg')) {
            self::qcldwpbot_update_option('wp_chatbot_exit_intent_bargain_msg', '');
        }
        
        if(!get_option('wp_chatbot_scroll_open_custom')) {
            self::qcldwpbot_update_option('wp_chatbot_scroll_open_custom', '');
        }
        if(!get_option('wp_chatbot_scroll_open_email')) {
            self::qcldwpbot_update_option('wp_chatbot_scroll_open_email', '');
        }
        if(!get_option('wp_chatbot_scroll_percent')) {
            self::qcldwpbot_update_option('wp_chatbot_scroll_percent', 50);
        }
        if(!get_option('wp_chatbot_scroll_once')) {
            self::qcldwpbot_update_option('wp_chatbot_scroll_once', '');
        }
    
        if(!get_option('enable_wp_chatbot_auto_open')) {
            self::qcldwpbot_update_option('enable_wp_chatbot_auto_open', '');
        }
    
        if(!get_option('enable_wp_chatbot_ret_sound')) {
            self::qcldwpbot_update_option('enable_wp_chatbot_ret_sound', '');
        }
        if(!get_option('enable_wp_chatbot_sound_initial')) {
            self::qcldwpbot_update_option('enable_wp_chatbot_sound_initial', '');
        }
    
    
        if(!get_option('wp_chatbot_auto_open_msg')) {
            self::qcldwpbot_update_option('wp_chatbot_auto_open_msg', '');
        }
        
        if(!get_option('wp_chatbot_auto_open_custom')) {
            self::qcldwpbot_update_option('wp_chatbot_auto_open_custom', '');
        }
        if(!get_option('wp_chatbot_auto_open_email')) {
            self::qcldwpbot_update_option('wp_chatbot_auto_open_email', '');
        }
        if(!get_option('wp_chatbot_auto_open_time')) {
            self::qcldwpbot_update_option('wp_chatbot_auto_open_time', 10);
        }
        if(!get_option('wp_chatbot_auto_open_once')) {
            self::qcldwpbot_update_option('wp_chatbot_auto_open_once', '');
        }
         if(!get_option('wp_chatbot_inactive_once')) {
            self::qcldwpbot_update_option('wp_chatbot_inactive_once', '');
        }
    
        //To complete checkout.
        if(!get_option('enable_wp_chatbot_ret_user_show')) {
            self::qcldwpbot_update_option('enable_wp_chatbot_ret_user_show', '');
        }
        if(!get_option('wp_chatbot_checkout_msg')) {
            self::qcldwpbot_update_option('wp_chatbot_checkout_msg', 'You have products in shopping cart, please complete your order.');
        }
        if(!get_option('wp_chatbot_inactive_time')) {
            self::qcldwpbot_update_option('wp_chatbot_inactive_time', 300);
        }
        if(!get_option('enable_wp_chatbot_inactive_time_show')) {
            self::qcldwpbot_update_option('enable_wp_chatbot_inactive_time_show', '');
        }
    
        if(!get_option('wp_chatbot_proactive_bg_color')) {
            self::qcldwpbot_update_option('wp_chatbot_proactive_bg_color', '#ffffff');
        }
        if(!get_option('disable_wp_chatbot_feedback')) {
            self::qcldwpbot_update_option('disable_wp_chatbot_feedback','');
        }
        
        if(!get_option('disable_wp_leave_feedback')) {
            self::qcldwpbot_update_option('disable_wp_leave_feedback','');
        }
        if(!get_option('disable_good_bye')) {
            self::qcldwpbot_update_option('disable_good_bye','');
        }
        if(!get_option('disable_wp_chatbot_site_search')) {
            self::qcldwpbot_update_option('disable_wp_chatbot_site_search','');
        }
        if(!get_option('disable_wp_chatbot_faq')) {
            self::qcldwpbot_update_option('disable_wp_chatbot_faq','');
        }
        if(!get_option('disable_email_subscription')) {
            self::qcldwpbot_update_option('disable_email_subscription','');
        }
        
        if(!get_option('disable_voice_message')) {
            self::qcldwpbot_update_option('disable_voice_message','');
        }
        if(!get_option('disable_str_categories')) {
            self::qcldwpbot_update_option('disable_str_categories','');
        }
        if(!get_option('disable_open_ticket')) {
            self::qcldwpbot_update_option('disable_open_ticket','');
        }
        if(!get_option('disable_livechat')) {
            self::qcldwpbot_update_option('disable_livechat','');
        }
        if(!get_option('disable_livechat_opration_icon')) {
            self::qcldwpbot_update_option('disable_livechat_opration_icon','');
        }
        if(!get_option('qlcd_wp_chatbot_feedback_label')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_feedback_label',serialize(array('Send Feedback')));
        }
    
        if(!get_option('enable_wp_chatbot_meta_title')) {
            self::qcldwpbot_update_option('enable_wp_chatbot_meta_title','');
        }
        if(!get_option('qlcd_wp_chatbot_meta_label')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_meta_label','*New Messages');
        }
    
        if(!get_option('disable_wp_chatbot_call_gen')) {
            self::qcldwpbot_update_option('disable_wp_chatbot_call_gen', '');
        }
        if(!get_option('disable_wp_chatbot_call_sup')) {
            self::qcldwpbot_update_option('disable_wp_chatbot_call_sup', '');
        }
    
        if(!get_option('qlcd_wp_chatbot_phone_sent')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_phone_sent',  'Thank you for the Phone number. We will call back ASAP.');
        }
        if(!get_option('qlcd_wp_chatbot_phone_fail')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_phone_fail', 'Sorry! I could not collect phone number!');
        }
        if(!get_option('qlcd_wp_chatbot_skip_conversation')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_skip_conversation', 'Click this button to skip the conversation');
        }
        if(!get_option('qlcd_wp_chatbot_load_more_search')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_load_more_search', 'Load More');
        }
        if(!get_option('qlcd_wp_chatbot_loading_search')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_loading_search', 'Load More');
        }
        if(!get_option('qlcd_wp_chatbot_conversation_details')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_conversation_details', 'Conversation Details');
        }
        if(!get_option('enable_wp_chatbot_opening_hour')) {
            self::qcldwpbot_update_option('enable_wp_chatbot_opening_hour', '');
        }
        if(!get_option('enable_wp_chatbot_opening_hour')) {
            self::qcldwpbot_update_option('wpwbot_hours', array());
        }
    
        if(!get_option('enable_wp_chatbot_dailogflow')) {
            self::qcldwpbot_update_option('enable_wp_chatbot_dailogflow', '');
        }
        if(!get_option('wpbot_trigger_intent')) {
            self::qcldwpbot_update_option('wpbot_trigger_intent', '');
        }
    
        if(!get_option('enable_authentication_webhook')) {
            self::qcldwpbot_update_option('enable_authentication_webhook', '');
        }
    
        if(!get_option('qcld_auth_username')) {
            self::qcldwpbot_update_option('qcld_auth_username', '');
        }
    
        if(!get_option('qcld_auth_password')) {
            self::qcldwpbot_update_option('qcld_auth_password', '');
        }
    
        
        
        if(!get_option('qlcd_wp_chatbot_dialogflow_client_token')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_dialogflow_client_token', '');
        }
        if(!get_option('qlcd_wp_chatbot_dialogflow_project_id')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_dialogflow_project_id', '');
        }
        if(!get_option('wp_chatbot_df_api')) {
            self::qcldwpbot_update_option('wp_chatbot_df_api', '');
        }
    
        
        if(!get_option('qlcd_wp_chatbot_dialogflow_project_key')) {
            self::qcldwpbot_update_option('qlcd_wp_chatbot_dialogflow_project_key', '');
        }
        if(!get_option('$qlcd_wp_chatbot_dialogflow_defualt_reply')) {
            self::qcldwpbot_update_option('$qlcd_wp_chatbot_dialogflow_defualt_reply', 'Sorry, I did not understand you. You may browse');
        }
        if(!get_option('$qlcd_wp_chatbot_dialogflow_agent_language')) {
            self::qcldwpbot_update_option('$qlcd_wp_chatbot_dialogflow_agent_language', 'en');
        }
        if(!get_option('qcwp_install_date')) {
            self::qcldwpbot_update_option('qcwp_install_date', date('Y-m-d'));
        }
    
        $value = self::qldf_botwp_content('logodata');	
        if($value!=''){
            self::qcldwpbot_update_option('_qopced_wgjsuelsdfj_', $value);
        }
        $value2 = self::qldf_botwp_content('customservicedata');
        if($value2!=''){
            self::qcldwpbot_update_option('_qopced_wgjegdselsdfj_', $value2);
        }
        $value3 = self::qldf_botwp_content('themedata');
        if($value3!=''){
            self::qcldwpbot_update_option('_qopced_wgjegdsetheme_', $value3);
        }
    
    
        if (get_page_by_title('wpwBot Mobile App') == NULL) {
            //post status and options
            $app_page = array(
                'comment_status' => 'closed',
                'ping_status' => 'closed',
                'post_author' => get_current_user_id(),
                'post_date' => current_time( 'mysql' ),
                'post_status' => 'publish',
                'post_title' => 'wpwBot Mobile App',
                'post_name' => 'wpwbot-mobile-app',
                'post_type' => 'page',
            );
            //insert page and save the id
            $wpwbot_app = wp_insert_post($app_page, false);
            //save the id in the database
            self::qcldwpbot_update_option('wp_chatbot_app_checkout', $wpwbot_app);
        }
    }
}
}
