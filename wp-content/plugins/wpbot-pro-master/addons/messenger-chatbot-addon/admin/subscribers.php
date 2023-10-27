<?php defined('ABSPATH') or die("No direct script access!");
global $wpdb;
wp_enqueue_style('qc_messenger_chatbot_subscriber_styles', WBFB_URL . '/assets/css/subscriber.css');	

$pageId = sanitize_text_field($_GET['fbpage']);
$pageDetails = qcld_wpbot_fb_page_details($pageId);

$tableuser    = $wpdb->prefix.'wpbot_fb_subscribers';

$customPagHTML = '';
// Main Report Area

$sql = "SELECT * FROM $tableuser where 1 and page_id = '$pageId' order by id desc";
$sql1 = "SELECT count(*) FROM $tableuser where 1 and page_id = '$pageId'";

$total             = $wpdb->get_var( $sql1 );
$items_per_page = 50;

$page             = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
$offset         = ( $page * $items_per_page ) - $items_per_page;

$sql .=" LIMIT ${offset}, ${items_per_page}";

$allsubscribers = $wpdb->get_results( $sql );
$totalPage         = ceil($total / $items_per_page);

if($totalPage > 1){
	$customPagHTML     =  '<div style="float: right;margin-top: 6px;"><span style="margin: 0 16px;" class="wpbot_pagination">Page '.esc_html($page).' of '.esc_html($totalPage).'</span>'.paginate_links( array(
	'base' => add_query_arg( 'cpage', '%#%' ),
	'format' => '',
	'prev_text' => esc_html__('&laquo;'),
	'next_text' => esc_html__('&raquo;'),
	'total' => esc_html($totalPage),
	'current' => esc_html($page)
	)).'</div>';
}
$mainurl = admin_url( 'admin.php?page=wpbot-fb-private-replies&sub=subscriber&fbpage='. $pageId );


//$allsubscribers = $wpdb->get_results("select * from $tableuser where 1 and page_id = '$pageId'");

?>

<div class="qchero_sliders_list_wrapper">
	<div class="sld_menu_title">
		<h2><?php echo esc_html($pageDetails->page_name.' - Subscriber List') ?></h2>
	</div>
	<div class="sld_menu_title">
	<a class="button button-primary" href="<?php echo admin_url( 'admin-post.php?action=import_old_subscriber&pageid='.$pageDetails->page_id ); ?>">Sync Subscribers</a>
	<?php echo ($customPagHTML); ?>
	</div>
	<?php if(!empty($allsubscribers)): ?>
	<div class="qchero_slider_table_area">
		<div class="sld_payment_table">
		
			<div class="sld_payment_row header">

				<div class="sld_payment_cell">
					<?php echo esc_html__( 'ID', 'qc-opd' ) ?>
				</div>
				<div class="sld_payment_cell">
					<?php echo esc_html__( 'Name', 'qc-opd' ) ?>
				</div>

				<div class="sld_payment_cell">
					<?php echo esc_html__( 'Facebook ID', 'qc-opd' ) ?>
				</div>

				<div class="sld_payment_cell">
					<?php echo esc_html__( 'Is Subscriber?', 'qc-opd' ) ?>
				</div>

			</div>
		<?php foreach($allsubscribers as $subscriber): ?>
		<div class="sld_payment_row">

			<div class="sld_payment_cell">
				<div class="sld_responsive_head"><?php echo esc_html__('ID', 'qc-opd') ?></div>
				<?php echo esc_html($subscriber->id); ?>
			</div>
			<div class="sld_payment_cell">
				<div class="sld_responsive_head"><?php echo esc_html__('Name', 'qc-opd') ?></div>
				<?php echo esc_html($subscriber->name); ?>
			</div>
			<div class="sld_payment_cell">
				<div class="sld_responsive_head"><?php echo esc_html__('Facebook ID', 'qc-opd') ?></div>
				<?php echo esc_html($subscriber->subscriber_id); ?>
			</div>
			<div class="sld_payment_cell">
				<div class="sld_responsive_head"><?php echo esc_html__('Is Subscriber?', 'qc-opd') ?></div>
				<?php echo esc_html( $subscriber->is_subscribed == 1 ? 'Yes' : 'No' ); ?>
			</div>
			
		</div>
		<?php endforeach; ?>



	</div>
</div>
<?php else: ?>
<p>No Messenger subscriber found for <?php echo esc_html($pageDetails->page_name); ?>!</p>
<a class="button button-primary" href="<?php echo admin_url( 'admin-post.php?action=import_old_subscriber&pageid='.$pageDetails->page_id ); ?>">Import Old Subscribers</a>
<?php endif; ?>
</div>