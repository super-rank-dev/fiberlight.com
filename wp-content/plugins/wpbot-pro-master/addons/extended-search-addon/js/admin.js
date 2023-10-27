jQuery('.wppt_generate_fuzzy_data').on('click',function(e){
	e.preventDefault();
	
	jQuery.ajax({
		url: wppt_fuse_admin_obj.ajaxurl,
        type: 'post',
        data: {
            'action':'wppt_generate_fuzzy_data'
        },
        beforeSend: function(xhr){
            jQuery('body').after('<div class="qcwbes_spinner_bg"></div>');
            jQuery('#wpbody-content .wrap').before('<div class="qcwbes_spinner spinner qcwbes_visible"></div>');
        },
        success: function( response ) {
            console.log(response);
        },
        complete: function(xhr,status){
            jQuery('.qcwbes_spinner_bg').remove();
            jQuery('.qcwbes_spinner').remove();
        }

	});
});

jQuery('.wppt_nav_container .nav-tab').on('click', function(e){
    e.preventDefault();
    var section_id = jQuery(this).attr('href');
    jQuery('.wppt_nav_container .nav-tab').removeClass('nav-tab-active');
    jQuery(this).addClass('nav-tab-active');
    jQuery('.wppt-settings-section').hide();
    jQuery('.wppt-settings-section').each(function(){
        jQuery(section_id).show();
    });
});
console.log('urlsid')
jQuery('body').on('click','#create_synonms', function(e){
    e.preventDefault();
    var word = jQuery('#syno_words').val();
    var synonyms = jQuery('#synonyms').val();
    jQuery.ajax({
		url: wppt_fuse_admin_obj.ajaxurl,
        type: 'post',
        data: {
            'action':'qcld_create_wpbot_synonymsearch',
            'word':word,
            'synonyms':synonyms,
        },
        success: function( response ) {
            console.log(response);
            location.reload();
        },
        complete: function(){
            jQuery('.qcwbes_spinner_bg').remove();
            jQuery('.qcwbes_spinner').remove();
        }

	});
});

var SynonymsTable= jQuery('#syno_table').DataTable( {
    "paging": true,
    "lengthMenu": [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
    "searchDelay" : 500,
    "ajax": {
        "url" : wppt_fuse_admin_obj.ajaxurl,
        "type" : "post",
        "datatype" : "json",
        "data": {
            action: "qcld_fetch_wpbot_synonymsearch"
        }
    },
    "columns": [
        { "data": "id"},
        { "data": "word"},
        { "data": "synonyms"},
        { "data": "action" },
        // { "data": "delete"},
    ],
});

jQuery('body').on('click','#delete_synonyms',function(e){
    var id = jQuery(this).attr('data-id');
    console.log(id)
    jQuery.ajax({
		url: wppt_fuse_admin_obj.ajaxurl,
        type: 'post',
        data: {
            'action':'qcld_delete_wpbot_synonymsearch',
            'id':id
        },
        success: function( response ) {
            SynonymsTable.ajax.reload();
        }
	});
});

if( document.getElementById("wppt_wrapper_urls") ){
    jQuery(document).ready(function(){
        var maxField = 10; //Input fields increment limitation
        var addButton = jQuery('.add_qcld_rest_url'); //Add button selector
        var wrapper = jQuery('#wppt_wrapper_urls'); //Input field wrapper
        var fieldHTML = '<div><input type="text" name="wppt_rest_api_urls[]" value=""/><a href="javascript:void(0);" class="remove_qcld_rest_url button">Remove Url</a></div>'; //New input field html 
        var x = 1; //Initial field counter is 1
        
        //Once add button is clicked
        jQuery('#wppt_wrapper_urls').on('click','.add_qcld_rest_url',function(){
            console.log('asdas')
            if(x < maxField){ 
                x++; //Increment field counter
                jQuery(wrapper).append(fieldHTML); //Add field html
            }
        });
   
        
        //Once remove button is clicked
        jQuery(wrapper).on('click', '.remove_qcld_rest_url', function(e){
            e.preventDefault();
            jQuery(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });
    });
}
