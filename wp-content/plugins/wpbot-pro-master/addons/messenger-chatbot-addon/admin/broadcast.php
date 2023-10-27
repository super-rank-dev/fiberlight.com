<?php defined('ABSPATH') or die("No direct script access!");
global $wpdb;
//wp_enqueue_style('qc_messenger_chatbot_subscriber_styles', WBFB_URL . '/assets/css/subscriber.css');	

$pageId = sanitize_text_field($_GET['fbpage']);
$pageDetails = qcld_wpbot_fb_page_details($pageId);

$tablebroadcast    = $wpdb->prefix.'wpbot_fb_broadcast';

$main_url = admin_url('admin.php?page=wpbot-fb-private-replies&sub=broadcast&fbpage='.$pageId);

?>

<?php if(isset($_GET['status']) && $_GET['status']=='success'): ?>
<div id="message" class="updated notice is-dismissible rlrsssl-success">
		<p>BroadCast has been successful!</p>
	<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
</div>
<?php endif; ?>

<?php if(isset($_GET['status']) && $_GET['status']=='failed'): ?>
<div id="message" class="notice is-dismissible notice-error">
		<p>Something went wrong. Please try again.</p>
	<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
</div>
<?php endif; ?>

<div class="wrap swpm-admin-menu-wrap">
	<h1>Broadcast for <b><?php echo esc_html($pageDetails->page_name); ?></b></h1>

	<!-- Main navigation -->
	<h2 class="nav-tab-wrapper sld_nav_container">
		<a class="nav-tab sld_click_handle <?php echo ($_GET['sub'] == 'broadcast'? 'nav-tab-active' : ''); ?>" href="<?php echo $main_url.'&tab=send'; ?>">Send BroadCast</a>
		<a class="nav-tab sld_click_handle <?php echo ($_GET['sub'] == 'broadcast_report'? 'nav-tab-active' : ''); ?>" href="<?php echo admin_url( 'admin.php?page=wpbot-fb-private-replies&sub=broadcast_report&fbpage='.$pageId); ?>">BroadCast Report</a>
	</h2>

	<?php if( ( ( isset( $_GET['tab'] ) && $_GET['tab']=='send' ) || ! isset( $_GET['tab'] ) ) && $_GET['sub'] !== 'broadcast_report' ): ?>

	<ul class="subsubsub">
		<li><a href="<?php echo $main_url.'&tab=send&template=generic'; ?>" class="<?php echo ( isset( $_GET['template'] ) && $_GET['template'] == 'generic' ) || ! isset( $_GET['template'] ) ? 'current' : ''; ?>">Generic Template</a> | </li>
		<li><a href="<?php echo $main_url.'&tab=send&template=button'; ?>" class="<?php echo ( isset( $_GET['template'] ) && $_GET['template'] == 'button' ? 'current' : '' ); ?>">Button Template</a> | </li>
		<li><a href="<?php echo $main_url.'&tab=send&template=media'; ?>" class="<?php echo ( isset( $_GET['template'] ) && $_GET['template'] == 'media' ? 'current' : '' ); ?>">Media Template</a> | </li>
		<li><a href="<?php echo $main_url.'&tab=send&template=product'; ?>" class="<?php echo ( isset( $_GET['template'] ) && $_GET['template'] == 'product' ? 'current' : '' ); ?>">Product Template</a>  </li>
	</ul>
	<br class="clear" />
	<div>
		<h2>Variable</h2>
		<p>You can use the below variable in Title and Subtitle section.</p>
		<p><b>Subscriber Name: #name</b></p>
	</div>

		<?php 
		if( ( isset( $_GET['template'] ) && $_GET['template'] == 'generic' ) || ! isset( $_GET['template'] ) ):
			include WBFB_PATH . 'admin/template/generic.php';
		endif; // Generic template

		if( isset( $_GET['template'] ) && $_GET['template'] == 'button' ):
			include WBFB_PATH . 'admin/template/button.php';
		endif; // Button template

		if( isset( $_GET['template'] ) && $_GET['template'] == 'media' ):
			include WBFB_PATH . 'admin/template/media.php';
		endif; // Media template

		if( isset( $_GET['template'] ) && $_GET['template'] == 'product' ):
			include WBFB_PATH . 'admin/template/product.php';
		endif; // Product template

	endif; //tab

	if( isset( $_GET['sub'] ) && $_GET['sub'] == 'broadcast_report' ) {
		include_once WBFB_PATH.'/admin/broadcast_report.php';
	}
	?>


</div>