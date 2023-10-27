<?php

if(!isset($element['mailer']['sender_name'])){
	$element['mailer']['sender_name'] = __('Chatbot Forms Notification', 'qcformbuilder-forms');
}
if(!isset($element['mailer']['sender_email'])){
	$element['mailer']['sender_email'] = Qcformbuilder_Forms_Email_Fallback::get_fallback( $element );
}
if(!isset($element['mailer']['email_type'])){
	$element['mailer']['email_type'] = 'html';
}
if(!isset($element['mailer']['recipients'])){
	$element['mailer']['recipients'] = '';
}
if(!isset($element['mailer']['email_subject'])){
	$element['mailer']['email_subject'] = $element['name'];
}
if(!isset($element['mailer']['email_message'])){
	$element['mailer']['email_message'] = '{summary}';
}

// backwords-compat
if ( ! empty( $element['mailer']['enable_mailer'] ) ) {
	$element['mailer']['on_insert'] = 1;
}


?>
<div class="mailer-control-panel wrapper-instance-pane">

	<div class="qcformbuilder-config-group">
		<label class="screen-reader-text"><?php esc_html_e('Use The Mailer', 'qcformbuilder-forms'); ?> </label>
		<div class="qcformbuilder-config-field">
			<div style="width:100%;text-align:center;" class="toggle_processor_event">

				<label style="width: 100%;" title="<?php echo esc_attr( __( 'Enable Or Disable Mailer', 'qcformbuilder-forms') ); ?>" class="button button-small <?php if( !empty( $element['mailer']['on_insert'] ) ){ echo 'activated'; } ?>"><input type="checkbox" style="display:none;" value="1" name="config[mailer][on_insert]" <?php if( !empty( $element['mailer']['on_insert'] ) ){ echo 'checked="checked"'; } ?>>
				<span class="is_active" style="width: 100%;<?php if( empty( $element['mailer']['on_insert'] ) ){ ?> display:none;visibility: hidden;<?php } ?>"><?php esc_html_e( 'Disable Mailer', 'qcformbuilder-forms' ); ?></span>
				<span class="not_active" style="width: 100%;<?php if( !empty( $element['mailer']['on_insert'] ) ){ ?> display:none;visibility: hidden;<?php } ?>"><?php esc_html_e( 'Enable Mailer', 'qcformbuilder-forms' ); ?></span>
				</label>
			</div>
		</div>
	</div>

	<div class="mailer_config_panel qcformbuilder-config-processor-notice" style="display:<?php if( empty( $element['mailer']['on_insert'] ) && empty( $element['mailer']['on_insert'] ) ){ ?> block;<?php }else{ ?>none;<?php }?>clear: both; padding: 20px 0px 0px;width:550px;">
		<p style="padding:12px; text-align:center;background:#e7e7e7;" class="description"><?php _e('Mailer is currently disabled', 'qcformbuilder-forms'); ?></p>
	</div>

	<div class="mailer_config_panel qcformbuilder-config-processor-setup" <?php if( empty( $element['mailer']['on_insert'] ) && empty( $element['mailer']['on_insert'] ) ){ echo 'style="display:none;"'; } ?>>
		<div class="qcformbuilder-config-group">
			<label for="wfb-email-from-name">
				<?php  esc_html_e( 'From Name', 'qcformbuilder-forms' ); ?> 
			</label>
			<div class="qcformbuilder-config-field">
				<input type="text" class="field-config" name="config[mailer][sender_name]" value="<?php echo $element['mailer']['sender_name']; ?>" style="width:400px;" id="wfb-email-from-name" aria-describedby="wfb-email-from-name-description" >
				<p class="description" id="wfb-email-from-name-description">
					<?php esc_html_e( 'Name for email sender', 'qcformbuilder-forms'); ?>
				</p>
			</div>
		</div>


        <div class="qcformbuilder-config-group">
            <label for="wfb-email-from-email" class="no-pro-enhanced">
                <?php esc_html_e('From Email', 'qcformbuilder-forms'); ?>
            </label>
            

            <div class="qcformbuilder-config-field">
                <input type="email" class="field-config" name="config[mailer][sender_email]" value="" style="width:400px;" id="wfb-email-from-email" aria-describedby="wfb-email-from-email-description">
                <p class="description no-pro-enhanced" id="wfb-email-from-email-description">
                    <?php esc_html_e( 'Email Address for sender. You can leave it blank for default.', 'qcformbuilder-forms'); ?>                    
                </p>                
            </div>
        </div>


		<div class="qcformbuilder-config-group">
			<label for="wfb-email-recipients">
				<?php esc_html_e('Email Recipients', 'qcformbuilder-forms'); ?> </label>
			<div class="qcformbuilder-config-field">
				<input type="text" class="field-config" name="config[mailer][recipients]" value="<?php echo $element['mailer']['recipients']; ?>" style="width:400px;" id="wfb-email-recipients" aria-describedby="wfb-email-recipients-description" />
				<p class="description" id="wfb-email-recipients-description">
					<?php esc_html_e( 'Who to send email to? Use a comma separated list of email addresses to send to more than one address.', 'qcformbuilder-forms'); ?>
				</p>
			</div>

		</div>
		

		<div class="qcformbuilder-config-group">
			<label for="wfb-email-subject">
				<?php esc_html_e('Email Subject', 'qcformbuilder-forms'); ?>
			</label>
			<div class="qcformbuilder-config-field">
				<input type="text" class="field-config" name="config[mailer][email_subject]" value="<?php echo $element['mailer']['email_subject']; ?>" style="width:400px;" id="wfb-email-subject" aria-describedby="wfb-email-subject-description">
				
			</div>
		</div>


		<?php
		/**
		 * Runs below the mail message field in email notifciation tab
		 *
		 * @since unknown
		 *
		 * @param array $element Form config
		 */
		do_action( 'qcformbuilder_forms_mailer_config', $element );
		?>
		

	</div>
</div>

<?php //Set Different From email and Reply-to text depending on Pro delivery status of the form
    if( qcformbuilder_forms_pro_is_active() === true ) {

        $enhanced_delivery = \qcformbuilderwp\qcformbuilderforms\pro\container::get_instance()->get_settings()->get_enhanced_delivery();

        if( $enhanced_delivery === true ) {

            $send_local = \qcformbuilderwp\qcformbuilderforms\pro\container::get_instance()->get_settings()->get_form( $element['ID'] )->get_send_local();
            ?>
            <script type="text/javascript">
              var cfId = "<?php echo $element['ID'] ?>";
              var $check = jQuery("<input id='wfb-pro-send-local-" + cfId + "' type='checkbox'/>" );
            </script>
            <?php
             if( $send_local === false ) { ?>
                <script type="text/javascript">
                    jQuery($check).prop('checked', false)
                </script>
            <?php } else if ( $send_local === true ) { ?>
                <script type="text/javascript">
                    jQuery($check).prop('checked', true);
                </script>
            <?php } ?>

            <script type="text/javascript">

                jQuery(function ($) {
                  var checkProStatus = function () {
                    if ( $check.prop("checked") === true) {
						$(".pro-enhanced").show().attr('aria-hidden', false);
						$(".no-pro-enhanced").hide().attr('aria-hidden', true);
                    } else {
						$(".pro-enhanced").hide().attr('aria-hidden', true);
						$(".no-pro-enhanced").show().attr('aria-hidden', false);
                    }
                  };

                  jQuery(function ($) {
                      $( 'body' ).on( 'change', $check, function(e) {
                        e.preventDefault();
                        if( $( $check ).prop('checked') !== true ){
                          $($check).prop('checked', true);
                        } else if( $( $check ).prop('checked') !== false ) {
                          $($check).prop('checked', false);
                        }
						checkProStatus();
                      });
                  });

                  $('.qcformbuilder-forms-options-form').on('click', '#tab_mailer', function() {
                    checkProStatus();
                  });

                  checkProStatus();
                });

            </script>

        <?php } else { ?>
            <script type="text/javascript">
              jQuery(".pro-enhanced").hide().attr('aria-hidden', true);
              jQuery(".no-pro-enhanced").show().attr('aria-hidden', false);
            </script>
        <?php }

    } else { ?>

        <script type="text/javascript">
          jQuery(".pro-enhanced").hide().attr('aria-hidden', true);
          jQuery(".no-pro-enhanced").show().attr('aria-hidden', false);
        </script>
    <?php } ?>

<script type="text/javascript">
	
    jQuery('body').on('change', '#mailer_status_select', function(){
        var status = jQuery(this);

        if(status.val() === '0'){
            jQuery('.mailer_config_panel').slideUp(100);
        }else{
            jQuery('.mailer_config_panel').slideDown(100);
        }
    });

</script>






