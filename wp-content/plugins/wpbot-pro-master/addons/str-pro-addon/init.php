<?php

 
if (!defined('ABSPATH')) exit; // Exit if accessed directly
 
define('QCLD_STRPRO_VERSION', '1.0.4');
define('QCLD_STRPRO_PLUGIN_DIR_PATH', plugin_dir_path(__FILE__));
define('QCLD_STRPRO_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once QCLD_STRPRO_PLUGIN_DIR_PATH.'includes/functions.php';
require_once(QCLD_STRPRO_PLUGIN_DIR_PATH . '/plugin-upgrader/plugin-upgrader.php');

add_action('init', 'qcld_str_pro_dependency');
function qcld_str_pro_dependency(){
	include_once(ABSPATH.'wp-admin/includes/plugin.php');
	
	if ( !defined('QCLD_wpCHATBOT_VERSION')) {
		add_action('admin_notices', 'qcpd_str_pro_require_notice');
	}

}

add_action('admin_enqueue_scripts', 'qcld_wb_chatbot_str_scripts');
function qcld_wb_chatbot_str_scripts() {
	if ( isset( $_GET['page'] ) && $_GET['page'] == 'simple-text-response' && isset( $_GET['action'] ) && $_GET['action'] == 'edit' ) {
		wp_register_style('qcld-wp-chatbot-str-css', QCLD_STRPRO_PLUGIN_URL . 'assets/css/style.css', '', QCLD_STRPRO_VERSION, 'screen');
		wp_enqueue_style('qcld-wp-chatbot-str-css');

		wp_register_script('qcld-wp-chatbot-str-script', QCLD_STRPRO_PLUGIN_URL . 'assets/js/script.js', array('jquery'), QCLD_STRPRO_VERSION, true);
		wp_enqueue_script('qcld-wp-chatbot-str-script');
	}
	
}


function qcpd_str_pro_require_notice()
{
?>
	<div id="message" class="error">
		<p>
			<?php echo esc_html__('Please install & activate the Chatbot Pro plugin to get the STR Pro Addon to work.', 'dfentity'); ?>
		</p>
	</div>
<?php
}


add_action( 'admin_menu', 'qcld_chatbot_str_menu_fnc' );

function qcld_chatbot_str_menu_fnc(){

//	add_menu_page( 'Bot - STR Pro', 'Bot - STR Pro', 'publish_posts', 'chatbot-str-page', 'qcld_chatbot_str_license_callback', 'dashicons-menu', '9' );

}


function qcld_chatbot_str_license_callback(){
	//
	//	str_display_license_section();
	?>
	
	
	<div class="qcld-wpbot-help-section">
            <h1>Welcome to the Simple Text Responses Pro Addon! You are awesome, by the way <img draggable="false" class="emoji" alt="ðŸ™‚" src="https://s.w.org/images/core/emoji/11/svg/1f642.svg"></h1>

            <div class="qcld-wpbot-section-block">
                <h2>How to Use?</h2>
                <p>Please go to <b>Chatbot Pro > Simple Text Responses</b> page. The pro features like Export/Import, Manage Categories, rich text editor etc should be added on that page.</p>
            </div>
	</div>
	
	<?php
}

/**
 *
 * Function to load translation files.
 *
 */
function qcpd_strpro_addon_lang_init() {
    load_plugin_textdomain( 'strpro', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

add_action( 'plugins_loaded', 'qcpd_strpro_addon_lang_init');

register_activation_hook(__FILE__, 'qcld_str_pro_defualt_options');
register_deactivation_hook(__FILE__, 'qcld_str_pro_deactive_options');
function qcld_str_pro_defualt_options($network_wide){
	global $wpdb;
   
    if ( is_multisite() && $network_wide ) {
        // Get all blogs in the network and activate plugin on each one
        $blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
        foreach ( $blog_ids as $blog_id ) {
            switch_to_blog( $blog_id );
            qcld_str_pro_create_table_all();
            restore_current_blog();
        }
    } else {
        qcld_str_pro_create_table_all();
    }
}

function qcld_str_pro_deactive_options($network_wide){
	global $wpdb;
	$table = $wpdb->prefix.'wpbot_response';
    if ( is_multisite() && $network_wide ) {
        // Get all blogs in the network and activate plugin on each one
        $blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
        foreach ( $blog_ids as $blog_id ) {
            switch_to_blog( $blog_id );
            
			if(function_exists('qcstrpro_mysql_remove_existing_indexes')){
				qcstrpro_mysql_remove_existing_indexes();
			}
			$wpdb->query("ALTER TABLE $table ADD FULLTEXT(`query`, `keyword`, `response`)");
			
            restore_current_blog();
        }
    } else {
        
		if(function_exists('qcstrpro_mysql_remove_existing_indexes')){
			qcstrpro_mysql_remove_existing_indexes();
		}
		$wpdb->query("ALTER TABLE $table ADD FULLTEXT(`query`, `keyword`, `response`)");
		
    }
}

function qcld_str_pro_create_table_all(){
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
	
	//Bot Response Category Table
	$table1    = $wpdb->prefix.'wpbot_response_category';
    $sql_sliders_Table1 = "
        CREATE TABLE IF NOT EXISTS `$table1` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(256) NOT NULL,
        `custom` varchar(256) NOT NULL,
        PRIMARY KEY (`id`)
        )  $collate AUTO_INCREMENT=1 ";
        
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql_sliders_Table1 );
	
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
		)  $collate AUTO_INCREMENT=1";
		
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql_sliders_Table1 );
	
}

//plugin activate redirect

function qc_chatbot_str_activation_redirect( $plugin ) {
    if( $plugin == plugin_basename( __FILE__ ) ) {
        exit( wp_redirect( admin_url('admin.php?page=chatbot-str-page') ) );
    }
}
add_action( 'activated_plugin', 'qc_chatbot_str_activation_redirect' );

function qcstrpro_mysql_remove_existing_indexes(){
	
	global $wpdb;
	$table = $wpdb->prefix.'wpbot_response';
	
	$results = $wpdb->get_results("SHOW INDEX FROM $table");
	
	$indexes = array();
	foreach($results as $result){
		
		if("PRIMARY" != $result->Key_name && !in_array($result->Key_name, $indexes)){
			$wpdb->query("ALTER TABLE $table DROP INDEX `".$result->Key_name
."`;");
			$indexes[] = $result->Key_name;
		}
		
	}
	
}

add_action('init', 'qc_str_filter_redirect');
function qc_str_filter_redirect(){
	//print_r( $_POST );exit;
	$baseurl = admin_url('admin.php?page=simple-text-response');
	if(isset($_POST['strcat-filter'])){
		
		if($_POST['strcat-filter']!=''){
			$category = $_POST['strcat-filter'];
			$baseurl = add_query_arg( 'strcat-filter', $category, $baseurl );
		}
		
	}

	if(isset($_POST['strlang-filter'])){
		
		if($_POST['strlang-filter']!=''){
			$category = $_POST['strlang-filter'];
			$baseurl = add_query_arg( 'strlang-filter', $category, $baseurl );
		}
		
	}
	
	if(isset($_POST['str_search'])){
		
		if($_POST['str_search']!=''){
			$search = $_POST['str_search'];
			$baseurl = add_query_arg( 'str_search', $search, $baseurl );
		}
		
	}
	
	if(isset($_POST['str_clearfilter_action'])){
		$baseurl = admin_url('admin.php?page=simple-text-response');
		wp_redirect($baseurl);exit;
	}
	
	if(isset($_POST['str_filter_action'])){
		wp_redirect($baseurl);exit;
	}
	
	
}


