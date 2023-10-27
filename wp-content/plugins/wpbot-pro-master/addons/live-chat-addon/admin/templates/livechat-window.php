<?php
global $wpdb;
$prefix = $wpdb->prefix;
$deparment_lists = $wpdb->get_results('SELECT * FROM '.$prefix.'wbca_department ORDER BY id ASC LIMIT 10');
$deparment_list = '';
if ( !class_exists('qcld_wb_Chatbot') && !class_exists('QCLD_Woo_Chatbot') && (qclivechat_is_kbxwpbot_active() != true)) {
    $bot_enable = false;
}else{
    $bot_enable = true;
}

foreach ($deparment_lists as $value) {
    $deparment_list .= '<option value="'.$value->id.'">'.$value->department.'</option>';
}
$html = '';
$html .= '
<div class="ui grid grid-main">
    <div class="sixteen wide tablet three wide computer column wbca-left-sidebar">
        <div class="ui floating card" style="width:100%"">
            <div class="ui middle aligned selection list">
                <div class="item">
                    <img class="ui avatar image" src="'.$src.'">
                    <div class="content">
                        <div class="header">'.$name.'</div>
                    </div>
                </div>
                <div class="item ui center aligned">
                    <a class="ui button '.$teal.' button-online" class="button-online" data-user="'.$user_id.'" data-online='.$online_button_text.'>Go '. $online_button_text1 .'</a>
                </div>
                <div class="ui item">
                    '.$go_online_text.'
                </div>
            </div>
            <div class="ui segment">
                <div class="ui relaxed divided list" id="wbca-chat-tabs">
                    <li data-event="dashboard-client-tabs" class="wbca-current wbca_dashboard">Dashboard</li>
                </div>
            </div>
        </div>
    </div>
    <div class="sixteen wide tablet eight wide computer column">
        <div class="ui floating card" style="width:100%">
            <div class="content">
                <div id="wbca-content-wrap">
                    <div class="wbca-chat-box wbca-visible">
                            <div class="wbca-dashbord">
                                <div class="wbca-chat-items middle aligned">
                                    <div id="wpca_active_client_count">0 active Users currently!</div>
                                    <div class="ui segment"><div class="ui relaxed divided list" id="wpca_active_client"> currently active</div></div>
                                </div>
                                <div class="wbca-search-items">
                                </div>
                            </div>
                        <div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="sixteen wide tablet four wide computer column wbca_rigth_sidebar hidden" >
    <div class="ui floating card" style="width:100%">
            <div class="content">
                <div class="ui raised segment">
                    <a class="ui violet ribbon label">User info</a>
                    <span class="custom-font-wigth">User info</span>
                </div>
                <div id="bot_personal_info" class="ui middle aligned divided list">
                </div>
            </div>
        </div>';

if($bot_enable == true){
    $html .= '
        
        <div class="ui floating card" style="width:100%">
            <div class="content"  id="bot_session_history">
                <div class="ui raised segment">
                    <a class="ui purple ribbon label">Bot session</a>
                    <span class="custom-font-wigth">Bot session History</span>
                </div>
                <div id="session_history" class="ui middle aligned divided list">
                </div>
            </div>
        </div>';
} 
$html .= '<div class="ui floating card" style="width:100%">
            <div class="content">
                <div class="ui raised segment">
                    <a class="ui violet ribbon label">History</a>
                    <span class="custom-font-wigth">Previous conversation Details</span>
                </div>
                <div id="user_history" class="ui middle aligned divided list">
                </div>
            </div>
        </div>';
$htmla  ='';
$htmla .= ' <div class="ui floating card" style="width:100%">
            <div class="content">
                <div class="ui raised segment">
                    <a class="ui purple ribbon label">Transfer</a>
                    <span class="custom-font-wigth">Transfer to other Department</span>
                </div>
                <div class="ui labeled input">
                    <div class="ui label">Transfer to</div>
                        <select class="ui selection dropdown">
                            '.$deparment_list.'
                        </select>
                    </div>
                </div>
            </div>
        </div>';
$html .= '   </div>
</div>
<div id="client_date_chat" class="ui modal">
  <i class="close icon"></i>
  <div class="header">
    Profile Picture
  </div>
  <div class="image content">
    <div class="ui medium image">
      <img src="/images/avatar/large/chris.jpg">
    </div>
    <div class="description">
      <div class="ui header">We have auto-chosen a profile image for you.</div>
      <p>We have grabbed the following image from the <a href="https://www.gravatar.com" target="_blank">gravatar</a> image associated with your registered e-mail address.</p>
      <p>Is it okay to use this photo?</p>
    </div>
  </div>
  <div class="actions">
    <div class="ui black deny button">
      Nope
    </div>
    <div class="ui positive right labeled icon button">
      Yep, thats me
      <i class="checkmark icon"></i>
    </div>
  </div>
</div>
';
$html .= '<ul class="wbca_hide" id="wbca_select_operator_id">';
$html .= $alloperator;
$html .= '</ul>';