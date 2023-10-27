
(function ($) {
	$(document).ready(function () {
		var ClientChatStored = [];
		var ChatIdStored = [];
		var NotifyUserID = [];
		var ChatCached = "";
		var RequestState1 = true;
		var RequestState2 = true;
		var notifyInterval, showNotifyInterval, chatRefresh;
		
		/*
		Array.prototype.remove = function(value){
			
			if (this.indexOf(value)!== -1) {
				this.splice(this.indexOf(value), 1);
				return true;
			} else {
				return false;
			}
		}
		*/
		
		var AjaxChat = {
			
			wbcaInit: function () {
				var self = $(this);
				this.LoadChatWindow();
				this.eventHandler();
				this.submitMessage();
				this.submitFile();
				this.notificationAtTitle();	
				this.resizewindow();
			},
						
			registerNewUser: function () {
				var error = false,
					fullName = $('#wbca_signup_fullname').val(),
					selected_department = $('.livechat-select-department').val(),		
					email = $('#wbca_signup_email').val();
					
				if(!fullName){
					$('#wbca_signup_fullname').css('border-color','#ff0000');
					error = true;
				}
				if(!email){
					$('#wbca_signup_email').css('border-color','#ff0000');
					error = true;
				}
				var e=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
				if(!e.test(email)){
					$('#wbca_signup_email').css('border-color','#ff0000');
					error = true;
				}
				if(!error){
				//	$('#wbca_signup_submit').append('<i class="wbca_spinnerx16 wbca_btn_spin"></i>');
					$('#wbca_signup_submit').prop('disabled', true);
				
					$.ajax({
						url: wbca_conf.ajaxURL,
						type: "POST",
						dataType: "JSON",
						data:{
							action : wbca_conf.ajaxActions.wbca_register_user.action,
							nonce : wbca_conf.ajaxNonce,
							wbca_signup_email : email,
							wbca_signup_fullname : fullName,
							selected_department: selected_department,
						},
						success: function(data) {
							var chatbox = $(data.wbca_chatbox),
								ClientID = data.wbca_userid;
							
							if($.inArray(ClientID, ClientChatStored) == -1){
								ClientChatStored.push(ClientID);
								AjaxChat.setActiveChat(ClientID);
							}
							/*$('.wbcaTitle span:first-child').after('<span class="chatCloseIcon" data-clientid="'+ClientID+'" data-event="close-chat-window">&times;</span>');*/	
							

							var maincontainerheight = (jQuery('.'+wbca_conf.mainContainer).height() - 30);

							chatbox.find('.wbcaBody').css( "height", maincontainerheight+"px" );
							chatbox.find('#wbca_chat_body').css( "height", (maincontainerheight-63)+"px" );
							
							
							$('.wbcaBody').html(chatbox.html())
							.delay(500, "steps")
							.queue("steps", function(next) {
								$('#wbca_chat_body').prepend('<div id="wbca_type_suggest"><p>'+wbca_conf.chatType+'</p></div>');
								$('#wbca_type_suggest').slideToggle('slow');
								next();
							})
							.delay(50000, "steps")
							.queue("steps", function(next) {
								$('#wbca_type_suggest').slideToggle('slow');
								next();
							})
							.dequeue( "steps" ); 

						},
						complete: function() {
						}
					});
				}
			},
			
			offlineMessage: function () {
				var error = false,
					name = $('#wbca_message_fullname').val(),
					email = $('#wbca_message_email').val(),
					message = $('#wbca_message').val();
				
				if(!name){
					$('#wbca_message_fullname').css('border-color','#ff0000');
					error = true;
				}
				if(!email){
					$('#wbca_message_email').css('border-color','#ff0000');
					error = true;
				}
				var e=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
				if(!e.test(email)){
					$('#wbca_message_email').css('border-color','#ff0000');
					error = true;
				}
				if(!message){
					$('#wbca_message').css('border-color','#ff0000');
					error = true;
				}
				if(!error){
					$('#wbca_message_submit').append('<i class="wbca_spinnerx16 wbca_btn_spin"></i>');
					$('#wbca_message_submit').prop('disabled', true);
					$.ajax({
						url: wbca_conf.ajaxURL,
						type: "POST",
						dataType: "JSON",
						data:{
							action : wbca_conf.ajaxActions.wbca_offline_message.action,
							nonce : wbca_conf.ajaxNonce,
							wbca_message_fullname : name,
							wbca_message_email : email,
							wbca_message : message
						},
						success: function(data) {
							var msg = data.wbca_msg;
							if(data.error == false){
								$('#wbca_message_fullname').val('');
								$('#wbca_message_email').val('');
								$('#wbca_message').val('');
							}	
							$('#wbca_msg_notify').html(msg).slideToggle('slow')
							.delay(4000, "steps")
							.queue("steps", function(next) {
								$('#wbca_msg_notify').slideToggle('slow');
								next();
							})
							.dequeue( "steps" ); 
							
							$('#wbca_message_submit i').remove();
							$('#wbca_message_submit').prop('disabled', false);
						},
						complete: function() {
							
						}
					});
				}
			},
			
			LoadChatWindow: function () {
				$.ajax({
					url: wbca_conf.ajaxURL,
					type: "POST",
					dataType: "JSON",
					data: { 
						action : wbca_conf.ajaxActions.wbca_load_wbca_window.action,
						nonce : wbca_conf.ajaxNonce
					 },
					success: function(data) {
						//alert('I am here');
						var bodydata = $(data.wbca_window),
							session = data.wbca_session;
						var title = data.title;
						var maincontainerheight = (jQuery('.'+wbca_conf.mainContainer).height() - 30);
						//bodydata.find('#wbca_chat_body').css( "height", maincontainerheight+"px" );
						bodydata.find('.wbcaBody').css( "height", maincontainerheight+"px" );
						bodydata.find('#wbca_chat_body').css( "height", (maincontainerheight-63)+"px" );
						$("."+wbca_conf.mainContainer).append(bodydata.html());
						//$("#wpbot-live-chat-header").append(' - '+title);
						if(session == 1){
							AjaxChat.initializeActiveChats();
						}
					},
					complete: function() {
						chatRefresh = setTimeout(AjaxChat.loadChatRow, wbca_conf.chatRate);
						RequestState1 = true;
						
					}
				});
				
			},
						
			eventHandler: function () {

				$(document).on("submit",'#wbca_signup_form', function (e) {
					e.preventDefault();
					AjaxChat.registerNewUser();
					return false;
				})

				$("body").on("click", "button[data-event]", function (event){
					//event.preventDefault();				
					var Event = $(this).attr("data-event");
					
					switch(Event) {						
						case "close-chat-window":
							var clientID = $(this).attr("data-clientid");
							ClientChatStored.remove(clientID);	
							$("#wbca_chat_body").html('');					
							$.ajax({
								url: wbca_conf.ajaxURL,						
								type: "POST",
								dataType: "JSON",
								data: { 
									cr_clientid: clientID, 
									action : wbca_conf.ajaxActions.wbca_remove_active_chat.action,
									nonce : wbca_conf.ajaxNonce
								 },
								success: function(data) { }
							});
						break;
												
						case "open-chat-window":
							if(wbca_conf.chatStyle == 'style_1'){
								var holder = $("#wbcaChatWindow").attr("data-window-state");
								if(holder=="0"){
									$("#wbcaChatWindow").slideDown("slow");
									$(".listOpenIcon").html("&or;");
									$("#wbcaChatWindow").attr("data-window-state", "1");
									$(".wbcaBodyHolder").attr("data-window-state", "1");
								}else{
									$("#wbcaChatWindow").slideUp("slow");
									$(".listOpenIcon").html("&and;");
									$("#wbcaChatWindow").attr("data-window-state", "0");
									$(".wbcaBodyHolder").attr("data-window-state", "0");
								}
							}else{
								if($(window).width() < 768){
									var holder = $("#wbcaChatWindow").attr("data-window-state");
									if(holder=="0"){
										$("#wbcaChatWindow").slideDown("slow");
										$(".listOpenIcon").html("&or;");
										$("#wbcaChatWindow").attr("data-window-state", "1");
										$(".wbcaBodyHolder").attr("data-window-state", "1");
									}else{
										$("#wbcaChatWindow").slideUp("slow");
										$(".listOpenIcon").html("&and;");
										$("#wbcaChatWindow").attr("data-window-state", "0");
										$(".wbcaBodyHolder").attr("data-window-state", "0");
									}
								}else{
									var holder = $(".wbcaBodyHolder").attr("data-window-state");
									if(holder=="0"){
										$(".wbcaBodyHolder").slideDown("slow");
										$(".listOpenIcon").html("&or;");
										$("#wbcaChatWindow").attr("data-window-state", "1");
										$(".wbcaBodyHolder").attr("data-window-state", "1");
									}else{
										$(".wbcaBodyHolder").slideUp("slow");
										$(".listOpenIcon").html("&and;");
										$("#wbcaChatWindow").attr("data-window-state", "0");
										$(".wbcaBodyHolder").attr("data-window-state", "0");
									}
								}
								
							}							
						break;
						
						case "open-mobile-chat-window":
							var holder = $("#wbcaChatWindow").attr("data-window-state");
							if(holder=="0"){
								$("#wbcaChatWindow").slideDown("slow");
								$(".listOpenIcon").html("&or;");
								$("#wbcaChatWindow").attr("data-window-state", "1");
								$(".wbcaBodyHolder").attr("data-window-state", "1");
							}else{
								$("#wbcaChatWindow").slideUp("slow");
								$(".listOpenIcon").html("&and;");
								$("#wbcaChatWindow").attr("data-window-state", "0");
								$(".wbcaBodyHolder").attr("data-window-state", "0");
							}
							
						break;
						
						case "offline-message":
							AjaxChat.offlineMessage();
						break;
												
					}
				});
				
			},
			
			setActiveChat: function(ClientID){
				var nVer = navigator.appVersion;
				var nAgt = navigator.userAgent;
				var browserName  = navigator.appName;
				var nameOffset,verOffset,ix;
				// In Opera, the true version is after "Opera" or after "Version"
				if ((verOffset=nAgt.indexOf("Opera"))!=-1) {
				browserName = "Opera";
				fullVersion = nAgt.substring(verOffset+6);
				if ((verOffset=nAgt.indexOf("Version"))!=-1) 
				fullVersion = nAgt.substring(verOffset+8);
				}
				// In MSIE, the true version is after "MSIE" in userAgent
				else if ((verOffset=nAgt.indexOf("MSIE"))!=-1) {
				browserName = "Microsoft Internet Explorer";
				fullVersion = nAgt.substring(verOffset+5);
				}
				// In Chrome, the true version is after "Chrome" 
				else if ((verOffset=nAgt.indexOf("Chrome"))!=-1) {
				browserName = "Chrome";
				fullVersion = nAgt.substring(verOffset+7);
				}
				// In Safari, the true version is after "Safari" or after "Version" 
				else if ((verOffset=nAgt.indexOf("Safari"))!=-1) {
				browserName = "Safari";
				fullVersion = nAgt.substring(verOffset+7);
				if ((verOffset=nAgt.indexOf("Version"))!=-1) 
				fullVersion = nAgt.substring(verOffset+8);
				}
				// In Firefox, the true version is after "Firefox" 
				else if ((verOffset=nAgt.indexOf("Firefox"))!=-1) {
				browserName = "Firefox";
				fullVersion = nAgt.substring(verOffset+8);
				}
				// In most other browsers, "name/version" is at the end of userAgent 
				else if ( (nameOffset=nAgt.lastIndexOf(' ')+1) < 
						(verOffset=nAgt.lastIndexOf('/')) ) 
				{
				browserName = nAgt.substring(nameOffset,verOffset);
				fullVersion = nAgt.substring(verOffset+1);
				if (browserName.toLowerCase()==browserName.toUpperCase()) {
				browserName = navigator.appName;
				}
				}
				
			
				{
				var OSName = "Unknown OS";
				if (navigator.userAgent.indexOf("Win") != -1) OSName = "Windows";
				if (navigator.userAgent.indexOf("Mac") != -1) OSName = "Macintosh";
				if (navigator.userAgent.indexOf("Linux") != -1) OSName = "Linux";
				if (navigator.userAgent.indexOf("Android") != -1) OSName = "Android";
				if (navigator.userAgent.indexOf("like Mac") != -1) OSName = "iOS";
				}
				$.ajax({
					url: wbca_conf.ajaxURL,						
					type: "POST",
					dataType: "JSON",
					data: { 
						cw_clientid: ClientID, 
						tz: Intl.DateTimeFormat().resolvedOptions().timeZone,
						OSName: OSName,
						browserName: browserName,
						location: window.location.href,
						userAgent: navigator.userAgent,
						screen_resolution : window.screen.width * window.devicePixelRatio + ' : ' + window.screen.height * window.devicePixelRatio,
						action : wbca_conf.ajaxActions.wbca_set_active_chat.action,
						nonce : wbca_conf.ajaxNonce
					 },
					success: function(data) { },
					complete: function() {
						RequestState5 = true;
					}
				});
			},
			
			loadChatRow: function () {
				
				if(RequestState1 == true) {
					RequestState1 = false;
					var ClientID = $("#wbca_chat_body").attr("data-clientid");
					$.ajax({
						url: wbca_conf.ajaxURL,						
						type: "POST",
						dataType: "JSON",
						data: { 
							action : wbca_conf.ajaxActions.wbca_load_client_chat.action,
							nonce : wbca_conf.ajaxNonce,
							wbca_clientID : ClientID
						 },
						 success: function (data){
							var chatdata = data.wbca_client_chat;
							jQuery.each(chatdata, function(i, object) {
								var chatID = i;																
								var operatorID = object.operatorid;
								var operatorName = object.operatorname;
								var clientID = object.clientid;
								var message = object.message;
								var chatTime = object.chat_time;
								var avatar = object.avatar;
								
								var Container = $("#wbca_chat_body");
								
								var ScrollTop = $(Container).scrollTop();
								var CurrentHeight = $(Container).prop("scrollHeight");
								
								var chatContent = '<div class="wbca_admin_message_row wbca_message_row wbca-clear" data-operatorname="'+operatorName+'" data-operatorid="'+operatorID+'"><div class="wbca_image leftImage"><img src="'+avatar+'" /></div><div class="wbcaMessage leftMessage ui floating violet message"><div data-wbca-chatid="'+chatID+'" class="wbcaContent">'+message+'</div><div class="ui list right aligned"><span>'+ chatTime +'</span></div></div></div>';
							
								$(Container).append(chatContent);
								var NewHeight = $(Container).prop("scrollHeight");
								var Difference = NewHeight - CurrentHeight;
								$(Container).scrollTop($(Container).prop("scrollHeight"));
							});
							
							if($('#wp-chatbot-board-container').hasClass('active-chat-board')){
								
								if(data.is_operator_online !=  globalwpw.settings.obj.is_operator_online){
									globalwpw.settings.obj.is_operator_online = data.is_operator_online;
									if(data.is_operator_online != 1){
										$('.qcld-chatbot-custom-intent').hide();
										$('.wpbo_live_chat').hide()
										wpwKits.updateGlobalMenu();

									}
									if(data.is_operator_online == 1){
										$('.qcld-chatbot-custom-intent').show();
										$('.wpbo_live_chat').show()
										wpwKits.updateGlobalMenu();
									}
								}
							}
							
							
						},
						complete: function() {
							chatRefresh = setTimeout(AjaxChat.loadChatRow, wbca_conf.chatRate);
							RequestState1 = true;
						}
					});
				}
			},

			submitMessage: function () {
				
				$("body").on("keyup", "[data-event=\"submit-client-chat\"]", function (e) {

					if((e.keyCode == 13) ) {
						var userImage = wbca_conf.avatar;
						var d = new Date();
						var n = d.getTime();
						var Message = $.trim($(this).val());
						var ClientID = $(this).attr("data-clientid");
						var operatorID = 'none';
						var department_id = 0;
						var dateTime = d.getFullYear()+'-'+( d.getMonth() + 1)+'-'+d.getDate()+' '+ d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
						
						var Container = $("#wbca_chat_body");
						if($("#wbca_chat_body div.wbca_admin_message_row").length > 0){
							operatorID = $("#wbca_chat_body div.wbca_admin_message_row:last").attr("data-operatorid");
						}
						//if( operatorID != 'none'){
							department_id = $('#wbca_chat_body').attr("data-departmet");
						//}
						var user_icon_src = wbca_conf.wbcaUrl +'/images/client.png';
						
						var msg = '<div class="wbca_client_message_row wbca_message_row wbca-clear"><div class="wbca_image rightImage"><img src="'+user_icon_src+'" /></div><div class="wbcaMessage rightMessage "><div class="wbcaContent">'+Message+'</div><div class="ui list right aligned"><span>'+ dateTime +'</span></div></div></div>';
						//var msg = '<div class="wbca_admin_message_row wbca_message_row wbca-clear"><div class="wbcaMessage rightMessage ui floating message"><div data-chatid="'+chatID+'" class="wbcaContent">'+Message+'</div></div></div><div class="date-user">'+ dateTime +'</div>';
						if(Message.length > 0) {
							$(Container).append(msg);
							$(Container).scrollTop($(Container).prop("scrollHeight"));
							$.ajax({
								url: wbca_conf.ajaxURL,						
								type: "POST",
								dataType: "JSON",
								data: { 
									messageContent: Message, 
									receiverUserId: operatorID,
									departmentId: department_id,
									senderUserId: ClientID,
									action : wbca_conf.ajaxActions.wbca_submit_client_message.action,
									nonce : wbca_conf.ajaxNonce
								},
								success: function(data) {
									if(data.is_submit == 1 && $(".wbca_admin_message_row").length == 0){
										var operator = data.operator_info;
										if(operator && data.opid == 'none'){
											var operatorID = operator.operatorid;
											var operatorName = operator.operatorname;
											var operatorBio = operator.operatorbio;
											var message = wbca_conf.welcome+' '+operatorName+'. ';
											var avatar = operator.avatar;
											
											if(operatorID==0){
												message = wbca_conf.no_operator;
												operatorBio = '';
											}
											
											var chatContent = '<div class="wbca_admin_message_row wbca_message_row wbca-clear" data-operatorname="'+operatorName+'" data-operatorid="'+operatorID+'"><div class="wbca_image leftImage">'+avatar+'</div><div class="wbcaMessage leftMessage ui floating violet message"><div class="wbcaContent">'+message+operatorBio+'</div></div></div>';
											$("#wbca_chat_body").append(chatContent);
										}
										$("#wbca_chat_body").append('<div class="wbca_admin_message_row wbca_message_row wbca-hide" data-operatorid="'+data.operator_id+'">&nbsp;</div>');
										var Container = $("#wbca_chat_body");
										var ScrollTop = $(Container).scrollTop();
										var CurrentHeight = $(Container).prop("scrollHeight");
									}
									if(RequestState1 == true && data.is_submit == 1){
										if($.inArray(ClientID, ClientChatStored) == -1){
											ClientChatStored.push(ClientID);
											AjaxChat.setActiveChat(ClientID);
										}
										AjaxChat.loadChatRow();
									}
								}
							});
						}
						$(this).val("");
					}
				});
				$("body").on("click", ".btn-send-message", function (e) {
						
						var userImage = wbca_conf.avatar;
						var d = new Date();
						var n = d.getTime();
						var Message = $.trim($("[data-event=\"submit-client-chat\"]").val());
						var ClientID = $(this).attr("data-clientid");
						var operatorID = 'none';
						var department_id = 0;
						var dateTime = d.getFullYear()+'-'+( d.getMonth() + 1)+'-'+d.getDate()+' '+ d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
						
						var Container = $("#wbca_chat_body");
						if($("#wbca_chat_body div.wbca_admin_message_row").length > 0){
							operatorID = $("#wbca_chat_body div.wbca_admin_message_row:last").attr("data-operatorid");
						}
						
						if( operatorID != 'none'){
							department_id = $('#wbca_chat_body').attr("data-departmet");
						}
						var user_icon_src = wbca_conf.wbcaUrl +'/images/client.png';
					
						var msg = '<div class="wbca_client_message_row wbca_message_row wbca-clear"><div class="wbca_image rightImage"><img src="'+user_icon_src+'" /></div><div class="wbcaMessage rightMessage "><div class="wbcaContent">'+Message+'</div><div class="ui list right aligned"><span>'+ dateTime +'</span></div></div></div>';
						//var msg = '<div class="wbca_admin_message_row wbca_message_row wbca-clear"><div class="wbcaMessage rightMessage ui floating message"><div data-chatid="'+chatID+'" class="wbcaContent">'+Message+'</div></div></div><div class="date-user">'+ dateTime +'</div>';
						
						if(Message.length > 0) {
							$(Container).append(msg);
							$(Container).scrollTop($(Container).prop("scrollHeight"));
							$.ajax({
								url: wbca_conf.ajaxURL,						
								type: "POST",
								dataType: "JSON",
								data: { 
									messageContent: Message, 
									receiverUserId: operatorID,
									departmentId: department_id,
									senderUserId: ClientID,
									action : wbca_conf.ajaxActions.wbca_submit_client_message.action,
									nonce : wbca_conf.ajaxNonce
								},
								success: function(data) {
									if(data.is_submit == 1 && $(".wbca_admin_message_row").length == 0){
										var operator = data.operator_info;
										if(operator && data.opid == 'none'){
											var operatorID = operator.operatorid;
											var operatorName = operator.operatorname;
											var operatorBio = operator.operatorbio;
											var message = wbca_conf.welcome+' '+operatorName+'. ';
											var avatar = operator.avatar;
											
											if(operatorID==0){
												message = wbca_conf.no_operator;
												operatorBio = '';
											}
											
											var chatContent = '<div class="wbca_admin_message_row wbca_message_row wbca-clear" data-operatorname="'+operatorName+'" data-operatorid="'+operatorID+'"><div class="wbca_image leftImage">'+avatar+'</div><div class="wbcaMessage leftMessage ui floating violet message"><div class="wbcaContent">'+message+operatorBio+'</div></div></div>';
											$("#wbca_chat_body").append(chatContent);
										}
										$("#wbca_chat_body").append('<div class="wbca_admin_message_row wbca_message_row wbca-hide" data-operatorid="'+data.operator_id+'">&nbsp;</div>');
										var Container = $("#wbca_chat_body");
										var ScrollTop = $(Container).scrollTop();
										var CurrentHeight = $(Container).prop("scrollHeight");
									}
									if(RequestState1 == true && data.is_submit == 1){
										if($.inArray(ClientID, ClientChatStored) == -1){
											ClientChatStored.push(ClientID);
											AjaxChat.setActiveChat(ClientID);
										}
										AjaxChat.loadChatRow();
									}
								}
							});
						}
						$("[data-event=\"submit-client-chat\"]").val("");
					
				});
				
			},
			submitFile: function(){
				$("body").on('change', '#qclivechat_file', function (e) {
					var ClientID = $(this).attr("data-clientid");
					var operatorID = 'none';
					var department_id = 0;
					//var dateTime = d.getFullYear()+'-'+( d.getMonth() + 1)+'-'+d.getDate()+' '+ d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
					var Container = $("#wbca_chat_body");
					if($("#wbca_chat_body div.wbca_admin_message_row").length > 0){
						operatorID = $("#wbca_chat_body div.wbca_admin_message_row:last").attr("data-operatorid");
					}
					$this = $(this);
					file_data = $(this).prop('files')[0];
        			form_data = new FormData();
        			form_data.append('file', file_data);
					form_data.append('receiverUserId', operatorID);
					form_data.append('senderUserId', ClientID);
					form_data.append('action',  wbca_conf.ajaxActions.wbca_livechatfile_upload.action);
					form_data.append('nonce', wbca_conf.ajaxNonce);
					
					$.ajax({
						url: wbca_conf.ajaxURL,
						type: 'POST',
						contentType: false,
						processData: false,
						data: form_data,
						success: function (data) {
							function isJsonString(str) {
								try {
									JSON.parse(str);
								} catch (e) {
									return false;
								}
								return true;
							}
							var Container = $("#wbca_chat_body");
							var ScrollTop = $(Container).scrollTop();
							var CurrentHeight = $(Container).prop("scrollHeight");
							var user_icon_src = wbca_conf.wbcaUrl +'/images/client.png';
							if(isJsonString(data)){
								datas = JSON.parse(data);
							}else{
								datas = data;
							}
							if(datas.message == 'file not supported'){
								
								Container.append('<div class="wbcaMessage"> ' + datas.message + '</div>');
							}else{
								
								Container.append('<div class="wbca_client_message_row wbca_message_row wbca-clear"><div class="wbca_image rightImage"><img src="'+user_icon_src+'" /></div><div class="wbcaMessage rightMessage"><div>' + data.message + '</div><div class="ui list right aligned"><span class="item">' + datas.date + '</span></div></div></div>');
								Container.scrollTop($(Container).prop("scrollHeight"));
								
								if(RequestState1 == true && data.is_submit == 1){
									if($.inArray(ClientID, ClientChatStored) == -1){
										ClientChatStored.push(ClientID);
										AjaxChat.setActiveChat(ClientID);
									}
									AjaxChat.loadChatRow();
								}
							}
						}
					});
				});
			},
			
			initializeActiveChats: function () {
				$.ajax({
					url: wbca_conf.ajaxURL,						
					type: "POST",
					dataType: "JSON",
					data: { 
						action : wbca_conf.ajaxActions.wbca_load_active_chat.action,
						nonce : wbca_conf.ajaxNonce
					 },
					success: function(data) {
						var data = data.ClientChatStored;
						$.each(data, function(i, object) {
							var ClientID = data[i].CLIENTID;
							
							$.ajax({
								url: wbca_conf.ajaxURL,						
								type: "POST",
								dataType: "JSON",
								data: { 
									cc_clientid: ClientID,
									action : wbca_conf.ajaxActions.wbca_load_allchat.action,
									nonce : wbca_conf.ajaxNonce
								 },
								success: function(data) {
									var data = data.allmessages;
									$.each(data, function(i, object) {
										var WindowId = i;
										var chatContent = object;
										var Container = $("#wbca_chat_body");
																				
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
					var id = $("#wbca_chat_body").attr('data-clientid');
					chatno[id] = $("#wbca_chat_body").find('.wbca_message_row').length;
					
					if(!vis()){
						notifyInterval = setInterval(function(){ 
							var nchatno = {}, ntitle;							
							var nid = $("#wbca_chat_body").attr('data-clientid'),
								ntitle =  'New message from '+$("#wbca_chat_body").find('.wbca_admin_message_row:last-child').attr('data-operatorname');
								
							nchatno[nid] = $("#wbca_chat_body").find('.wbca_message_row').length;
							
							if(nchatno[nid] > chatno[nid] && $.inArray(ntitle, newtitle) == -1){
								newtitle.push(ntitle);
							}
						}, 2000);
						
						showNotifyInterval = setInterval(function(){ 
							if(newtitle.length > 1){
								document.title = newtitle[timer];
								timer++
								if (timer >= newtitle.length){
									timer=0;
								}
								audioplayer.play();
							}
						}, 3000);
						
					}else{
						clearInterval(notifyInterval);
						clearInterval(showNotifyInterval);
						document.title = oldtitle;
						newtitle = [];
						newtitle.push(oldtitle);
					//	audioplayer.pause();
					}
					
				});
				
			},
			
			resizewindow: function(){
				if(wbca_conf.fullHeight && $(window).width() < 768){
					$(window).resize(function(e) {
                        $('#wbcaChatWindow').css('height',$(window).height()+'px');
						$('#wbca_chat_body').css('height',$(window).height()-68.5+'px');
                    });
				}
			}
		}
		
		AjaxChat.wbcaInit();
		
	});
}(jQuery));
