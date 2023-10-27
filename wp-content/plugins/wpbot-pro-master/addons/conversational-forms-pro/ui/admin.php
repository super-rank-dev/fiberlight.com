<?php

// Just some basics.
$per_page_limit = 20;

Qcformbuilder_Forms::check_tables();
// get all forms
$orderby = isset( $_GET[ Qcformbuilder_Forms_Admin::ORDERBY_KEY ] ) && 'name' == $_GET[ Qcformbuilder_Forms_Admin::ORDERBY_KEY ] ? 'name' : false;
$forms = Qcformbuilder_Forms_Forms::get_forms( true, false, $orderby );
$forms = apply_filters( 'qcformbuilder_forms_admin_forms', $forms );

$style_includes = get_option( '_qcformbuilder_forms_styleincludes' );
if(empty($style_includes)){
	$style_includes = array(
		'alert'	=>	true,
		'form'	=>	true,
		'grid'	=>	true,
	);
	update_option( '_qcformbuilder_forms_styleincludes', $style_includes);
}



// create user modal buttons
$modal_new_form = esc_html__('Create Form', 'qcformbuilder-forms').'|{"data-action" : "wfb_create_form", "data-active-class": "disabled", "data-load-class": "disabled", "data-callback": "new_form_redirect", "data-before" : "serialize_modal_form", "data-modal-autoclose" : "new_form" }|right';

?><div class="qcformbuilder-editor-header">

        <ul class="qcformbuilder-editor-header-nav">
            <li class="qcformbuilder-editor-logo">
                <span class="qcformbuilder-forms-name">Chatbot Form Builder</span>
            </li>
            <?php $deprecated = Qcformbuilder_Forms_Admin_PHP::is_version_deprecated( PHP_VERSION );
            if ( ! $deprecated ): ?>
                <li class="qcformbuilder-forms-version">
                    <?php echo WFBCORE_VER; ?>
                </li>
                <li class="qcformbuilder-forms-toolbar-item">
                    <button class="button button-primary ajax-trigger wfb-new-form-button"
                            data-request="start_new_form"
                            data-modal-no-buttons='<?php echo $modal_new_form; ?>'
                            data-modal-width="70%"
                            data-modal-height="80%"
                            data-load-class="none" data-modal="new_form"
                            data-nonce="<?php echo wp_create_nonce('wfb_create_form'); ?>"
                            data-modal-title="<?php esc_attr_e('Create New Form', 'qcformbuilder-forms' ); ?>"
                            data-template="#new-form-tmpl">
                        <?php  esc_html_e('New Form', 'qcformbuilder-forms'); ?>
                    </button>
                </li>
                <li class="qcformbuilder-forms-toolbar-item">
                    <button class="button ajax-trigger"
                            data-request="start_new_form"
                            data-modal-width="400"
                            data-modal-height="270"
                            data-modal-element="div"
                            data-load-class="none"
                            data-modal="import_form"
                            data-template="#import-form-tmpl"
                            data-modal-title="<?php esc_attr_e('Import Form', 'qcformbuilder-forms' ); ?>">
                        <?php  esc_html_e('Import', 'qcformbuilder-forms'); ?>
                    </button>
                </li>
                <li class="qcformbuilder-forms-toolbar-item separator">&nbsp;&nbsp;</li>
                
                <li class="qcformbuilder-forms-toolbar-item" id="wfb-form-order-item">
                    <?php
                    if ('name' === $orderby) {
                        $text = __('Order Forms By ID', 'qcformbuilder-forms');
                        $url = Qcformbuilder_Forms_Admin::main_admin_page_url();
                    } else {
                        $text = __('Order Forms By Name', 'qcformbuilder-forms');
                        $url = Qcformbuilder_Forms_Admin::main_admin_page_url('name');
                    }
                    printf('<a  class="button" id="wfb-form-order" title="%s" href="%s">%s</a>',
                        esc_attr__('Click to change order of the forms', 'qcformbuilder-forms'),
                        esc_url($url),
                        esc_html__($text)
                    );
                    ?>
                </li>
                <li class="qcformbuilder-forms-toolbar-item separator qcformbuilder-forms-hide-when-entry-viewer-closed">&nbsp;&nbsp;</li>
                <li class="qcformbuilder-forms-toolbar-item qcformbuilder-forms-hide-when-entry-viewer-closed" id="qcformbuilder-forms-close-entry-viewer-wrap" style="display: none;visibility: hidden" aria-hidden="true">
                    <?php
                    printf('<button title="%s" class="button" id="qcformbuilder-forms-close-entry-viewer">%s</button>',
                        esc_attr__('Click to close entry Viewer', 'qcformbuilder-forms'),
                        esc_html__('Close Entry Viewer', 'qcformbuilder-forms')
                    );
                    ?>
                </li>
                <?php if (isset($_GET['message_resent'])) { ?>
                    <li class="qcformbuilder-forms-toolbar-item separator">&nbsp;&nbsp;</li>
                    <li class="qcformbuilder-forms-toolbar-item success">
                        <?php esc_html_e('Message Resent', 'qcformbuilder-forms'); ?>
                    </li>
            <?php } ?>
            <?php else : //is deprecated
                echo '<li id="wfb-deprecated-notice-wrap wfb-alert-wrap"><span class="wfb-alert wfb-alert-error">' . Qcformbuilder_Forms_Admin_PHP::get_deprecated_notice() . '</span></li>';
            endif; //php version depreacted ?>
        </ul>

</div>

<div class="form-admin-page-wrap">
	<div id="qcformbuilder-forms-admin-page-left">
		<div class="form-panel-wrap">
	<?php

	// admin notices


	?>
	<div class="wfb-notification" style="display:none;">
		<span class="dashicons dashicons-arrow-down wfb-notice-toggle"></span>
		<span class="dashicons dashicons-arrow-up wfb-notice-toggle" style="display:none;"></span>
		<div class="wfb-notification-notice">
			<span class="dashicons dashicons-warning"></span>
			<span class="wfb-notice-info-line"></span>
		</div>
		<div class="wfb-notification-count"></div>
		<div class="wfb-notification-panel"></div>
	</div>
	<?php if(! empty( $forms ) ){ ?>
		<table class="widefat fixed">
			<thead>
				<tr>
					<th><?php _e('Form', 'qcformbuilder-forms'); ?></th>
					<th style="width:5em; text-align:center;"><?php _e('Entries', 'qcformbuilder-forms'); ?></th>
				</tr>
			</thead>
			<tbody>
		<?php

			global $wpdb;

			$class = "alternate";
			foreach($forms as $form_id=>$form){
				if( !empty( $form['hidden'] ) ){
					continue;
				}

				if(!empty($form['db_support'])){
					$total = 0;
					$totalresults = $wpdb->get_results($wpdb->prepare("SELECT * FROM `" . $wpdb->prefix . "wfb_form_entries` WHERE `form_id` = %s && `status` = 'active';", $form_id));
					if( !empty( $totalresults ) ){
						foreach( $totalresults as $totres ) {
							$fresult = $wpdb->get_results($wpdb->prepare("SELECT * FROM `" . $wpdb->prefix . "wfb_form_entry_values` WHERE `entry_id` = %d;", $totres->id));
							if( !empty( $fresult )){
								$total ++;
							}
						}
					}
					
				}else{
					$total = __('Disabled', 'qcformbuilder-forms');
				}

				?>

				<tr id="<?php  echo esc_attr( trim( 'form_row_' . $form_id ) ); ?>" class="<?php echo $class; ?> form_entry_row">
					<td class="<?php if( !empty( $form['form_draft'] ) ) { echo 'draft-form'; }else{ echo 'active-form'; } ?>">
						<span class="wfb-form-name-preview"><?php esc_html_e( $form[ 'name' ] ); ?></span> 

						<?php if( !empty( $form['debug_mailer'] ) ) { ?>
						<span style="color: rgb(207, 0, 0);" class="description"><?php _e('Mailer Debug enabled.', 'qcformbuilder-forms') ;?></span>
						<?php } ?>

						<div class="row-actions">
						<?php if( empty( $form['_external_form'] ) ){ ?><span class="edit"><a class="form-control" href="<?php echo esc_url( Qcformbuilder_Forms_Admin::form_edit_link( $form_id ) ); ?>"><?php echo __('Edit'); ?></a> | </span>
						<?php } ?>

						<?php if(!empty($form['db_support'])) { ?>
							<span class="edit">
								<?php if (  ! version_compare( PHP_VERSION, '5.3.0', '>=' ) ) {
									echo '<span title="' . esc_attr( sprintf( __( 'Entry viewer is disabled due to your PHP version, see %s', 'qcformbuilder-forms' ), 'https://quantumcloud.com/php?utm_source=wp-admin&utm_keyword=entry_viewer_php_version' ) ) .'" data-toggle="tooltip" data-placement="bottom" class="disabled">' . esc_html__( 'Entries', 'qcformbuilder-forms' ) . '</span> |';
								} else { ?>
									<a class="form-control form-entry-trigger ajax-trigger wfb-entry-viewer-link"
									   href="#entries"
									   data-nonce="<?php echo wp_create_nonce( 'view_entries' ); ?>"
									   data-action="qc_browse_entries"
									   data-target="#form-entries-viewer"
									   data-form="<?php echo esc_attr( trim( $form_id ) ); ?>"
									   data-template="#forms-list-alt-tmpl"
									   data-active-element="<?php echo esc_attr( '#form_row_' . trim( $form_id ) ); ?>"
									   data-load-class="spinner"
									   data-active-class="highlight"
									   data-group="entry_nav"
									   data-callback="setup_pagination"
									   data-status="active"
									   data-page="1"
									><?php esc_html_e( 'Entries', 'qcformbuilder-forms' ); ?></a> | </span><?php }
						}?>
						<input type="hidden" id="form-export-<?php echo $form_id; ?>" value='{ "formslug" : "<?php echo sanitize_title( $form['name'] ); ?>", "formid" : "<?php echo $form_id; ?>", "nonce" : "<?php echo wp_create_nonce( 'wfb_del_frm' ); ?>" }'>
						
						<?php if( empty( $form['_external_form'] ) ){ ?><span class="export">
						<a href="<?php echo esc_attr( admin_url('admin.php?page=qcformbuilder-forms' ) ); ?>&export-form=<?php echo trim( $form_id ); ?>&cal_del=<?php echo wp_create_nonce( 'wfb_del_frm' ); ?>&format=json&form_id=<?php echo sanitize_title( $form['name'] ); ?>" class="form-control qc_export_form_button"><?php esc_html_e('Export', 'qcformbuilder-forms'); ?></a> 
							
						| </span>

						<?php } ?>
						<span><a class="form-control qc_clone_form_button" href="#clone" data-request="start_new_form" data-modal-buttons='<?php echo $modal_new_form; ?>' data-name="<?php echo $form['name']; ?>" data-clone="<?php echo $form_id; ?>" data-modal-width="600" data-modal-height="160" data-load-class="none" data-modal="new_clone" data-nonce="<?php echo esc_attr( wp_create_nonce( 'wfb_create_form' ) ); ?>" data-modal-title="<?php echo __('Clone Form', 'qcformbuilder-forms'); ?>" data-template="#new-form-tmpl"><?php echo __('Clone', 'qcformbuilder-forms'); ?></a><?php if( empty( $form['_external_form'] ) ){ ?> | </span>
						<span class="trash form-delete"><a class="form-control" data-confirm="<?php echo __('This will delete this form permanently. Continue?', 'qcformbuilder-forms'); ?>" href="admin.php?page=qcformbuilder-forms&delete=<?php echo trim( $form_id ); ?>&cal_del=<?php echo wp_create_nonce( 'wfb_del_frm' ); ?>"><?php echo __('Delete'); ?></a></span><?php } ?>


						</div>
					</td>
					<td style="width:4em; text-align:center;" class="<?php echo esc_attr( 'entry_count_' . trim( $form_id ) ); ?><?php echo $form_id; ?>"><?php echo $total; ?></td>
				</tr>


				<?php
				if($class == 'alternate'){
					$class = '';
				}else{
					$class = "alternate";
				}

			}
		?></tbody>
		</table>
		<?php }else{ ?>
		<div id="wfb-you-have-no-forms">
			<p style="margin: 24px;">
				<?php esc_html_e( 'You don\'t have any forms yet.', 'qcformbuilder-forms'); ?>
			</p>

		</div>
		

		<?php } ?>
	</div>
	
	<div class="qc_cfp_help_section">
	
		<h2>How to create a Conversational Form?</h2>

		<p>Creating a Conversational form is easy with the visual form builder. You can get started with a ready template and see how it works. Also, check out the <a href="https://www.youtube.com/watch?v=YUgyyVPKsSo" target="_blank">video tutorial</a> to get started.</p>
	
		<h2>How to add forms as custom intent button in bot window?</h2>
		<p>To add the forms as chatbot intent button in bot window, please go to <b>Chatbot Pro > Settings > Start Menu</b> page. Here all of the created forms will be listed in <b>"Menu List"</b> section. You just have to drag it and drop inside the <b>"Menu area"</b>. If you left the <b>"Menu Area"</b> empty then all intents (including predefined & Custom) buttons will be displayed inside the bot window. You can see the intents button by typing <b>"start"</b> command in bot window.</p>
		<p style="color:red">**After making changes in the settings, please clear browser cache and cookies before reloading the page or open a new Incognito window (Ctrl+Shit+N in chrome).</p>
		
		<h2>What is the Command to trigger the specific form intent in Chatbot?</h2>
		<p>During form creation you have to provide the ChatBot Command for the form. You will find the field under <b>"Form Settings"</b> tab. If you write the command in chatbot window the conversational form will be started.</p>
	</div>
	
	</div>
	<div id="qcformbuilder-forms-admin-page-right">
        <?php if ( 1===7 && ! is_ssl() ): ?>
            <div class="qcformbuilder-forms-clippy-zone warn-clippy">
                <div class="qcformbuilder-forms-clippy-zone-inner-wrap" style="background: white">
                    <div class="qcformbuilder-forms-clippy"
                         style="background-color:white;border-left: 4px solid #dc3232;">
                        <h2>
                            <?php esc_html_e( 'Your Forms Might Be Marked Insecure', 'qcformbuilder-forms' ); ?>
                        </h2>
                        <p>
                            <?php esc_html_e( 'WordPress reports that you are not using SSL. Your forms may be marked insecure by browsers if not loaded using HTTPS.', 'qcformbuilder-forms' ); ?>
                        </p>
                        <a href="https://quantumcloud.com/docs/ssl?utm-source=wp-admin&utm_campaign=clippy&utm_term=support"
                           target="_blank" class="bt-btn btn btn-green" style="width: 80%;margin-left:5%;">
                            <?php esc_html_e( 'Learn More', 'qcformbuilder-forms' ); ?>
                        </a>
                    </div>
                </div>
            </div>
        <?php endif ?>

        <?php //id is "clippy for historical reason
        ///do not change without accounting for other JS and CSS that assumes this id ?>
		<div id="qcformbuilder-forms-clippy">

		</div>
		<?php echo Qcformbuilder_Forms_Entry_Viewer::full_viewer(); ?>

	</div>
</div>

<?php
do_action('qcformbuilder_forms_admin_templates');

global $wp_version;
?>
<script type="text/javascript">

function set_form_state( obj ){
	if( true === obj.data.success ){

		var row = jQuery('#form_row_' + obj.data.data.ID + '>td');
		row.first().attr('class', obj.data.data.state );
		obj.params.trigger.text( obj.data.data.label );

	}
}

function new_form_redirect(obj){
	if(typeof obj.data === 'string'){
		window.location = 'admin.php?page=qcformbuilder-forms&edit=' + obj.data.trim();
	}else{
		alert(obj.data.error);
	}
}

function serialize_modal_form(el){

	var clicked	= jQuery(el),
		data 	= clicked.closest('.baldrick-modal-wrap'),
		name 	= data.find('.new-form-name');

	if( clicked.hasClass( 'wfb-loading-form' ) ){
		return false;
	}
	//verify name is set
	if(name.val().length < 1){
		name.focus().addClass('has-error');
		return false;
	}


	clicked.data('data', data.serialize()).addClass('wfb-loading-form').animate({width: 348}, 200);

	jQuery('.wfb-change-template-button').animate({ marginLeft: -175, opacity: 0 }, 200);

	return true;
}

var wfb_front_end_settings = {};
function update_setting_toggle(obj){
	wfb_front_end_settings = obj.data;
	toggle_front_end_settings();
}
function toggle_front_end_settings(){

	for( var k in wfb_front_end_settings){
		if(wfb_front_end_settings[k] === true){
			jQuery('.setting_toggle_' + k).addClass('active');
		}else{
			jQuery('.setting_toggle_' + k).removeClass('active');
		}
	}
}

function get_front_end_settings( obj ){
	//wfb_front_end_settings
	return wfb_front_end_settings;
}

function extend_fail_notice(el){
	jQuery("#extend_wfb_baldrickModalBody").html('<div class="alert error"><p><?php echo __('Looks like something is not working. Please try again a little later or post to the <a href="http://wordpress.org/support/plugin/qcformbuilder-forms" target="_blank">support forum</a>.', 'qcformbuilder-forms'); ?></p></div>');
}

function start_new_form(obj){
	if( obj.trigger.data('clone') ){
		return {clone: obj.trigger.data('clone') };
	}
	return {};
}

var wfb_build_export;
jQuery( function( $ ){

	wfb_build_export = function( el ){
		var export_object = $('#export_baldrickModal').serialize();
		window.location = "<?php echo esc_attr( admin_url('admin.php?page=qcformbuilder-forms' ) ); ?>&" + export_object;
	};

	var $notices = $('.error,.notice,.notice-error');
	$notices.remove();

	$( document ).on('submit', '#new_form_baldrickModal', function(e){
		e.preventDefault();
		var trigger = $(this).find('button.ajax-trigger');
		trigger.trigger('click');
	});
	
	<?php if( $wp_version >= 5.6  ){ ?>
	/*
	$(document).on('click', '.wfb-create-form-button', function(e){
		e.preventDefault();
		
		var obj = $(this);
		var input = obj.parent().find('.block-input').val();
		if( input != '' ){
			
			var nonce = obj.attr('data-nonce');
			var dataa = 'template='+obj.parent().parent().find('.wfb-template-select').val()+'&name='+input;
			
			var data = {'action': 'wfb_create_form', 'before': 'serialize_modal_form', 'data': dataa, 'callback': 'new_form_redirect', 'loadClass': 'disabled', 'activeClass': 'disabled', 'nonce': nonce, 'modalAutoclose': 'new_form'};
			jQuery.post('<?php echo admin_url('admin-ajax.php'); ?>', data, function (response) {
			   window.location = "<?php echo esc_attr( admin_url('admin.php?page=qcformbuilder-forms' ) ); ?>&edit=" + response;
			});
			
		}else{
			obj.parent().find('.block-input').focus();
		}
		
	})
	*/
	<?php } ?>
	
	$(document).on('click', '.qc_clone_form_button', function(e){
		e.preventDefault();
		var obj = $(this);
		var nonce = obj.attr('data-nonce');
		var clone = obj.attr('data-clone');
		var name = obj.attr('data-name')+' New';
		var data = 'nonce='+nonce+'&name='+ name +'&clone='+clone;
		
		var data = {'action': 'wfb_create_form', 'before': 'serialize_modal_form', 'data': data, 'callback': 'new_form_redirect', 'loadClass': 'disabled', 'activeClass': 'disabled', 'modalAutoclose': 'new_form'};
		$('body').append('<div class="baldrick-backdrop" style="display: block;"></div>');
		jQuery.post('<?php echo admin_url('admin-ajax.php'); ?>', data, function (response) {
		   window.location = "<?php echo esc_attr( admin_url('admin.php?page=qcformbuilder-forms' ) ); ?>&edit=" + response;
		});
		
	})
	
	
	
	var form_toggle_state = false;

	$( document ).on('change', '.wfb-template-select', function(){
		var template = $(this).parent(),
			create = $('.wfb-form-create'),
			name = $('.new-form-name');

		if( create.find('.wfb-loading-form').length ){
			return;
		}
		$('.wfb-template-title').html( template.find('small').html() );
		$('.wfb-form-template.selected').removeClass('selected');
		template.addClass('selected');
		$('.wfb-form-template.selected').animate( {opacity: 1}, 100 );
		//$('.wfb-form-template:not(.selected)').animate( {opacity: 0.6}, 200 );
		// shift siding
		var box = $('.wfb-templates-wrapper');
		var relativeX = box.offset().left - template.offset().left;
		var boxwid = box.offset().left + box.innerWidth();
		var diffwid = template.offset().left + template.innerWidth();
		$('.wfb-form-template').css('overflow', 'hidden').find('.row,small').show();
		template.css('overflow', 'visible').find('.row,small').hide();
		if( boxwid - diffwid > template.outerWidth() ){
			create.css( { left : -2, right: '' } );
		}else{
			create.css( { right : -2, left: '' } );
		}

		create.appendTo(template).attr( 'aria-hidden', 'false' ).css( 'visibility', 'visible' ).fadeIn( 100 );

		name.focus();
	});
	$( document ).on('click', '.wfb-change-template-button', function(){
		$('.wfb-template-select:checked').prop('checked', false);
		$('.wfb-form-template').removeClass('selected');
		//$('.wfb-form-template').animate( {opacity: 1}, 200 );
		$('.wfb-form-create').fadeOut(100, function(){
			$('.wfb-form-template').css('overflow', 'hidden').find('div,small').fadeIn(100);
			$(this).attr( 'aria-hidden', 'true' ).css( 'visibility', 'hidden' );
		})
	});



	//switch in and out of email settings
	var inEmailSettings = false;
	$( '#wfb-email-settings' ).on( 'click', function(e){
		e.preventDefault();
		var $emailSettingsUI = $('#wfb-email-settings-ui'),
			$otherButtons = $('.qcformbuilder-forms-toolbar-item a'),
			$toggles = $('.toggle_option_preview, #render-with-label'),
			$clippy = $('#qcformbuilder-forms-clippy');

		if( inEmailSettings ){
			$( this ).html( '<?php esc_html_e( 'Email Settings', 'qcformbuilder-forms' ); ?>' );
			inEmailSettings = false;
			$otherButtons.removeClass( 'disabled' );
			$emailSettingsUI.hide().attr( 'aria-hidden', 'true' ).css( 'visibility', 'hidden' );
			$toggles.show().attr( 'aria-hidden', 'false' ).css( 'visibility', 'visible' );
			$clippy.show().attr( 'aria-hidden', 'false' ).css( 'visibility', 'visible' );
		}else{
			inEmailSettings = true;
			$( this ).html( '<?php esc_html_e( 'Close Email Settings', 'qcformbuilder-forms' ); ?>' );
			$otherButtons.addClass( 'disabled' );
			$emailSettingsUI.show().attr( 'aria-hidden', 'false' ).css( 'visibility', 'visible' );
			$( this ).html = "<?php esc_html__( 'Email Settings', 'qcformbuilder-forms' ); ?>";
			$clippy.hide().attr( 'aria-hidden', 'true' ).css( 'visibility', 'hidden' );
			$toggles.hide().attr( 'aria-hidden', 'true' ).css( 'visibility', 'hidden' );
		}



	});

	//handle save of email settings
	$( '#wfb-email-settings-save' ).on( 'click', function( e ) {
		e.preventDefault( e );
		var data = {
			nonce: $('#cfemail').val(),
			action: 'wfb_email_save',
			method: $('#wfb-emails-api').val(),
			sendgrid: $('#wfb-emails-sendgrid-key').val()
		};
		var $spinner = $( '#wfb-email-spinner' );
		$spinner.attr( 'aria-hidden', false ).css( 'visibility', 'visible' ).show();

		$.post( ajaxurl, data ).done( function( r ) {
			$spinner.attr( 'aria-hidden', true ).css( 'visibility', 'hidden' ).hide(
				500, function(){
					document.getElementById( 'wfb-email-settings' ).click();
				}
			);
		});

	});




	$(document).on('click', '.wfb-form-shortcode-preview', function(){
		var clicked = $( this ),
			shortcode = clicked.prev(),
			name = shortcode.prev();
		name.hide();
		clicked.hide();
		shortcode.show().focus().select();
	});
	$(document).on('blur', '.wfb-shortcode-preview', function(){
		var clicked = $( this ),
			form = clicked.prev(),
			name = clicked.next();
		clicked.hide();
		form.show();
		name.show();
	})

});
</script>
<style>
#view_entry_baldrickModalFooter .button-primary {
    display: none;
}
</style>
<?php


/**
 * Runs at the bottom of the main Chatbot Form Builder admin page
 *
 * @since unknown
 */
do_action('qcformbuilder_forms_admin_footer');
?>
