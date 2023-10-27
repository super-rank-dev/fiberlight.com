(function ($) {
	$(document).ready(function () {
	
		var AdminStoredChat = [];
		var ChatIdStored = [];
		var NotifyUserID = [];
		var ChatCached = "";
		var RequestState1 = true;
		var RequestState2 = true;
		var notifyInterval, showNotifyInterval, chatRefresh;
		var tabsNo = [], oldMsgsNo = {}, newMsgsNo = {}, newMessageInterval;
		
		Array.prototype.remove = function(value){
			if (this.indexOf(value)!== -1) {
				this.splice(this.indexOf(value), 1);
				return true;
			} else {
				return false;
			};
		}
		
		var AdminChat = {
			
			wbcaInit: function () {
				var self = $(this);
				this.eventHandler();
				this.loadChatRow();
				this.submitMessage();
				this.initializeActiveChats();
				this.notificationAtTitle();	
			},
			initTabs: function () {
				$('ul#wbca-chat-tabs').find('li').each(function(i) {
					$(this).on("click", function (event){
						$(this).addClass('wbca-current').siblings().removeClass('wbca-current');
						$('div#wbca-content-wrap').find('div.wbca-chat-box').eq($(this).index()).fadeIn(150).siblings('div.wbca-chat-box').hide();
					});
				});
			},
			eventHandler: function () {
				$("body").on("click", "[data-event]", function (event){
					event.preventDefault();				
					var Event = $(this).attr("data-event");
							
					switch(Event) {		
						case "close-client-window":
							var ClientID = $(this).attr("data-clientid");
							var confirmmsg = 'Are you sure you want to close chat with this client?';
							if(confirm(confirmmsg)){
								AdminChat.closeClientWindow(ClientID);
							}
							
						break;																		
						case "open-register":
							$(".wbca_login_wrap").slideUp("slow");
							$(".open-register").slideUp("slow");
							$(".open-log-in").slideDown("slow");
							$(".wbca_register_wrap").slideDown("slow");							
						break;
						case "open-log-in":
							$(".wbca_register_wrap").slideUp("slow");
							$(".open-log-in").slideUp("slow");
							$(".open-register").slideDown("slow");
							$(".wbca_login_wrap").slideDown("slow");			
						break;
						
						case "register-user":
							AdminChat.registerNewUser();
						break;
						
						case "wbca_add_search":
							AdminChat.addSearchContent();
						break;
						
						case "wbca_edit_form_button":
							var editrowid = $(this).attr("data-wbca-searchid");
							if(editrowid){
								$(".wbca_search_msg").html('');
								AdminChat.editSearchContent(editrowid);
							}else{
								$(".wbca_search_msg").html('<p class="wbca_error">Please select edit item only from right side list.</p>');
							}
						break;
						
						case "wbca_search_query":
							AdminChat.fetchSearchContent($(this).attr("data-clientid"));
						break;
						
						case "send-to-chat-form":
							var tid = $(this).attr("data-titleid");
							var cid = $(this).attr("data-clientid");
							var content = $("#descid_"+tid).html();
							$("#wbca_reply_to_client_"+cid).val(content).focus();
							
							//AdminChat.sendToChatSection();
						break;
						
						case "wbca_edit_search_nav":
							AdminChat.fetchEditSearchContent();
						break;
						
						case "wbca_edit_button_nav":
							if($(this).attr("data-direction") == 'next'){
								AdminChat.fetchEditNavContent($(this).attr("data-direction"), $(this).attr("data-pageid"));
							}else{
								if($(this).attr("data-direction") == 'back' && parseInt($(this).attr("data-pageid")) > 0){
									AdminChat.fetchEditNavContent($(this).attr("data-direction"), $(this).attr("data-pageid"));
								}else{
									alert("You are in the first page.");
								}
								
							}
						break;
						
						case "dashboard-client-tabs":
							var clientchat = $(this).attr('data-wbca-tabid');
							$('.wbca_rigth_sidebar').removeClass('hidden');
							if(clientchat == null){
								$('.wbca_rigth_sidebar').addClass('hidden');
							}
							
							AdminChat.userchathistory(clientchat);
							$(this).addClass('wbca-current').siblings().removeClass('wbca-current');
							$('div#wbca-content-wrap').find('div.wbca-chat-box').eq($(this).index()).fadeIn(150).siblings('div.wbca-chat-box').hide();
							if($(this).hasClass('wbca_client_on')){
								$(this).removeClass('wbca_client_on').addClass('wbca_client_off');
							}
							
						break;
						case "client_date_chat_detail":
							var date = $(this).attr('data-date');
							var id = $(this).attr('data-id');
							AdminChat.btn_chat_detail(id,date);
						break;
						case "expand-wbca-edit-desc":
							var titleid = $(this).parent().attr('data-titleid');
							var state = $('#descid_'+titleid).attr('data-desc-state');
							
							if(state == "0"){
								$(this).html("<span>&and;</span>");
								$('#descid_'+titleid).slideDown(200);
								$('#descid_'+titleid).attr("data-desc-state", "1")
							}else{
								$(this).html("<span>&or;</span>");
								$('#descid_'+titleid).slideUp(200);
								$('#descid_'+titleid).attr("data-desc-state", "0")
							}
						break;
						case "send-to-edit-form":
							var title_id = $(this).parent().attr('data-titleid');
							var title = $(this).html();
							var desc = $("#descid_"+title_id).html();
							$("#wbca_edit_search_question").val(title);
							$("#wbca_edit_search_answer").html(desc);
							$("#wbca_edit_form_button").attr("data-wbca-searchid",title_id);
						break;
						case "wbca-delete-chat-row":	
							var rowid = $(this).parent().attr('data-titleid');
							var loading = '<i class="wbca_spinnerx16 wbca_delete"></i>';
							var alert_msg = 'Do you really want to delete this from database?';
							if(confirm(alert_msg)){
								AdminChat.DeleteSearchRow(rowid);
							}
						break;	
						case "wbca_transfer_operator":
							var c_id = $(this).attr('data-clientid');
							var c_name = $(this).attr('data-clientname');
							var o_id = $('#wbca_selected_operator_'+c_id).val();
							var o_name = $('#wbca_selected_operator_'+c_id+' option:selected').text();
							AdminChat.transferChatOperator(c_id, o_id, c_name, o_name);
						break;	
						
						case "transferred-help-request":
							var t_cid = $(this).attr('data-clientid');
							var t_id = $(this).parent().parent().attr('data-chatid');
							AdminChat.fetchTransferredClientMsg(t_cid, t_id);
						break;
						
						case "wbca-sq-select":
							var ClientID = $(this).attr('data-clientid');
							var clicked = $(this);
							var Container = $("[data-location=\"wbca-body-" + ClientID + "\"]");
							$(Container).find('.wbca_select_sq').each(function() {
								if($(this).not(clicked).hasClass('wbca_selected_sq')){
									$(this).removeClass('wbca_selected_sq');
								}
							});
							if($(this).hasClass('wbca_selected_sq')){
								$(this).removeClass('wbca_selected_sq');
							}else{
								$(this).addClass('wbca_selected_sq');
							}
							
						break;		
					}
				});
			},
			
			closeClientWindow: function(clientid){
				var ClientID = clientid;
				$("#wbca-chat-tabs [data-wbca-tabid=\"" + ClientID + "\"]").remove();
				$("#client-window-id-" + ClientID ).remove();
				console.log(clientid)
				if($("#wbca-chat-tabs li:nth-child(2)").length > 0){
					$("#wbca-chat-tabs li:nth-child(2)").addClass('wbca-current').siblings().removeClass('wbca-current');
					$('div#wbca-content-wrap').find('div.wbca-chat-box').eq($("#wbca-chat-tabs li:nth-child(2)").index()).fadeIn(150).siblings('div.wbca-chat-box').hide();
					
				}else{
					$("#wbca-chat-tabs li:nth-child(1)").addClass('wbca-current').siblings().removeClass('wbca-current');
					$('div#wbca-content-wrap').find('div.wbca-chat-box').eq($("#wbca-chat-tabs li:nth-child(1)").index()).fadeIn(150).siblings('div.wbca-chat-box').hide();
				}
				
				$.ajax({
					url: wbca_admin_conf.ajaxURL,						
					type: "POST",
					dataType: "JSON",
					data: { 
						messagecontent: 'This chat has been closed by the operator', 
						clientid: ClientID,
						action : wbca_admin_conf.ajaxActions.wbca_admin_submit_message.action,
						nonce : wbca_admin_conf.ajaxNonce
					 }
				
				});						
				AdminStoredChat.remove(ClientID);
				$.ajax({
					url: wbca_admin_conf.ajaxURL,						
					type: "POST",
					dataType: "JSON",
					data: { 
						rm_clientid: ClientID, 
						action : wbca_admin_conf.ajaxActions.wbca_remove_admin_active_chat.action,
						nonce : wbca_admin_conf.ajaxNonce
					 },
					success: function(data) { }
				});
			},
			notificationNewChat: function(){
				var notifyInterval1, showNotifyInterval1;
				var timer=0, newtitle1 = [], oldtitle = document.title;
				newtitle1.push(oldtitle);
				if(wp_livechat_obj != 1){
					console.log(wp_livechat_obj)
					var audioplayer = document.getElementById("wbca_alert");
					var playedPromise = audioplayer.play();
					if (playedPromise) {
						playedPromise.then(() => {
							console.log(stopAttempt);
							clearInterval(stopAttempt)
					 	}).catch(e=>{
							console.log('' + e);
					  	})
					}
				}
				var hidden, visibilityChange; 
				if (typeof document.hidden !== "undefined") { // Opera 12.10 and Firefox 18 and later support 
				  hidden = "hidden";
				  visibilityChange = "visibilitychange";
				} else if (typeof document.msHidden !== "undefined") {
				  hidden = "msHidden";
				  visibilityChange = "msvisibilitychange";
				} else if (typeof document.webkitHidden !== "undefined") {
				  hidden = "webkitHidden";
				  visibilityChange = "webkitvisibilitychange";
				}
				var videoElement = document.getElementById("videoElement");
				function handleVisibilityChange(){
				  if (document[hidden]) {
					notifyInterval1 = setInterval(function(){
						var nchatno = {}, ntitle;							
						$(".wbca_client_on").each(function(i, element) {
							var tabid = $(this).attr('data-wbca-tabid'),
							ntitle =  'New message from '+$('#client-window-id-'+tabid).attr('data-clientname');
							newtitle1.push(ntitle);
							
						});
					}, 2000);
						
					showNotifyInterval1 = setInterval(function(){
						if(newtitle1.length > 1){
							document.title = newtitle1[timer];
							timer++
							if (timer >= newtitle1.length){
								timer=0;
							}
						//	audioplayer.play();
						}
					}, 3000);
					
				  } else {
					clearInterval(notifyInterval1);
					clearInterval(showNotifyInterval1);
					document.title = oldtitle;
					newtitle1 = [];
					newtitle1.push(oldtitle);
					
					//audioplayer.pause();
					//audioplayer.play();
				  }
				}

				// Warn if the browser doesn't support addEventListener or the Page Visibility API
				if (typeof document.addEventListener === "undefined" || hidden === undefined) {
				  console.log("This demo requires a browser, such as Google Chrome or Firefox, that supports the Page Visibility API.");
				}
				document.addEventListener(visibilityChange, handleVisibilityChange, false);
			},
			DeleteSearchRow: function(rowid){
				var dbutton = $("#docid_"+rowid+" button.wbca-delete-chat-row");
				dbutton.append('<i class="wbca_spinnerx16 wbca_delete"></i>');
				$(dbutton).prop('disabled', true);
				$.ajax({
					url: wbca_admin_conf.ajaxURL,						
					type: "POST",
					dataType: "JSON",
					data: { 
						search_rowid: rowid, 
						action : wbca_admin_conf.ajaxActions.wbca_delete_search_row.action,
						nonce : wbca_admin_conf.ajaxNonce
					 },
					success: function(data) { 
						if(data.is_delete == "0"){
							alert("Database Error: Please try again.");
							$("#docid_"+data.delete_id+" button.wbca-delete-chat-row i").remove();
							$("#docid_"+rowid+" button.wbca-delete-chat-row").prop('disabled', false);
						}else{
							$("#docid_"+data.delete_id).remove();
							$("#docid_"+rowid+" button.wbca-delete-chat-row").prop('disabled', false);
							if($("#wbca_edit_search").attr("data-wbca-searchid") == data.delete_id){
								$("#wbca_edit_form input").val('');
								$("#wbca_edit_form textarea").html('');
								$("#wbca_edit_search").attr("data-wbca-searchid", "")
							}
						}
					},
					complete: function() { 
						
					}
				});
			},
			setActiveChat: function(ClientID, ClientName, ClientEmail, avatar){
				
				$.ajax({
					url: wbca_admin_conf.ajaxURL,						
					type: "POST",
					dataType: "JSON",
					data: { 
						ac_clientid: ClientID, 
						ac_clientname: ClientName,
						ac_clientemail: ClientEmail, 
						ac_avatar: avatar,
						action : wbca_admin_conf.ajaxActions.wbca_set_admin_active_chat.action,
						nonce : wbca_admin_conf.ajaxNonce
					 },
					success: function(data) { },
					complete: function() { }
				});
			},
			
			loadChatRow: function () {
				if(RequestState1 == true) {
					RequestState1 = false;
					
					$.ajax({
						url: wbca_admin_conf.ajaxURL,						
						type: "POST",
						dataType: "JSON",
						data: { 
							action : wbca_admin_conf.ajaxActions.wbca_load_admin_chat.action,
							nonce : wbca_admin_conf.ajaxNonce
						 },
						success: function (data){
							var clientdata = data.wbca_clientinfo;
							var chatdata = data.wbca_chatinfo;
							
							var searchdata = data.wbca_searchinfo;
							
							var cdata = data.wbca_activeclient;
							var all_activesession = data.wbca_all_activesession;
							var count_active = 0;
							$.each( all_activesession, function( key, value ) {	
								
								if( (value[0] != null)){
									count_active = Object.keys(value[0]).length+ count_active;
								} 
								
							});
							
								if(count_active >0){
									jQuery('.qct_no_client_msg').remove();
									jQuery('#wpca_active_client_count').html(count_active + ' Active Users Currently!')
								}
						
								
							jQuery.each(clientdata, function(i, object) {
								var ClientID = i;
								var ClientName = object.clientname;
								var ClientEmail = object.clientemail;
								var ClientUserName = object.clientusername;
								var avatar = object.avatar;
								if($("#client-window-id-"+ClientID).length > 0){
									//Do nothing
								}else{
									AdminChat.createChatWindow(ClientID, ClientName, ClientEmail, avatar);
								}
							});
							
							
							jQuery.each(chatdata, function(i, object) {
								var chatID = i;								
								var senderID = object.senderid;
								var receiverID = object.receiverid;
								var message = object.message;
								var chatTime = object.chat_time;
								var buzzer = object.buzzer;
								if(buzzer == 0){
									AdminChat.notificationNewChat();
									$.ajax({
										url: wbca_admin_conf.ajaxURL,						
										type: "POST",
										dataType: "JSON",
										data: { 
											action : wbca_admin_conf.ajaxActions.wbca_update_notification_status.action,
											nonce : wbca_admin_conf.ajaxNonce,
											chatID : i,	
										 },
										success: function (data){
	
										}
									})
								}
								if(chatTime == '0000-00-00 00:00:00'){
									currwntTime = new Date();
									chatTime = currwntTime.getFullYear()+'-'+currwntTime.getMonth()+'-'+currwntTime.getDate()+' '+currwntTime.getHours()+':'+currwntTime.getMinutes()+':'+currwntTime.getSeconds();
								}
								var Container = $("[data-location=\"wbca-body-" + senderID + "\"]");
														
								var ChatContent = '<div class="wbca_client_message_row wbca_message_row wbca-clear"><div class="wbcaMessage leftMessage ui floating message"><div data-chatid="'+chatID+'" class="wbcaContent wbcaMessageLocation-'+senderID+'"><span class="wbca_msg_span">'+message+'</span></div></div></div><div class="date-operator">'+ chatTime +'</div>';
							
								$(Container).append(ChatContent);
								
								$(Container).scrollTop($(Container).prop("scrollHeight"));
							});
							
							jQuery.each(searchdata, function(i, object) {
								var SearchContent = '';
								var clientID = i;
								var msgID = object.chatid;
								var docID = object.docid;
								var docTitle = object.doctitle;
								var docDesc = object.docdesc;
								
								SearchContent += '<div class="wbca_auto_chat_div" id="docid_'+docID+'">';
									SearchContent += '<div class="wbca-clear" data-titleid="'+docID+'">';
									SearchContent += '<b class="wbca_auto_title" data-clientid="'+clientID+'" data-titleid="'+docID+'" data-event="send-to-chat-form">'+docTitle+'</b>';
									SearchContent += '<button class="expand-wbca-edit-desc" data-event="expand-wbca-edit-desc"><span>&or;</span></button>';
									SearchContent += '</div>';
									SearchContent += '<div class="wbca_edit_desc" id="descid_'+docID+'" data-desc-state="0">';
									SearchContent += docDesc;
									SearchContent += '</div>';
								SearchContent += '</div>';
								$("#wbcaSearchBody_"+clientID).prepend(SearchContent);
							});	
							$('#wpca_active_client').empty();
							jQuery.each(all_activesession,function(k,v){
								var operator_name = '<li class="item">'+k+'</li>';
								jQuery.each(v[0],function(key,value){
									var item_active = '<li data-event="dashboard-client-tabs" class="item wbca_client_on" data-wbca-tabid="'+value.WINDOWID+'"><img class="ui avatar image" src="'+value.AVATAR+'"><div class="content"><div class="header">'+value.USERNAME+' Assined to  '+ k +' </div><div class="description">'+value.CLIENTEMAIL+'</div></div></li>';
									$('#wpca_active_client').append(item_active);
									value
								});
							});
						},
						complete: function() {
							chatRefresh = setTimeout(AdminChat.loadChatRow, wbca_admin_conf.chatRate);
							RequestState1 = true;
							
						}
					});
				}
			},

			createChatWindow: function (ClientID, ClientName, ClientEmail, avatar){
								
				var operator = '';
				
				$("#wbca_select_operator_id li").each(function(index, element) {
                    var opid = $(this).attr('data-operatorid');
					var opname = $(this).attr('data-operatorname');
					operator +='<option value="'+opid+'">'+opname+'</option>';
                });
				
				var chatWindow = '', clientTab = '';
					chatWindow += '<div id="client-window-id-'+ClientID+'" data-clientname="'+ClientName+'" class="wbcaWindow wbca-chat-box">';
						chatWindow += '<div class="clientHeader wbca-clear" data-parameter-window-id="'+ClientID+'">';
							chatWindow += '<div class="wbcaUser ui equal width grid">';
								chatWindow += '<div class="wbcaUserName column">';
									chatWindow += '<img class="floated mini ui image" src="'+avatar+'" />';
									chatWindow += '<div class="header">'+ClientName+'</div><div class="meta">'+ClientEmail+'</div>';
								chatWindow += '</div>';
								
								chatWindow += '<div class="column"><div class="wbcaOperatorList " id="wbcaOperatorList_'+ClientID+'">';
									chatWindow += '<i title="Close" data-event="close-client-window" data-clientid="'+ClientID+'" class="wbca_close right floated">&times;</i>';
									chatWindow += '<form class="wbca_operator_list_form right floated" method="post" action="">';
									chatWindow += '<select name="wbca_selected_operator_id" id="wbca_selected_operator_'+ClientID+'">';
									chatWindow += operator;
									chatWindow += '</select>';
									chatWindow += '<button class="wbca_button" id="wbca_transfer_operator_'+ClientID+'" type="submit" data-event="wbca_transfer_operator" data-clientid="'+ClientID+'" data-clientname="'+ClientName+'" name="wbca_transfer_button">Transfer</button>';
					
									chatWindow += '</form>';
									
								chatWindow += '</div></div>';
								
								
							chatWindow += '</div>';
						chatWindow += '</div>';
						chatWindow += '<div class="wbca-chat-items">';
							chatWindow += '<div class="wbcaChatBody" data-location="wbca-body-'+ClientID+'">';
							chatWindow += '</div>';
							chatWindow += '<div class="wbcaFooter">';
								chatWindow += '<textarea id="wbca_reply_to_client_'+ClientID+'" data-event="reply-to-client" placeholder="Start chat" data-clientid="'+ClientID+'" ></textarea>';
							chatWindow += '</div>';
						chatWindow += '</div>';
						
					chatWindow += '</div>';
					
					//clientTab += '<li data-event="dashboard-client-tabs" class="wbca_client_on" data-wbca-tabid="'+ClientID+'">'+ClientName+'</li>';
					clientTab += '<li data-event="dashboard-client-tabs" class="item wbca_client_on" data-wbca-tabid="'+ClientID+'"><img class="ui avatar image" src="'+avatar+'" /><div class="content"><div class="header">'+ClientName+'</div><div class="description">'+ClientEmail+'</div></div></li>';
				if($('#client-window-id-'+ClientID).length > 0){
					// do nothing
				}else{
					$("#wbca-content-wrap").append(chatWindow);
					$("#wbca-chat-tabs").append(clientTab);
					
					AdminChat.notificationNewChat();
					if($.inArray(ClientID, AdminStoredChat) == -1) {
						AdminStoredChat.push(ClientID);
						AdminChat.setActiveChat(ClientID, ClientName, ClientEmail, avatar);
					}
				}
				
			},
			
			submitMessage: function () {
				$("body").on("keyup", "[data-event=\"reply-to-client\"]", function (e) {
					if(e.keyCode == 13) {
						var d = new Date();
						var n = d.getTime();
						var Message = $.trim($(this).val());
						var ClientID = $(this).attr("data-clientid");
						var dateTime = d.getFullYear()+'-'+( d.getMonth() + 1)+'-'+d.getDate()+' '+ d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
						var Container = $("[data-location=\"wbca-body-" + ClientID + "\"]");
						var msg = '<div class="wbca_admin_message_row wbca_message_row wbca-clear"><div class="wbcaMessage rightMessage ui floating message"><div class="wbcaContent">'+Message+'</div></div></div><div class="date-user">'+ dateTime +'</div>';
						//var msg = '<div class="wbca_admin_message_row wbca_message_row wbca-clear"><div class="wbcaMessage rightMessage ui floating blue message"><div class="wbcaContent">'+Message+'</div><div class="ui list right aligned"><span>'+dateTime+'</span></div></div></div>';
						
						if($(Container).find('.wbca_selected_sq').length > 0){
							var question = $(Container).find('.wbca_selected_sq').siblings('span').html();
						}else{
							var question = '';
						}
						
						if(Message.length > 0) {
							$(Container).append(msg);
							$(Container).scrollTop($(Container).prop("scrollHeight"));
							$.ajax({
								url: wbca_admin_conf.ajaxURL,						
								type: "POST",
								dataType: "JSON",
								data: { 
									messagecontent: Message, 
									clientid: ClientID,
									question: question,
									action : wbca_admin_conf.ajaxActions.wbca_admin_submit_message.action,
									nonce : wbca_admin_conf.ajaxNonce
								 },
								success: function(data) {
									//AdminChat.loadChatRow();
									
								},
								complete: function(){
									$(Container).find('.wbca_select_sq').each(function() {
										if($(this).hasClass('wbca_selected_sq')){
											$(this).removeClass('wbca_selected_sq');
										}
									});
								}
							});
						}
						$(this).val("");
					}
				});
			},
			
			transferChatOperator: function (cid, oid, c_name, o_name) {
				var Message = '<a href="" data-clientid="'+cid+'" data-event="transferred-help-request">'+c_name+'</a> needs your help. Please help this client.';
				$('#wbca_transfer_operator_'+cid).append('<i class="wbca_spinnerx16 wbca_btn_spin"></i>');
				$('#wbca_transfer_operator_'+cid).prop('disabled', true);
				$.ajax({
					url: wbca_admin_conf.ajaxURL,						
					type: "POST",
					dataType: "JSON",
					data: { 
						wbca_message: Message, 
						wbca_clientid: cid,
						wbca_operatorid: oid, 
						action : wbca_admin_conf.ajaxActions.wbca_admin_chat_transfer.action,
						nonce : wbca_admin_conf.ajaxNonce
					 },
					success: function(data) {
						if(data.wbca_submit){
							var ClientID = data.wbca_clientid;
							AdminChat.closeClientWindow(ClientID);
							WBCA_BOX.box.show({html:'Operator transferred successfully!',animate:false,close:false,mask:true,boxid:'wbca_box_success',autohide:4, height: 'auto'})
						}else{
							//alert("Chat transfer failed. Please try again.");
							WBCA_BOX.box.show({html:'Chat transfer failed. Please try again.',animate:false,close:false,mask:true,boxid:'wbca_box_error',autohide:4, height: 'auto'})
						}	
						$('#wbca_transfer_operator_'+data.wbca_clientid+' i').remove();
						$('#wbca_transfer_operator_'+data.wbca_clientid).prop('disabled', false);					
					},
					complete: function(){
						
					}
				});
			},
			
			fetchTransferredClientMsg: function (t_cid, t_id) {
				var tid = $('[data-chatid="' + t_id + '"]');
				$(tid).prepend('<i class="wbca_spinnerx16 wbca_left_spin"></i>');
				$.ajax({
					url: wbca_admin_conf.ajaxURL,						
					type: "POST",
					dataType: "JSON",
					data: { 
						wbca_clientid: t_cid,
						wbca_chatid: t_id, 
						action : wbca_admin_conf.ajaxActions.wbca_fetch_transferred_client_msg.action,
						nonce : wbca_admin_conf.ajaxNonce
					 },
					success: function(data) {
						var t_id = data.wbca_chatid;
						var t_mrow = data.wbca_msg_row;
						if(data.is_result == "1"){
							$.each(t_mrow, function(i, object) {
								var chatID = i;								
								var senderID = object.senderid;
								var receiverID = object.receiverid;
								var message = object.message;
								var chatTime = object.chat_time;
								
								var Container = $("[data-location=\"wbca-body-" + senderID + "\"]");
																
								var ChatContent = '<div class="wbca_client_message_row wbca_message_row wbca-clear"><div class="wbcaMessage leftMessage ui floating violet message"><div  data-chatid="'+chatID+'" class="wbcaContent wbcaMessageLocation-'+senderID+'"><span class="wbca_msg_span">'+message+'</span><span data-event="wbca-sq-select" data-clientid="'+senderID+'" class="wbca_select_sq">&nbsp;</span></div></div></div>';
								
								$(Container).append(ChatContent);
								$(Container).scrollTop($(Container).prop("scrollHeight"));
							});
						}else{
							WBCA_BOX.box.show({html:'No Result found.',animate:false,close:false,mask:true,boxid:'wbca_box_error',autohide:4, height: 'auto'})
						}
						$('[data-chatid="' + t_id + '"]').find('i').remove();
					},
					complete: function(){
						
					}
				});
			},
			
			addSearchContent: function(){
				$('#wbca_add_search').append('<i class="wbca_spinnerx16 wbca_btn_spin"></i>');
				$('#wbca_add_search').prop('disabled', true);
				var error = false,
					wbca_question = $('#wbca_search_question').val(),
					wbca_answer = $('#wbca_search_answer').val();
				if(!wbca_question){
					$('#wbca_search_question').css('border-color','#ff0000');
					error = true;
				}
				if(!wbca_answer){
					$('#wbca_search_answer').css('border-color','#ff0000');
					error = true;
				}
				if(!error){
					$(".wbca_search_msg").html('<div class="wbcaBodyLoading"></div>');
					$.ajax({
						url: wbca_admin_conf.ajaxURL,
						type: "POST",
						dataType: "JSON",
						data:{
							action : wbca_admin_conf.ajaxActions.wbca_add_search_content.action,
							nonce : wbca_admin_conf.ajaxNonce,
							wbca_search_question : wbca_question,
							wbca_search_answer : wbca_answer
						},
						success: function(data) {
							if(data.is_search_added == "1"){
								//WBCA_BOX.box.show({html:'Content added successfully',animate:false,close:false,mask:true,boxid:'wbca_box_success',autohide:4, height: 'auto'})
								$(".wbca_search_msg").html('<p class="wbca_success">Content added successfully</p>');
								$('#wbca_search_question').val(''),
								$('#wbca_search_answer').val('');
							}else{
								//WBCA_BOX.box.show({html:'Database error: Please try again.',animate:false,close:false,mask:true,boxid:'wbca_box_error',autohide:4, height: 'auto'})
								$(".wbca_search_msg").html('<p class="wbca_error">Database error: Please try again.</p>');
							}
						},
						complete: function() {
							$('#wbca_add_search i').remove();
							$('#wbca_add_search').prop('disabled', false);
						}
					});
				}else{
					$('#wbca_add_search i').remove();
					$('#wbca_add_search').prop('disabled', false);
				}
			},
			
			editSearchContent: function(editrowid){
				$('#wbca_edit_form_button').append('<i class="wbca_spinnerx16 wbca_btn_spin"></i>');
				$('#wbca_edit_form_button').prop('disabled', true);
				var error = false,
					question = $('#wbca_edit_search_question').val(),
					answer = $('#wbca_edit_search_answer').html();
				
				if(!question){
					$('#wbca_edit_search_question').css('border-color','#ff0000');
					error = true;
				}
				if(!answer){
					$('#wbca_edit_search_answer').css('border-color','#ff0000');
					error = true;
				}
				
				if(!error){
					$.ajax({
						url: wbca_admin_conf.ajaxURL,
						type: "POST",
						dataType: "JSON",
						data:{
							action : wbca_admin_conf.ajaxActions.wbca_edit_search_content.action,
							nonce : wbca_admin_conf.ajaxNonce,
							wbca_edit_search_question : question,
							wbca_edit_search_answer : answer,
							wbca_edit_doc_id : editrowid,
							wbca_edit_search : true,
						},
						success: function(data) {
							if(data.is_search_updated == "1"){
								$(".wbca_search_msg").html('<p class="wbca_success">Content edited successfully</p>');
								var newr = '';
								newr += '<li id="docid_'+data.new_row_id+'">';
									newr += '<div class="wbca-clear" data-titleid="'+data.new_row_id+'">';
									newr += '<b class="wbca_edit_title" data-event="send-to-edit-form">'+$('#wbca_edit_search_question').val()+'</b>';
									newr += '<button class="wbca-delete-chat-row" data-event="wbca-delete-chat-row"><span>&times;</span></button>';
									newr += '<button class="expand-wbca-edit-desc" data-event="expand-wbca-edit-desc"><span>&or;</span></button>';
									newr += '</div>';
									newr += '<div class="wbca_edit_desc" id="descid_'+data.new_row_id+'" data-desc-state="0">';
									newr += $('#wbca_edit_search_answer').html();
									newr += '</div>';
								newr += '</li>';
								$('#wbca_edit_chat_row').prepend(newr);
								$('#docid_'+data.old_row_id).remove();
								$('#wbca_edit_search_question').val('');
								$('#wbca_edit_search_answer').val('');
								$('#wbca_edit_form_button').attr("data-wbca-searchid", '');
							}else{
								$(".wbca_search_msg").html('<p class="wbca_error">Database error: Please try again.</p>');
							}
						},
						complete: function() {
							$('#wbca_edit_form_button i').remove();
							$('#wbca_edit_form_button').prop('disabled', false);
						}
					});
				}else{
					$('#wbca_edit_form_button i').remove();
					$('#wbca_edit_form_button').prop('disabled', false);
				}
			},
			
			fetchSearchContent: function(cid){
				var search_value = $("#wbca_search_form_"+cid+" input[type=text]").val();
				var ClientID = cid;
				
				if(search_value) {
					$('#wbca_search_button_'+cid).append('<i class="wbca_spinnerx16 wbca_btn_spin"></i>');
					$('#wbca_search_button_'+cid).prop('disabled', true);
					$.ajax({
						url: wbca_admin_conf.ajaxURL,						
						type: "POST",
						dataType: "JSON",
						data: { 
							wbca_search_query: search_value, 
							wbca_search_id: ClientID,
							action : wbca_admin_conf.ajaxActions.wbca_search_content.action,
							nonce : wbca_admin_conf.ajaxNonce
						 },
						success: function(data) {
							//AdminChat.loadChatRow();
							var search_body = $('#wbcaSearchBody_'+data.wbca_search_id);
							if(data.is_search_found == "1"){
								//search_body.append(data.wbca_mispelled_data);
								search_body.append(data.total_search_result);
								search_body.append(data.wbca_search_data);
							}else{
								search_body.html("No match found");
							}
							$("#wbca_search_form_"+cid+" input[type=text]").val('');
							$('#wbca_search_button_'+data.wbca_search_id).prop('disabled', false);
							$('#wbca_search_button_'+data.wbca_search_id+' i').remove();
						}
					});
				}
			},
			
			fetchEditSearchContent: function(){
				var search_value = $("#wbca_edit_search_form input[type=text]").val();
				
				if(search_value) {
					$('#wbca_edit_search_button').append('<i class="wbca_spinnerx16 wbca_btn_spin"></i>');
					$('#wbca_edit_search_button').prop('disabled', true);
					$.ajax({
						url: wbca_admin_conf.ajaxURL,						
						type: "POST",
						dataType: "JSON",
						data: { 
							wbca_edit_nav_query: search_value, 
							action : wbca_admin_conf.ajaxActions.wbca_edit_search_nav.action,
							nonce : wbca_admin_conf.ajaxNonce
						 },
						success: function(data) {
							//AdminChat.loadChatRow();
							var search_body = $('#wbca_edit_row_container');
							if(data.is_search_found == "1"){
								//search_body.append(data.wbca_mispelled_data);
								//search_body.html(data.total_search_result);
								search_body.html(data.wbca_search_data);
							}else{
								search_body.html("No match found");
							}
							$('#wbca_edit_row_footer').html('');
							$("#wbca_edit_search_form input[type=text]").val('');
							$('#wbca_edit_search_button').prop('disabled', false);
							$('#wbca_edit_search_button i').remove();
						}
					});
				}
			},
			
			fetchEditNavContent: function(direction, page_id){
				
				$('#wbca_edit_nav_'+direction).append('<i class="wbca_spinnerx16 wbca_btn_spin"></i>');
				$('#wbca_edit_nav_'+direction).prop('disabled', true);
				$.ajax({
					url: wbca_admin_conf.ajaxURL,						
					type: "POST",
					dataType: "JSON",
					data: { 
						wbca_edit_nav_dir: direction, 
						wbca_edit_page_id: page_id,
						action : wbca_admin_conf.ajaxActions.wbca_edit_nav_button.action,
						nonce : wbca_admin_conf.ajaxNonce
					 },
					success: function(data) {
						//AdminChat.loadChatRow();
						var search_body = $('#wbca_edit_row_container');
						if(data.is_row_found == "1"){
							//search_body.append(data.wbca_mispelled_data);
							//search_body.html(data.total_search_result);
							search_body.html(data.wbca_nav_data);
							var nid = $('#wbca_edit_nav_next').attr('data-pageid');
							var bid = $('#wbca_edit_nav_back').attr('data-pageid');
							
							if(data.wbca_direction == 'next'){
								$('#wbca_edit_nav_next').attr('data-pageid', (parseInt(nid)+1));
								$('#wbca_edit_nav_back').attr('data-pageid', (parseInt(bid)+1));
							}else{
								if(parseInt(bid) > 0){
									$('#wbca_edit_nav_next').attr('data-pageid', (parseInt(nid)-1));
									$('#wbca_edit_nav_back').attr('data-pageid', (parseInt(bid)-1));
								}
							}
							
						}else{
							search_body.html("No match found");
							$('#wbca_edit_row_footer').html('');
						}
						$('#wbca_edit_nav_'+data.wbca_direction).prop('disabled', false);
						$('#wbca_edit_nav_'+data.wbca_direction+' i').remove();
					}
				});
			},
			userchathistory: function(cid){
				document.getElementById('user_history').innerHTML = '';
			
				$.ajax({
					url: wbca_admin_conf.ajaxURL,						
					type: "POST",
					dataType: "JSON",
					data: {
						client_id: cid,
						action : wbca_admin_conf.ajaxActions.wbca_client_chat_history.action,
						nonce : wbca_admin_conf.ajaxNonce
					 },
					success: function(data) {
						let text = "";
						console.log(data)
						data.Message_history.forEach(itemfunction);
						document.getElementById("user_history").innerHTML = text;
						function itemfunction(item) {
							if(item.has_attachment == 1){
								text += '<div class="item"><div class="right floated content"><div class="ui button teal" data-event="client_date_chat_detail" data-id="'+cid+'" data-date="'+item.date+'"><span class="dashicons dashicons-paperclip"></span>Details</div></div><div class="content">'+item.date+'</div></div>';
							}else{
								text += '<div class="item"><div class="right floated content"><div class="ui button teal" data-event="client_date_chat_detail" data-id="'+cid+'" data-date="'+item.date+'">Details</div></div><div class="content">'+item.date+'</div></div>';
							}
						}
						
					}
				});
				$.ajax({
					url: wbca_admin_conf.ajaxURL,						
					type: "POST",
					dataType: "JSON",
					data: {
						client_id: cid,
						action : wbca_admin_conf.ajaxActions.wbca_client_personal_info.action,
						nonce : wbca_admin_conf.ajaxNonce
					 },
					success: function(data) {
						let text = "";
						data.Message_history.forEach(itemfunction);
						document.getElementById("bot_personal_info").innerHTML = text;
						function itemfunction(item) {
							text += '<div class="item"><div class="content"> <b>Browser: </b>'+ item.browser +'</br></br> <b>OS:</b> '+item.os_name+'</br></br><b>Language:</b> '+item.lang+'</br></br><b>RESOLUTION: </b>' +item.screen_resolution+'</br></br><b>TIME ZONE: </b>' +item.time_zone+'</br></br><b>USER AGENT: </b>'+item.userAgent+'</br></br><b>IP Address:</b> '+item.ipadd+'</br></br>  <b>Start Page:</b> '+item.page_url+'</br></br> <b>Is phone:</b> '+item.is_phone+'</div></div>';
						}
						
					}
				});
				
				if($('#bot_session_history').is(':visible')){
					$.ajax({
						url: wbca_admin_conf.ajaxURL,						
						type: "POST",
						dataType: "JSON",
						data: {
							client_id: cid,
							action : wbca_admin_conf.ajaxActions.wbca_client_session_history.action,
							nonce : wbca_admin_conf.ajaxNonce
						 },
						success: function(data) {
							let text = "";
							data.session_history.forEach(itemfunction);
							document.getElementById("session_history").innerHTML = text;
							function itemfunction(item) {
								text += '<div class="item"><div class="right floated content"><a class="ui button teal" target="_blank" href="'+data.url+'admin.php?page=wbcs-botsessions-page&amp;userid='+item.id+'">Details</a></div><div class="left floated content">'+item.date+'</div><p></p></div>';
							}
							if(data.session_history.length == 0){
								document.getElementById("session_history").innerHTML = "No session history found";
							}
							
						}
					})
				}
			},
			btn_chat_detail: function(sender_id,chat_date){
				
				$.ajax({
					url: wbca_admin_conf.ajaxURL,						
					type: "POST",
					dataType: "JSON",
					data: { 
						senderID: sender_id,
						chat_date: chat_date,
						action : wbca_admin_conf.ajaxActions.wbca_load_client_admin_chat.action,
						nonce : wbca_admin_conf.ajaxNonce
					 },
					success: function(data) {
						var clientdata = data.allmessages;
						$.each(clientdata, function(i, object) {
							var ClientID = i;
							var chatContent = object;
							var Container = $("[data-location=\"wbca-body-" + i + "\"]");
							$(Container).empty();
							$(Container).prepend(chatContent);
							$(Container).scrollTop($(Container).prop("scrollHeight"));
						});
						
					}
					
				});
			},			
			initializeActiveChats: function () {
				
				$.ajax({
					url: wbca_admin_conf.ajaxURL,						
					type: "POST",
					dataType: "JSON",
					data: { 
						action : wbca_admin_conf.ajaxActions.wbca_load_admin_active_chat.action,
						nonce : wbca_admin_conf.ajaxNonce
					 },
					success: function(data) {
						var clientdata = data.AdminStoredChat;
						var keys = Object.keys(clientdata);
						if(keys.length>0){
							jQuery('.qct_no_client_msg').remove();
							jQuery('#wpca_active_client_count').html(keys.length+ ' Active Users Currently!')
						}
						$.each(clientdata, function(i, object) {
							var ClientID = clientdata[i].WINDOWID;
							var ClientName = clientdata[i].USERNAME;
							var ClientEmail = clientdata[i].CLIENTEMAIL;
							var avatar = clientdata[i].AVATAR;
							
							AdminChat.createChatWindow(ClientID, ClientName, ClientEmail, avatar);
							
							$.ajax({
								url: wbca_admin_conf.ajaxURL,						
								type: "POST",
								dataType: "JSON",
								data: { 
									senderID: ClientID,
									action : wbca_admin_conf.ajaxActions.wbca_load_all_admin_chat.action,
									nonce : wbca_admin_conf.ajaxNonce
								 },
								success: function(data) {
									var clientdata = data.allmessages;
									$.each(clientdata, function(i, object) {
										var ClientID = i;
										var chatContent = object;
										var Container = $("[data-location=\"wbca-body-" + i + "\"]");
										$(Container).prepend(chatContent);
										$(Container).scrollTop($(Container).prop("scrollHeight"));
									});
									
								}
								
							});
						});
					}
				});
			},		
			notificationAtTitle : function(){
				var timer=0, newtitle = [], oldtitle = document.title;
				newtitle.push(oldtitle);
				var vis = (function(){
					var stateKey, eventKey, keys = {
						hidden: "visibilitychange",
						webkitHidden: "webkitvisibilitychange",
						mozHidden: "mozvisibilitychange",
						msHidden: "msvisibilitychange"
					};
					for (stateKey in keys) {
						if (stateKey in document) {
							eventKey = keys[stateKey];
							break;
						}
					}
					return function(c) {
						if (c) document.addEventListener(eventKey, c);
						return !document[stateKey];
					}
				})();
				vis(function(){
					var boxname = [], chatno = {};
					var audioplayer = document.getElementById("wbca_alert");
					$(".wbcaWindow").each(function(i, element) {
						var id = $(this).attr('id');
						chatno[id] = $(this).find('.wbca_message_row').length;
					});
					
					if(!vis()){
						
						notifyInterval = setInterval(function(){ 
							var nchatno = {}, ntitle;							
							$(".wbcaWindow").each(function(i, element) {
								var nid = $(this).attr('id'),
									ntitle =  'New message from '+$(this).attr('data-clientname');
									
								nchatno[nid] = $(this).find('.wbca_message_row').length;
								
								if(nchatno[nid] > chatno[nid] && $.inArray(ntitle, newtitle) == -1){
									newtitle.push(ntitle);
								}
							});
						}, 2000);
						
						showNotifyInterval = setInterval(function(){ 
							if(newtitle.length > 1){
								document.title = newtitle[timer];
								timer++
								if (timer >= newtitle.length){
									timer=0;
								}
							//	audioplayer.play();
							}
						}, 3000);
						
					}else{
						
						clearInterval(notifyInterval);
						clearInterval(showNotifyInterval);
						document.title = oldtitle;
						newtitle = [];
						newtitle.push(oldtitle);
						audioplayer.pause();
					}
					
				});
				
				newMessageInterval  = setInterval(function(){ 
					$("#wbca-chat-tabs li:not(:first)").each(function(){
						var cid = $(this).attr('data-wbca-tabid');
						newMsgsNo[cid] = $("[data-location=\"wbca-body-" + cid + "\"]").children().length;
						
						if(newMsgsNo[cid] > oldMsgsNo[cid] ){
							if(!$(this).hasClass('wbca-current') && $(this).hasClass('wbca_client_off')){
								$(this).removeClass('wbca_client_off').addClass('wbca_client_on');
							}
							
						}
						oldMsgsNo[cid] = $("[data-location=\"wbca-body-" + cid + "\"]").children().length;
					})
					
				}, 3500);
			},
			
			
		}

		jQuery('body').on('click','.button-online',function(e){
			e.preventDefault();
			var btn_text = $('.button-online').attr('data-online');
			var user_id = $('.button-online').attr('data-user');
			$.ajax({
				url: wbca_admin_conf.ajaxURL,						
				type: "POST",
				dataType: "JSON",
				data: { 
					online_satuts: btn_text,
					user_id: user_id,
					action : wbca_admin_conf.ajaxActions.wbca_go_operator_offline.action,
					nonce : wbca_admin_conf.ajaxNonce
				},
				success: function(data) { 
						if(data.online_status == 'offline'){
							var messagecontent = 'the operator goes ' +  data.online_status;
							var clients = document.getElementsByClassName('wbca_client_on');
							$.each( clients, function( key, value ) {
								var ClientID = $(this).attr('data-wbca-tabid');
								if((ClientID == 'online') || (ClientID == 'online')){

								}else{
									$.ajax({
										url: wbca_admin_conf.ajaxURL,						
										type: "POST",
										dataType: "JSON",
										data: { 
											messagecontent: messagecontent, 
											clientid: ClientID,
											userid:user_id,
											action : wbca_admin_conf.ajaxActions.wbca_admin_submit_message.action,
											nonce : wbca_admin_conf.ajaxNonce
										}
									
									});

								}
								
							})
						}
						//attributes
					setTimeout(() => {		
						location.reload();
					}, 1000);
				}
			});
		})
		
			
			//	alert('Please go offline before you leave')
		
			var firecount = 0;
			document.addEventListener("mouseout", function() {
				let e = event, t = e.relatedTarget || e.toElement
				if(  $.cookie("offline_msg") != 'yes'){
					if(firecount < 1){
						if (!t || t.nodeName == "HTML") {
							var btn_text = $('.button-online').attr('data-online');
							if(btn_text == 'offline'){
								firecount = firecount + 1;
								Swal.fire({
									title: 'Are you sure?',
									text: "Please go offline if you are not attending the Live chat",
									showCancelButton: true,
									confirmButtonColor: '#3085d6',
									cancelButtonColor: '#d33',
									confirmButtonText: 'Go, Offline'
								}).then((result) => {
									if (result.isConfirmed) {
										var user_id = $('.button-online').attr('data-user');
										$.ajax({
											url: wbca_admin_conf.ajaxURL,						
											type: "POST",
											dataType: "JSON",
											data: { 
												online_satuts: 'offline',
												user_id: user_id,
												action : wbca_admin_conf.ajaxActions.wbca_go_operator_offline.action,
												nonce : wbca_admin_conf.ajaxNonce
											},
											success: function(data) { 
												var date = new Date();
												date.setTime(date.getTime() +  60 * 60 * 1000);
												$.cookie('offline_msg', 'yes', {
													expires: date
												});
												location.reload();
											}
										});
									}
									if(result.isDismissed){
										var date = new Date();
										date.setTime(date.getTime() +  60 * 60 * 1000);
										$.cookie('offline_msg', 'yes', {
											expires: date
										});
									}
									
								})
							}
						}
					}
				}
			});
			
		
			function ConfirmLeave() {
				return "";
			}
			var prevKey="";
			$(document).keydown(function (e) {
				if (e.key.toUpperCase() == "W" && prevKey == "CONTROL") {                
					window.onbeforeunload = ConfirmLeave;   
				}
			});
		AdminChat.wbcaInit();
		
	});
	
	
	


	
	
}(jQuery));

