
(function($){
    $(document).on('click','.save_lc_setting',function(){
        var enable_livechat_salone = $('#enable_livechat_salone').prop("checked");
        var enable_floating = $('#enable_livechat_floating').prop("checked");
        var enable_right = $('#lc_right_position').prop("checked");
        var enable_bottom = $('#lc_bottom_position').prop("checked");
        var img_url = $("input[name='agent_icon']:checked").siblings().find('img').attr('src');
        var position_right = $("input[name='position_right']").val();
        var position_bottom = $("input[name='position_bottom']").val();

        jQuery.ajax({
            type : "post",
            dataType : "json",
            url : ajaxurl,
            data : {action: "settings_stand_alone", enable_livechat_salone: enable_livechat_salone,enable_floating : enable_floating, enable_right: enable_right,enable_bottom: enable_bottom,img_url:img_url,position_right:position_right,position_bottom:position_bottom },
            success: function(response) {
                location.reload();
            }
        });
    })
    setTimeout(() => {
        if($(".operator_list").is(":visible")){
            function urlparamsfun(){
                var url = window.location.href;
                var full_url = url.split("&");
                var params = {};
                full_url.forEach(function (p) {
                    var pair = p.split("=").map(decodeURIComponent);
                    if (pair[0].length){
                        params[pair[0]] = pair[1];
                    }
                });
                return params;
            }
            var urlparams = urlparamsfun();
            $.ajax({
                url: wbca_admin_conf.ajaxURL,						
                type: "POST",
                dataType: "JSON",
                data: {
                    dept_id: urlparams.depid,
                    action : wbca_admin_conf.ajaxActions.available_department.action,
                    nonce : wbca_admin_conf.ajaxNonce 
                },
                success: function(data) {
                    let text = "";
                    const operators = Object.values(data.operators);
                    operators.forEach(itemfunction);
                    document.getElementById("bot_available_operator").innerHTML = text;
                    function itemfunction(item) {
                        console.log(item)
                        text += '<tr><td><div>'+item[1]+'</div><a class="ui right floated mini orange button add_to_department" data-operetor='+item[0]+'">Add</a></td></tr>';
                    }
                }
            });
            $.ajax({
                url: wbca_admin_conf.ajaxURL,						
                type: "POST",
                dataType: "JSON",
                data: {
                    dept_id: urlparams.depid,
                    action : wbca_admin_conf.ajaxActions.departmental_oparetor.action,
                    nonce : wbca_admin_conf.ajaxNonce 
                },
                success: function(data) {
                    let text = "";
                    data.operators.forEach(itemfunction);
                    document.getElementById("departmental_operator").innerHTML = text;
                    function itemfunction(item) {
                        text += '<tr><td><div>'+item[1]+'</div><a class="ui right floated mini red button remove_from_department" data-operetor='+item[0]+'">Remove</a></td></tr>';
                    }
                }
            });
        }
        $("#bot_available_operator").on('click','.add_to_department',function(){
            var operetor_id = $(this).attr('data-operetor'); 
            var urlparams = urlparamsfun();
            $.ajax({
                url: wbca_admin_conf.ajaxURL,						
                type: "POST",
                dataType: "JSON",
                data: {
                    dept_id: urlparams.depid,
                    operetor_id: operetor_id,
                    action : wbca_admin_conf.ajaxActions.add_to_department.action,
                    nonce : wbca_admin_conf.ajaxNonce 
                },
                success: function(data) {
                    location.reload();
                }
            });
        });
        $("#departmental_operator").on('click','.remove_from_department',function(){
            var operetor_id = $(this).attr('data-operetor'); 
            var urlparams = urlparamsfun();
            $.ajax({
                url: wbca_admin_conf.ajaxURL,						
                type: "POST",
                dataType: "JSON",
                data: {
                    operetor_id: operetor_id,
                    dept_id: urlparams.depid,
                    action : wbca_admin_conf.ajaxActions.remove_from_department.action,
                    nonce : wbca_admin_conf.ajaxNonce 
                },
                success: function(data) {
                    location.reload();
                }
            });
        });
    }, 500);
    //if($("").is(":visible")){
        $.ajax({
            url: wbca_admin_conf.ajaxURL,						
            type: "POST",
            dataType: "JSON",
            data: {
                client_id: 35,
                action : wbca_admin_conf.ajaxActions.wbca_client_department.action,
                nonce : wbca_admin_conf.ajaxNonce 
            },
            success: function(data) {
                let text = "";
                data.department_list.forEach(itemfunction);
                document.getElementById("bot_department").innerHTML = text;
                function itemfunction(item) {
                    text += '<tr><td><div>'+item.department+'</div><div class="ui right floated mini red button delete_department" data-dept="'+item.id+'">Delete</div><a class="ui right floated mini orange button edit_department" href="'+data.home_url+'/wp-admin/admin.php?page=qcld_operator_manage&depid='+item.id+'">Details</a></td></tr>';
                }
            }
        });
   // }
 
    $(document).on('click','.edit_department', function() {
        var id = $(this).attr('data-dept');
        $.ajax({
            url: wbca_admin_conf.ajaxURL,						
            type: "POST",
            dataType: "JSON",
            data: {
                department_id: id,
                action : wbca_admin_conf.ajaxActions.wbca_delete_department.action,
                nonce : wbca_admin_conf.ajaxNonce 
            },
            success: function(data) {
              //  location.reload();
            }
        });
    });
    $(document).on('click','.delete_department', function() {
        var id = $(this).attr('data-dept');
        $.ajax({
            url: wbca_admin_conf.ajaxURL,						
            type: "POST",
            dataType: "JSON",
            data: {
                department_id: id,
                action : wbca_admin_conf.ajaxActions.wbca_delete_department.action,
                nonce : wbca_admin_conf.ajaxNonce 
            },
            success: function(data) {
                location.reload();
            }
        });
    });
    $(document).on('click','.insert_department', function() {
        var department_name = $("#add_department_field").val();
        $.ajax({
            url: wbca_admin_conf.ajaxURL,						
            type: "POST",
            dataType: "JSON",
            data: {
                department_name: department_name,
                action : wbca_admin_conf.ajaxActions.wbca_insert_department.action,
                nonce : wbca_admin_conf.ajaxNonce 
            },
            success: function(data) {
                location.reload();
            }
        });
    });
    $(document).on('click','.wp_custom_icon_livechat', function() {
        var image = wp.media({
            title: 'Custom Icon',
            // mutiple: true if you want to upload multiple files at once
            multiple: false
        })
        .open()
        .on('select', function(e){
            // This will return the selected image from the Media Uploader, the result is an object
            var uploaded_image = image.state().get('selection').first();
            var image_url = uploaded_image.toJSON().url;
            // Let's assign the url value to the hidden field value and img src.
            $('#wp_custom_icon_livechat_src').html('<img src="'+image_url+'" alt="" width="50" height="50" />');
            $('#wp_chatbot_custom_icon_src').attr('src',image_url);
            $('#wp_custom_icon_livechat').val(image_url);
        });

    });
    
})(jQuery)