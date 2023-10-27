jQuery(function($){

	$(document).on('click', '#wl_brand_image', function(e){
		e.preventDefault();
 
    		var button = $(this),
    		    custom_uploader = wp.media({
			title: 'Insert image',
			library : {
				// uncomment the next line if you want to attach image to the current post
				// uploadedTo : wp.media.view.settings.post.id, 
				type : 'image'
			},
			button: {
				text: 'Use this image' // button label text
			},
			multiple: false // for multiple image selection set to true
		}).on('select', function() { // it also has "open" and "close" events 
			var attachment = custom_uploader.state().get('selection').first().toJSON();
			$('.wl_brand_image_container').html('<img class="true_pre_image" src="' + attachment.url + '" style="max-width:200px;display:block;margin-top:10px;" /><button id="wl_remove_image">Remove</button>');
			$('#wpwl_brand_logo').val(attachment.url);
			
			
		})
		.open();
	});
	$(document).on('click', '#wo_brand_image', function(e){
		e.preventDefault();
 
    		var button = $(this),
    		    custom_uploader = wp.media({
			title: 'Insert image',
			library : {
				// uncomment the next line if you want to attach image to the current post
				// uploadedTo : wp.media.view.settings.post.id, 
				type : 'image'
			},
			button: {
				text: 'Use this image' // button label text
			},
			multiple: false // for multiple image selection set to true
		}).on('select', function() { // it also has "open" and "close" events 
			var attachment = custom_uploader.state().get('selection').first().toJSON();
			$('.wo_brand_image_container').html('<img class="true_pre_image" src="' + attachment.url + '" style="max-width:200px;display:block;margin-top:10px;" /><button id="wo_remove_image">Remove</button>');
			$('#wpwo_brand_logo').val(attachment.url);
			
			
		})
		.open();
	});
 
	$(document).on('click', '#wl_remove_image', function(e){
		e.preventDefault();
		$('#wpwl_brand_logo').val('');
		$('.wl_brand_image_container').html('');
		
	})
	$(document).on('click', '#wo_remove_image', function(e){
		e.preventDefault();
		$('#wpwo_brand_logo').val('');
		$('.wo_brand_image_container').html('');
		
	})
	$('.full_content').on('click', '.btn-hide-inmenu', function(e){
		e.preventDefault();
		var hide_status = $('.btn-hide-inmenu').attr('value');
		$.ajax({
			url: ajaxurl,
			type: 'POST',
			data: {
				action: 'hide_from_menu_item',
				menu_status: hide_status
			},
			success: function(data) {
				location.reload()
		 	}
		});
		
	})
 
});