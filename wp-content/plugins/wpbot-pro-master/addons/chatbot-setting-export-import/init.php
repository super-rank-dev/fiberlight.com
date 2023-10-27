<?php

 
if (!defined('ABSPATH')) exit; // Exit if accessed directly
define('QCLD_WPSEI_VERSION', '1.0.0');
define('QCLD_WPSEI_PLUGIN_DIR_PATH', plugin_dir_path(__FILE__));
define('QCLD_WPSEI_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 *
 * Function to load translation files.
 *
 */
function qc_wpsei_addon_lang_init() {
    load_plugin_textdomain( 'qccsi', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'qc_wpsei_addon_lang_init');


add_action( 'admin_menu', 'wpsei_admin_menu');

function wpsei_admin_menu(){
	if ( current_user_can( 'publish_posts' ) ){
		add_menu_page( 'Bot - Settings Export/Import', 'Bot - Settings Export/Import', 'manage_options', 'wpsei-settings-export-import', 'qc_wpsei_export_callback', '
dashicons-controls-repeat', '9' );
	}
}

function qc_wpsei_export_callback(){
?>
<div class="qchero_sliders_list_wrapper">
	<div class="sld_menu_title">
		<h2><?php echo esc_html__('Export/Import All Settings for Chatbot & Bot Woocommerce', 'qccsi') ?></h2>
	</div>
		<br>
		<div class="content">
			<h4><?php echo esc_html__('Export Settings', 'qccsi') ?></h4>
			<p>
				<?php echo esc_html('Export button will create a downloadable JSON file with all of your existing settings for Chatbot & Bot Woocommerce.', 'qccsi'); ?>
			</p>
			<a class="button-primary" href="<?php echo admin_url( 'admin-post.php?action=wpwbotsettings.csv' ); ?>"><?php echo esc_html__('Export Settings', 'qccsi') ?></a>
			
			<div>
			<br>
			<h4>
				<?php echo esc_html__('Upload your backup settings JSON file', 'qccsi'); ?>
			</h4>

			<form name="uploadfile" id="uploadfile_form" method="POST" enctype="multipart/form-data" action="" accept-charset="utf-8">
				
				<p>
					<?php echo esc_html__('Select file to upload', 'qccsi') ?>
					<input type="file" name="wp_csv_upload" id="csv_upload" size="35" class="uploadfiles" required/>
				</p>
				
				<p>
					<input class="button-primary" type="submit" name="wp_upload_csv" id="" value="<?php echo esc_html__('Import Settings', 'qccsi') ?>"/>

				</p>

			</form>				
			<?php if(isset($_GET['msg']) && $_GET['msg']=='success'): ?>
			<p style="color:green;font-weight:bold;"><?php echo esc_html__('Settings imported successfully!', 'qccsi'); ?></p>
			<?php endif; ?>
			</div>
		</div>
</div>
<?php
}

//===========settings export ==============//

function qc_wpsei_download_send_headers($filename) {
    // disable caching
    $now = gmdate("D, d M Y H:i:s");
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
    header("Last-Modified: {$now} GMT");

    // force download  
    header("Content-Type: application/force-download");
    /*header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");*/

    // disposition / encoding on response body
    header("Content-Disposition: attachment;filename={$filename}");
	header("Content-Transfer-Encoding: binary");
}

function qc_wpsei_array2csv(array &$array)
{
   if (count($array) == 0) {
     return null;
   }

   ob_start();

   $df = fopen("php://output", 'w');

   $titles = array('key', 'value');

   fputcsv($df, $titles);

   foreach ($array as $row) {
      fputcsv($df, $row);
   }

   fclose($df);

   return ob_get_clean();
}

add_action( 'admin_post_wpwbotsettings.csv', 'qc_wpsei_export_print_csv' );

function qc_wpsei_export_print_csv()
{    
	
	
	$wpbot_settings = qcld_wpbot()->get_settings();
	if( get_option( 'wbca_options' ) ){
		$wpbot_settings[] = 'wbca_options';
	}
	
	$mainArray = array();
	if( ! empty( $wpbot_settings ) ){
		foreach( $wpbot_settings as $setting ){
			$mainArray[$setting] = get_option( $setting );
		}
	}
	
	qc_wpsei_download_send_headers("chatbot_settings_" . date("Y-m-d") . ".json");

	echo json_encode( $mainArray );
}


add_action('init', 'qc_wpsei_settings_upload_handle');

function qc_wpsei_settings_upload_handle(){
	
	if(isset($_POST['wp_upload_csv'])){
		//First check if the uploaded file is valid
		$valid = true;
		
		$allowedTypes = array( 
                        			'application/json', 

                        		);
		//echo $_FILES['csv_upload']['type'];exit;
		if( !in_array($_FILES['wp_csv_upload']['type'], $allowedTypes) ){
			$valid = false;
		}

		if( ! $valid ){
			echo "Status: Invalid file type.";
		}
		
		
		$tmpName = $_FILES['wp_csv_upload']['tmp_name'];
								
		if( $tmpName != "" )
		{
		
			$file = fopen($tmpName, "r");
			$flag = true;
			
			//Reading file and building our array
			
			
			while(!feof($file)){
				$line_of_text = fgets($file);
				$settings = json_decode($line_of_text, true);
				if( ! empty( $settings ) && is_array( $settings ) ){
					foreach( $settings as $key => $value ){
						update_option( $key, $value );
					}
				}
			}
			
			
		}
		wp_redirect(admin_url('admin.php?page=wpsei-settings-export-import&msg=success'));die();
	}
	
}