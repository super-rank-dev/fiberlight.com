<?php
		
		wp_register_style('qlcd-wp-chatbot-admin-style-email', QCLD_wpCHATBOT_PLUGIN_URL.'/css/email_subscription.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
		wp_enqueue_style('qlcd-wp-chatbot-admin-style-email');

		wp_register_script('qcld-wp-chatbot-email-subscription-js', QCLD_wpCHATBOT_PLUGIN_URL.'/js/email_subscription.js', array('jquery'), true);
            wp_enqueue_script('qcld-wp-chatbot-email-subscription-js');

		global $wpdb;
		if(!function_exists('wp_get_current_user')) {
			include(ABSPATH . "wp-includes/pluggable.php"); 
		}
		
		$table             = $wpdb->prefix.'wpbot_subscription';
		$current_user = wp_get_current_user();
		$url = admin_url('edit.php?post_type=sld&page=qcsld_click_list');
		$customPagHTML = '';
		// Main Report Area
		
		$sql = "SELECT * FROM $table where 1 order by id desc";
		$sql1 = "SELECT count(*) FROM $table where 1";

		$total             = $wpdb->get_var( $sql1 );
		$items_per_page = 50;
		
		$page             = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
		$offset         = ( $page * $items_per_page ) - $items_per_page;
		
		$sql .=" LIMIT ${offset}, ${items_per_page}";
		
		$rows = $wpdb->get_results( $sql );
		$totalPage         = ceil($total / $items_per_page);
		
		if($totalPage > 1){
			$customPagHTML     =  '<div><span class="wpbot_pagination">Page '.esc_html($page).' of '.esc_html($totalPage).'</span>'.paginate_links( array(
			'base' => add_query_arg( 'cpage', '%#%' ),
			'format' => '',
			'prev_text' => esc_html__('&laquo;'),
			'next_text' => esc_html__('&raquo;'),
			'total' => esc_html($totalPage),
			'current' => esc_html($page)
			)).'</div>';
		}
		$mainurl = admin_url( 'admin.php?page=email-subscription');
		
	?>	
		<div class="qchero_sliders_list_wrapper">
			<div class="sld_menu_title">
				<h2><?php echo esc_html__('User Data', 'qc-opd') ?></h2>

			</div>
			
			<div class="sld_menu_title sld_menu_title_align"><?php echo ($customPagHTML); ?><span style="float: right;"><a class="button-primary" href="<?php echo admin_url( 'admin-post.php?action=wpbprint.csv' ); ?>">Export All Contacts</a> Total <?php echo esc_html($total); ?></span> </div>
			
			<?php 
			if(isset($_GET['msg']) && $_GET['msg']=='success'){
				echo '<div class="notice notice-success"><p>Record has beed Deleted Successfully!</p></div>';
			}
			?>
			
			<form id="wpcs_form_sessions" action="<?php echo $mainurl; ?>" method="POST" style="width:100%">
			<input type="hidden" name="wpbot_email_subscription_remove" />
			<br>
			<button class="button-primary" id="wpbot_submit_email_form">Delete</button>

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
							<?php echo esc_html__( 'Name', 'qc-opd' ) ?>
						</div>
						<div class="sld_payment_cell">
							<?php echo esc_html__( 'Email', 'qc-opd' ); ?>
						</div>
						<div class="sld_payment_cell">
							<?php echo esc_html__( 'Phone', 'qc-opd' ); ?>
						</div>
						
					</div>

			<?php
			foreach($rows as $row){
			?>
				<div class="sld_payment_row">

					<div class="sld_payment_cell">
						
						<input type="checkbox" name="emails[]" class="wpbot_email_checkbox" value="<?php echo $row->id ?>" />
					</div>
					
					<div class="sld_payment_cell">
						<div class="sld_responsive_head"><?php echo esc_html__('Date', 'qc-opd') ?></div>
						<?php echo esc_html(date('m/d/Y', strtotime($row->date))); ?>
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
							echo ($row->phone);
							
						?>
					</div>
					
				</div>
			<?php
			}
			?>

			</div>
			</form>
		</div>
		</div>