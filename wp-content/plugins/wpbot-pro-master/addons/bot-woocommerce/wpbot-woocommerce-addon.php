<?php

defined('ABSPATH') or die("No direct script access!");

if( !defined('WBWC_PATH') )
	define( 'WBWC_PATH', plugin_dir_path(__FILE__) );
if( !defined('WBWC_URL') )
	define( 'WBWC_URL', plugin_dir_url(__FILE__ ) );

if(file_exists(WBWC_PATH. "/conversion-tracker/class-qc-conversion-tracker.php")){
    require_once (WBWC_PATH. "/conversion-tracker/class-qc-conversion-tracker.php");
}

add_action('init', 'qcpd_wpwc_checking_dependencies');
function qcpd_wpwc_checking_dependencies(){
	include_once(ABSPATH.'wp-admin/includes/plugin.php');
	
	if ( !class_exists( 'WooCommerce' ) ) {
	//	add_action('admin_notices', 'qcpd_wpwc_require_notice');
	}
	if ( !class_exists('qcld_wb_Chatbot') ) {
	//	add_action('admin_notices', 'qcpd_wpwc_require_notice2');
	}
}

function qcpd_wpwc_require_notice()
{
?>
	<div id="message" class="error">
		<p>
			<?php echo esc_html__('Please install & activate the WooCommerce plugin to get the Woocommerce Addon to work.', 'wpwc'); ?>
		</p>
	</div>
<?php
}

function qcpd_wpwc_require_notice2()
{
?>
	<div id="message" class="error">
		<p>
			<?php echo esc_html__('Please install & activate the  WPBot pro plugin to get the Woocommerce Addon to work.', 'wpwc'); ?>
		</p>
	</div>
<?php
}

add_action( 'admin_menu', 'wpwc_admin_menu');

function wpwc_admin_menu(){
	if ( current_user_can( 'publish_posts' ) && class_exists('qcld_wb_Chatbot') ){
		add_menu_page( 'Bot - Woo Settings', 'Bot - Woo Settings', 'manage_options', 'wpwc-settings-page', 'wpwc_settings_page', '
dashicons-networking', '9' );

		//add_submenu_page( 'wpwc-settings-page', 'Help & License', 'Help & License', 'manage_options','wpwc-settings-page-help-license', 'wpbotwoo_display_license_section' );
	}
}


function qc_wpwbotwoo_activation_redirect( $plugin ) {
	
	
	if(!get_option('qlcd_wp_chatbot_order_email')) {
        update_option('qlcd_wp_chatbot_order_email',serialize(array('What is your order email address?')));
    }
	if(!get_option('qlcd_wp_chatbot_order_id')) {
        update_option('qlcd_wp_chatbot_order_id',serialize(array('What is your order ID?')));
    }

}
add_action( 'activated_plugin', 'qc_wpwbotwoo_activation_redirect' );

if (!function_exists('qcld_wpwc_chatboot_plugin_init')) {
    function qcld_wpwc_chatboot_plugin_init()
    {
		if ((!empty($_GET["page"])) && ($_GET["page"] == "wpwc-settings-page")) {
            add_action('admin_init', 'qcld_wpwc_chatbot_save_options');
        }
    }
}
add_action('plugins_loaded', 'qcld_wpwc_chatboot_plugin_init');

function qcld_wpwc_chatbot_save_options(){
	if (isset($_POST['submit'])) {
		
		if(isset( $_POST["enable_wp_chatbot_disable_producticon"])) {
			$enable_wp_chatbot_disable_producticon = qcld_sanitize_field($_POST["enable_wp_chatbot_disable_producticon"]);
		}else{ $enable_wp_chatbot_disable_producticon='';}
		update_option('enable_wp_chatbot_disable_producticon', stripslashes($enable_wp_chatbot_disable_producticon));
		
		if(isset( $_POST["enable_wp_chatbot_disable_carticon"])) {
			$enable_wp_chatbot_disable_carticon = qcld_sanitize_field($_POST["enable_wp_chatbot_disable_carticon"]);
		}else{ $enable_wp_chatbot_disable_carticon='';}
		update_option('enable_wp_chatbot_disable_carticon', stripslashes($enable_wp_chatbot_disable_carticon));
		
		if(isset( $_POST["disable_wp_chatbot_product_search"])) {
		$disable_wp_chatbot_product_search = qcld_sanitize_field($_POST["disable_wp_chatbot_product_search"]);
		}else{ $disable_wp_chatbot_product_search='';}
		update_option('disable_wp_chatbot_product_search', stripslashes($disable_wp_chatbot_product_search));
		if(isset( $_POST["disable_wp_chatbot_catalog"])) {
		$disable_wp_chatbot_catalog= qcld_sanitize_field($_POST["disable_wp_chatbot_catalog"]);
		}else{ $disable_wp_chatbot_catalog='';}
		update_option('disable_wp_chatbot_catalog', stripslashes($disable_wp_chatbot_catalog));
		if(isset( $_POST["disable_wp_chatbot_order_status"])) {
			$disable_wp_chatbot_order_status = qcld_sanitize_field($_POST["disable_wp_chatbot_order_status"]);
		}else{ $disable_wp_chatbot_order_status='';}
		update_option('disable_wp_chatbot_order_status', stripslashes($disable_wp_chatbot_order_status));
		if(isset( $_POST["disable_wp_chatbot_featured_product"])) {
			$disable_wp_chatbot_featured_product = qcld_sanitize_field($_POST["disable_wp_chatbot_featured_product"]);
		}else{ $disable_wp_chatbot_featured_product='';}
		update_option('disable_wp_chatbot_featured_product', stripslashes($disable_wp_chatbot_featured_product));
		//Enable /disable sale products button
		if(isset( $_POST["disable_wp_chatbot_sale_product"])) {
			$disable_wp_chatbot_sale_product = qcld_sanitize_field($_POST["disable_wp_chatbot_sale_product"]);
		}else{ $disable_wp_chatbot_sale_product='';}
		update_option('disable_wp_chatbot_sale_product', stripslashes($disable_wp_chatbot_sale_product));
		
		$qlcd_wp_chatbot_viewed_products= @$_POST["qlcd_wp_chatbot_viewed_products"];
		update_option('qlcd_wp_chatbot_viewed_products', serialize($qlcd_wp_chatbot_viewed_products));
		$qlcd_wp_chatbot_shopping_cart= @$_POST["qlcd_wp_chatbot_shopping_cart"];
		update_option('qlcd_wp_chatbot_shopping_cart', serialize($qlcd_wp_chatbot_shopping_cart));
		$qlcd_wp_chatbot_add_to_cart= @$_POST["qlcd_wp_chatbot_add_to_cart"];
		update_option('qlcd_wp_chatbot_add_to_cart', serialize($qlcd_wp_chatbot_add_to_cart));

		$qlcd_wp_chatbot_cart_link= @$_POST["qlcd_wp_chatbot_cart_link"];
		update_option('qlcd_wp_chatbot_cart_link', serialize($qlcd_wp_chatbot_cart_link));

		$qlcd_wp_chatbot_cart_url= @$_POST["qlcd_wp_chatbot_cart_url"];
		update_option('qlcd_wp_chatbot_cart_url', serialize($qlcd_wp_chatbot_cart_url));

		$qlcd_wp_chatbot_checkout_url= @$_POST["qlcd_wp_chatbot_checkout_url"];
		update_option('qlcd_wp_chatbot_checkout_url', serialize($qlcd_wp_chatbot_checkout_url));

		$qlcd_wp_chatbot_checkout_link= @$_POST["qlcd_wp_chatbot_checkout_link"];
		update_option('qlcd_wp_chatbot_checkout_link', serialize($qlcd_wp_chatbot_checkout_link));

		// $qlcd_wp_chatbot_checkout_link= @$_POST["qlcd_wp_chatbot_checkout_url"];
		// update_option('qlcd_wp_chatbot_checkout_link', serialize($qlcd_wp_chatbot_checkout_url));

		$qlcd_wp_chatbot_cart_welcome= @$_POST["qlcd_wp_chatbot_cart_welcome"];
		update_option('qlcd_wp_chatbot_cart_welcome', serialize($qlcd_wp_chatbot_cart_welcome));
		$qlcd_wp_chatbot_featured_product_welcome= @$_POST["qlcd_wp_chatbot_featured_product_welcome"];
		update_option('qlcd_wp_chatbot_featured_product_welcome', serialize($qlcd_wp_chatbot_featured_product_welcome));
		$qlcd_wp_chatbot_viewed_product_welcome= @$_POST["qlcd_wp_chatbot_viewed_product_welcome"];
		update_option('qlcd_wp_chatbot_viewed_product_welcome', serialize($qlcd_wp_chatbot_viewed_product_welcome));
		$qlcd_wp_chatbot_latest_product_welcome= @$_POST["qlcd_wp_chatbot_latest_product_welcome"];
		update_option('qlcd_wp_chatbot_latest_product_welcome', serialize($qlcd_wp_chatbot_latest_product_welcome));
		$qlcd_wp_chatbot_cart_title= @$_POST["qlcd_wp_chatbot_cart_title"];
		update_option('qlcd_wp_chatbot_cart_title', serialize($qlcd_wp_chatbot_cart_title));
		$qlcd_wp_chatbot_cart_quantity= @$_POST["qlcd_wp_chatbot_cart_quantity"];
		update_option('qlcd_wp_chatbot_cart_quantity', serialize($qlcd_wp_chatbot_cart_quantity));
		$qlcd_wp_chatbot_cart_price= @$_POST["qlcd_wp_chatbot_cart_price"];
		update_option('qlcd_wp_chatbot_cart_price', serialize($qlcd_wp_chatbot_cart_price));
		$qlcd_wp_chatbot_no_cart_items= @$_POST["qlcd_wp_chatbot_no_cart_items"];
		update_option('qlcd_wp_chatbot_no_cart_items', serialize($qlcd_wp_chatbot_no_cart_items));
		$qlcd_wp_chatbot_cart_updating= @$_POST["qlcd_wp_chatbot_cart_updating"];
		update_option('qlcd_wp_chatbot_cart_updating', serialize($qlcd_wp_chatbot_cart_updating));
		$qlcd_wp_chatbot_cart_removing= @$_POST["qlcd_wp_chatbot_cart_removing"];
		update_option('qlcd_wp_chatbot_cart_removing', serialize($qlcd_wp_chatbot_cart_removing));
		$qlcd_wp_chatbot_continue_shopping= @$_POST["qlcd_wp_chatbot_continue_shopping"];
		update_option('qlcd_wp_chatbot_continue_shopping', serialize($qlcd_wp_chatbot_continue_shopping));
		$qlcd_wp_chatbot_cart_total= @$_POST["qlcd_wp_chatbot_cart_total"];
		update_option('qlcd_wp_chatbot_cart_total', serialize($qlcd_wp_chatbot_cart_total));
		
		$qlcd_wp_chatbot_wildcard_product = @$_POST["qlcd_wp_chatbot_wildcard_product"];
		update_option('qlcd_wp_chatbot_wildcard_product', serialize($qlcd_wp_chatbot_wildcard_product));
		$qlcd_wp_chatbot_wildcard_catalog = @$_POST["qlcd_wp_chatbot_wildcard_catalog"];
		update_option('qlcd_wp_chatbot_wildcard_catalog', serialize($qlcd_wp_chatbot_wildcard_catalog));
		$qlcd_wp_chatbot_featured_products = @$_POST["qlcd_wp_chatbot_featured_products"];
		update_option('qlcd_wp_chatbot_featured_products', serialize($qlcd_wp_chatbot_featured_products));
		$qlcd_wp_chatbot_sale_products = @$_POST["qlcd_wp_chatbot_sale_products"];
		update_option('qlcd_wp_chatbot_sale_products', serialize($qlcd_wp_chatbot_sale_products));
		
		$qlcd_wp_chatbot_product_asking = @$_POST["qlcd_wp_chatbot_product_asking"];
		update_option('qlcd_wp_chatbot_product_asking', serialize($qlcd_wp_chatbot_product_asking));
		if (isset($_POST["qlcd_wp_chatbot_product_success"])) {
			$qlcd_wp_chatbot_product_success = $_POST["qlcd_wp_chatbot_product_success"];
			update_option('qlcd_wp_chatbot_product_success', serialize($qlcd_wp_chatbot_product_success));
		}
		if (isset($_POST["qlcd_wp_chatbot_product_fail"])) {
			$qlcd_wp_chatbot_product_fail = $_POST["qlcd_wp_chatbot_product_fail"];
			update_option('qlcd_wp_chatbot_product_fail', serialize($qlcd_wp_chatbot_product_fail));
		}
		$qlcd_wp_chatbot_product_suggest = @$_POST["qlcd_wp_chatbot_product_suggest"];
		update_option('qlcd_wp_chatbot_product_suggest', serialize($qlcd_wp_chatbot_product_suggest));
		$qlcd_wp_chatbot_product_infinite = @$_POST["qlcd_wp_chatbot_product_infinite"];
		update_option('qlcd_wp_chatbot_product_infinite', serialize($qlcd_wp_chatbot_product_infinite));
		$qlcd_wp_chatbot_load_more = @$_POST["qlcd_wp_chatbot_load_more"];
		update_option('qlcd_wp_chatbot_load_more', serialize($qlcd_wp_chatbot_load_more));
		//Order
		$qlcd_wp_chatbot_wildcard_order = @$_POST["qlcd_wp_chatbot_wildcard_order"];
		update_option('qlcd_wp_chatbot_wildcard_order', serialize($qlcd_wp_chatbot_wildcard_order));
		$qlcd_wp_chatbot_order_welcome = @$_POST["qlcd_wp_chatbot_order_welcome"];
		update_option('qlcd_wp_chatbot_order_welcome', serialize($qlcd_wp_chatbot_order_welcome));
		$qlcd_wp_chatbot_order_username_asking = @$_POST["qlcd_wp_chatbot_order_username_asking"];
		update_option('qlcd_wp_chatbot_order_username_asking', serialize($qlcd_wp_chatbot_order_username_asking));
		$qlcd_wp_chatbot_order_username_not_exist = @$_POST["qlcd_wp_chatbot_order_username_not_exist"];
		update_option('qlcd_wp_chatbot_order_username_not_exist', serialize($qlcd_wp_chatbot_order_username_not_exist));
		$qlcd_wp_chatbot_order_username_thanks = @$_POST["qlcd_wp_chatbot_order_username_thanks"];
		update_option('qlcd_wp_chatbot_order_username_thanks', serialize($qlcd_wp_chatbot_order_username_thanks));
		$qlcd_wp_chatbot_order_username_password = @$_POST["qlcd_wp_chatbot_order_username_password"];
		update_option('qlcd_wp_chatbot_order_username_password', serialize($qlcd_wp_chatbot_order_username_password));
		$qlcd_wp_chatbot_order_password_incorrect= @$_POST["qlcd_wp_chatbot_order_password_incorrect"];
		update_option('qlcd_wp_chatbot_order_password_incorrect', serialize($qlcd_wp_chatbot_order_password_incorrect));
		$qlcd_wp_chatbot_order_not_found= @$_POST["qlcd_wp_chatbot_order_not_found"];
		update_option('qlcd_wp_chatbot_order_not_found', serialize($qlcd_wp_chatbot_order_not_found));
		$qlcd_wp_chatbot_order_found= @$_POST["qlcd_wp_chatbot_order_found"];
		update_option('qlcd_wp_chatbot_order_found', serialize($qlcd_wp_chatbot_order_found));
		$qlcd_wp_chatbot_order_email_support= @$_POST["qlcd_wp_chatbot_order_email_support"];
		update_option('qlcd_wp_chatbot_order_email_support', serialize($qlcd_wp_chatbot_order_email_support));
		
		$qlcd_wp_chatbot_order_email= @$_POST["qlcd_wp_chatbot_order_email"];
		update_option('qlcd_wp_chatbot_order_email', serialize($qlcd_wp_chatbot_order_email));
		$qlcd_wp_chatbot_order_id= @$_POST["qlcd_wp_chatbot_order_id"];
		update_option('qlcd_wp_chatbot_order_id', serialize($qlcd_wp_chatbot_order_id));
		//system
		$qlcd_wp_chatbot_sys_key_product = @$_POST["qlcd_wp_chatbot_sys_key_product"];
		update_option('qlcd_wp_chatbot_sys_key_product', qcld_sanitize_field($qlcd_wp_chatbot_sys_key_product));
		$qlcd_wp_chatbot_sys_key_catalog = @$_POST["qlcd_wp_chatbot_sys_key_catalog"];
		update_option('qlcd_wp_chatbot_sys_key_catalog', qcld_sanitize_field($qlcd_wp_chatbot_sys_key_catalog));
		$qlcd_wp_chatbot_sys_key_order = @$_POST["qlcd_wp_chatbot_sys_key_order"];
		update_option('qlcd_wp_chatbot_sys_key_order', qcld_sanitize_field($qlcd_wp_chatbot_sys_key_order));
		
		$qlcd_wp_chatbot_ppp = @$_POST["qlcd_wp_chatbot_ppp"];
		update_option('qlcd_wp_chatbot_ppp', qcld_sanitize_field($qlcd_wp_chatbot_ppp));

		$qlcd_woo_chatbot_product_orderby = @$_POST["qlcd_woo_chatbot_product_orderby"];
		update_option('qlcd_woo_chatbot_product_orderby', sanitize_text_field($qlcd_woo_chatbot_product_orderby));
		
		$qlcd_woo_chatbot_product_order = @$_POST["qlcd_woo_chatbot_product_order"];
		update_option('qlcd_woo_chatbot_product_order', sanitize_text_field($qlcd_woo_chatbot_product_order));

		$qlcd_chatbot_exclude_category_list = @$_POST["wp_chatbot_exclude_category_list"];
		update_option('qlcd_chatbot_exclude_category_list', $qlcd_chatbot_exclude_category_list);

		$qlcd_wp_chatbot_order_date = @$_POST["qlcd_wp_chatbot_order_date"];
		update_option('qlcd_wp_chatbot_order_date', serialize($qlcd_wp_chatbot_order_date));
		$qlcd_wp_chatbot_order_item = @$_POST["qlcd_wp_chatbot_order_item"];
		update_option('qlcd_wp_chatbot_order_item', serialize($qlcd_wp_chatbot_order_item));
		$qlcd_wp_chatbot_order_status = @$_POST["qlcd_wp_chatbot_order_status"];
		update_option('qlcd_wp_chatbot_order_status', serialize($qlcd_wp_chatbot_order_status));
		$qlcd_wp_chatbot_order_id_text = @$_POST["qlcd_wp_chatbot_order_id_text"];
		update_option('qlcd_wp_chatbot_order_id_text', serialize($qlcd_wp_chatbot_order_id_text));
		
		//Enable /disable Cart Item Number
		if(isset( $_POST["disable_wp_chatbot_cart_item_number"])) {
			$disable_wp_chatbot_cart_item_number = qcld_sanitize_field($_POST["disable_wp_chatbot_cart_item_number"]);
		}else{ $disable_wp_chatbot_cart_item_number='';}
		update_option('disable_wp_chatbot_cart_item_number', stripslashes($disable_wp_chatbot_cart_item_number));
		//Enable /disable featured products button.
		
		//Enable Product details page.
		if(isset( $_POST["wp_chatbot_open_product_detail"])) {
			$wp_chatbot_open_product_detail = qcld_sanitize_field($_POST["wp_chatbot_open_product_detail"]);
		}else{ $wp_chatbot_open_product_detail='';}
		update_option('wp_chatbot_open_product_detail', stripslashes($wp_chatbot_open_product_detail));
		
		
		if(isset( $_POST["wp_chatbot_exclude_stock_out_product"])) {
		$wp_chatbot_exclude_stock_out_product = qcld_sanitize_field($_POST['wp_chatbot_exclude_stock_out_product']);
		}else{ $wp_chatbot_exclude_stock_out_product='';}
		update_option('wp_chatbot_exclude_stock_out_product', stripslashes($wp_chatbot_exclude_stock_out_product));
		
		if(isset( $_POST["wp_chatbot_show_parent_category"])) {
			$wp_chatbot_show_parent_category = qcld_sanitize_field($_POST['wp_chatbot_show_parent_category']);
		}else{ $wp_chatbot_show_parent_category='';}
		update_option('wp_chatbot_show_parent_category', stripslashes($wp_chatbot_show_parent_category));
		
		if(isset( $_POST["wp_chatbot_show_sub_category"])) {
			$wp_chatbot_show_sub_category = qcld_sanitize_field($_POST['wp_chatbot_show_sub_category']);
		}else{ $wp_chatbot_show_sub_category='';}
		update_option('wp_chatbot_show_sub_category', stripslashes($wp_chatbot_show_sub_category));
		
		if(isset( $_POST["wp_chatbot_order_status_without_login"])) {
			$wp_chatbot_order_status_without_login = qcld_sanitize_field($_POST['wp_chatbot_order_status_without_login']);
		}else{ $wp_chatbot_order_status_without_login='';}
		update_option('wp_chatbot_order_status_without_login', stripslashes($wp_chatbot_order_status_without_login));
		
	}
}

function wpwc_settings_page(){
	$action = admin_url('admin.php?page=wpwc-settings-page');
?>

<div class="wp-chatbot-wrap">

    <form action="<?php echo esc_attr($action); ?>" method="POST" id="wp-chatbot-admin-form"
          enctype="multipart/form-data">
        <div class="container form-container">
            <header class="wp-chatbot-admin-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h2><?php echo esc_html__('Woocommerce Addon Control Panel', 'wpchatbot'); ?><?php echo get_option('wp_chatbot_index_meta'); ?></h2>
                    </div>
                    <div class="col-sm-6 text-right wp-chatbot-version">
                        
                        <?php qcld_wpbot_load_additional_validation_required(); ?>
                    </div>
                </div>
            </header>
			<section class="wp-chatbot-tab-container-inner">
                <div class="wp-chatbot-tabs wp-chatbot-tabs-style-flip">
                    <nav>
                        <ul>
                            <li tab-data="general"><a href="<?php echo esc_attr($action); ?>&tab=general">
                                    <span class="wpwbot-admin-tab-icon">
                                        <i class="fa fa-toggle-on"> </i>
                                    </span>
                                    <span class="wpwbot-admin-tab-name"> <?php echo esc_html__('General SETTINGS', 'wpchatbot'); ?></span>
                                </a></li>
								
								<li tab-data="icons_settings"><a href="<?php echo esc_attr($action); ?>&tab=icons_settings">
                                    <span class="wpwbot-admin-tab-icon">
                                        <i class="fa fa-toggle-on"> </i>
                                    </span>
                                    <span class="wpwbot-admin-tab-name"> <?php echo esc_html__('Bottom ICON SETTINGS', 'wpchatbot'); ?></span>
                                </a></li>
								
								<li tab-data="intents"><a href="<?php echo esc_attr($action); ?>&tab=intents">
                                    <span class="wpwbot-admin-tab-icon">
                                        <i class="fa fa-toggle-on"> </i>
                                    </span>
                                    <span class="wpwbot-admin-tab-name"> <?php echo esc_html__('Predefined Intents', 'wpchatbot'); ?></span>
                                </a></li>
								<li tab-data="languages"><a href="<?php echo esc_attr($action); ?>&tab=languages">
                                    <span class="wpwbot-admin-tab-icon">
                                        <i class="fa fa-toggle-on"> </i>
                                    </span>
                                    <span class="wpwbot-admin-tab-name"> <?php echo esc_html__('Language Center', 'wpchatbot'); ?></span>
                                </a></li>

                        </ul>
                    </nav>
					<div class="content-wrap">
					
						<section id="section-flip-1">
							<div class="top-section">
								<div class="row">
								  <div class="col-xs-12">
									<h4 class="qc-opt-title">
									  <?php _e('Disable Cart Item Number', 'woochatbot'); ?>
									</h4>
									<div class="cxsc-settings-blocks">
									  <input value="1" id="disable_wp_chatbot_cart_item_number" type="checkbox"
																	   name="disable_wp_chatbot_cart_item_number" <?php echo(get_option('disable_wp_chatbot_cart_item_number') == 1 ? 'checked' : ''); ?>>
									  <label for="disable_wp_chatbot_cart_item_number">
										<?php _e('Disable cart item number display', 'woochatbot'); ?>
									  </label>
									</div>
								  </div>
								</div>
								<div class="row">
								  <div class="col-xs-12">
									<h4 class="qc-opt-title">
									  <?php _e('Open Product Details in Page Instead of Bot Window', 'woochatbot'); ?>
									</h4>
									<div class="cxsc-settings-blocks">
									  <input value="1" id="wp_chatbot_open_product_detail" type="checkbox"
																	   name="wp_chatbot_open_product_detail" <?php echo(get_option('wp_chatbot_open_product_detail') == 1 ? 'checked' : ''); ?>>
									  <label for="wp_chatbot_open_product_detail">
										<?php _e('Enable to display product details page in new tab ', 'woochatbot'); ?>
									  </label>
									</div>
								  </div>
								</div>
								
								<div class="row">
								  <div class="col-xs-12">
									<h4 class="qc-opt-title">
									  <?php _e('Display Parent Categories only', 'woochatbot'); ?>
									</h4>
									<div class="cxsc-settings-blocks">
									  <input value="1" id="wp_chatbot_show_parent_category" type="checkbox"
																	   name="wp_chatbot_show_parent_category" <?php echo(get_option('wp_chatbot_show_parent_category') == 1 ? 'checked' : ''); ?>>
									  <label for="wp_chatbot_show_parent_category">
										<?php _e('Enable to display only parent category list.', 'woochatbot'); ?>
									  </label>
									</div>
								  </div>
								</div>
								<div class="row">
								  <?php
														if (get_option('wp_chatbot_show_parent_category') == 1) {
															$wp_chatbot_sub_cat_display = "block";
														} else {
															$wp_chatbot_sub_cat_display = "none";
														}
														?>
								  <div class="col-xs-12" id="wp_chatbot_sub_cats_container"
															 style=" display:<?php echo $wp_chatbot_sub_cat_display; ?>">
									<h4 class="qc-opt-title">
									  <?php _e('Display Sub Category after Parent Category', 'woochatbot'); ?>
									</h4>
									<div class="cxsc-settings-blocks">
									  <input value="1" id="wp_chatbot_show_sub_category" type="checkbox"
																	   name="wp_chatbot_show_sub_category" <?php echo(get_option('wp_chatbot_show_sub_category') == 1 ? 'checked' : ''); ?>>
									  <label for="wp_chatbot_show_sub_category">
										<?php _e('Enable to display Sub Category after Parent Category.', 'woochatbot'); ?>
									  </label>
									</div>
								  </div>
								</div>
								<div class="row">
								  <div class="col-xs-12">
									<h4 class="qc-opt-title">
									  <?php _e('Exclude Out of Stock products in Products Search', 'woochatbot'); ?>
									</h4>
									<div class="cxsc-settings-blocks">
									  <input value="1" id="wp_chatbot_exclude_stock_out_product" type="checkbox"
																	   name="wp_chatbot_exclude_stock_out_product" <?php echo(get_option('wp_chatbot_exclude_stock_out_product') == 1 ? 'checked' : ''); ?>>
									  <label for="wp_chatbot_exclude_stock_out_product">
										<?php _e('Exclude Out of Stock products to display in search results', 'woochatbot'); ?>
									  </label>
									</div>
								  </div>
								</div>
								<div class="row">
								  <div class="col-xs-12">
									<h4 class="qc-opt-title">
									  <?php _e('Hide Add to Cart button (Catalog Mode)', 'woochatbot'); ?>
									</h4>
									<div class="cxsc-settings-blocks">
									  <input value="1" id="wp_chatbot_hide_product_details_add_to_cart"
																	   type="checkbox"
																	   name="wp_chatbot_hide_product_details_add_to_cart" <?php echo(get_option('wp_chatbot_hide_product_details_add_to_cart') == 1 ? 'checked' : ''); ?>>
									  <label for="wp_chatbot_hide_product_details_add_to_cart">
										<?php _e('Enable to hide Add to Cart button on product details popup', 'woochatbot'); ?>
									  </label>
									</div>
								  </div>
								</div>
								
								<div class="row">
								  <div class="col-xs-12">
									<h4 class="qc-opt-title">
									  <?php _e('Allow order status checking using Email and order ID instead of login', 'woochatbot'); ?>
									</h4>
									<div class="cxsc-settings-blocks">
									  <input value="1" id="wp_chatbot_order_status_without_login"
																	   type="checkbox"
																	   name="wp_chatbot_order_status_without_login" <?php echo(get_option('wp_chatbot_order_status_without_login') == 1 ? 'checked' : ''); ?>>
									  <label for="wp_chatbot_order_status_without_login">
										<?php _e('Allow order status checking using Email and order ID instead of login', 'woochatbot'); ?>
									  </label>
									</div>
								  </div>
								</div>

								<div class="row">
								  <div class="col-xs-12">
									<h4 class="qc-opt-title">
									  <?php _e('Product Per Page', 'woochatbot'); ?>
									</h4>
									<div class="cxsc-settings-blocks">
									  <input value="<?php echo( get_option('qlcd_wp_chatbot_ppp')?get_option('qlcd_wp_chatbot_ppp'):10); ?>" id="qlcd_wp_chatbot_ppp"
																	   type="number"
																	   name="qlcd_wp_chatbot_ppp" >
									  <label for="qlcd_wp_chatbot_ppp">
										
									  </label>
									</div>
								  </div>
								</div>

								<div class="row">
									<div class="col-xs-12">
										<h4 class="qc-opt-title">
										<?php _e('Products display orderby', 'woochatbot'); ?>
										</h4>
										<div class="cxsc-settings-blocks">
										<div class="form-group">
											<select class="form-control" name="qlcd_woo_chatbot_product_orderby">
											<option value="title" <?php if (get_option('qlcd_woo_chatbot_product_orderby') == 'title') {
																				echo 'selected';
																			} ?>>
											<?php _e('Orderby Product Title', 'woochatbot'); ?>
											</option>
											<option value="date" <?php if (get_option('qlcd_woo_chatbot_product_orderby') == 'date') {
																				echo 'selected';
																			} ?>>
											<?php _e('Orderby Date', 'woochatbot'); ?>
											</option>
											<option value="modified" <?php if (get_option('qlcd_woo_chatbot_product_orderby') == 'modified') {
																				echo 'selected';
																			} ?>>
											<?php _e('Orderby Modified Date', 'woochatbot'); ?>
											</option>
											<option value="comment_count" <?php if (get_option('qlcd_woo_chatbot_product_orderby') == 'comment_count') {
																				echo 'selected';
																			} ?>>
											<?php _e('Orderby Comments Number', 'woochatbot'); ?>
											</option>
											<option value="rand" <?php if (get_option('qlcd_woo_chatbot_product_orderby') == 'rand') {
																				echo 'selected';
																			} ?>>
											<?php _e('Orderby Random', 'woochatbot'); ?>
											</option>
											<option value="menu_order" <?php if (get_option('qlcd_woo_chatbot_product_orderby') == 'menu_order') {
																				echo 'selected';
																			} ?>>
											<?php _e('Orderby Menu Order', 'woochatbot'); ?>
											</option>
											<option value="none" <?php if (get_option('qlcd_woo_chatbot_product_orderby') == 'none') {
																				echo 'selected';
																			} ?>>
											<?php _e('Orderby None', 'woochatbot'); ?>
											</option>
											</select>
										</div>
										</div>
										<!--                                        cxsc-settings-blocks--> 
									</div>
								</div>
								
								<div class="row">
									<div class="col-xs-12">
										<h4 class="qc-opt-title">
										<?php _e('Product display order (ASCENDING or DESCENDING)', 'woochatbot'); ?>
										</h4>
										<div class="cxsc-settings-blocks">
										<div class="form-group">
											<select class="form-control" name="qlcd_woo_chatbot_product_order">
											<option value="ASC" <?php if (get_option('qlcd_woo_chatbot_product_order') == 'ASC') {
																				echo 'selected';
																			} ?>>
											<?php _e('ASCENDING', 'woochatbot'); ?>
											</option>
											<option value="DESC" <?php if (get_option('qlcd_woo_chatbot_product_order') == 'DESC') {
																				echo 'selected';
																			} ?>>
											<?php _e('DESCENDING', 'woochatbot'); ?>
											</option>
											</select>
										</div>
										</div>
										<!--                                        cxsc-settings-blocks--> 
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12">
										<h4 class="qc-opt-title">
										<?php _e('Exclude Product category', 'woochatbot'); ?>
										</h4>
									</div>
									<div class="col-xs-12">
										<div id="wp-chatbot-exclude-pages-list">
											<ul class="checkbox-list">           
											<?php
												 global $post;
												 $args = array(
													
												);
												
												$product_categories = get_terms( 'product_cat', $args );
												$wp_chatbot_pages = get_pages();
                                				$wp_chatbot_exclude_category_list = maybe_unserialize(get_option('qlcd_chatbot_exclude_category_list'));
												
												foreach ($product_categories as $term) {
											?>
												<li>
													<input id="wp_chatbot_exclude_page_<?php echo  $term->term_id; ?>" type="checkbox" name="wp_chatbot_exclude_category_list[]" value="<?php echo  $term->term_id; ?>" <?php if (!empty($wp_chatbot_exclude_category_list) && in_array($term->term_id, $wp_chatbot_exclude_category_list) == true) {
														echo 'checked';
													} ?> >
													<label for="wp_chatbot_exclude_page_<?php echo  $term->term_id; ?>"> <?php echo  $term->name; ?></label>
												</li> <li> </li>
											<?php } ?>
											</ul>
										</div>
									</div>
								</div>
							</div>
							
						</section>
						
						<section id="section-flip-2">
							<div class="top-section">
								<?php do_action('qcld_wpwc_bottomicon_option_woocommerce'); ?>
							</div>
							
						</section>
						
						<section id="section-flip-3">
							<div class="top-section">
								<?php do_action('qcld_wpwc_intent_option_fields'); ?>
							</div>
							
						</section>
						
						<section id="section-flip-4">
							
                            <div class="wp-chatbot-language-center-summmery">
                                
                            </div>
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#wp-chatbot-lng-general"><?php echo esc_html__('General', 'wpchatbot'); ?></a></li>
                                <?php 
                                    if(function_exists('qcpd_wpwc_addon_lang_init')){
                                        do_action('qcld_wpwc_language_tab_woocommerce');
                                    }
                                
                                ?>
								<li><a data-toggle="tab" href="#wp-chatbot-lng-system-keyword"><?php echo esc_html__('System Keywords', 'wpchatbot'); ?></a></li>

                            </ul>
                            <div class="tab-content">
								<div id="wp-chatbot-lng-general" class="tab-pane fade in active">
                                    <div class="top-section">
                                        <div class="row">
                                            <div class="col-xs-12" id="wp-chatbot-language-section">
											<?php 
                                                    if(function_exists('qcpd_wpwc_addon_lang_init')){
                                                        do_action('qcld_wpwc_language_option_woocommerce');
                                                    }
                                                
                                                ?>
											</div>
										</div>
									</div>
								</div>
								<?php 
                                    if(function_exists('qcpd_wpwc_addon_lang_init')){
                                        do_action('qcld_wpwc_language_tab_content_woocommerce');
                                    }
                                
                                ?>
								<div id="wp-chatbot-lng-system-keyword" class="tab-pane fade">
                                    <div class="top-section">
                                        <div class="row">
                                            <div class="col-xs-12" id="wp-chatbot-language-section">
                                                <?php 
                                                    if(function_exists('qcpd_wpwc_addon_lang_init')){
                                                        do_action('qcld_wpwc_language_system_option_woocommerce');
                                                    }
                                                
                                                ?>
                                            </div>
                                            <!--                                            col-xs-12-->
                                        </div>
                                        <!--                                        row-->
                                    </div>
                                    <!--                                    top-section-->
                                </div>
							</div>
							
						</section>
					</div>
					
				</div>
				<footer class="wp-chatbot-admin-footer">
                    <div class="row">
                        <div class="text-left col-sm-3 col-sm-offset-3">
                            
                        </div>
                        <div class="text-right col-sm-6">
                            <input type="submit" class="btn btn-primary submit-button" name="submit"
                                   id="submit" value="<?php echo esc_html__('Save Settings', 'wpchatbot'); ?>"/>
                        </div>
                    </div>
                    <!--                    row-->
                </footer>
			</section>
			
		</div>
	</form>
</div>

<?php
}


/**
 *
 * Function to load translation files.
 *
 */
function qcpd_wpwc_addon_lang_init() {
    load_plugin_textdomain( 'wpwc', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'qcpd_wpwc_addon_lang_init');

add_action('qcld_wpwc_intent_option_fields', 'qcld_wpwc_intent_option_fields_fnc');
function qcld_wpwc_intent_option_fields_fnc(){
?>
	<div class="row">
		<div class="col-xs-12">
			<h4 class="qc-opt-title">
			<?php _e('Disable Product Search', 'woochatbot'); ?>
			</h4>
			<div class="cxsc-settings-blocks">
			<input value="1" id="disable_wp_chatbot_product_search"
												type="checkbox"
												name="disable_wp_chatbot_product_search" <?php echo(get_option('disable_wp_chatbot_product_search') == 1 ? 'checked' : ''); ?>>
			<label for="disable_wp_chatbot_product_search">
				<?php _e('Disable Product Search feature and button on Start Menu', 'woochatbot'); ?>
			</label>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<h4 class="qc-opt-title">
			<?php _e('Disable Catalog', 'woochatbot'); ?>
			</h4>
			<div class="cxsc-settings-blocks">
			<input value="1" id="disable_wp_chatbot_catalog" type="checkbox"
												name="disable_wp_chatbot_catalog" <?php echo(get_option('disable_wp_chatbot_catalog') == 1 ? 'checked' : ''); ?>>
			<label for="disable_wp_chatbot_catalog">
				<?php _e('Disable Catalog feature and button on Start Menu', 'woochatbot'); ?>
			</label>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<h4 class="qc-opt-title">
			<?php _e('Disable Featured Products', 'woochatbot'); ?>
			</h4>
			<div class="cxsc-settings-blocks">
			<input value="1" id="disable_wp_chatbot_featured_product"
												type="checkbox"
												name="disable_wp_chatbot_featured_product" <?php echo(get_option('disable_wp_chatbot_featured_product') == 1 ? 'checked' : ''); ?>>
			<label for="disable_wp_chatbot_featured_product">
				<?php _e('Disable Featured Products feature and button on Start Menu', 'woochatbot'); ?>
			</label>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<h4 class="qc-opt-title">
			<?php _e('Disable Sale Products', 'woochatbot'); ?>
			</h4>
			<div class="cxsc-settings-blocks">
			<input value="1" id="disable_wp_chatbot_sale_product"
												type="checkbox"
												name="disable_wp_chatbot_sale_product" <?php echo(get_option('disable_wp_chatbot_sale_product') == 1 ? 'checked' : ''); ?>>
			<label for="disable_wp_chatbot_sale_product">
				<?php _e('Disable Sale Products feature and button on Start Menu', 'woochatbot'); ?>
			</label>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<h4 class="qc-opt-title">
			<?php _e('Disable Order Status', 'woochatbot'); ?>
			</h4>
			<div class="cxsc-settings-blocks">
			<input value="1" id="disable_wp_chatbot_order_status"
												type="checkbox"
												name="disable_wp_chatbot_order_status" <?php echo(get_option('disable_wp_chatbot_order_status') == 1 ? 'checked' : ''); ?>>
			<label for="disable_wp_chatbot_order_status">
				<?php _e('Disable Order Status feature and button on Start Menu', 'woochatbot'); ?>
			</label>
			</div>
		</div>
	</div>
<?php
}

add_action('qcld_wpwc_language_option_woocommerce', 'qcld_wpwc_language_option_woocommerce_fnc');
function qcld_wpwc_language_option_woocommerce_fnc(){
?>

<br>
<div class="form-group">
<?php
								$featured_product_welcome_options = unserialize(get_option('qlcd_wp_chatbot_featured_product_welcome'));
								$featured_product_welcome_option = 'qlcd_wp_chatbot_featured_product_welcome';
								$featured_product_welcome_text = __('I have found following featured products', 'woochatbot');
								qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($featured_product_welcome_options, $featured_product_welcome_option, $featured_product_welcome_text);
								?>
</div>
<div class="form-group">
<?php
								$viewed_product_welcome_options = unserialize(get_option('qlcd_wp_chatbot_viewed_product_welcome'));
								$viewed_product_welcome_option = 'qlcd_wp_chatbot_viewed_product_welcome';
								$viewed_product_welcome_text = __('I have found following recently viewed products', 'woochatbot');
								qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($viewed_product_welcome_options, $viewed_product_welcome_option, $viewed_product_welcome_text);
								?>
</div>
<div class="form-group">
<?php
								$latest_product_welcome_options = unserialize(get_option('qlcd_wp_chatbot_latest_product_welcome'));
								$latest_product_welcome_option = 'qlcd_wp_chatbot_latest_product_welcome';
								$latest_product_welcome_text = __('I have found following latest products', 'woochatbot');
								qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($latest_product_welcome_options, $latest_product_welcome_option, $latest_product_welcome_text);
								?>
</div>

<div class="form-group">
<?php
								$viewed_products_options = unserialize(get_option('qlcd_wp_chatbot_viewed_products'));
								$viewed_products_option = 'qlcd_wp_chatbot_viewed_products';
								$viewed_products_text = __('Recently viewed products', 'woochatbot');
								qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($viewed_products_options, $viewed_products_option, $viewed_products_text);
								?>
</div>
<h4 class="text-success">
<?php _e('Message setting for Shopping Cart', 'woochatbot'); ?>
</h4>
<br>
<div class="form-group">
<?php
								$shopping_cart_options = unserialize(get_option('qlcd_wp_chatbot_shopping_cart'));
								$shopping_cart_option = 'qlcd_wp_chatbot_shopping_cart';
								$shopping_cart_text = __('Shopping Cart', 'woochatbot');
								qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($shopping_cart_options, $shopping_cart_option, $shopping_cart_text);
								?>
</div>
<div class="form-group">
<?php
								$add_to_cart_options = unserialize(get_option('qlcd_wp_chatbot_add_to_cart'));
								$add_to_cart_option = 'qlcd_wp_chatbot_add_to_cart';
								$add_to_cart_text = __('Add to Cart', 'woochatbot');
								qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($add_to_cart_options, $add_to_cart_option, $add_to_cart_text);
								?>
</div>
<div class="form-group">
<?php
								$cart_link_options = unserialize(get_option('qlcd_wp_chatbot_cart_link'));
								$cart_link_option = 'qlcd_wp_chatbot_cart_link';
								$cart_link_text = __('Cart', 'woochatbot');
								qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($cart_link_options, $cart_link_option, $cart_link_text);
								?>
</div>
<div class="form-group">
<?php
								$cart_url_options = unserialize(get_option('qlcd_wp_chatbot_cart_url'));
								$cart_url_option = 'qlcd_wp_chatbot_cart_url';
								$cart_url_text = __(wc_get_cart_url(), 'woochatbot');
								qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($cart_url_options, $cart_url_option, $cart_url_text);
								?>
</div>
<div class="form-group">
<?php
								$checkout_link_options = unserialize(get_option('qlcd_wp_chatbot_checkout_link'));
								$checkout_link_option = 'qlcd_wp_chatbot_checkout_link';
								$checkout_link_text = __('Checkout', 'woochatbot');
								qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($checkout_link_options, $checkout_link_option, $checkout_link_text);
								?>
</div>
<div class="form-group">
<?php
								$checkout_url_options =  unserialize(get_option('qlcd_wp_chatbot_checkout_url')) ;
								
								$checkout_url_option = 'qlcd_wp_chatbot_checkout_url';
								$checkout_url_text = __(wc_get_checkout_url(), 'woochatbot');
								qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($checkout_url_options, $checkout_url_option, $checkout_url_text);
								?>
</div>
<div class="form-group">
<?php
								$cart_welcome_options = unserialize(get_option('qlcd_wp_chatbot_cart_welcome'));
								$cart_welcome_option = 'qlcd_wp_chatbot_cart_welcome';
								$cart_welcome_text = 'I have found following items from Shopping Cart.';
								qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($cart_welcome_options, $cart_welcome_option, $cart_welcome_text);
								?>
</div>
<div class="form-group">
<?php
								$no_cart_items_options = unserialize(get_option('qlcd_wp_chatbot_no_cart_items'));
								$no_cart_items_option = 'qlcd_wp_chatbot_no_cart_items';
								$no_cart_items_text = __('No items in the cart', 'woochatbot');
								qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($no_cart_items_options, $no_cart_items_option, $no_cart_items_text);
								?>
</div>
<div class="form-group">
<?php
								$cart_title_options = unserialize(get_option('qlcd_wp_chatbot_cart_title'));
								$cart_title_option = 'qlcd_wp_chatbot_cart_title';
								$cart_title_text = __('Title', 'woochatbot');
								qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($cart_title_options, $cart_title_option, $cart_title_text);
								?>
</div>
<div class="form-group">
<?php
								$cart_quantity_options = unserialize(get_option('qlcd_wp_chatbot_cart_quantity'));
								$cart_quantity_option = 'qlcd_wp_chatbot_cart_quantity';
								$cart_quantity_text = __('Qty', 'woochatbot');
								qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($cart_quantity_options, $cart_quantity_option, $cart_quantity_text);
								?>
</div>
<div class="form-group">
<?php
								$cart_price_options = unserialize(get_option('qlcd_wp_chatbot_cart_price'));
								$cart_price_option = 'qlcd_wp_chatbot_cart_price';
								$cart_price_text = __('Price', 'woochatbot');
								qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($cart_price_options, $cart_price_option, $cart_price_text);
								?>
</div>
<div class="form-group">
<?php
								$cart_total_options = unserialize(get_option('qlcd_wp_chatbot_cart_total'));
								$cart_total_option = 'qlcd_wp_chatbot_cart_total';
								$cart_total_text = __('Total', 'woochatbot');
								qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($cart_total_options, $cart_total_option, $cart_total_text);
?>
</div>
<div class="form-group">
<?php
								$cart_updating_options = unserialize(get_option('qlcd_wp_chatbot_cart_updating'));
								$cart_updating_option = 'qlcd_wp_chatbot_cart_updating';
								$cart_updating_text = __('Updating cart items ...', 'woochatbot');
								qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($cart_updating_options, $cart_updating_option, $cart_updating_text);
								?>
</div>
<div class="form-group">
<?php
								$cart_removing_options = unserialize(get_option('qlcd_wp_chatbot_cart_removing'));
								$cart_removing_option = 'qlcd_wp_chatbot_cart_removing';
								$cart_removing_text = __('Removing cart items ...', 'woochatbot');
								qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($cart_removing_options, $cart_removing_option, $cart_removing_text);
								?>
</div>
<div class="form-group">
<?php
								$cart_removing_options = unserialize(get_option('qlcd_wp_chatbot_continue_shopping'));
								$cart_removing_option = 'qlcd_wp_chatbot_continue_shopping';
								$cart_removing_text = __('Continue Shopping', 'woochatbot');
								qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($cart_removing_options, $cart_removing_option, $cart_removing_text);
								?>
</div>
<?php
}
add_action('qcld_wpwc_language_system_option_woocommerce', 'qcld_wpwc_language_system_option_woocommerce_fnc');
function qcld_wpwc_language_system_option_woocommerce_fnc(){
?>
<div class="form-group">
	<?php 
		qcld_wpbot()->helper->render_language_field(esc_html__('Product Search Keyword', 'wpchatbot'), 'qlcd_wp_chatbot_sys_key_product', 'product', '');
	?>
</div>
<div class="form-group">
	<?php 
		qcld_wpbot()->helper->render_language_field(esc_html__('Product Catalog Keyword', 'wpchatbot'), 'qlcd_wp_chatbot_sys_key_catalog', 'catalog', '');
	?>
</div>
<div class="form-group">
	<?php 
		qcld_wpbot()->helper->render_language_field(esc_html__('Order Status  Keyword', 'wpchatbot'), 'qlcd_wp_chatbot_sys_key_order', 'order', '');
	?>
</div>
<?php
}


add_action('qcld_wpwc_language_tab_woocommerce', 'qcld_wpwc_language_tab_woocommerce_fnc');
function qcld_wpwc_language_tab_woocommerce_fnc(){
?>
	<li><a data-toggle="tab" href="#wp-chatbot-lng-product">
	<?php _e('Product Search', 'woochatbot'); ?>
	</a></li>
	<li><a data-toggle="tab" href="#wp-chatbot-lng-order">
	<?php _e('Order Status', 'woochatbot'); ?>
	</a></li>
<?php
}

add_action('qcld_wpwc_language_tab_content_woocommerce', 'qcld_wpwc_language_tab_content_woocommerce_fnc');
function qcld_wpwc_language_tab_content_woocommerce_fnc(){
?>

<div id="wp-chatbot-lng-product" class="tab-pane fade">
	<div class="top-section">
		<div class="row">
		<div class="col-xs-12" id="wp-chatbot-language-section">
			<div class="form-group">
			<?php
			$wildcard_product_options = unserialize(get_option('qlcd_wp_chatbot_wildcard_product'));
			$wildcard_product_option = 'qlcd_wp_chatbot_wildcard_product';
			$wildcard_product_text = __('Product Search', 'woochatbot');
			qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($wildcard_product_options, $wildcard_product_option, $wildcard_product_text);
			?>
			</div>
			<div class="form-group">
			<?php
			$wildcard_catalog_options = unserialize(get_option('qlcd_wp_chatbot_wildcard_catalog'));
			$wildcard_catalog_option = 'qlcd_wp_chatbot_wildcard_catalog';
			$wildcard_catalog_text = __('Catalog', 'woochatbot');
			qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($wildcard_catalog_options, $wildcard_catalog_option, $wildcard_catalog_text);
			?>
			</div>
			<div class="form-group">
			<?php
			$featured_products_options = unserialize(get_option('qlcd_wp_chatbot_featured_products'));
			$featured_products_option = 'qlcd_wp_chatbot_featured_products';
			$featured_products_text = __('Featured Products ', 'woochatbot');
			qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($featured_products_options, $featured_products_option, $featured_products_text);
			?>
			</div>
			<div class="form-group">
			<?php
			$sale_products_options = unserialize(get_option('qlcd_wp_chatbot_sale_products'));
			$sale_products_option = 'qlcd_wp_chatbot_sale_products';
			$sale_products_text = __('Products on Sale', 'woochatbot');
			qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($sale_products_options, $sale_products_option, $sale_products_text);
			?>
			</div>
			<div class="form-group">
			<?php
			$product_asking_options = unserialize(get_option('qlcd_wp_chatbot_product_asking'));
			$product_asking_option = 'qlcd_wp_chatbot_product_asking';
			$product_asking_text = __('What are you shopping for?', 'woochatbot');
			qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($product_asking_options, $product_asking_option, $product_asking_text);
			?>
			</div>
			<div class="form-group">
			<?php
			$product_success_options = unserialize(get_option('qlcd_wp_chatbot_product_success'));
			$product_success_option = 'qlcd_wp_chatbot_product_success';
			$product_success_text = __('Great! We have these products for', 'woochatbot');
			qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($product_success_options, $product_success_option, $product_success_text);
			?>
			</div>
			<div class="form-group">
			<?php
			$product_fail_options = unserialize(get_option('qlcd_wp_chatbot_product_fail'));
			$product_fail_option = 'qlcd_wp_chatbot_product_fail';
			$product_fail_text = __('Oops! Nothing matches your criteria', 'woochatbot');
			qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($product_fail_options, $product_fail_option, $product_fail_text);
			?>
			</div>
			<div class="form-group">
			<?php
			$product_suggest_options = unserialize(get_option('qlcd_wp_chatbot_product_suggest'));
			$product_suggest_option = 'qlcd_wp_chatbot_product_suggest';
			$product_suggest_text = __('You can browse our extensive catalog. Just pick a category from below:', 'woochatbot');
			qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($product_suggest_options, $product_suggest_option, $product_suggest_text);
			?>
			</div>
			<div class="form-group">
			<?php
			$product_infinite_options = unserialize(get_option('qlcd_wp_chatbot_product_infinite'));
			$product_infinite_option = 'qlcd_wp_chatbot_product_infinite';
			$product_infinite_text = __('Too many choices? Let\'s try another search term', 'woochatbot');
			qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($product_infinite_options, $product_infinite_option, $product_infinite_text);
			?>
			</div>
			<div class="form-group">
			<?php
			$load_more_options = unserialize(get_option('qlcd_wp_chatbot_load_more'));
			$load_more_option = 'qlcd_wp_chatbot_load_more';
			$load_more_text = __('Load More', 'woochatbot');
			qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($load_more_options, $load_more_option, $load_more_text);
			?>
			</div>
		</div>
		<!--                                            col-xs-12--> 
		</div>
		<!--                                        row--> 
	</div>
	<!--                                    top-section--> 
</div>
<div id="wp-chatbot-lng-order" class="tab-pane fade">
	<div class="top-section">
		<div class="row">
		<div class="col-xs-12" id="wp-chatbot-language-section">
			<div class="form-group">
			<?php
			$wildcard_order_options = unserialize(get_option('qlcd_wp_chatbot_wildcard_order'));
			$wildcard_order_option = 'qlcd_wp_chatbot_wildcard_order';
			$wildcard_order_text = __('Order Status', 'woochatbot');
			qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($wildcard_order_options, $wildcard_order_option, $wildcard_order_text);
			?>
			</div>
			<div class="form-group">
			<?php
			$order_date_options = unserialize(get_option('qlcd_wp_chatbot_order_date'));
			$order_date_option = 'qlcd_wp_chatbot_order_date';
			$order_date_text = __('Order Date', 'woochatbot');
			qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($order_date_options, $order_date_option, $order_date_text);
			?>
			</div>
			<div class="form-group">
			<?php
			$order_welcome_options = unserialize(get_option('qlcd_wp_chatbot_order_welcome'));
			$order_welcome_option = 'qlcd_wp_chatbot_order_welcome';
			$order_welcome_text = __('Welcome to Order status section!', 'woochatbot');
			qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($order_welcome_options, $order_welcome_option, $order_welcome_text);
			?>
			</div>
			<div class="form-group">
			<?php
			$username_asking_options = unserialize(get_option('qlcd_wp_chatbot_order_username_asking'));
			$username_asking_option = 'qlcd_wp_chatbot_order_username_asking';
			$username_asking_text = __('Please type your username?', 'woochatbot');
			qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($username_asking_options, $username_asking_option, $username_asking_text);
			?>
			</div>
			<div class="form-group">
			<?php
			$username_not_exist_options = unserialize(get_option('qlcd_wp_chatbot_order_username_not_exist'));
			$username_not_exist_option = 'qlcd_wp_chatbot_order_username_not_exist';
			$username_not_exist_text = __('This username does not exist.', 'woochatbot');
			qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($username_not_exist_options, $username_not_exist_option, $username_not_exist_text);
			?>
			</div>
			<div class="form-group">
			<?php
			$username_thanks_options = unserialize(get_option('qlcd_wp_chatbot_order_username_thanks'));
			$username_thanks_option = 'qlcd_wp_chatbot_order_username_thanks';
			$username_thanks_text = __('Thank you for given username!', 'woochatbot');
			qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($username_thanks_options, $username_thanks_option, $username_thanks_text);
			?>
			</div>
			<div class="form-group">
			<?php
			$username_password_options = unserialize(get_option('qlcd_wp_chatbot_order_username_password'));
			$username_password_option = 'qlcd_wp_chatbot_order_username_password';
			$username_password_text = __('Please type your password', 'woochatbot');
			qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($username_password_options, $username_password_option, $username_password_text);
			?>
			</div>
			<div class="form-group">
			<?php
			$password_incorrect_options = unserialize(get_option('qlcd_wp_chatbot_order_password_incorrect'));
			$password_incorrect_option = 'qlcd_wp_chatbot_order_password_incorrect';
			$password_incorrect_text = __('Sorry Password is not correct!', 'woochatbot');
			qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($password_incorrect_options, $password_incorrect_option, $password_incorrect_text);
			?>
			</div>
			<div class="form-group">
			<?php
			$order_found_options = unserialize(get_option('qlcd_wp_chatbot_order_found'));
			$order_found_found_option = 'qlcd_wp_chatbot_order_found';
			$order_found_found_text = __('I have found the following orders', 'woochatbot');
			qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($order_found_options, $order_found_found_option, $order_found_found_text);
			?>
			</div>
			<div class="form-group">
			<?php
			$order_not_found_options = unserialize(get_option('qlcd_wp_chatbot_order_not_found'));
			$order_not_found_option = 'qlcd_wp_chatbot_order_not_found';
			$order_not_found_text = __('I did not find any order by you', 'woochatbot');
			qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($order_not_found_options, $order_not_found_option, $order_not_found_text);
			?>
			</div>
			<div class="form-group">
			<?php
			$order_email_support_options = unserialize(get_option('qlcd_wp_chatbot_order_email_support'));
			$order_email_support_option = 'qlcd_wp_chatbot_order_email_support';
			$order_email_support_text = __('Email our support center about your order.', 'woochatbot');
			qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($order_email_support_options, $order_email_support_option, $order_email_support_text);
			?>
			</div>
			
			<div class="form-group">
			<?php
			$order_email_support_options = unserialize(get_option('qlcd_wp_chatbot_order_id'));
			$order_email_support_option = 'qlcd_wp_chatbot_order_id';
			$order_email_support_text = __('What is your order ID?', 'woochatbot');
			qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($order_email_support_options, $order_email_support_option, $order_email_support_text);
			?>
			</div>
			
			<div class="form-group">
			<?php
			$order_email_support_options = unserialize(get_option('qlcd_wp_chatbot_order_email'));
			$order_email_support_option = 'qlcd_wp_chatbot_order_email';
			$order_email_support_text = __('What is your order email address?', 'woochatbot');
			qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($order_email_support_options, $order_email_support_option, $order_email_support_text);
			?>

			</div>
			<div class="form-group">
			<?php
			$order_id_text_options = unserialize(get_option('qlcd_wp_chatbot_order_id_text'));
			$order_id_text_option = 'qlcd_wp_chatbot_order_id_text';
			$order_ids_text = __('Order id', 'woochatbot');
			qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($order_id_text_options, $order_id_text_option, $order_ids_text);
			?>
			</div>
			
			<div class="form-group">
			<?php
			$order_item_options = unserialize(get_option('qlcd_wp_chatbot_order_item'));
			$order_item_option = 'qlcd_wp_chatbot_order_item';
			$order_item_text = __('Order item', 'woochatbot');
			qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($order_item_options, $order_item_option, $order_item_text);
			?>
			</div>
		</div>
		</div>
	</div>
</div>

<?php
}

add_action('qcld_wpwc_start_menu_option_woocommerce', 'qcld_wpwc_start_menu_option_woocommerce_fnc');
function qcld_wpwc_start_menu_option_woocommerce_fnc( $language ){
	
?>

	<li>
		<?php if(get_option('disable_wp_chatbot_product_search')==''): ?>
		
		<span class="qcld-chatbot-wildcard qc_draggable_item"  data-wildcart="product"><?php 
			$whatsapp = maybe_unserialize(get_option('qlcd_wp_chatbot_wildcard_product'));
			if( is_array( $whatsapp ) && isset( $whatsapp[$language] ) ){
				echo qcld_choose_random($whatsapp[$language]);
			}elseif( is_array( $whatsapp ) && isset( $whatsapp[get_locale()] ) ){
				echo qcld_choose_random( $whatsapp[get_locale()] );
			}else{
				echo qcld_choose_random($whatsapp);
			}
		?></span>
		<?php endif; ?>
	</li>

	<li>
		<?php if(get_option('disable_wp_chatbot_catalog')==''): ?>
		<span class="qcld-chatbot-wildcard qc_draggable_item"  data-wildcart="catalog"><?php 
			$whatsapp = maybe_unserialize(get_option('qlcd_wp_chatbot_wildcard_catalog'));
			if( is_array( $whatsapp ) && isset( $whatsapp[$language] ) ){
				echo qcld_choose_random($whatsapp[$language]);
			}elseif( is_array( $whatsapp ) && isset( $whatsapp[get_locale()] ) ){
				echo qcld_choose_random( $whatsapp[get_locale()] );
			}else{
				echo qcld_choose_random($whatsapp);
			}
		?></span>
		<?php endif; ?>
	</li>

	<li>
		<?php if(get_option('disable_wp_chatbot_featured_product')==''): ?>
		<span class="qcld-chatbot-wildcard qc_draggable_item"  data-wildcart="featured"><?php 
			$whatsapp = maybe_unserialize(get_option('qlcd_wp_chatbot_featured_products'));
			if( is_array( $whatsapp ) && isset( $whatsapp[$language] ) ){
				echo qcld_choose_random($whatsapp[$language]);
			}elseif( is_array( $whatsapp ) && isset( $whatsapp[get_locale()] ) ){
				echo qcld_choose_random( $whatsapp[get_locale()] );
			}else{
				echo qcld_choose_random($whatsapp);
			}
		?></span>
		<?php endif; ?>
	</li>

	<li>
		<?php if(get_option('disable_wp_chatbot_sale_product')==''): ?>
		<span class="qcld-chatbot-wildcard qc_draggable_item"  data-wildcart="sale"><?php 
			$whatsapp = maybe_unserialize(get_option('qlcd_wp_chatbot_sale_products'));
			if( is_array( $whatsapp ) && isset( $whatsapp[$language] ) ){
				echo qcld_choose_random($whatsapp[$language]);
			}elseif( is_array( $whatsapp ) && isset( $whatsapp[get_locale()] ) ){
				echo qcld_choose_random( $whatsapp[get_locale()] );
			}else{
				echo qcld_choose_random($whatsapp);
			}
		?></span>
		<?php endif; ?>
	</li>

	<li>
		<?php if(get_option('disable_wp_chatbot_order_status')==''): ?>
		<span class="qcld-chatbot-wildcard qc_draggable_item"  data-wildcart="order"><?php 
			$whatsapp = maybe_unserialize(get_option('qlcd_wp_chatbot_wildcard_order'));
			if( is_array( $whatsapp ) && isset( $whatsapp[$language] ) ){
				echo qcld_choose_random($whatsapp[$language]);
			}elseif( is_array( $whatsapp ) && isset( $whatsapp[get_locale()] ) ){
				echo qcld_choose_random( $whatsapp[get_locale()] );
			}else{
				echo qcld_choose_random($whatsapp);
			}
		?></span>
		<?php endif; ?>
	</li>
<?php
}
add_action('qcld_wpwc_bottomicon_option_woocommerce', 'qcld_wpwc_bottomicon_option_woocommerce_fnc');
function qcld_wpwc_bottomicon_option_woocommerce_fnc(){
?>
<div class="row">
<div class="col-xs-12">
	<h4 class="qc-opt-title">
	<?php _e('Disable Product Icon', 'woochatbot'); ?>
	</h4>
	<div class="form-group">
	<input value="1" id="enable_wp_chatbot_disable_producticon" type="checkbox"
									name="enable_wp_chatbot_disable_producticon" <?php echo(get_option('enable_wp_chatbot_disable_producticon') == 1 ? 'checked' : ''); ?>>
	<label for="enable_wp_chatbot_disable_producticon">
		<?php _e('Enable to hide product icon from bottom area.', 'woochatbot'); ?>
	</label>
	</div>
</div>
</div>
<div class="row">
<div class="col-xs-12">
	<h4 class="qc-opt-title">
	<?php _e('Disable Cart Icon', 'woochatbot'); ?>
	</h4>
	<div class="form-group">
	<input value="1" id="enable_wp_chatbot_disable_carticon" type="checkbox"
									name="enable_wp_chatbot_disable_carticon" <?php echo(get_option('enable_wp_chatbot_disable_carticon') == 1 ? 'checked' : ''); ?>>
	<label for="enable_wp_chatbot_disable_carticon">
		<?php _e('Enable to hide cart icon from bottom area.', 'woochatbot'); ?>
	</label>
	</div>
</div>
</div>
<?php
}

add_action('qcld_wpwc_product_details_woocommerce', 'qcld_wpwc_product_details_woocommerce_fnc');
function qcld_wpwc_product_details_woocommerce_fnc(){
?>
<div class="wp-chatbot-product-container">
	<div class="wp-chatbot-product-details">
		<div class="wp-chatbot-product-image-col">
			<div id="wp-chatbot-product-image"></div>
		</div>
		<!--woo-chatbot-product-image-col-->
		<div class="wp-chatbot-product-info-col">
			<div class="wp-chatbot-product-reload"></div>
			<div id="wp-chatbot-product-title" class="wp-chatbot-product-title"></div>
			<div id="wp-chatbot-product-price" class="wp-chatbot-product-price"></div>
			<div id="wp-chatbot-product-description" class="wp-chatbot-product-description"></div>
			<div id="wp-chatbot-product-quantity" class="wp-chatbot-product-quantity"></div>
			<div id="wp-chatbot-product-variable" class="wp-chatbot-product-variable"></div>
			<div id="wp-chatbot-product-cart-button" class="wp-chatbot-product-cart-button"></div>
		</div>
		<!--woo-chatbot-product-info-col-->
		<a href="#" class="wp-chatbot-product-close"></a>
	</div>
	<!--            woo-chatbot-product-details-->
</div>
<?php
}
add_action('qcld_wpwc_template_bottom_icon_woocommerce', 'qcld_wpwc_template_bottom_icon_woocommerce_fnc');
function qcld_wpwc_template_bottom_icon_woocommerce_fnc($cart_items_number){
?>
	<?php if(get_option('enable_wp_chatbot_disable_producticon')!='1'): ?>
	<li><a class="wp-chatbot-operation-option" data-option="recent" href="" title="<?php echo esc_html__('Recent Products', 'wpchatbot'); ?>"></a></li>
	<?php endif; ?>
	<?php if(get_option('enable_wp_chatbot_disable_carticon')!='1'): ?>
	<li>
		<a class="wp-chatbot-operation-option" data-option="cart" href="" title="<?php echo esc_html__('Cart', 'wpchatbot'); ?>">
			<?php if (get_option('disable_wp_chatbot_cart_item_number') != 1) { ?> <span
				id="wp-chatbot-cart-numbers"><?php echo $cart_items_number; ?></span> <?php } ?>
		</a>
	</li>
	<?php endif; ?>
<?php
}
add_action('qcld_wpwc_cart_item_number_woocommerce', 'qcld_wpwc_cart_item_number_woocommerce_fnc');
function qcld_wpwc_cart_item_number_woocommerce_fnc($cart_items_number){
?>
<?php if (get_option('disable_wp_chatbot_cart_item_number') != 1) { ?>
	<span class="wp-chatbot-ball-cart-items"><?php echo $cart_items_number; ?></span>
<?php } ?>
<?php
}


add_action('qcld_wpwc_cart_ret_option_woocommerce', 'qcld_wpwc_cart_ret_option_woocommerce_fnc');

function qcld_wpwc_cart_ret_option_woocommerce_fnc(){
?>
<div class="col-xs-12">
<div class="wp-chatbot-language-center-summmery" style="margin-top: 20px;">
	<p><?php echo esc_html__('Show message to complete checkout (when user has products in the cart)', 'wpchatbot'); ?></p>
</div>
	
	<div class="cxsc-settings-blocks">
	  <div class="form-group">
		<input value="1" id="enable_wp_chatbot_ret_user_show" type="checkbox"
											   name="enable_wp_chatbot_ret_user_show" <?php echo(get_option('enable_wp_chatbot_ret_user_show') == 1 ? 'checked' : ''); ?>>
		<label for="enable_wp_chatbot_ret_user_show">
		  <?php _e('Show message when the user returns to the site', 'woochatbot'); ?>
		</label>
	  </div>
	</div>
	<br>
	<div class="cxsc-settings-blocks">
	  <div class="form-group">
		<input value="1" id="enable_wp_chatbot_inactive_time_show"
											   type="checkbox"
											   name="enable_wp_chatbot_inactive_time_show" <?php echo(get_option('enable_wp_chatbot_inactive_time_show') == 1 ? 'checked' : ''); ?>>
		<label for="enable_wp_chatbot_inactive_time_show">
		  <?php _e('Show message when user inactive.', 'woochatbot'); ?>
		</label>
	  </div>
	</div>
	<div class="cxsc-settings-blocks"> <span class="qc-opt-dcs-font">
	  <?php _e('Chatbot will be opened for inactive user after', 'woochatbot'); ?>
	  </span>
	  <input type="number" name="wp_chatbot_inactive_time"
										   value="<?php echo(get_option('wp_chatbot_inactive_time') != '' ? get_option('wp_chatbot_inactive_time') : 10); ?>">
	  <span class="qc-opt-dcs-font">
	  <?php _e('seconds', 'woochatbot'); ?>
	  </span></div>
	<div class="cxsc-settings-blocks">
	  <div class="form-group">
		<input value="1" id="wp_chatbot_inactive_once" type="checkbox"
											   name="wp_chatbot_inactive_once" <?php echo(get_option('wp_chatbot_inactive_once') == 1 ? 'checked' : ''); ?>>
		<label for="wp_chatbot_inactive_once">
		  <?php _e('Show only once per visit for inactive users.', 'woochatbot'); ?>
		</label>
	  </div>
	</div>
	<br>
	<div class="cxsc-settings-blocks" id="wp_chatbot_checkout_open_body">
		<?php 
			qcld_wpbot()->helper->render_retmsg_field(esc_html__('Your Message', 'wpchatbot'), 'wp_chatbot_checkout_msg');
		?>
	</div>
  </div>									  

<?php
}




