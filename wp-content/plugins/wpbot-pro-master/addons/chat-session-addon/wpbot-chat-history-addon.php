<?php


if(!function_exists('qcwp_chat_session_menu_fnc')){
defined('ABSPATH') or die("No direct script access!");
define('QCLD_wpCHATBOT_HISTORY_PLUGIN_URL', plugin_dir_url(__FILE__));
define('QCLD_WPCHATBOT_HISTORY_DIR_PATH', plugin_dir_path(__FILE__));
define('QCLD_WPBOT_HISTORY_VERSION', '2.2.7');

add_action('init', 'qcpd_wpcs_chat_session_dependencies');
function qcpd_wpcs_chat_session_dependencies(){
	include_once(ABSPATH.'wp-admin/includes/plugin.php');
	if ( !class_exists('qcld_wb_Chatbot') && !class_exists('QCLD_Woo_Chatbot') && (qcwpcs_is_kbxwpbot_active() != true) ) {
		add_action('admin_notices', 'qcpd_wpbot_cs_require_notice');
	} 
}

add_action( 'admin_menu', 'qcwp_chat_session_menu_fnc' );

function qcwp_chat_session_menu_fnc(){
	
	if ( current_user_can( 'publish_posts' ) ){


		add_menu_page( 'Bot - Sessions', 'Bot - Sessions', 'publish_posts', 'wbcs-botsessions-page', 'qc_wpbot_cs_menu_page_callback_func', 'dashicons-menu', '9' );
		
		add_submenu_page( 'wbcs-botsessions-page', 'Questions Not Answered', 'Questions Not Answered', 'manage_options','wbcs-botsessions-notansweredpage', 'qcld_wpbot_not_answered_question' );

		if(qcpdcs_is_woowbot_active()){
			add_submenu_page( 'wbcs-botsessions-page', 'ChatBot Sessions', 'ChatBot Sessions', 'manage_options','woowbot_cs_menu_page', 'woowbot_cs_menu_page_callback_func' );
		}
	}
	
}

function qcpd_wpbot_cs_require_notice()
{
?>
	<div id="message" class="error">
		<p>
			<?php echo esc_html('Please install & activate the WPBot pro or WoowBot WooCommerce Chatbot Pro plugin to get the Chat Session Addon work properly.') ?>
		</p>
	</div>
<?php
}

function qcld_wpbot_not_answered_question(){
	global $wpdb;
	$wpdb->show_errors = true;
	$table    = $wpdb->prefix.'wpbot_failed_response';

	if(isset($_GET['msg']) && $_GET['msg']=='success'){
		echo '<div class="notice notice-success"><p>Record has beed Deleted Successfully!</p></div>';
	}

	$msg = '';
	if(isset($_GET['action']) && $_GET['action']=='deleteall'){
		global $wpdb;
		$wpdb->query("TRUNCATE TABLE `$table`");
		echo '<div class="notice notice-success"><p>All Records has been deleted successfully!</p></div>';
	}

	$sql = "SELECT * FROM $table WHERE 1 order by `id` DESC";

	$sql1 = "SELECT count(*) FROM $table WHERE 1 order by `id` DESC";
	
	$total             = $wpdb->get_var( $sql1 );
	$items_per_page = 30;
	$page             = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
	$offset         = ( $page * $items_per_page ) - $items_per_page;
	$sql .=" LIMIT ${offset}, ${items_per_page}";
	$rows = $wpdb->get_results( $sql );
	$totalPage         = ceil($total / $items_per_page);
	$result = $wpdb->get_results($sql);
	$customPagHTML = '';
	if($totalPage > 1){
		$customPagHTML     =  '<div><span class="wpbot_pagination">Page '.esc_html($page).' of '.esc_html($totalPage).'</span>'.paginate_links( array(
		'base' => add_query_arg( 'cpage', '%#%' ),
		'format' => '',
		'prev_text'    => __('« prev'),
		'next_text'    => __('next »'),
		'total' => esc_html($totalPage),
		'current' => esc_html($page),
		
		)).'</div>';
	}

	?>
		
		<div class="sld_menu_title">
			<h2 style="font-size: 26px;text-align:center"><?php echo esc_html__('Questions Not Answered', 'qc-opd').' ('.$total.')'; ?></h2>
		</div>

		<?php if($customPagHTML!=''): ?>
		<div class="sld_menu_title sld_menu_title_align"><?php echo ($customPagHTML); ?> </div>
		<?php endif; ?>

		<?php if( ! empty( $result ) ): 
		$deleteurl = admin_url( 'admin.php?page=wbcs-botsessions-notansweredpage&action=deleteall');	
		?>
		<br>
		<a href="<?php echo esc_url($deleteurl); ?>" class="button button-primary" ><?php echo esc_html('Delete All Records'); ?></a>
		<div class="qchero_slider_table_area">
			<div class="sld_payment_table">
				<div class="sld_payment_row header">
					
					<div class="sld_payment_cell">
						<?php echo esc_html__( 'User\'s Query', 'qc-opd' ) ?>
					</div>
					<div class="sld_payment_cell">
						<?php echo esc_html__( 'Count', 'qc-opd' ) ?>
					</div>
					<div class="sld_payment_cell">
						<?php echo esc_html__( 'Action', 'qc-opd' ); ?>
					</div>
				</div>
				<?php foreach( $result as $row ): 
				$delurl = admin_url( 'admin.php?page=wbcs-botsessions-notansweredpage&id='.$row->id.'&act=delete');	
				?>
				<div class="sld_payment_row body">
					<div class="sld_payment_cell">
						<div class="sld_responsive_head"><?php echo esc_html__('User\'s Query', 'qc-opd') ?></div>
						<?php echo esc_html( $row->query ); ?>
					</div>

					<div class="sld_payment_cell">
						<div class="sld_responsive_head"><?php echo esc_html__('Session ID', 'qc-opd') ?></div>
						<?php echo esc_html( $row->count ); ?>
					</div>
					
					<div class="sld_payment_cell">
						<div class="sld_responsive_head"><?php echo esc_html__('Action', 'qc-opd') ?></div>
						<a href="<?php echo $delurl; ?>" class="button-primary" onclick="return confirm('are you sure?')"><?php echo esc_html('Delete'); ?></a>

					</div>
				</div>
				<?php endforeach; ?>

			</div>
		</div>
		<?php else: ?>
		<div style="text-align: center;background: #fff;margin-top: 10px;padding: 20px;font-size: 20px;">No record Found!</div>
		<?php endif; ?>

	<?php
}

function qc_wpbot_cs_menu_page_callback_func(){
	global $wpdb;
	$wpdb->show_errors = true;
	
	$tableuser    = $wpdb->prefix.'wpbot_user';
	$tableconversation    = $wpdb->prefix.'wpbot_Conversation';
	$mainurl = admin_url( 'admin.php?page=wbcs-botsessions-page');
	if( isset($_GET['min_interaction']) ){
		$mainurl = $mainurl.'&min_interaction='.$_GET['min_interaction'];
	}

	if( isset($_GET['wp_user']) && $_GET['wp_user'] !="" ){
		$mainurl = $mainurl.'&wp_user='.$_GET['wp_user'];
	}
	
	$msg = '';
	if(isset($_GET['action']) && $_GET['action']=='deleteall'){
		global $wpdb;
		$wpdb->query("TRUNCATE TABLE `$tableuser`");
		$wpdb->query("TRUNCATE TABLE `$tableconversation`");
		$msg = esc_html('All Sessions has been deleted successfully!');
	}
	
	if(isset($_GET['msg']) && $_GET['msg']=='success'){
		echo '<div class="notice notice-success"><p>Record has beed Deleted Successfully!</p></div>';
	}
	
	if(isset($_GET['userid']) && $_GET['userid']!=''){
	$userid = sanitize_text_field($_GET['userid']);
	$userinfo = $wpdb->get_row("select * from $tableuser where 1 and id = '".$userid."'");
	$delurl = admin_url( 'admin.php?page=wbcs-botsessions-page&userid='.$userinfo->id.'&act=delete');
	$export =  admin_url( 'admin-post.php?action=wpbot_conversations.csv&user_id='.$userid );
	?>	
	<div class="sld_menu_title" style="text-align:left;">
		<table class="form-table">
			<tbody>
			<tr><th style="padding: 5px;" scope="row"><?php echo esc_html('User Name'); ?></th><td style="padding: 5px;"><?php echo esc_html($userinfo->name) ?></td></tr>
			<tr><th style="padding: 5px;" scope="row"><?php echo esc_html('User Email') ?></th><td style="padding: 5px;"><?php echo esc_html($userinfo->email) ?></td></tr>
			<tr><th style="padding: 5px;" scope="row"><?php echo esc_html('Date'); ?></th><td style="padding: 5px;"><?php echo date('M,d,Y h:i:s A', strtotime($userinfo->date)); ?></td></tr>
			</tbody>
		</table>

		<a href="<?php echo esc_url($delurl); ?>" class="button-primary" onclick="return confirm('are you sure?')" style="float: right; position: relative; top: -65px; right: 21px;"><?php echo esc_html('Delete'); ?></a>
		
		<a href="<?php echo esc_url($export); ?>" class="button-primary" style="float: right; position: relative; top: -65px; right: 32px;"><?php echo esc_html('Export'); ?></a>
	</div>
	<?php 
	
	$result = $wpdb->get_row("select * from $tableconversation where 1 and user_id = '".$userid."'");
	
		if(!empty($result)):
		
		$qcld_wb_chatbot_theme = get_option('qcld_wb_chatbot_theme');
		if (file_exists(QCLD_wpCHATBOT_PLUGIN_DIR_PATH . '/templates/' . $qcld_wb_chatbot_theme . '/style.css')) {
			wp_register_style('qcld-wp-chatbot-style', QCLD_wpCHATBOT_PLUGIN_URL . '/templates/' . $qcld_wb_chatbot_theme . '/style.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
			wp_enqueue_style('qcld-wp-chatbot-style');
		}
		wp_register_style('qcld-wp-chatbot-history-style', QCLD_wpCHATBOT_HISTORY_PLUGIN_URL . '/css/history-style.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
        wp_enqueue_style('qcld-wp-chatbot-history-style');
		wp_enqueue_style('qcld-wp-chatbot-jquery-ui');
		wp_register_style('qcld-wp-chatbot-jquery-ui', QCLD_wpCHATBOT_HISTORY_PLUGIN_URL . '/css/jqueryui.css', '', '', 'screen');
		wp_register_style('qcld-wp-chatbot-common-style', QCLD_wpCHATBOT_PLUGIN_URL . '/css/common-style.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
        wp_enqueue_style('qcld-wp-chatbot-common-style');
		
		
	?>
		<div class="qchero_sliders_list_wrapper">
		<div class="qchero_slider_table_area" style="max-width: 650px;">
			<div class="wp-chatbot-messages-wrapper">
			<?php 
			
				echo htmlspecialchars_decode($result->conversation); 
				
				?>
			</div>
		</div>
		</div>
	<?php
		endif;
	}else{
		wp_register_style('qcld-wp-chatbot-history-style', QCLD_wpCHATBOT_HISTORY_PLUGIN_URL . '/css/history-style.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
        wp_enqueue_style('qcld-wp-chatbot-history-style');
		wp_enqueue_style('qcld-wp-chatbot-jquery-ui');
		wp_register_style('qcld-wp-chatbot-jquery-ui', QCLD_wpCHATBOT_HISTORY_PLUGIN_URL . '/css/jqueryui.css', '', '', 'screen');
		wp_register_script('qcld-wp-chatsession-admin-js',QCLD_wpCHATBOT_HISTORY_PLUGIN_URL . '/js/chatsession.js' , array('jquery'), true);
         wp_enqueue_script('qcld-wp-chatsession-admin-js');
		 wp_localize_script('qcld-wp-chatsession-admin-js', 'ajax_object',
                array('ajax_url' => admin_url('admin-ajax.php')));
		
		$where = '';
		if( isset( $_GET['min_interaction'] ) && $_GET['min_interaction'] != 'all' ){

			if( isset( $_GET['min_interaction'] ) && $_GET['min_interaction'] > 0 ){
				$where = ' and `interaction` >= '.$_GET['min_interaction'];
			}
			if( isset( $_GET['min_interaction'] ) && $_GET['min_interaction'] == 0 ){
				$where = ' and `interaction` = '.$_GET['min_interaction'];
			}

		}
		
		$wwhere = '';
		if( isset( $_GET['wp_user'] ) && $_GET['wp_user'] != "all" && $_GET['wp_user'] != 0 && $_GET['wp_user'] != "" ){
			$wwhere = ' and `user_id` = '.$_GET['wp_user'];
		}
		
		$sql = "SELECT * FROM $tableuser WHERE 1 $where $wwhere order by `date` DESC";
		
		$sql1 = "SELECT count(*) FROM $tableuser WHERE 1 $where $wwhere order by `date` DESC";
		
		$total             = $wpdb->get_var( $sql1 );
		$items_per_page = 30;
		$page             = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
		$offset         = ( $page * $items_per_page ) - $items_per_page;
		$sql .=" LIMIT ${offset}, ${items_per_page}";
		$rows = $wpdb->get_results( $sql );
		$totalPage         = ceil($total / $items_per_page);
		$result = $wpdb->get_results($sql);
		$customPagHTML = '';
		if($totalPage > 1){
			$customPagHTML     =  '<div><span class="wpbot_pagination">Page '.esc_html($page).' of '.esc_html($totalPage).'</span>'.paginate_links( array(
			'base' => add_query_arg( 'cpage', '%#%' ),
			'format' => '',
			'prev_text'    => __('« prev'),
            'next_text'    => __('next »'),
			'total' => esc_html($totalPage),
			'current' => esc_html($page),
			
			)).'</div>';
		}
$deleteurl = admin_url( 'admin.php?page=wbcs-botsessions-page&action=deleteall');
	?>
	<div class="qchero_sliders_list_wrapper">
		<?php 
			if($msg!=''){
				?>
				<div class="notice notice-success is-dismissible">
					<p><?php echo esc_html($msg); ?></p>
				</div>
				<?php
			}
		?>
		<div class="sld_menu_title">
			<h2 style="font-size: 26px;text-align:center"><?php echo esc_html__('Chat Sessions', 'qc-opd').' ('.$total.')'; ?></h2>
		</div>
		
		<?php if($customPagHTML!=''): ?>
		<div class="sld_menu_title sld_menu_title_align"><?php echo ($customPagHTML); ?> </div>
		<?php endif; ?>
		<?php
		wp_enqueue_style('qcld-wp-chatbot-jquery-ui');
		wp_register_style('qcld-wp-chatbot-jquery-ui', QCLD_wpCHATBOT_HISTORY_PLUGIN_URL . '/css/jqueryui.css', '', '', 'screen');
		wp_register_script('qcld-wp-jqueryui-js',QCLD_wpCHATBOT_HISTORY_PLUGIN_URL . '/js/jqueryui.js' , array('jquery'), true);
		wp_enqueue_script('qcld-wp-jqueryui-js');
		
		?>
		
		<form id="wpcs_form_sessions_min" action="<?php echo esc_url($mainurl); ?>" method="GET" style="width:100%;margin-top: 20px;">
		<input type="hidden" name="page" value="wbcs-botsessions-page" />
		Filter by Minimum Interaction <select name="min_interaction" id="qcld_session_min_interaction">
			<option value="all" <?php echo (isset($_GET['min_interaction']) && $_GET['min_interaction']=='all' ?'selected="selected"':'') ?> >All</option>
			<option value="0" <?php echo (isset($_GET['min_interaction']) && $_GET['min_interaction']==0 ?'selected="selected"':'') ?>>0</option>
			<option value="1" <?php echo (isset($_GET['min_interaction']) && $_GET['min_interaction']==1 ?'selected="selected"':'') ?>>1</option>
			<option value="2" <?php echo (isset($_GET['min_interaction']) && $_GET['min_interaction']==2 ?'selected="selected"':'') ?>>2</option>
			<option value="3" <?php echo (isset($_GET['min_interaction']) && $_GET['min_interaction']==3 ?'selected="selected"':'') ?>>3</option>
			<option value="4" <?php echo (isset($_GET['min_interaction']) && $_GET['min_interaction']==4 ?'selected="selected"':'') ?>>4</option>
			<option value="5" <?php echo (isset($_GET['min_interaction']) && $_GET['min_interaction']==5 ?'selected="selected"':'') ?>>5</option>
		</select>

		<?php 
		$wpusersql = "SELECT DISTINCT `user_id` FROM $tableuser WHERE 1 $where order by `date` DESC limit 0, 150";
		$wp_user_ids =  $wpdb->get_col( $wpusersql );

		if ( ! empty( $wp_user_ids ) ) {
			$args = array(
				'include' => $wp_user_ids, // These are the ID's of users you want to get.
				'fields'   => array( 'ID', 'display_name' ),
			);
			   
			$wp_users = get_users( $args );
			if( ! empty( $wp_users ) ) {
				?>
				Filter By Registered User <select name="wp_user" id="qcld_session_wp_user">
					<option value="">All</option>
					<?php 
						foreach( $wp_users as $wp_user ) {
							?>
							<option value="<?php echo $wp_user->ID; ?>" <?php echo ( isset($_GET['wp_user']) && $_GET['wp_user'] == $wp_user->ID ? 'selected="selected"' : '' ); ?> > <?php echo $wp_user->display_name; ?> </option>
							<?php
						}
					?>
				</select>
				<?php
			}
		}

		?>
		

		<!--<div class="wpvo_filter_session">
			<div class="filter_session_start_date">Start Date: <input type="text" id="session_s_date"></div>
			<div class="filter_session_end_date"> End Date: <input type="text" id="session_e_date"></div>
			<a class="filter_session_button">Find</a>
		</div>-->
		</form>
		
		<form id="wpcs_form_sessions" action="<?php echo esc_url($mainurl); ?>" method="POST" style="width:100%">
		<input type="hidden" name="wpbot_session_remove" />
		<br>
		<button class="button-primary" id="wpbot_submit_session_delete" name="wpbot_session_delete"><?php echo esc_html('Delete'); ?></button>
		<a href="<?php echo esc_url($deleteurl); ?>" class="button button-primary" ><?php echo esc_html('Delete All Sessions'); ?></a>
		
		<button class="button-primary" id="wpbot_submit_session_export" name="wpbot_session_export"><?php echo esc_html('Export'); ?></button>
		
		<button class="button-primary" id="wpbot_submit_session_export_all" name="wpbot_session_export_all"><?php echo esc_html('Export All'); ?></button>
		
		<?php if(!empty($result)): ?>
		
		<div class="qchero_slider_table_area">
			<div class="sld_payment_table">
				<div class="sld_payment_row header">
				
					<div class="sld_payment_cell">
						<input type="checkbox" id="wpbot_checked_all" />
					</div>
					
					<div class="sld_payment_cell">
						<?php echo esc_html__( 'Date', 'qc-opd' ) ?>
					</div>
					<div class="sld_payment_cell">
						<?php echo esc_html__( 'User Interaction Count', 'qc-opd' ) ?>
					</div>
					<div class="sld_payment_cell">
						<?php echo esc_html__( 'Session ID', 'qc-opd' ) ?>
					</div>
					
					<div class="sld_payment_cell">
						<?php echo esc_html__( 'Name', 'qc-opd' ); ?>
					</div>
					<div class="sld_payment_cell">
						<?php echo esc_html__( 'Email', 'qc-opd' ); ?>
					</div>
					<div class="sld_payment_cell">
						<?php echo esc_html__( 'Phone', 'qc-opd' ); ?>
					</div>
					<div class="sld_payment_cell">
						<?php echo esc_html__( 'Action', 'qc-opd' ); ?>
					</div>
					
				</div>

		<?php
		foreach($result as $row){
			$url = admin_url( 'admin.php?page=wbcs-botsessions-page&userid='.$row->id);
			$delurl = admin_url( 'admin.php?page=wbcs-botsessions-page&userid='.$row->id.'&act=delete');
		?>
			<div class="sld_payment_row body">
				
				<div class="sld_payment_cell">
					
					<input type="checkbox" name="sessions[]" class="wpbot_sessions_checkbox" value="<?php echo esc_html($row->id) ?>" />
				</div>
				
				<div class="sld_payment_cell">
					<div class="sld_responsive_head"><?php echo esc_html__('Date', 'qc-opd') ?></div>
					<a href="<?php echo esc_url($url); ?>"><?php echo date('M,d,Y h:i:s A', strtotime($row->date)); ?></a>
				</div>
				<div class="sld_payment_cell">
					<div class="sld_responsive_head"><?php echo esc_html__('User Interaction Count', 'qc-opd') ?></div>
					<?php
						$res = $wpdb->get_row("select * from $tableconversation where 1 and user_id = '".$row->id."'");
						echo $res->interaction;
					?>
				</div>
				<div class="sld_payment_cell">
					<div class="sld_responsive_head"><?php echo esc_html__('Session ID', 'qc-opd') ?></div>
					<?php echo esc_html($row->session_id); ?>
				</div>
				
				<div class="sld_payment_cell">
					<div class="sld_responsive_head"><?php echo esc_html__('Name', 'qc-opd') ?></div>
					<?php echo esc_html($row->name); ?>
				</div>
				<div class="sld_payment_cell">
					<div class="sld_responsive_head"><?php echo esc_html__('Email', 'qc-opd') ?></div>
					<?php
						echo esc_html($row->email);
					?>
				</div>
				<div class="sld_payment_cell">
					<div class="sld_responsive_head"><?php echo esc_html__('Phone', 'qc-opd') ?></div>
					<?php
						echo esc_html($row->phone);
					?>
				</div>
				<div class="sld_payment_cell">
					<div class="sld_responsive_head"><?php echo esc_html__('Action', 'qc-opd') ?></div>
					<a href="<?php echo esc_url($url); ?>" class="button-primary"><?php echo esc_html('View Chat') ?></a>
					<a href="<?php echo esc_url($delurl); ?>" class="button-primary" onclick="return confirm('are you sure?')"><?php echo esc_html('Delete'); ?></a>
					<?php if($row->email!=''): ?>
					<a href="#" data-email="<?php echo esc_html($row->email); ?>" class="button-primary wpcsmyBtn"><?php echo esc_html('Send Email') ?></a>
					<?php endif; ?>
				</div>
				
			</div>
		<?php
		}
		?>

		</div>

	</div>
	</form>
	<?php endif; ?>
	</div>
	<?php
	}
}

function woowbot_cs_menu_page_callback_func(){
	global $wpdb;
	$wpdb->show_errors = true;
	
	$tableuser    = $wpdb->prefix.'wowbot_user';
	$tableconversation    = $wpdb->prefix.'wowbot_Conversation';

	
	$msg = '';
	if(isset($_GET['action']) && $_GET['action']=='deleteall'){
		global $wpdb;
		$wpdb->query("TRUNCATE TABLE `$tableuser`");
		$wpdb->query("TRUNCATE TABLE `$tableconversation`");
		$msg = esc_html('All Sessions has been deleted successfully!');
	}
	
	if(isset($_GET['msg']) && $_GET['msg']=='success'){
		echo '<div class="notice notice-success"><p>Record has beed Deleted Successfully!</p></div>';
	}
	
	if(isset($_GET['userid']) && $_GET['userid']!=''){
	$userid = $_GET['userid'];
	$userinfo = $wpdb->get_row("select * from $tableuser where 1 and id = '".$userid."'");
	?>	
	<div class="sld_menu_title" style="text-align:left;">
		<table class="form-table">
			<tbody>
			<tr><th style="padding: 5px;" scope="row"><?php echo esc_html('User Name'); ?></th><td style="padding: 5px;"><?php echo esc_html($userinfo->name); ?></td></tr>
			<tr><th style="padding: 5px;" scope="row"><?php echo esc_html('User Email'); ?></th><td style="padding: 5px;"><?php echo esc_html($userinfo->email) ?></td></tr>
			<tr><th style="padding: 5px;" scope="row"><?php echo esc_html('Date'); ?></th><td style="padding: 5px;"><?php echo date('M,d,Y h:i:s A', strtotime($userinfo->date)); ?></td></tr>
			</tbody>
		</table>
	</div>
	<?php 
	
	$result = $wpdb->get_row("select * from $tableconversation where 1 and user_id = '".$userid."'");
	
		if(!empty($result)):
		
		$qcld_wb_chatbot_theme = get_option('qcld_woo_chatbot_theme');
		if (file_exists(QCLD_WOOCHATBOT_PLUGIN_DIR_PATH . '/templates/' . $qcld_wb_chatbot_theme . '/style.css')) {
			wp_register_style('qcld-wp-chatbot-style', QCLD_WOOCHATBOT_PLUGIN_URL . '/templates/' . $qcld_wb_chatbot_theme . '/style.css', '', QCLD_WOOCHATBOT_VERSION, 'screen');
			wp_enqueue_style('qcld-wp-chatbot-style');
		}
		wp_register_style('qcld-wp-chatbot-history-style', QCLD_wpCHATBOT_HISTORY_PLUGIN_URL . '/css/history-style.css', '', QCLD_WOOCHATBOT_VERSION, 'screen');
        wp_enqueue_style('qcld-wp-chatbot-history-style');
		wp_register_style('qcld-wp-chatbot-common-style', QCLD_WOOCHATBOT_PLUGIN_URL . '/css/common-style.css', '', QCLD_WOOCHATBOT_VERSION, 'screen');
        wp_enqueue_style('qcld-wp-chatbot-common-style');
		
		
	?>
		<div class="qchero_sliders_list_wrapper">
		<div class="qchero_slider_table_area" style="max-width: 650px;">
			<div id="woo-chatbot-shortcode-template-container" class="wp-chatbot-messages-wrapper">
			<?php echo htmlspecialchars_decode($result->conversation); ?>
			</div>
		</div>
		</div>
	<?php
		endif;
	}else{
		wp_register_style('qcld-wp-chatbot-history-style', QCLD_wpCHATBOT_HISTORY_PLUGIN_URL . '/css/history-style.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
        wp_enqueue_style('qcld-wp-chatbot-history-style');
		
		 wp_register_script('qcld-wp-chatsession-admin-js',QCLD_wpCHATBOT_HISTORY_PLUGIN_URL . '/js/chatsession.js' , array('jquery'), true);
         wp_enqueue_script('qcld-wp-chatsession-admin-js');
		wp_localize_script('qcld-wp-chatsession-admin-js', 'ajax_object',
                array('ajax_url' => admin_url('admin-ajax.php')));
		
		
		$sql = "select * from $tableuser where 1 order by `date` DESC";
		$result1 = $wpdb->get_results($sql);
		$sql1 = "SELECT count(*) FROM $tableuser where 1";
		
		$total             = $wpdb->get_var( $sql1 );
		$items_per_page = 30;
		$page             = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
		$offset         = ( $page * $items_per_page ) - $items_per_page;
		$sql .=" LIMIT ${offset}, ${items_per_page}";
		$rows = $wpdb->get_results( $sql );
		$totalPage         = ceil($total / $items_per_page);
		$result = $wpdb->get_results($sql);

		if($totalPage > 1){
			$customPagHTML     =  '<div><span class="wpbot_pagination">Page '.esc_html($page).' of '.esc_html($totalPage).'</span>'.paginate_links( array(
			'base' => add_query_arg( 'cpage', '%#%' ),
			'format' => '',
			'prev_text'    => __('« prev'),
            'next_text'    => __('next »'),
			'total' => esc_html($totalPage),
			'current' => esc_html($page),
			
			)).'</div>';
		}
		$mainurl = admin_url( 'admin.php?page=woowbot_cs_menu_page');
		$deleteurl = admin_url( 'admin.php?page=woowbot_cs_menu_page&action=deleteall');
	?>
	<div class="qchero_sliders_list_wrapper">
	
		<?php 
			if($msg!=''){
				?>
				<div class="notice notice-success is-dismissible">
					<p><?php echo esc_html($msg); ?></p>
				</div>
				<?php
			}
		?>
	
		<div class="sld_menu_title">
			<h2 style="font-size: 26px;text-align:center"><?php echo esc_html__('Chat Sessions', 'qc-opd').' ('.count($result1).')'; ?></h2>
		</div>
		<?php if($customPagHTML!=''): ?>
		<div class="sld_menu_title sld_menu_title_align"><?php echo ($customPagHTML); ?> </div>
		<?php endif; ?>
		<?php if(!empty($result)): ?>
		
		<form id="wpcs_form_sessions" action="<?php echo esc_url($mainurl); ?>" method="POST" style="width:100%">
		<input type="hidden" name="wowbot_session_remove" />
		<br>
		<button class="button-primary" id="wpbot_submit_delcs_form"><?php echo esc_html('Delete'); ?></button>
		<a href="<?php echo esc_url($deleteurl); ?>" class="button button-primary" ><?php echo esc_html('Delete All Sessions'); ?></a>
		<div class="qchero_slider_table_area">
			<div class="sld_payment_table">
				<div class="sld_payment_row header">
					
					<div class="sld_payment_cell">
						<input type="checkbox" id="wpbot_checked_all" />
					</div>
					
					<div class="sld_payment_cell">
						<?php echo esc_html__( 'Date', 'qc-opd' ) ?>
					</div>
					<div class="sld_payment_cell">
						<?php echo esc_html__( 'User Interaction Count', 'qc-opd' ) ?>
					</div>
					<div class="sld_payment_cell">
						<?php echo esc_html__( 'Session ID', 'qc-opd' ) ?>
					</div>
					
					<div class="sld_payment_cell">
						<?php echo esc_html__( 'Name', 'qc-opd' ); ?>
					</div>
					<div class="sld_payment_cell">
						<?php echo esc_html__( 'Email', 'qc-opd' ); ?>
					</div>
					<div class="sld_payment_cell">
						<?php echo esc_html__( 'Action', 'qc-opd' ); ?>
					</div>
					
				</div>

		<?php
		foreach($result as $row){
			$url = admin_url( 'admin.php?page=woowbot_cs_menu_page&userid='.$row->id);
			$delurl = admin_url( 'admin.php?page=woowbot_cs_menu_page&userid='.$row->id.'&act=delete');
		?>
			<div class="sld_payment_row body">
			
				<div class="sld_payment_cell">
					
					<input type="checkbox" name="sessions[]" class="wpbot_sessions_checkbox" value="<?php echo esc_html($row->id) ?>" />
				</div>
				
				<div class="sld_payment_cell">
					<div class="sld_responsive_head"><?php echo esc_html__('Date', 'qc-opd') ?></div>
					<a href="<?php echo esc_url($url); ?>"><?php echo date('M,d,Y h:i:s A', strtotime($row->date)); ?></a>
				</div>
				<div class="sld_payment_cell">
					<div class="sld_responsive_head"><?php echo esc_html__('User Interaction Count', 'qc-opd') ?></div>
					<?php
						$res = $wpdb->get_row("select * from $tableconversation where 1 and user_id = '".$row->id."'");
						echo substr_count($res->conversation, "woo-chat-user-msg");
					?>
				</div>
				<div class="sld_payment_cell">
					<div class="sld_responsive_head"><?php echo esc_html__('Session ID', 'qc-opd') ?></div>
					<?php echo esc_html($row->session_id); ?>
				</div>
				
				<div class="sld_payment_cell">
					<div class="sld_responsive_head"><?php echo esc_html__('Name', 'qc-opd') ?></div>
					<?php echo esc_html($row->name); ?>
				</div>
				<div class="sld_payment_cell">
					<div class="sld_responsive_head"><?php echo esc_html__('Email', 'qc-opd') ?></div>
					<?php
						echo esc_html($row->email);
					?>
				</div>
				<div class="sld_payment_cell">
					<div class="sld_responsive_head"><?php echo esc_html__('Action', 'qc-opd') ?></div>
					<a href="<?php echo esc_url($url); ?>" class="button-primary"><?php echo esc_html('View Chat'); ?></a>
					<a href="<?php echo esc_url($delurl); ?>" class="button-primary" onclick="return confirm('are you sure?')"><?php echo esc_html('Delete'); ?></a>
					<?php if($row->email!=''): ?>
					<a href="#" data-email="<?php echo esc_html($row->email); ?>" class="button-primary wpcsmyBtn"><?php echo esc_html('Send Email'); ?></a>
					<?php endif; ?>
				</div>
				
			</div>
		<?php
		}
		?>

		</div>

	</div>
	</form>
	<?php endif; ?>
	</div>
	<?php
	}
}

if(!function_exists('qcwp_isset_table_column')) {
	function qcwp_isset_table_column($table_name, $column_name)
	{
		global $wpdb;
		$columns = $wpdb->get_results("SHOW COLUMNS FROM  " . $table_name, ARRAY_A);
		foreach ($columns as $column) {
			if ($column['Field'] == $column_name) {
				return true;
			}
		}
	}
}

register_activation_hook(__FILE__, 'qcld_wb_chatboot_sessions_defualt_options');
function qcld_wb_chatboot_sessions_defualt_options(){
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
	


    //Bot User Table
    $table1    = $wpdb->prefix.'wpbot_user';
	$sql_sliders_Table1 = "
		CREATE TABLE IF NOT EXISTS `$table1` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `session_id` varchar(256) NOT NULL,
          `name` varchar(256) NOT NULL,
          `email` varchar(256) NOT NULL,
		  `date` datetime NOT NULL,
		  `phone` varchar(256) NOT NULL,
		  `interaction` int(11) NOT NULL,
		  PRIMARY KEY (`id`)
		)  $collate AUTO_INCREMENT=1 ";
		
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql_sliders_Table1 );
	
	if ( ! qcwp_isset_table_column( $table1, 'phone' ) ) {
		$sql_wp_Table_update_1 = "ALTER TABLE `$table1` ADD `phone` varchar(256) NOT NULL;";
		$wpdb->query( $sql_wp_Table_update_1 );
	}

    //Bot User Table
    $table2    = $wpdb->prefix.'wpbot_Conversation';
	$sql_sliders_Table2 = "
		CREATE TABLE IF NOT EXISTS `$table2` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `user_id` int(11) NOT NULL,
		  `conversation` LONGTEXT NOT NULL,
		  `interaction` int(11) NOT NULL,
		  PRIMARY KEY (`id`)
		)  $collate AUTO_INCREMENT=1 ";
		
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql_sliders_Table2 );

	if ( ! qcwp_isset_table_column( $table2, 'interaction' ) ) {
		$sql_wp_Table_update_1 = "ALTER TABLE `$table2` ADD `interaction` int(11) NOT NULL;";
		$wpdb->query( $sql_wp_Table_update_1 );
    }
    if ( ! qcwp_isset_table_column( $table1, 'interaction' ) ) {
		$sql_wp_Table_update_1 = "ALTER TABLE `$table1` ADD `interaction` int(11) NOT NULL;";
		$wpdb->query( $sql_wp_Table_update_1 );
    }
	
}


function qcld_chatbot_sessions_license_callback(){
	wp_enqueue_script('qcld-wp-chatsession-admin-lisence-js',QCLD_wpCHATBOT_HISTORY_PLUGIN_URL . '/js/admin.js' , array('jquery'), true);
    
	?>
	<div id="licensing">
				<h1><?php echo esc_html('Please Insert your license Key'); ?></h1>
				<?php if( get_chatsessions_valid_license() ){ ?>
					<div class="qcld-success-notice">
						<p><?php echo esc_html('Thank you, Your License is active'); ?></p>
					</div>
				<?php } ?>
				
				<?php

					$total_active_domain = 0;
                $active_domain_lists = array();
                $track_domain_request = wp_remote_get(chatsessions_LICENSING_PRODUCT_DEV_URL."wp-json/qc-domain-tracker/v1/getdomain/?license_key=".get_chatsessions_licensing_key(), array('timeout' => 300));
                if( !is_wp_error( $track_domain_request ) || wp_remote_retrieve_response_code( $track_domain_request ) === 200 ){
                    $track_domain_result = json_decode($track_domain_request['body']);
                    
                    $current_domain_url =  site_url() ;
                    $current_domain = str_replace(
                                            array( 'https://', 'http://', 'www.' ),
                                            array('', '', ''),
                                            $current_domain_url
                                        );

                    if( !empty($track_domain_result) ){
                        $max_domain_num = $track_domain_result[0]->max_domain + 1;
                        $total_domains = json_decode($track_domain_result[0]->domain, true);
                        $total_domains_num = count($total_domains);

                        foreach ($total_domains as $key => $value) {
                            if( !isset($value['status']) || $value['status'] == 'active' ){
                                $total_active_domain++;
                                $active_domain_lists[] = $value['domain_name'];
                            }
                        }

                        if($total_active_domain == $max_domain_num){
                        //if( $max_domain_num < $total_active_domain ){
                            //$first_domain_name = $total_domains[0]['domain_name'];
                            if( !in_array($current_domain, $active_domain_lists) ){
                                set_chatsessions_invalid_license();
                                delete_chatsessions_valid_license();
                    ?>
                                <div class="qcld-error-notice">
                                    <p>You have activated this key for maximum number of sites allowed by your license. Please <a href='https://www.quantumcloud.com/products/'>purchase additional license.</a></p>
                                </div>
                    <?php
                            }
                        }
                    }
                    
                }
				?>
			</div>
	<?php
}

//plugin activate redirect codecanyon

function qc_chatsessions_activation_redirect( $plugin ) {
    if( $plugin == plugin_basename( __FILE__ ) ) {
        exit( wp_redirect( admin_url('admin.php?page=chatbot-sessions-help-license') ) );
    }
}
add_action( 'activated_plugin', 'qc_chatsessions_activation_redirect' );

function qcpdcs_is_woowbot_active(){
	if(class_exists('QCLD_Woo_Chatbot')){
        return true;
    }else{
        return false;
    }
}

function qcpdcs_is_wpbot_active(){
	
	if(class_exists('qcld_wb_Chatbot')){
        return true;
    }else{
        return false;
    }
	
}

add_action('init', 'qc_wp_cs_request_handle');

function qc_wp_cs_request_handle(){
	global $wpdb;
	$wpdb->show_errors = true;
	
	$tableuser    = $wpdb->prefix.'wowbot_user';
	$tableconversation    = $wpdb->prefix.'wowbot_Conversation';
	
	$tableuser1    = $wpdb->prefix.'wpbot_user';
	$tableconversation1    = $wpdb->prefix.'wpbot_Conversation';

	$table    = $wpdb->prefix.'wpbot_failed_response';
	
	if(isset($_GET['page']) && $_GET['page']=='woowbot_cs_menu_page' && isset($_GET['act']) && $_GET['act']=='delete'){
		$userid = $_GET['userid'];
		$wpdb->delete(
            "$tableuser",
            array( 'id' => $userid ),
            array( '%d' )
        );
		$wpdb->delete(
            "$tableconversation",
            array( 'user_id' => $userid ),
            array( '%d' )
        );
		wp_redirect(admin_url( 'admin.php?page=woowbot_cs_menu_page&msg=success'));exit;
	}

	if(isset($_GET['page']) && $_GET['page']=='wbcs-botsessions-notansweredpage' && isset($_GET['act']) && $_GET['act']=='delete'){
		$userid = $_GET['id'];
		$wpdb->delete(
            "$table",
            array( 'id' => $userid ),
            array( '%d' )
        );
		wp_redirect(admin_url( 'admin.php?page=wbcs-botsessions-notansweredpage&msg=success'));exit;
	}
	
	if(isset($_POST['wowbot_session_remove']) && !empty($_POST['sessions'])){
		
		$userids = $_POST['sessions'];
		foreach($userids as $userid){
			$wpdb->delete(
				"$tableuser",
				array( 'id' => $userid ),
				array( '%d' )
			);
			$wpdb->delete(
				"$tableconversation",
				array( 'user_id' => $userid ),
				array( '%d' )
			);
		}
		wp_redirect(admin_url( 'admin.php?page=woowbot_cs_menu_page&msg=success'));exit;
		
	}
	
	if(isset($_GET['page']) && $_GET['page']=='wbcs-botsessions-page' && isset($_GET['act']) && $_GET['act']=='delete'){
		$userid = $_GET['userid'];
		$wpdb->delete(
            "$tableuser1",
            array( 'id' => $userid ),
            array( '%d' )
        );
		$wpdb->delete(
            "$tableconversation1",
            array( 'user_id' => $userid ),
            array( '%d' )
        );
		wp_redirect(admin_url( 'admin.php?page=wbcs-botsessions-page&msg=success'));exit;
	}
	
	if(isset($_POST['wpbot_session_export_all']) && isset($_POST['wpbot_session_remove'])){
		
		$tableuser    = $wpdb->prefix.'wpbot_user';
		$tableconversation    = $wpdb->prefix.'wpbot_Conversation';
		
		$users = $wpdb->get_results("select wu.`id`, wu.`session_id`, wu.`name`, wu.`email`, wu.`date`, wu.`phone`, wu.`interaction`, wc.`conversation` from $tableuser as wu, $tableconversation as wc where 1 AND wu.id = wc.user_id limit 5000");
		
		$sessions = array();
		if( ! empty( $users ) ){
			foreach( $users as $user ) {
				$data = wpbot_conversations_export( $user );
				$sessions[] = $data;
			}

		}

		qcld_wpbot_chatsession_download_send_headers("wpbot_chatsession_" . date("Y-m-d") . ".csv");
		$result = wpbot_chatsession_array2csv($sessions);
		print $result;
		exit;
	}
	
	if(isset($_POST['wpbot_session_remove']) && !empty($_POST['sessions'])){
		
		if(isset($_POST['wpbot_session_export'])){
			$userids = $_POST['sessions'];
			$tableuser    = $wpdb->prefix.'wpbot_user';
			$tableconversation    = $wpdb->prefix.'wpbot_Conversation';
			$sessions = array();
			foreach($userids as $userid){
				$user = $wpdb->get_row("select wu.`id`, wu.`session_id`, wu.`name`, wu.`email`, wu.`date`, wu.`phone`, wu.`interaction`, wc.`conversation` from $tableuser as wu, $tableconversation as wc where 1 AND wu.id = wc.user_id AND wu.id = '$userid'");
				$data = wpbot_conversations_export($user);
				$sessions[] = $data;
			}
			qcld_wpbot_chatsession_download_send_headers("wpbot_chatsession_" . date("Y-m-d") . ".csv");
			$result = wpbot_chatsession_array2csv($sessions);
			print $result;
			exit;
		}
		
		if(isset($_POST['wpbot_session_delete'])){
			$userids = $_POST['sessions'];
			foreach($userids as $userid){
				$wpdb->delete(
					"$tableuser1",
					array( 'id' => $userid ),
					array( '%d' )
				);
				$wpdb->delete(
					"$tableconversation1",
					array( 'user_id' => $userid ),
					array( '%d' )
				);
			}
			wp_redirect(admin_url( 'admin.php?page=wbcs-botsessions-page&msg=success'));exit;
		}

		
	}
	
}


function qcwpcs_order_menu_submenu(){
	global $submenu;
	
	if(!qcpdcs_is_wpbot_active() && !qcwpcs_is_kbxwpbot_active() ){
		unset($submenu['wbcs-botsessions-page'][0]);
	}
	
	
	
	return $submenu;
}
add_filter( 'custom_menu_order', 'qcwpcs_order_menu_submenu', 1 );

add_action('admin_footer', 'wpcs_admin_footer_content');
function wpcs_admin_footer_content(){
	if((isset($_GET['page']) && $_GET['page']=='wbcs-botsessions-page') || (isset($_GET['page']) && $_GET['page']=='woowbot_cs_menu_page')){
	?>
	<div id="wpcsmyModal" class="wpcsmodal">

	  <!-- Modal content -->
		<div class="wpcsmodal-content">
		<span class="wpcsclose">&times;</span>
		<h2><?php echo esc_html('Send an Email to'); ?> <span id="wpcs_show_email"></span></h2>
		<div class="wpcs_form_container">
		  <form id="wpcs_email_form" action="">
			<label for="fname"><?php echo esc_html('Subject'); ?></label>
			<input type="text" class="wpcs_text_field" id="wpcs_email_subject" name="wpcs_email_subject" placeholder="Subject.." required>
			
			<label for="lname"><?php echo esc_html('Your Message'); ?></label>
			<textarea id="wpcs_email_message" class="wpcs_text_field" name="wpcs_email_message" placeholder="" style="height:200px" required></textarea>
			<input type="hidden" id="wpcs_to_email_address" value="" />
			<input type="submit" class="wpcs_submit_field" id="wpcs_email_submit" value="Submit">
			<span id="wpcs_email_loading" style=" display: none;"><img style="width:20px;" src="<?php echo esc_url(QCLD_wpCHATBOT_HISTORY_PLUGIN_URL.'images/ajax-loader.gif'); ?>"></span>
			<span id="wpcs_email_status"></span>
		  </form>
		</div>
		</div>

	</div>
	<?php
	}
}


function wpcs_send_email() {

		
	$subject = sanitize_text_field($_POST['data']['subject']);
	$message = sanitize_text_field($_POST['data']['message']);
	$to = sanitize_email($_POST['data']['to']);
	
	$url = get_site_url();
    $url = parse_url($url);
    $domain = $url['host'];
	$fromEmail = "wordpress@" . $domain;
	
	$body = $message;

	$headers = array();
	$headers[] = 'Content-Type: text/html; charset=UTF-8';
	$headers[] = 'From: ' . esc_html($domain) . ' <' . esc_html($fromEmail) . '>';

	$result = wp_mail($to, $subject, $body, $headers);
	if ($result) {
		$response['status'] = 'success';
		$response['message'] = 'Email has been sent successfully!';
	}else{
		$response['status'] = 'fail';
		$response['message'] = 'Unable to send email. Please contact your server administrator.';
	}
    
    ob_clean();
    echo json_encode($response);
    die();

}

add_action( 'wp_ajax_wpcs_send_email',        'wpcs_send_email' );
add_action( 'wp_ajax_nopriv_wpcs_send_email', 'wpcs_send_email' );



function qcwpcs_is_kbxwpbot_active(){

	if ( defined( 'KBX_WP_CHATBOT' ) && (KBX_WP_CHATBOT == '1') ) {
		return true;
	}else{
		return false;
	}
}

if(!function_exists('qcld_wb_chatbot_conversation_save')){
	function qcld_wb_chatbot_conversation_save() {
		
		check_ajax_referer( 'qcsecretbotnonceval123qc', 'security' );
		global $wpdb;

		$tableuser    = $wpdb->prefix.'wpbot_user';
		$tableconversation    = $wpdb->prefix.'wpbot_Conversation';
		
		$conversation = qc_wpbot_input_validation($_POST['conversation']);
		$email = sanitize_email($_POST['email']);
		$phone = sanitize_text_field($_POST['phone']);
		$name = sanitize_text_field($_POST['name']);
		$session_id = sanitize_text_field($_POST['session_id']);
		$wpuser_id = sanitize_text_field($_POST['user_id']);
		
		
		$response = array();
		$response['status'] = 'success';
		
		$user_exists = $wpdb->get_row("select * from $tableuser where 1 and session_id = '".$session_id."'");
		if(empty($user_exists)){
		
			$interaction = (int)substr_count($conversation, "wp-chat-user-msg");
			if( $interaction == 0 ){
				$interaction = (int)substr_count($conversation, "woo-chat-user-msg");
			}

			$wpdb->insert(
				$tableuser,
				array(
					'date'  => current_time( 'mysql' ),
					'name'   => $name,
					'email'   => $email,
					'phone'   => $phone,
					'session_id'   => $session_id,
					'interaction'	=> $interaction,
					'user_id'		=> $wpuser_id
				)
			);

			
			$user_id = $wpdb->insert_id;
			$wpdb->insert(
				$tableconversation,
				array(
					'user_id'   => $user_id,
					'conversation'   => $conversation,
					'interaction'   => $interaction
				)
			);

		}else{

			$interaction = (int)substr_count($conversation, "wp-chat-user-msg");
			if( $interaction == 0 ){
				$interaction = (int)substr_count($conversation, "woo-chat-user-msg");
			}

			$user_id = $user_exists->id;
			$wpdb->update(
				$tableuser,
				array(
					'date'  => current_time( 'mysql' ),
					'name'=>$name,
					'email' => $email,
					'phone' => $phone,
					'interaction'	=> $interaction,
					'user_id'		=> $wpuser_id
				),
				array('id'=>$user_id),
				array(
					'%s',
					'%s',
					'%s',
					'%s',
					'%d',
					'%d',
				),
				array('%d')
			);
			$wpdb->update(
				$tableconversation,
				array(
					'conversation' => $conversation,
					'interaction' => $interaction,
				),
				array('user_id'=>$user_id),
				array(
					'%s',
					'%d',
				),
				array('%d')
			);
			
		}


		echo json_encode($response);

		die();
	}
}
add_action( 'wp_ajax_qcld_wb_chatbot_conversation_save', 'qcld_wb_chatbot_conversation_save' );
add_action( 'wp_ajax_nopriv_qcld_wb_chatbot_conversation_save', 'qcld_wb_chatbot_conversation_save' );
function qcld_chatbot_session_date_filter(){
	global $wpdb;
	$tableuser    = $wpdb->prefix.'wpbot_user';
	$start_date = sanitize_text_field($_POST['start_date']);
	$end_date = sanitize_text_field($_POST['end_date']);
	$sql = "SELECT * FROM $tableuser WHERE date between '". $start_date ."' AND '". $end_date ."'";
	$result = $wpdb->get_results($sql);
	echo json_encode($result);
	wp_die();

}

add_action('wp_ajax_wpbot_send_email_transcript', 'wpbot_send_email_transcript');
add_action('wp_ajax_nopriv_wpbot_send_email_transcript', 'wpbot_send_email_transcript');

function wpbot_send_email_transcript() {

	global $wpdb;

    $session = trim(sanitize_text_field($_POST['session']));
    $email = sanitize_email($_POST['email']);
	$subject = 'Chat transcript by WPBot';
	//Extract Domain
	$url = get_site_url();
	$url = parse_url($url);
	$domain = $url['host'];

	$admin_email = get_option('admin_email');
	$toEmail = get_option('qlcd_wp_chatbot_admin_email') != '' ? get_option('qlcd_wp_chatbot_admin_email') : $admin_email;
	$fromEmail = "wordpress@" . $domain;

	//Starting messaging and status.
	$response['status'] = 'fail';

	$texts = maybe_unserialize(get_option('qlcd_wp_chatbot_email_fail'));
	if( is_array( $texts ) && isset( $texts[get_wpbot_locale()] )){
		$texts = $texts[get_wpbot_locale()];
	}
	$response['message'] = esc_html(str_replace('\\', '',$texts));


	if(get_option('qlcd_wp_chatbot_from_email') && get_option('qlcd_wp_chatbot_from_email')!=''){
		$fromEmail = get_option('qlcd_wp_chatbot_from_email');
	}

	$replyto = $fromEmail;

	if(get_option('qlcd_wp_chatbot_reply_to_email') && get_option('qlcd_wp_chatbot_reply_to_email')!=''){
		$replyto = get_option('qlcd_wp_chatbot_reply_to_email');
	}

	
	$tableuser    = $wpdb->prefix.'wpbot_user';
	$tableconversation    = $wpdb->prefix.'wpbot_Conversation';

	$user = $wpdb->get_row("select * from $tableuser where 1 and session_id = '".$session."'");
	
	if ( ! empty( $user ) ) {

		$userinfo = $wpdb->get_row("select * from $tableuser where 1 and id = '".$user->id."'");
		$result = $wpdb->get_row("select * from $tableconversation where 1 and user_id = '".$user->id."'");

		//build email body
        $bodyContent = "";
        $bodyContent .= '<p><strong>' . esc_html__('User Details', 'wpchatbot') . ':</strong></p><hr>';
        $bodyContent .= '<p>' . esc_html__('Name', 'wpchatbot') . ' : ' . esc_html( $userinfo->name ) . '</p>';
        $bodyContent .= '<p>' . esc_html__('Email', 'wpchatbot') . ' : ' . esc_html( $email ) . '</p>';
        $bodyContent .= '<p>' . esc_html__('Subject', 'wpchatbot') . ' : ' . esc_html( $subject ) . '</p>';
       
		$bodyContent .= '<p><b>Conversations</b></p>';
		$bodyContent .= '<p>-----------------------</p>';

		$messages = qcld_wpch_conversation_extract(htmlspecialchars_decode($result->conversation));
		foreach($messages as $message){
			if(isset($message['bot']) && trim($message['bot'])!=''){
				$bodyContent .= '<p>' . esc_html__('Chatbot', 'wpchatbot') . ' : ' . esc_html( trim($message['bot']) ) . '</p>';
			}
			if(isset($message['user']) && trim($message['user'])!=''){
				$bodyContent .= '<p>' . esc_html( $userinfo->name ) . ' : ' . esc_html( trim($message['user']) ) . '</p>';
			}
		}

		$bodyContent .= '<p>-----------------------</p>';

        $bodyContent .= '<p>' . esc_html__('Mail Generated on', 'wpchatbot') . ': ' . current_time('F j, Y, g:i a') . '</p>';
        $to = $email;
        $body = $bodyContent;
        $headers = array();
        $headers[] = 'Content-Type: text/html; charset=UTF-8';
        $headers[] = 'From: ' . esc_html($userinfo->name) . ' <' . esc_html($fromEmail) . '>';
        $headers[] = 'Reply-To: ' . esc_html($userinfo->name) . ' <' . esc_html($email) . '>';
        $result = wp_mail($to, $subject, $body, $headers);
        
        if ($result) {
            $response['status'] = 'success';
			$texts = maybe_unserialize(get_option('qlcd_wp_chatbot_email_sent'));
			if( is_array( $texts ) && isset( $texts[get_wpbot_locale()] )){
				$texts = $texts[get_wpbot_locale()];
			}
			$response['message'] = esc_html(str_replace('\\', '',$texts));
        }


	}
	echo json_encode($response);
	die();

}

add_action( 'wp_ajax_qcld_chatbot_session_date_filter', 'qcld_chatbot_session_date_filter' );
add_action( 'wp_ajax_nopriv_qcld_chatbot_session_date_filter', 'qcld_chatbot_session_date_filter' );
	function qcld_wpch_conversation_extract($html){

		$doc = new DOMDocument();
		libxml_use_internal_errors(true);
		$doc->loadHTML('<?xml encoding="utf-8" ?>' . $html);
		$lis = $doc->getElementsByTagName('li');
		$class = 'wp-chatbot-msg';
		$messages = array();
		foreach ($lis as $li) {
			foreach($li->attributes as $attribute){
				if ( isset($attribute->name) && trim($attribute->name) =='class' && isset($attribute->textContent) ) {
					$class = $attribute->textContent;
				}
			}
			
			$textContent = '';
			foreach($li->childNodes as $chilenode){
				foreach($chilenode->attributes as $attribute){
					if ( isset($attribute->name) && trim($attribute->name) =='class' && isset($attribute->textContent) && $attribute->textContent == 'wp-chatbot-paragraph' ) {
						$textContent .="&nbsp;" . $chilenode->textContent;
					}
				}
			}
			
			if (strpos($class, 'wp-chatbot-msg') !== false) {
				$messages[]['bot'] = trim($textContent);
			}
			if (strpos($class, 'wp-chat-user-msg') !== false) {
				$messages[]['user'] = trim($textContent);
			}
			
			
		}

		$messages = array_filter( $messages, function( $val ) {
			if ( isset($val['bot']) && empty($val['bot']) ) {
				return false;
			}
			return true;
		} );

		return $messages;

	}
	
	//wpbot_conversations.csv
	add_action( 'admin_post_wpbot_conversations.csv', 'wpbot_conversations_csv_export' );

	function wpbot_conversations_csv_export($user_id = ''){
		
		global $wpdb;
		$tableuser    = $wpdb->prefix.'wpbot_user';
		$tableconversation    = $wpdb->prefix.'wpbot_Conversation';
		$userid = ($user_id != '' ? $user_id : sanitize_text_field($_GET['user_id']));
		
		$userinfo = $wpdb->get_row("select * from $tableuser where 1 and id = '".$userid."'");
		
		$result = $wpdb->get_row("select * from $tableconversation where 1 and user_id = '".$userid."'");
	
		$data = array();
	
		if(!empty($result)){
			
			$data[] = array('User Name', $userinfo->name);
			$data[] = array('User Email', $userinfo->email);
			$data[] = array('Session ID', $userinfo->session_id);
			$data[] = array('Date', date('M,d,Y h:i:s A', strtotime($userinfo->date)));
			$data[] = array('Bot Message', 'User Message');
			$messages = qcld_wpch_conversation_extract(htmlspecialchars_decode($result->conversation));

			foreach($messages as $message){
				if(isset($message['bot']) && trim($message['bot'])!=''){
					
					$data[] = array(str_replace("&nbsp;", " ",trim($message['bot'])), '');
				}
				if(isset($message['user']) && trim($message['user'])!=''){
					$data[] = array('', str_replace("&nbsp;", " ",trim($message['user'])));
				}
			}
			
		}
		
		
		qcld_wpbot_chatsession_download_send_headers($userinfo->name."_wpbot_chatsession_" . date("Y-m-d") . ".csv");

		$result = wpbot_chatsession_array2csv($data);

		print $result;
		
	}
	
	function wpbot_conversations_export( $user ){
		global $wpdb;

		
		if( isset($user->id) ){
			$user_id = $user->id;
		}else{
			$user_id = $user;
		}

		$userid = ($user_id != '' ? $user_id : sanitize_text_field($_GET['user_id']));

		$userinfo = $user;
	
		$dataArray = array();
	
		if(!empty($userinfo)){
			
			
			$messages = qcld_wpch_conversation_extract(htmlspecialchars_decode($userinfo->conversation));

			$dataArray = array(
				'Session ID' 	=> $userinfo->session_id,
				'Date'			=> date('M,d,Y h:i:s A', strtotime($userinfo->date)),
				'User Name'		=> $userinfo->name,
				'User Email'	=> $userinfo->email
			);
			$conversations = '';
			foreach($messages as $message){
				if(isset($message['bot']) && trim($message['bot'])!=''){
					
					$conversations .= 'Bot Message: ' . str_replace("&nbsp;", " ",trim($message['bot'])) . "\n";
				}
				if(isset($message['user']) && trim($message['user'])!=''){
					$conversations .= 'User Message: ' . str_replace("&nbsp;", " ",trim($message['user'])) . "\n";
				}
			}
			$dataArray['Conversations'] = $conversations;


			
		}
		$dataArray['Interaction'] = $userinfo->interaction;
		
		return $dataArray;
	}
	
	function qcld_wpbot_chatsession_download_send_headers($filename){
		// disable caching
		$now = gmdate("D, d M Y H:i:s");
		header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
		header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
		header("Last-Modified: {$now} GMT");

		// force download 
		header('Content-Encoding: UTF-8');
		header("Content-type: text/csv; charset=UTF-8");		
		//header("Content-Type: application/force-download; charset=utf-8");
		/*header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");*/

		// disposition / encoding on response body
		header("Content-Disposition: attachment;filename={$filename}");
		header("Content-Transfer-Encoding: binary");
	}
	
	function wpbot_chatsession_array2csv(array &$array)
	{

		
	   if (count($array) == 0) {
		 return null;
	   }

	   ob_start();

	   $df = fopen("php://output", 'w');
		// Insert the UTF-8 BOM in the file
		fputs($df, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
		foreach($array as $data){
			$header = array_keys( $data );
			fputcsv($df, $header);
			break;
		}
		
	   foreach ($array as $row) {
		  fputcsv($df, $row);
	   }

	   fclose($df);

	   return ob_get_clean();
	}

	add_action('upgrader_process_complete', 'qcld_wpbot_session_maybe_upgrade');
	function qcld_wpbot_session_maybe_upgrade(){
		if( ! get_option( 'qcld_bot_session_version' ) || ( version_compare( get_option( 'qcld_bot_session_version' ), QCLD_WPBOT_HISTORY_VERSION, '<' ) ) ){
            
            if( file_exists( QCLD_WPCHATBOT_HISTORY_DIR_PATH . "upgrades/update-".QCLD_WPBOT_HISTORY_VERSION.".php" ) ){
				update_option( 'qcld_bot_session_version', QCLD_WPBOT_HISTORY_VERSION );
                include_once( QCLD_WPCHATBOT_HISTORY_DIR_PATH . "upgrades/update-".QCLD_WPBOT_HISTORY_VERSION.".php" );
                
            }
        }

	}

}
