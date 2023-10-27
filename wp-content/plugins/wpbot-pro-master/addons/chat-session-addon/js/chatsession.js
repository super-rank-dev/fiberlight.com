jQuery(document).ready(function($){
	"use strict";
	$('#wpbot_checked_all').on('click', function(){
		if($(this).is(':checked')){
			$('.wpbot_sessions_checkbox').prop('checked', true);
		}else{
			$('.wpbot_sessions_checkbox').prop('checked', false);
		}
	})
	
	// $('#wpbot_submit_delcs_form').on('click', function(e){
		// e.preventDefault();
		// $( "#wpcs_form_sessions" ).submit();
	// })
	
	
	// Get the modal
	var modal = document.getElementById("wpcsmyModal");


	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("wpcsclose")[0];

	$('.wpcsmyBtn').on('click', function(e){
		e.preventDefault();
		$('#wpcs_to_email_address').val($(this).attr('data-email'));
		$('#wpcs_show_email').html($(this).attr('data-email'));
		$('#wpcsmyModal').show();
	})

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
	  modal.style.display = "none";
	  $('#wpcs_show_email').html('');
	}

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
	  if (event.target == modal) {
		modal.style.display = "none";
		$('#wpcs_show_email').html('');
	  }
	}
	
	
	jQuery( "#wpcs_email_form" ).submit(function( event ) {	  
	
		event.preventDefault();
		jQuery('#wpcs_email_loading').hide();
		jQuery( "#wpcs_email_status" ).html('');
		var subject = jQuery('#wpcs_email_subject').val();

		var message = jQuery('#wpcs_email_message').val();
		var to = jQuery('#wpcs_to_email_address').val();

		var error = false;

		if(subject==''){
		  alert('please provide the subject');
		  error = true;
		}
		if(message==''){
		  alert('please provide the message content');
		  error = true;
		}

		if(error==false){
			jQuery('#wpcs_email_loading').show();
			
			
			var data = {
			  'to': to,
			  'subject': subject,
			  'message': message,
			}
			$.post(
				ajax_object.ajax_url,
				{
					action : 'wpcs_send_email',
					data: data,
				},
				function(data){
					jQuery('#wpcs_email_loading').hide();
					var json = $.parseJSON(data);
					jQuery( "#wpcs_email_status" ).html(json.message);
					jQuery('#wpcs_email_subject').val('');
					jQuery('#wpcs_email_message').val('');
					jQuery('#wpcs_to_email_address').val('');
					
				}
			);
			
			
		}
	  
	});

	$('#qcld_session_min_interaction').change(function() {
        this.form.submit();
    });

	$('#qcld_session_wp_user').change(function() {
        this.form.submit();
    });

	
	
		$( "#session_s_date" ).datepicker({dateFormat: 'yy-mm-dd'});
		$( "#session_e_date" ).datepicker({dateFormat: 'yy-mm-dd'});
		$('.wpvo_filter_session').on('click','.filter_session_button',function(){
			var session_s_date = $( "#session_s_date" ).val();
			var session_e_date = $( "#session_e_date" ).val();
			$.post(
				ajax_object.ajax_url,
				{
					action : 'qcld_chatbot_session_date_filter',
					start_date: session_s_date,
				 	end_date: session_e_date,
				},
				function(data){
					var datas = JSON.parse(data);
					var sure = "'are you sure'";
					$('.sld_payment_row.body').empty();
					$.each( datas, function( key, value ) {
						var row = '<div class="sld_payment_row body"><div class="sld_payment_cell"><input type="checkbox" name="sessions[]" class="wpbot_sessions_checkbox" value="'+value.id+'"></div><div class="sld_payment_cell">'+value.date+'</div><div class="sld_payment_cell">'+value.interaction+'</div><div class="sld_payment_cell">'+value.session_id+'</div><div class="sld_payment_cell">'+value.name+'</div><div class="sld_payment_cell">'+value.email+'</div><div class="sld_payment_cell">'+value.phone+'</div><div class="sld_payment_cell"><div class="sld_responsive_head">Action</div><a href="http://devel1/wpbot-pro/wp-admin/admin.php?page=wbcs-botsessions-page&amp;userid='+value.id+'" class="button-primary">View Chat</a> <a href="http://devel1/wpbot-pro/wp-admin/admin.php?page=wbcs-botsessions-page&amp;userid='+value.id+'&amp;act=delete" class="button-primary" onclick="return confirm('+sure+')">Delete</a></div></div>';
						$('.sld_payment_table').append(row);
					  });
					
				}
			);
		});
	
})