<?php

class Qcld_WPBot_Maybe_Upgrade
{
    public $mysql_version = '';
    public function __construct() {
        add_action('init', array( $this, 'qc_wp_latest_update_check_pro' ), 10 );
        add_action('init', array( $this, 'str_reindex' ), 50 );
        add_action( 'init', array( $this, 'maybe_update' ), 100 );
        add_action( 'init', array( $this, 'check_mysql_version' ), 80 );
    }
    
    public function str_reindex(){
        global $wpdb;
        $table = $wpdb->prefix.'wpbot_response';
        if(isset($_POST['qc-re-index'])){
            qc_mysql_remove_existing_indexes();
            qc_mysql_reindex();
            add_action('admin_notices', array($this, 'general_admin_notice') );
        }
    }

    public function general_admin_notice(){
        
        if ( isset($_GET['page']) && $_GET['page'] == 'simple-text-response' ) {
             echo '<div class="notice notice-success is-dismissible">
                 <p>Re-Indexing has been completed!</p>
             </div>';
        }
    }
    

    public function qc_wp_latest_update_check_pro(){
        global $wpdb;
        
        if(!get_option('qc_wp_ludate_ck_pro')){
            update_option('qlcd_wp_chatbot_support_phone', 'Leave your number. We will call you back!');
            update_option('qlcd_wp_chatbot_wildcard_support', 'FAQ');
            update_option('qc_wp_ludate_ck_pro', 'done');
        }
        
        if(!get_option('qc_wpbot_simple_response_db_upgrade_pro')){

            $collate = '';
            if ( $wpdb->has_cap( 'collation' ) ) {
        
                if ( ! empty( $wpdb->charset ) ) {
        
                    $collate .= "DEFAULT CHARACTER SET $wpdb->charset";
                }
                if ( ! empty( $wpdb->collate ) ) {
        
                    $collate .= " COLLATE $wpdb->collate";
        
                }
            }
            //Bot Response Table
            $table1    = $wpdb->prefix.'wpbot_response';
            $sql_sliders_Table1 = "
                CREATE TABLE IF NOT EXISTS `$table1` (
                `id` INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
                `query` TEXT NOT NULL,
                `keyword` TEXT NOT NULL,
                `response` TEXT NOT NULL,
                `category` varchar(256) NOT NULL,
                `intent` varchar(256) NOT NULL,
                `custom` varchar(256) NOT NULL,
                FULLTEXT(`query`, `keyword`, `response`)
                )  $collate AUTO_INCREMENT=1 ENGINE=InnoDB";
                
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql_sliders_Table1 );

            if(!get_option('qlcd_wp_chatbot_did_you_mean')) {
                update_option('qlcd_wp_chatbot_did_you_mean', serialize(array('Did you mean?')));
            }
            $sqlqry = $wpdb->get_results("select * from $table1");
            if(empty($sqlqry)){
                $query = 'What Can WPBot do for you?';
                $response = 'WPBot can converse fluidly with users on website and FB messenger. It can search your website, send/collect eMails, user feedback & phone numbers . You can create Custom Intents from DialogFlow with Rich Messages & Card responses!';

                $data = array('query' => $query, 'keyword' => '', 'response'=> $response, 'intent'=> '');
                $format = array('%s','%s', '%s', '%s');
                $wpdb->insert($table1,$data,$format);
            }
            update_option('qc_wpbot_simple_response_db_upgrade_pro', 'done');

        }

        if( ! get_option( 'wpbot_main_plugin_installed' ) ){
            if ( is_multisite() && $network_wide ) {
                // Get all blogs in the network and activate plugin on each one
                $blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
                foreach ( $blog_ids as $blog_id ) {
                    switch_to_blog( $blog_id );
                    Qcld_WPBot_Install::install();
                    restore_current_blog();
                }
            } else {
                Qcld_WPBot_Install::install();
            }
    
            update_option('wpbot_main_plugin_installed', 1);
        }
        
        if(!get_option('qc_wpbotpro_failed_query')){

            $table    = $wpdb->prefix.'wpbot_failed_response';
            $sql_sliders_Table = "
                CREATE TABLE IF NOT EXISTS `$table` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `query` varchar(256) NOT NULL,
                `count` int(11) NOT NULL,
                `status` int(11) NOT NULL,
                PRIMARY KEY (`id`)
                )  $collate AUTO_INCREMENT=1 ";
                
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql_sliders_Table );

            update_option( 'qc_wpbotpro_failed_query', '1' );
        }
        
        if(!get_option('qc_wp_db_engine_update_pro')){
            $table1    = $wpdb->prefix.'wpbot_response';
            $wpdb->query("ALTER TABLE $table1 ENGINE = InnoDB");
            update_option('qc_wp_db_engine_update_pro', 'done');
        }
        
        if(!get_option('qc_wp_db_engine_update_pro_unassign')){
            $table1    = $wpdb->prefix.'wpbot_response';
            $wpdb->query("ALTER TABLE $table1 CHANGE `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT;");
            update_option('qc_wp_db_engine_update_pro_unassign', 'done');
        }

        if(isset($_POST['qc_bot_str_query']) && $_POST['qc_bot_str_query']!='' && !class_exists('Qcld_str_pro')){
            
            $query = wp_unslash(sanitize_text_field($_POST['qc_bot_str_query']));
            $keyword = wp_unslash(sanitize_text_field($_POST['qc_bot_str_keyword']));
            $intent = wp_unslash(sanitize_text_field($_POST['qc_bot_str_intent']));
            
            $category = '';
            $lang = ( isset( $_POST['qc_bot_str_lang'] ) ?  get_wpbot_locale() : get_wpbot_locale() );
            
            $response = wp_kses(wp_unslash($_POST['qc_bot_str_response']), 'post');
            
            $table = $wpdb->prefix.'wpbot_response';
            $data = array('query' => $query, 'keyword' => $keyword, 'response'=> $response, 'intent'=> $intent, 'category'=> $category, 'lang'=> $lang);
            $format = array('%s','%s', '%s', '%s', '%s');
            
            if(isset($_POST['qc_bot_str_id']) && $_POST['qc_bot_str_id']!=''){
                $id = sanitize_text_field($_POST['qc_bot_str_id']);
                $where = array('id'=>$id);
                $whereformat = array('%d');
                $wpdb->update( $table, $data, $where, $format, $whereformat );
            }else{
                $wpdb->insert($table,$data,$format);
            }

            qc_mysql_remove_existing_indexes();
            qc_mysql_reindex();
            
            wp_redirect(admin_url('admin.php?page=simple-text-response'));exit;
            
        }

        if(isset($_POST['qc_bot_str_weight']) && $_POST['qc_bot_str_weight']!=''){
            $weight = sanitize_text_field($_POST['qc_bot_str_weight']);
       
            update_option('qc_bot_str_weight', $weight);
        }
        
        if(isset($_POST['qc_bot_str_fields']) && !empty($_POST['qc_bot_str_fields'])){
            
            $table = $wpdb->prefix.'wpbot_response';
            $fields = ($_POST['qc_bot_str_fields']);
            qc_mysql_remove_existing_indexes();
            
            update_option('qc_bot_str_fields', $fields);

            qc_mysql_reindex();

            if(isset($_POST['qc_bot_str_remove_stopwords']) && $_POST['qc_bot_str_remove_stopwords']!=''){
                $stopwords = sanitize_text_field($_POST['qc_bot_str_remove_stopwords']);
                update_option('qc_bot_str_remove_stopwords', $stopwords);
            }else{
                delete_option('qc_bot_str_remove_stopwords');
            }
            if(isset($_POST['qc_bot_str_allow_shortcode']) && $_POST['qc_bot_str_allow_shortcode']!=''){
                $qc_bot_str_allow_shortcode = sanitize_text_field($_POST['qc_bot_str_allow_shortcode']);
                update_option('qc_bot_str_allow_shortcode', $qc_bot_str_allow_shortcode);
            }else{
                delete_option('qc_bot_str_allow_shortcode');
            }
        }
        //compatible with Userswp plugin
        if(is_admin() && isset($_GET['page']) && ($_GET['page']=='wpbot' || $_GET['page']=='wpwc-settings-page')){
            add_action( 'wp_print_scripts', array( $this, 'qcwp_userswp_dequeue_script' ), 100 );
        }

    }

    function qcwp_userswp_dequeue_script() {
        wp_dequeue_script( 'bootstrap-js-bundle' );
    }

    /**
     * Check if update is needed then run updater
     *
     * @return void
     */
    public function maybe_update(){

        if( ! get_option( 'qcld_wpbot_version' ) || ( version_compare( get_option( 'qcld_wpbot_version' ), qcld_wpbot()->version, '<' ) ) ){
            
            if( file_exists( QCLD_wpCHATBOT_PLUGIN_DIR_PATH . "includes/upgrades/update-".qcld_wpbot()->version.".php" ) ){
                include_once( QCLD_wpCHATBOT_PLUGIN_DIR_PATH . "includes/upgrades/update-".qcld_wpbot()->version.".php" );
                update_option( 'qcld_wpbot_version', qcld_wpbot()->version );
            }
        }
    }

    public function check_mysql_version(){
        global $wpdb;
        if( is_admin() ){

            $connection = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
			if($connection === false){
				return;
			}
            $content = $connection->server_info;

            $mysql_server_info = $wpdb->db_server_info();

            // Check for the MariaDB.
            $is_mariadb = false;
			if ( ! empty( $mysql_server_info ) && strpos( strtolower( $mysql_server_info ), 'maria' ) !== false ) {
				$is_mariadb = true;
			}

            preg_match_all('/\d+\.\d+/', $content, $matches);
            
            if( !empty( $matches ) && isset( $matches[0] ) && !empty( $matches[0] ) && is_array( $matches[0] ) && ! $is_mariadb ){
                $versions = $matches[0];
                $notice = true;
                foreach( $versions as $version ){
                    if (version_compare($version, '5.5', '>')) {
                        $this->mysql_version = $version;
                        $notice = false;
                    }else{
                        $this->mysql_version = $version;
                    }
                }

                if( $notice ){
                    add_action('admin_notices', array($this, 'mysql_version_notice') );
                }

            }

            $connection->close();
        }
    }

    public function mysql_version_notice(){
        $class="notice notice-error is-dismissible qc-notice-error";
        $message = "Your server's MySQL version is **".$this->mysql_version."**. MySQL version 5.6+ is required for Simple Text Responses to work. Please contact your hosting support to upgrade the MySQL to the latest version.";
        printf( '<div class="%1$s"><a href="'.esc_url('https://www.quantumcloud.com/products/').'" target="_blank"><img src="'.esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'plugin-upgrader/images/qc-logo.jpg').'" /></a><p>%2$s</p></div>', esc_attr( $class ), $message ); 
    }


}

new Qcld_WPBot_Maybe_Upgrade();
