jQuery(document).ready(function($){

	function getRandomNumberBetween(min,max){
		return Math.floor(Math.random()*(max-min+1)+min);
	}
	var random_number = 'first';

	$('#wpfb_reload_pages').on('click', function(e){
		e.preventDefault();
		$('.wpfb_pages_loading').html('Loading...');
		$('.wpfb_pages_loading').show();
		$.post(object.ajax_url, {
            action: 'qcwpfb_reload_pages_action', 
			security:object.ajax_nonce
        }, function(data) {
            var json = $.parseJSON(data);
            if(json.status=='success'){
				$('.wpfb_pages_loading').html('Completed successfully!');
				$('.wpfb_pages_content_area').html(json.content);
			}else{
				$('.wpfb_pages_loading').html('Failed - '+ json.reason);
			}
        });
	})

	/*
	$('.qc_fb_view_profile').on('click', function(e){
		e.preventDefault();
		var clicked_item = $(this);
		if( ! clicked_item.find('.spinner').hasClass('is-active') ) {
			clicked_item.find('.spinner').addClass('is-active');
		}

		$.post(object.ajax_url, {
            action: 'qcwpfb_load_profile_link', 
			security:object.ajax_nonce,
			pageid: clicked_item.attr('data-page_id'),
			profile_id: clicked_item.attr('data-profile')
        }, function(data) {
            var json = $.parseJSON(data);
            
			console.log( data );
			

        });

	})
	*/
	
	$('#wpfb_reload_fb_post').on('click', function(e){
		e.preventDefault();
		
		$('.wpfb_posts_load').html('Loading...');
		$('.wpfb_posts_load').show();
		$.post(object.ajax_url, {
            action: 'qcwpfb_reload_posts_action', 
			security:object.ajax_nonce
        }, function(data) {
            var json = $.parseJSON(data);
            if(json.status=='success'){
				$('.wpfb_posts_load').html('Completed successfully!');
				setTimeout(function(){
					
					location.reload();
					
				},800)
			}else{
				$('.wpfb_posts_load').html('Failed - '+ json.reason);
			}
        });
	})

	
	$(document).on('click', '.fb_add_new_condition', function(e){
		e.preventDefault();
		random_number = getRandomNumberBetween(21, 333);
		$(this).parent().find('.fb_condition_container').append( object.private_repeater_html.replace(/placeholder/g, random_number) );
	} )
	$(document).on('click', '.fb_add_new_condition_comment', function(e){
		e.preventDefault();
		random_number = getRandomNumberBetween(21, 333);
		$(this).parent().find('.fb_condition_container').append( object.comment_repeater_html.replace(/placeholder/g, random_number) );
	} )
	
	$(document).on( 'click', '.fb_condition_item_close', function(e) {
		e.preventDefault();
		if( $(this).parent().parent().find('.fb_condition_item').length == 1 ){
			return alert('You need at least one condition.');
		}
		$(this).parent().remove();
	} )
	//console.log(object.repeater_html);
	$(document).on( 'click', '.wpfb_condition_add', function(e){
		e.preventDefault();
		var itemid = $(this).parent().parent().attr('data-itemid');
		$(this).parent().find('.wpfb_logical_container').append('<div class="wpfb_logic_elem"><span>Comment</span><select name="wpfb_condition['+itemid+'][]"><option value="1">is equal to</option><option value="2">contains</option><option value="3">match any</option><option value="4">match all</option><option value="5">if tagged people more than or equal to</option></select><input type="text" value="" name="wpfb_condition_value['+itemid+'][]" /><a class="button button-secondary wpfb_logic_remove">Remove</a><br>Or</div>');
	} );
	
	$(document).on( 'click', '.wpfb_comment_condition_add', function(e){
		e.preventDefault();
		var itemid = $(this).parent().parent().attr('data-itemid');
		$(this).parent().find('.wpfb_logical_container_comment').append('<div class="wpfb_logic_elem"><span>Comment</span><select name="wpfb_comment_condition['+itemid+'][]"><option value="1">is equal to</option><option value="2">contains</option><option value="3">match any</option><option value="4">match all</option><option value="5">if tagged people more than or equal to</option></select><input type="text" value="" name="wpfb_comment_condition_value['+itemid+'][]" /><a class="button button-secondary wpfb_logic_remove">Remove</a><br>Or</div>');
	} );
	
	$(document).on('click', '.wpfb_logic_remove', function(e){
		
		var obj = $(this);
		if($('.wpfb_logic_elem').length > 1){
			obj.closest('.wpfb_logic_elem').remove();
		}else{
			alert('Last element cannot be deleted!');
		}
		
	})

	$(document).on( 'change', 'input:radio[name^="wpfb_private_reply_condition"]', function(){
        if ($(this).is(':checked') && $(this).val() == '0') {
            $(this).parent().find('.wpfb_logical_container').hide();
			$(this).parent().find('.wpfb_condition_add').hide();
        }else{
			$(this).parent().find('.wpfb_logical_container').show();
			$(this).parent().find('.wpfb_condition_add').show();
		}
	} )
	

	$(document).on( 'change', 'input:checkbox[name="wpfb_enable_private_reply"]', function(){
		
        if ($(this).is(':checked') && $(this).val() == 'on') {
            $(this).parent().find('.fb_condition_container').show();
			$(this).parent().find('.fb_add_new_condition').show();
        }else{
			$(this).parent().find('.fb_condition_container').hide();
			$(this).parent().find('.fb_add_new_condition').hide();
		}
	} )

	
	$(document).on( 'change', 'input:radio[name^="wpfb_comment_reply_condition"]', function(){
        if ($(this).is(':checked') && $(this).val() == '0') {
            $(this).parent().find('.wpfb_logical_container_comment').hide();
			$(this).parent().find('.wpfb_comment_condition_add').hide();
        }else{
			$(this).parent().find('.wpfb_logical_container_comment').show();
			$(this).parent().find('.wpfb_comment_condition_add').show();
		}
    });

	$(document).on( 'change', 'input:checkbox[name="wpfb_enable_comment_reply"]', function(){
        if ($(this).is(':checked') && $(this).val() == 'on') {
            $(this).parent().find('.fb_condition_container').show();
			$(this).parent().find('.fb_add_new_condition').show();
        }else{
			$(this).parent().find('.fb_condition_container').hide();
			$(this).parent().find('.fb_add_new_condition').hide();
		}
	} )

	$(document).on( 'change', 'input:checkbox[name="wpfb_enable_built_in_app"]', function(){
        if ($(this).is(':checked') && $(this).val() == 'on') {
            $('.qcld_app_setting').hide();
        }else{
			$('.qcld_app_setting').show();
		}
	} )
	

	$('#qc_fb_get_image_url').on('click', function(e){
		e.preventDefault();
		var title = 'Get BroadCast Image';
		
        var image = wp.media({ 
            title: title,
            // mutiple: true if you want to upload multiple files at once
            multiple: false
        }).open()
        .on('select', function(e){
            // This will return the selected image from the Media Uploader, the result is an object
            var uploaded_image = image.state().get('selection').first();
            var image_url = uploaded_image.toJSON().url;
            
			$('#qc_fb_bc_image').val(image_url);
        });
	})
	
	$('#wpfb_campaign_comment_add').on('click', function(e){
		e.preventDefault();
		var obj = $(this);
		obj.parent().find('.wpfb_comment_text_area').append(`<div class="wpfb_campaign_comment_repeatable">
					<textarea name="wpfb_campaign_comment_text[]"></textarea>
					<a class="button button-secondary" id="wpfb_campaign_comment_remove">remove</a>
				</div>`);
	})
	
	jQuery('.wpfb_campaign_start').datetimepicker();
	jQuery('.wpfb_campaign_end').datetimepicker();
	
	$(document).on('click', '#wpfb_campaign_comment_remove', function(e){
		e.preventDefault();
		var obj = $(this);
		obj.parent().remove();
	})
	
})