<?php defined('ABSPATH') or die("No direct script access!");
global $wpdb;
wp_enqueue_style('qc_messenger_chatbot_subscriber_styles', WBFB_URL . '/assets/css/subscriber.css');	

$pageId = sanitize_text_field($_GET['fbpage']);
$pageDetails = qcld_wpbot_fb_page_details($pageId);

$tablebroadcast = $wpdb->prefix.'wpbot_fb_broadcasts';
$allbroadcasts = $wpdb->get_results("select * from $tablebroadcast where 1 and page_id = '$pageId'");

?>

<div class="qchero_sliders_list_wrapper">

	<?php if(!empty($allbroadcasts)): ?>
	<div class="qchero_slider_table_area">
		<div class="sld_payment_table">
		
			<div class="sld_payment_row header">

				<div class="sld_payment_cell">
					<?php echo esc_html__( 'Date', 'qc-opd' ) ?>
				</div>
				<div class="sld_payment_cell">
					<?php echo esc_html__( 'Template', 'qc-opd' ) ?>
				</div>
				<div class="sld_payment_cell">
					<?php echo esc_html__( 'Title', 'qc-opd' ) ?>
				</div>
				
				<div class="sld_payment_cell">
					<?php echo esc_html__( 'Subtitle', 'qc-opd' ) ?>
				</div>
				
				<div class="sld_payment_cell">
					<?php echo esc_html__( 'Image', 'qc-opd' ) ?>
				</div>
				
				<div class="sld_payment_cell">
					<?php echo esc_html__( 'Buttons', 'qc-opd' ) ?>
				</div>

			</div>
		<?php foreach($allbroadcasts as $broadcast): 
		
			$message = unserialize($broadcast->message);
			$template = 'generic';
			if( !empty( $message['template'] ) ) {
				$template = $message['template'];
			}
		?>
		<div class="sld_payment_row">

			<div class="sld_payment_cell">
				<div class="sld_responsive_head"><?php echo esc_html__('Date', 'qc-opd') ?></div>
				<?php echo esc_html($broadcast->date); ?>
			</div>
			<div class="sld_payment_cell">
				<div class="sld_responsive_head"><?php echo esc_html__('Template', 'qc-opd') ?></div>
				<?php echo esc_html($template); ?>
			</div>
			<div class="sld_payment_cell">
				<div class="sld_responsive_head"><?php echo esc_html__('Title', 'qc-opd') ?></div>
				<?php 
					if( $template != 'media' ){
						echo esc_html($message['title']); 
					}
				?>
			</div>
			<div class="sld_payment_cell">
				<div class="sld_responsive_head"><?php echo esc_html__('Subtitle', 'qc-opd') ?></div>
				<?php
					if( $template == 'generic' ){
						echo esc_html($message['subtitle']);
					} elseif( $template == 'product' ) {
						echo esc_html($message['price']);
					}
				?>
			</div>
			
			<div class="sld_payment_cell">
				<div class="sld_responsive_head"><?php echo esc_html__('Image', 'qc-opd') ?></div>
				<?php 
					if( $template !== 'button' ){
					?>
					<img src="<?php echo esc_html($message['image']); ?>" width="80" />
					<?php
					}
				?>
				
			</div>	
			
			<div class="sld_payment_cell">
				<div class="sld_responsive_head"><?php echo esc_html__('Buttons', 'qc-opd') ?></div>
				
				<?php 
					if( $template == 'generic' || $template == 'button' ) {
						if(isset($message['buttons']) && !empty($message['buttons'])){
						
							foreach($message['buttons'] as $key=>$val){
								
								echo '<a href="'.esc_url_raw($val['link']).'" class="button" target="_blank">'.esc_html($val['title']).'</a>';
								
							}
							
						}
					}elseif( $template == 'media' ){
						echo '<a href="'.esc_url_raw($message['button']['link']).'" class="button" target="_blank">'.esc_html($message['button']['title']).'</a>';
					}elseif( $template == 'product' ){
						echo '<a href="'.esc_url_raw($message['link']).'" class="button" target="_blank">Product Link</a>';
					}
					
				?>
				
			</div>
			
		</div>
		<?php endforeach; ?>



	</div>
</div>
<?php else: ?>
<p>No broadcast found for <?php echo esc_html($pageDetails->page_name); ?>!</p>
<?php endif; ?>
</div>