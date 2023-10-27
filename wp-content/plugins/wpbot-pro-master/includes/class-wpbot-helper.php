<?php 

class Qcld_WPBot_Helper
{
    public function qcld_wb_chatbot_str_replace($messages=array()){
        /* $refined_mesgses=array();
        if(!empty($messages)){
            foreach ($messages as $message){
                $refined_msg=str_replace('\\', '', $message);
                array_push($refined_mesgses,$refined_msg);
            }
        }
        return $refined_mesgses; */

        return stripslashes_deep( $messages );


    }

    public function qcld_get_stopwords(){

        $words = str_replace('\\', '', get_option('qlcd_wp_chatbot_stop_words'));
        if(get_option('qlcd_wp_chatbot_stop_words_name')!='english'){
            $words .="a,able,about,above,abst,accordance,according,accordingly,across,act,actually,added,adj,affected,affecting,affects,after,afterwards,again,against,ah,all,almost,alone,along,already,also,although,always,am,among,amongst,an,and,announce,another,any,anybody,anyhow,anymore,anyone,anything,anyway,anyways,anywhere,apparently,approximately,are,aren,arent,arise,around,as,aside,ask,asking,at,auth,available,away,awfully,b,back,be,became,because,become,becomes,becoming,been,before,beforehand,begin,beginning,beginnings,begins,behind,being,believe,below,beside,besides,between,beyond,biol,both,brief,briefly,but,by,c,ca,came,can,cannot,can't,cause,causes,certain,certainly,co,com,come,comes,contain,containing,contains,could,couldnt,d,date,did,didn't,different,do,does,doesn't,doing,done,don't,down,downwards,due,during,e,each,ed,edu,effect,eg,eight,eighty,either,else,elsewhere,end,ending,enough,especially,et,et-al,etc,even,ever,every,everybody,everyone,everything,everywhere,ex,except,f,far,few,ff,fifth,first,five,fix,followed,following,follows,for,former,formerly,forth,found,four,from,further,furthermore,g,gave,get,gets,getting,give,given,gives,giving,go,goes,gone,got,gotten,h,had,happens,hardly,has,hasn't,have,haven't,having,he,hed,hence,her,here,hereafter,hereby,herein,heres,hereupon,hers,herself,hes,hi,hid,him,himself,his,hither,home,how,howbeit,however,hundred,i,id,ie,if,i'll,im,immediate,immediately,importance,important,in,inc,indeed,index,information,instead,into,invention,inward,is,isn't,it,itd,it'll,its,itself,i've,j,just,k,keep,keeps,kept,kg,km,know,known,knows,l,largely,last,lately,later,latter,latterly,least,less,lest,let,lets,like,liked,likely,line,little,'ll,look,looking,looks,ltd,m,made,mainly,make,makes,many,may,maybe,me,mean,means,meantime,meanwhile,merely,mg,might,million,miss,ml,more,moreover,most,mostly,mr,mrs,much,mug,must,my,myself,n,na,name,namely,nay,nd,near,nearly,necessarily,necessary,need,needs,neither,never,nevertheless,new,next,nine,ninety,no,nobody,non,none,nonetheless,noone,nor,normally,nos,not,noted,nothing,now,nowhere,o,obtain,obtained,obviously,of,off,often,oh,ok,okay,old,omitted,on,once,one,ones,only,onto,or,ord,other,others,otherwise,ought,our,ours,ourselves,out,outside,over,overall,owing,own,p,page,pages,part,particular,particularly,past,per,perhaps,placed,please,plus,poorly,possible,possibly,potentially,pp,predominantly,present,previously,primarily,probably,promptly,proud,provides,put,q,que,quickly,quite,qv,r,ran,rather,rd,re,readily,really,recent,recently,ref,refs,regarding,regardless,regards,related,relatively,research,respectively,resulted,resulting,results,right,run,s,said,same,saw,say,saying,says,sec,section,see,seeing,seem,seemed,seeming,seems,seen,self,selves,sent,seven,several,shall,she,shed,she'll,shes,should,shouldn't,show,showed,shown,showns,shows,significant,significantly,similar,similarly,since,six,slightly,so,some,somebody,somehow,someone,somethan,something,sometime,sometimes,somewhat,somewhere,soon,sorry,specifically,specified,specify,specifying,still,stop,strongly,sub,substantially,successfully,such,sufficiently,suggest,sup,sure,t,take,taken,taking,tell,tends,th,than,thank,thanks,thanx,that,that'll,thats,that've,the,their,theirs,them,themselves,then,thence,there,thereafter,thereby,thered,therefore,therein,there'll,thereof,therere,theres,thereto,thereupon,there've,these,they,theyd,they'll,theyre,they've,think,this,those,thou,though,thoughh,thousand,throug,through,throughout,thru,thus,til,tip,to,together,too,took,toward,towards,tried,tries,truly,try,trying,ts,twice,two,u,un,under,unfortunately,unless,unlike,unlikely,until,unto,up,upon,ups,us,use,used,useful,usefully,usefulness,uses,using,usually,v,value,various,'ve,very,via,viz,vol,vols,vs,w,want,wants,was,wasnt,way,we,wed,welcome,we'll,went,were,werent,we've,what,whatever,what'll,whats,when,whence,whenever,where,whereafter,whereas,whereby,wherein,wheres,whereupon,wherever,whether,which,while,whim,whither,who,whod,whoever,whole,who'll,whom,whomever,whos,whose,why,widely,willing,wish,with,within,without,wont,words,world,would,wouldnt,www,x,y,yes,yet,you,youd,you'll,your,youre,yours,yourself,yourselves,you've,z,zero";
        }
        return $words;
    }

    public function default_langauge(){

        $data = qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_wildcard_msg')));
        if( function_exists( 'array_key_first' ) ){
            return array_key_first( $data );
        }else{
            foreach( $data as $lan=>$value ){
                return $lan;
                break;
            }
        }
        
    }

    //getting exact agent icon path
    public  function qcld_wb_chatbot_agent_icon(){
		
        if(get_option('wp_chatbot_custom_agent_path')!="" && get_option('wp_chatbot_agent_image')=="custom-agent.png"  ){
            $wp_chatbot_custom_icon_path=get_option('wp_chatbot_custom_agent_path');
        }
		else if(get_option('wp_chatbot_custom_agent_path')!="" && get_option('wp_chatbot_agent_image')!="custom-agent.png"){
            $wp_chatbot_custom_icon_path=QCLD_wpCHATBOT_IMG_URL.get_option('wp_chatbot_agent_image');
        }
		else
		{
			if(get_option('wp_chatbot_agent_image')!=''){
				$wp_chatbot_custom_icon_path=QCLD_wpCHATBOT_IMG_URL.get_option('wp_chatbot_agent_image');
			}else{
				$wp_chatbot_custom_icon_path=QCLD_wpCHATBOT_IMG_URL.'custom-agent.png';
			}
            
        }
		
        return $wp_chatbot_custom_icon_path;
    }
	public function qcld_wb_chatbot_dynamic_multi_option($options = array(), $option_name = "", $option_text = "")
    {
        if( function_exists( 'qcld_wpbotml' ) ){
            do_action( 'ml_render_dynamic_multi_option', $options, $option_name, $option_text );
        } else {
        ?>
        <div class="wp-lng-wrap">
            <h4 class="qc-opt-title"><?php echo esc_html__($option_text, 'wpchatbot'); ?></h4>
            <div class="wp-chatbot-lng-items">
                <?php

                if (is_array($options) && isset( $options[get_wpbot_locale()] ) && is_array( $options[get_wpbot_locale()] ) && count($options) > 0) {
                    foreach ($options[get_wpbot_locale()] as $key => $value) {
                        ?>
                        <div class="row" class="wp-chatbot-lng-item">
                            <div class="col-xs-10">
                                <textarea type="text"
                                    class="form-control qc-opt-dcs-font"
                                    name="<?php echo esc_html($option_name); ?>[<?php echo get_wpbot_locale(); ?>][]"
                                    ><?php echo esc_html(str_replace('\\', '', ($value !=''?$value:$option_text) )); ?></textarea>
                            </div>
                            <div class="col-xs-2">
                                <button type="button" class="btn btn-danger btn-sm wp-chatbot-lng-item-remove">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </button>
                            </div>
                        </div>
                        <?php
                    }
                } else { ?>
                    <div class="row" class="wp-chatbot-lng-item">
                        <div class="col-xs-10">
                            <textarea type="text"
                                class="form-control qc-opt-dcs-font"
                                name="<?php echo esc_html($option_name); ?>[<?php echo get_wpbot_locale(); ?>][]"
                                ><?php echo esc_html($option_text); ?></textarea>
                        </div>
                        <div class="col-xs-2">
                            <span class="wp-chatbot-lng-item-remove"><?php echo esc_html__('X', 'wpchatbot'); ?></span>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="row">
                <div class="col-sm-2 col-sm-offset-10">
                    <button type="button" class="btn btn-success btn-sm wp-chatbot-lng-item-add"> <span class="glyphicon glyphicon-plus"></span> </button>
                </div>
            </div>
        </div>
        <?php
        }
    }
	public function qcld_wb_chatbot_dynamic_multi_option_custom($options = array(), $option_name = "", $option_text = "")
    {
        ?>
        <div class="wp-lng-wrap">
            <h4 class="qc-opt-title"><?php echo esc_html__($option_text, 'wpchatbot'); ?></h4>
            <div class="wp-chatbot-lng-items">
                <?php if (is_array($options) && count($options) > 0) { 
                    $checkboxes = maybe_unserialize(get_option($option_name.'_checkbox'));
                    $labels = maybe_unserialize(get_option($option_name.'_label'));
                    foreach($options as $key=>$value){
                ?>
                    <div class="row" class="wp-chatbot-lng-item">
                        <div class="col-xs-10">
                            <p><?php echo esc_html__('Intent Name - Must match EXACTLY as what you Added in DialogFlow. This will show the intent in the Start Menu','wpchatbot'); ?></p>
                            <input type="text"
                                class="form-control qc-opt-dcs-font"
                                name="<?php echo esc_html($option_name); ?>[]"
                                value="<?php echo esc_html(str_replace('\\', '', $value)); ?>">
                                
                            <p class="wpbot_multi_option" ><?php echo esc_html__('Intent Label','wpchatbot'); ?></p>
                            <input type="text"
                                class="form-control qc-opt-dcs-font"
                                name="<?php echo esc_html($option_name); ?>_label[]"
                                value="<?php echo esc_html(str_replace('\\', '', $labels[$key])); ?>">
                                
                            <div class="cxsc-settings-blocks wpb_custom_checkbox">
                                
                                <p><input value="1" type="checkbox" class="wpb_repeatable_checkbox"
                                                    name="<?php echo esc_html($option_name); ?>_checkbox[]" <?php echo (isset( $checkboxes[$key] ) && $checkboxes[$key]==1?'checked="checked"':''); ?> >
                                &nbsp;&nbsp;<?php echo esc_html__('If you have created a Step by Step Question Answer Intent in DialogFlow, you can Enable the Option to have the Answers emailed to you. This can be used to create a Poll or Survey. See documentation for more details!','wpchatbot'); ?>
                                <input value="0" class="wp_check_hidden" type="hidden"
                                                    name="<?php echo esc_html($option_name); ?>_checkbox[]" <?php echo (isset( $checkboxes[$key] ) && $checkboxes[$key]==1?'disabled="disabled"':''); ?> >
                                </p>
                            </div>
                        </div>
                        <div class="col-xs-2 wpb_custom_remove">
                            <button type="button" class="btn btn-danger btn-sm wp-chatbot-lng-item-remove">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </button>
                        </div>
                    </div>
                <?php 
                    }
                }else{ 
                ?>
                    <div class="row" class="wp-chatbot-lng-item">
                        <div class="col-xs-10">
                            <p><?php echo esc_html__('Intent Name','wpchatbot'); ?></p>
                            <input type="text"
                                class="form-control qc-opt-dcs-font"
                                name="<?php echo esc_html($option_name); ?>[]"
                                value="<?php echo esc_html($option_text); ?>" placeholder="Intent Name">
                                
                            <p class="wpbot_multi_option"><?php echo esc_html(esc_html__('Intent Label','wpchatbot')); ?></p>
                            <input type="text"
                                class="form-control qc-opt-dcs-font"
                                name="<?php echo esc_html($option_name); ?>_label[]"
                                value="<?php echo esc_html($option_text); ?>" placeholder="Intent Name">
                                
                            <div class="cxsc-settings-blocks wpb_custom_checkbox">
                                <p><input value="1" type="checkbox" class="wpb_repeatable_checkbox"
                                                    name="<?php echo esc_html($option_name); ?>_checkbox[]" >
                                &nbsp;&nbsp;<?php echo esc_html(esc_html__('If you have created a Step by Step Question Answer Intent in DialogFlow, you can Enable the Option to have the Answers emailed to you. This can be used to create a Poll or Survey. See documentation for more details!','wpchatbot')); ?></p>
                            </div>
                        </div>
                        <div class="col-xs-2 wpb_custom_remove">
                            <button type="button" class="btn btn-danger btn-sm wp-chatbot-lng-item-remove">
                                    <span class="glyphicon glyphicon-remove"></span>
                            </button>
                        </div>
                    </div>
                <?php } ?>
                    
            </div>
            <div class="row">
                <div class="col-sm-2 col-sm-offset-10">
                    <button type="button" class="btn btn-success btn-sm wp-chatbot-lng-item-add"> <span class="glyphicon glyphicon-plus"></span> </button>
                </div>
            </div>
        </div>
        <?php
    }

    public function qcld_wb_chatbot_dynamic_multi_option_menu($options = array(), $option_name = "", $option_text = "")
    {
        ?>
        <div class="wp-lng-wrap">
            <h4 class="qc-opt-title"><?php echo esc_html__($option_text, 'wpchatbot'); ?></h4>
            <div class="wp-chatbot-lng-items">
                <?php if (is_array($options) && count($options) > 0) { 
                    $checkboxes = maybe_unserialize(get_option($option_name.'_checkbox'));
                    $labels = maybe_unserialize(get_option($option_name.'_link'));
                    $types = maybe_unserialize(get_option($option_name.'_type'));
                    foreach($options as $key=>$value){
                ?>
                    <div class="row" class="wp-chatbot-lng-item">
                        <div class="col-xs-10">
                            <p><?php echo esc_html__('Button Label','wpchatbot'); ?></p>
                            <input type="text"
                                class="form-control qc-opt-dcs-font"
                                name="<?php echo esc_html($option_name); ?>[]"
                                value="<?php echo esc_html(str_replace('\\', '', $value)); ?>">
                                
                            <p class="wpbot_multi_option" ><?php echo esc_html__('Button Link','wpchatbot'); ?></p>
                            <input type="text"
                                class="form-control qc-opt-dcs-font"
                                name="<?php echo esc_html($option_name); ?>_link[]"
                                value="<?php echo esc_html(str_replace('\\', '', $labels[$key])); ?>">
                                
                            <div class="cxsc-settings-blocks wpb_custom_checkbox">
                                
                                <p style="display: flex;align-items: center;"><input value="1" type="checkbox" class="wpb_repeatable_checkbox"
                                                    name="<?php echo esc_html($option_name); ?>_checkbox[]" <?php echo (isset($checkboxes[$key]) && $checkboxes[$key]==1?'checked="checked"':''); ?> >
                                &nbsp;&nbsp;<?php echo esc_html__('Open in New Tab','wpchatbot'); ?>
                                <input value="0" class="wp_check_hidden" type="hidden"
                                                    name="<?php echo esc_html($option_name); ?>_checkbox[]" <?php echo (isset($checkboxes[$key]) && $checkboxes[$key]==1?'disabled="disabled"':''); ?> />
                                </p>
                            </div>
                            
                            
                            <div class="cxsc-settings-blocks wpb_custom_checkbox">
                                
                                <p style="display: flex;align-items: center;">
                                
                                Link Type: 
                                <select name="<?php echo esc_html($option_name); ?>_type[]">
                                    <option value="link" <?php echo (isset($types[$key]) && $types[$key]=='link'?'selected="selected"':''); ?>>Link</option>
                                    
                                    <option value="email" <?php echo (isset($types[$key]) && $types[$key]=='email'?'selected="selected"':''); ?>>Email</option>
                                    
                                    <option value="phone" <?php echo (isset($types[$key]) && $types[$key]=='phone'?'selected="selected"':''); ?>>Phone</option>
                                </select>

                                </p>
                            </div>
                            
                        </div>
                        <div class="col-xs-2 wpb_custom_remove">
                            <button type="button" class="btn btn-danger btn-sm wp-chatbot-lng-item-remove">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </button>
                        </div>
                    </div>
                <?php 
                    }
                }else{ 
                ?>
                    <div class="row" class="wp-chatbot-lng-item">
                        <div class="col-xs-10">
                            <p><?php echo esc_html__('Button Label','wpchatbot'); ?></p>
                            <input type="text"
                                class="form-control qc-opt-dcs-font"
                                name="<?php echo esc_html($option_name); ?>[]"
                                value="<?php echo esc_html($option_text); ?>" placeholder="Button Label">
                                
                            <p class="wpbot_multi_option"><?php echo esc_html(esc_html__('Button Link','wpchatbot')); ?></p>
                            <input type="text"
                                class="form-control qc-opt-dcs-font"
                                name="<?php echo esc_html($option_name); ?>_link[]"
                                value="<?php echo esc_html($option_text); ?>" placeholder="Button Link">
                                
                            <div class="cxsc-settings-blocks wpb_custom_checkbox">
                                <p style="display: flex;align-items: center;"><input value="1" type="checkbox" class="wpb_repeatable_checkbox"
                                                    name="<?php echo esc_html($option_name); ?>_checkbox[]" >
                                &nbsp;&nbsp;<?php echo esc_html(esc_html__('Open in New Tab','wpchatbot')); ?></p>
                            </div>
                            
                            <div class="cxsc-settings-blocks wpb_custom_checkbox">
                                
                                <p style="display: flex;align-items: center;">
                                
                                Link Type: 
                                <select name="<?php echo esc_html($option_name); ?>_type[]">
                                    <option value="link" >Link</option>
                                    
                                    <option value="email" >Email</option>
                                    
                                    <option value="phone" >Phone</option>
                                </select>
                                
                                </p>
                            </div>
                            
                        </div>
                        <div class="col-xs-2 wpb_custom_remove">
                            <button type="button" class="btn btn-danger btn-sm wp-chatbot-lng-item-remove">
                                    <span class="glyphicon glyphicon-remove"></span>
                            </button>
                        </div>
                    </div>
                <?php } ?>
                    
            </div>
            <div class="row">
                <div class="col-sm-2 col-sm-offset-10">
                    <button type="button" class="btn btn-success btn-sm wp-chatbot-lng-item-add"> <span class="glyphicon glyphicon-plus"></span> </button>
                </div>
            </div>
        </div>
        <?php
    }
    
    public function wp_chatbot_opening_hours($day_name,$wpwbot_times){
        if(!empty($wpwbot_times) && isset($wpwbot_times[$day_name])){
            $day_times=$wpwbot_times[$day_name];
            if(!empty($day_times)){
                $segment=0;
                foreach ($day_times as $day_time ){
        ?>
            <div class="wp-chatbot-hours-container">
                <div class="wp-chatbot-hours">
                    <input type="text" class="wp-chatbot-hour" name="wpwbot_hours[<?php echo esc_html($day_name); ?>][<?php echo esc_html($segment); ?>][]" value="<?php if(isset($day_time[0])){echo $day_time[0];}else{ echo "00:00";}  ?>" >
                    <input type="text" class="wp-chatbot-hour" name="wpwbot_hours[<?php echo esc_html($day_name); ?>][<?php echo esc_html($segment); ?>][]" value="<?php if(isset($day_time[1])){echo $day_time[1];}else{ echo "00:00";}  ?>" >
                </div>
                <div class="wp-chatbot-hours-remove">
                    <button type="button" class="btn btn-danger btn-sm wp-chatbot-hours-remove-btn">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

        <?php
            $segment++;
            }
          }
        }else{
        ?>
            <div class="wp-chatbot-hours-container">
                <div class="wp-chatbot-hours">
                    <input type="text" class="wp-chatbot-hour" name="wpwbot_hours[<?php echo esc_html($day_name); ?>][0][]" value="00:00" > <input type="text" name="wpwbot_hours[<?php echo esc_html($day_name); ?>][0][]" value="00:00">
                </div>
                <div class="wp-chatbot-hours-remove">
                    <button type="button" class="btn btn-danger btn-sm wp-chatbot-hours-remove-btn">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        <?php
        }
    }

    public function render_language_field($title, $key, $default, $class=''){

        if( function_exists( 'qcld_wpbotml' ) ){
            do_action( 'ml_render_language_fields', $title, $key, $default, $class );
        } else {

        $option_val = get_option($key);
        if( $option_val && is_array( $option_val ) && array_key_exists( get_wpbot_locale(), $option_val ) && $option_val[get_wpbot_locale()] != '' ){
            $value = $option_val[get_wpbot_locale()];
        }else{
            $value = $default;
        }

        ?>
        <h4 class="qc-opt-title"><?php echo $title; ?>  </h4>
            <div class="cxsc-settings-blocks">
                <input class="form-control qc-opt-dcs-font" style="width: 100%;" value="<?php echo esc_html($value); ?>" id="<?php echo esc_attr($key) ?>" type="text" name="<?php echo esc_attr($key) ?>[<?php echo get_wpbot_locale(); ?>]" />
            </div>
        <?php
        }

    }

    public function render_intent_selection( $title, $settings_key ){

        if( function_exists( 'qcld_wpbotml' ) ){
            do_action( 'ml_render_intent_selection_fields', $title, $settings_key );
        } else {

        $option_val = get_option($settings_key);
        if( $option_val && is_array( $option_val ) && array_key_exists( get_wpbot_locale(), $option_val ) ){
            $value = $option_val[get_wpbot_locale()];
        }else{
            $value = '';
        }

        ?>
        <div class="col-xs-12">
            <h4 class="qc-opt-title"><?php echo $title; ?>  </h4>
            <div class="cxsc-settings-blocks">
                <select name="<?php echo esc_attr($settings_key) ?>[<?php echo get_wpbot_locale(); ?>]">
                    <?php 
                        $intents = qc_get_all_intents();

                        

                        foreach($intents as $key=>$values){
                        ?>
                        <optgroup label="<?php echo ucfirst($key); ?>">
                            <?php 
                                foreach($values as $val){
                                ?>
                                    <option value="<?php echo trim($val); ?>" <?php echo ($value==trim($val)?'selected="selected"':''); ?>><?php echo trim($val); ?></option>
                                <?php
                                }
                            ?>
                        </optgroup>
                        <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <?php
        }
    }

    public function render_notifications(){

        if( function_exists( 'qcld_wpbotml' ) ){
            do_action( 'ml_render_notifications' );
        } else {
        
        $notifications = qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_notifications')));
        $intents = qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_notifications_intent')));
        
        $notifications = (isset($notifications[get_wpbot_locale()])?$notifications[get_wpbot_locale()]:$notifications);
        $intents = (isset($intents[get_wpbot_locale()])?$intents[get_wpbot_locale()]:$intents);
        $language = get_wpbot_locale();
        ?>
        <div class="notification-lan-container">
        <h3>Notification Content - <?php echo get_wpbot_locale(); ?></h3>
        <hr>
        <div class="notification-block-inner">
        <?php $allIntents = qc_get_all_intents(); ?>
        <?php
        if (!empty($notifications)) {
            $chatbot_notif_counter=0;
            foreach ($notifications as $notification) {
                ?>
                <div class="row">
                    <div class="col-xs-12">
                        <button type="button"
                                class="btn btn-danger btn-sm wp-chatbot-remove-notification pull-right">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </button>
                        <div class="cxsc-settings-blocks" style="margin-top:26px">
                            <?php wp_editor(html_entity_decode(stripcslashes($notification)), 'qlcd_wp_chatbot_notifications_'.$language.'_'.esc_html($chatbot_notif_counter), array('textarea_name' =>
                                'qlcd_wp_chatbot_notifications['.get_wpbot_locale().'][]',
                                'textarea_rows' => 20,
                                'editor_height' => 100,
                                'disabled' => 'disabled',
                                'media_buttons' => false,
                                'tinymce'       => array(
                                    'toolbar1'      => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,link,unlink',)
                            )); ?>
                        </div>
                        
                        <div class="cxsc-settings-blocks">
                            <h4 class="qc-opt-title">Select an Intent for Click Action</h4>     
                            <select name="qlcd_wp_chatbot_notifications_intent[<?php echo get_wpbot_locale(); ?>][]">

                                <?php 
                                    if( is_array( $allIntents ) && ! empty( $allIntents ) ){
                                        foreach($allIntents as $key => $value){
                                            ?>
                                            <optgroup label="<?php echo $key ?>">
                                                <option value="" >None</option>
                                                <?php foreach($value as $val){ ?>

                                                    <option value="<?php echo $val; ?>" <?php echo (isset($intents[$chatbot_notif_counter])&&$intents[$chatbot_notif_counter]==$val?'selected="selected"':''); ?>><?php echo $val; ?></option>

                                                <?php } ?>
                                            </optgroup>
                                            <?php
                                        }
                                    }
                                ?>

                            </select>                                                   
                        </div>

                    </div>
                    
                </div>
                
                <?php
                $chatbot_notif_counter++;
            }
            
        } else {
            ?>
            <div class="row">
                <div class="col-xs-12">
                    <button type="button"
                            class="btn btn-danger btn-sm wp-chatbot-remove-notification pull-right">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>
                    <div class="cxsc-settings-blocks">
                        <?php wp_editor(html_entity_decode(stripcslashes('')), 'qlcd_wp_chatbot_notifications_'.$language.'_0', array('textarea_name' =>
                            'qlcd_wp_chatbot_notifications['.get_wpbot_locale().'][]',
                            'textarea_rows' => 20,
                            'editor_height' => 100,
                            'disabled' => 'disabled',
                            'media_buttons' => false,
                            'tinymce'       => array(
                                'toolbar1'      => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,link,unlink',)
                        )); ?>
                    </div>
                    <div class="cxsc-settings-blocks">
                        <h4 class="qc-opt-title">Select an Intent for Click Action</h4>     
                        <select name="qlcd_wp_chatbot_notifications_intent[<?php echo get_wpbot_locale(); ?>][]">

                            <?php 
                            if( is_array( $allIntents ) && ! empty( $allIntents ) ){
                                foreach($allIntents as $key => $value){
                                    ?>
                                    <optgroup label="<?php echo $key ?>">
                                        <option value="" >None</option>
                                        <?php foreach($value as $val){ ?>

                                            <option value="<?php echo $val; ?>" ><?php echo $val; ?></option>

                                        <?php } ?>
                                    </optgroup>
                                    <?php
                                }
                            }
                            ?>

                        </select>                                                   
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        </div>
        <div class="row">
            <div class="col-sm-6 text-left"></div>
            <div class="col-sm-6 text-right">
                <button class="btn btn-success btn-sm add-more-notification-message" type="button" data-language="<?php echo get_wpbot_locale(); ?>">
                    <i class="fa fa-plus" aria-hidden="true"></i> <?php echo esc_html__('Add', 'wpchatbot'); ?>
                </button>
            </div>
        </div>
        </div>
        
        <?php 
        }
    }

    public function render_faqs(){

        if( function_exists( 'qcld_wpbotml' ) ){
            do_action( 'ml_render_faqs' );
        } else {

    ?>
    <h4 class="qc-opt-title"><?php echo esc_html__('Build FAQ Query and Answers', 'wpchatbot'); ?></h4>
    <div class="block-inner ui-sortable" id="wp-chatbot-support-builder_<?php echo get_wpbot_locale(); ?>">
        <?php
        $support_quereis=qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize( get_option('support_query')));
        $support_ans=qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize( get_option('support_ans')));

        $support_quereis = (isset($support_quereis[get_wpbot_locale()])?$support_quereis[get_wpbot_locale()]:$support_quereis);
        $support_ans = (isset($support_ans[ get_wpbot_locale() ])?$support_ans[ get_wpbot_locale() ]:$support_ans);

        if (is_array( $support_ans ) && count($support_ans) >= 1) {
            
            $query_ans_counter=0;
            foreach (array_combine($support_quereis, $support_ans) as $query => $ans) {
                ?>
                <div class="row">
                    <span class="pull-right">  </span>
                    <div class="col-xs-12">
                        <button type="button"
                                class="btn btn-danger btn-sm wp-chatbot-remove-support pull-right">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </button>
                        <span  class="wp-chatbot-support-cross pull-right" >
                            <i  class="fa fa-crosshairs" aria-hidden="true"></i>
                        </span>
                        <div class="cxsc-settings-blocks">
                            <p class="qc-opt-dcs-font"><?php echo esc_html__('FAQ query ', 'wpchatbot'); ?></p>
                            <input type="text" class="form-control" name="support_query[<?php echo get_wpbot_locale(); ?>][]"
                                    placeholder="<?php echo esc_html__('FAQ query ', 'wpchatbot'); ?>" value="<?php echo esc_html($query) ?>">
                            <br>
                            <p class="qc-opt-dcs-font"><?php echo esc_html__('FAQ answer', 'wpchatbot'); ?></p>
                            <?php wp_editor(html_entity_decode(stripcslashes($ans)), 'support_ans_'.get_wpbot_locale().'_'.esc_html($query_ans_counter), array('textarea_name' =>
                            'support_ans['. get_wpbot_locale() .'][]',
                            'textarea_rows' => 20,
                            'editor_height' => 100,
                            'disabled' => 'disabled',
                            'media_buttons' => false,
                            'tinymce'       => array(
                            'toolbar1'      => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,link,unlink',)
                            )); ?>
                        </div>
                    </div>
                </div>
                <?php
                $query_ans_counter++;
            }
            
        } else {
            ?>
            <div class="row">
                <div class="col-xs-12">
                    <button type="button"
                            class="btn btn-danger btn-sm wp-chatbot-remove-support pull-right">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>
                    <span  class="wp-chatbot-support-cross pull-right" >
                            <i  class="fa fa-crosshairs" aria-hidden="true"></i>
                        </span>
                    <div class="cxsc-settings-blocks">
                        <p class="qc-opt-dcs-font"><?php echo esc_html__('FAQ query', 'wpchatbot'); ?> </p>
                        <input type="text" class="form-control" name="support_query[ <?php echo get_wpbot_locale(); ?> ][]"
                                placeholder="<?php echo esc_html__('FAQ query ', 'wpchatbot'); ?>">
                        <br>
                        <p class="qc-opt-dcs-font"><strong><?php echo esc_html__('FAQ answer', 'wpchatbot'); ?></strong></p>
                        <?php wp_editor(html_entity_decode(stripcslashes('')), 'support_ans_'.get_wpbot_locale().'_0', array('textarea_name' =>
                            'support_ans['. get_wpbot_locale() .'][]',
                            'textarea_rows' => 20,
                            'editor_height' => 100,
                            'disabled' => 'disabled',
                            'media_buttons' => false,
                            'tinymce'       => array(
                                'toolbar1'      => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,link,unlink',)
                        )); ?>
                    </div>
                    <br>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <div class="row">
        <div class="col-sm-6 text-left"></div>
        <div class="col-sm-6 text-right">
            <button class="btn btn-success btn-sm add-more-support-query " type="button"
                     data-language="<?php echo get_wpbot_locale(); ?>" ><i
                        class="fa fa-plus" aria-hidden="true"></i> <?php echo esc_html__('Add More Questions and Answers', 'wpchatbot'); ?>
            </button>
        </div>
    </div>

    <?php 
        }
    }

    public function render_start_menu($language){
        global $wpdb;
    ?>
        <ul>
            <li>
                <?php if(qcld_wpbot_is_active_livechat()==true): 
                    $data = get_option('wbca_options');
                    ?>
                    <span class="qcld-chatbot-custom-intent qc_draggable_item" data-text="<?php echo (isset($data['qlcd_wp_chatbot_sys_key_livechat']) && $data['qlcd_wp_chatbot_sys_key_livechat']!=''?$data['qlcd_wp_chatbot_sys_key_livechat']:'livechat'); ?>" ><?php echo (isset($data['qlcd_wp_livechat']) && $data['qlcd_wp_livechat']!=''?$data['qlcd_wp_livechat']:'Livechat'); ?></span>
                <?php endif; ?>
            </li>
            <li>
                <span class="qcld-chatbot-default wpbd_subscription qc_draggable_item"><?php 
                    $subscription = maybe_unserialize(get_option('qlcd_wp_email_subscription'));
                    
                    if( is_array( $subscription ) && isset( $subscription[$language] ) ){
                        echo $subscription[$language];
                    }else{
                        echo $subscription;
                    }
                ?></span>
            </li>
            <li>
                <?php if(get_option('enable_wp_custom_intent_livechat_button')==1 or qcld_wpbot_is_active_livechat()!==true): ?>
                    <span class="qcld-chatbot-default wpbo_live_chat qc_draggable_item" ><?php 
                        $livechat_button_label = maybe_unserialize(get_option('qlcd_wp_livechat_button_label'));
                        if( is_array( $livechat_button_label ) && isset( $livechat_button_label[$language] ) ){
                            echo $livechat_button_label[$language];
                        }else{
                            echo $livechat_button_label;
                        }
                    
                    ?></span>
                <?php endif; ?>
            </li>
            <li>
                <?php if(get_option('disable_wp_chatbot_site_search')==''): ?>
                    <span class="qcld-chatbot-site-search qc_draggable_item" ><?php 
                    $site_search = maybe_unserialize(get_option('qlcd_wp_site_search'));
                    if( is_array( $site_search ) && isset( $site_search[$language] ) ){
                        echo $site_search[$language];
                    }else{
                        echo $site_search;
                    }
                    ?></span>
                <?php endif; ?>
            
            </li>
            <li>
                <?php if(get_option('disable_wp_chatbot_faq')==''): ?>
                <span class="qcld-chatbot-wildcard qc_draggable_item"  data-wildcart="support"><?php 
                $wildcard_support = maybe_unserialize(get_option('qlcd_wp_chatbot_wildcard_support'));
                if( is_array( $wildcard_support ) && isset( $wildcard_support[$language] ) ){
                    echo $wildcard_support[$language];
                }else{
                    echo $wildcard_support;
                }
                ?></span>
                <?php endif; ?>
            
            </li>
            <li>
                <?php if(get_option('enable_wp_chatbot_messenger')=='1'): ?>
                <span class="qcld-chatbot-wildcard qc_draggable_item"  data-wildcart="messenger"><?php 
                $wildcard_support = maybe_unserialize(get_option('qlcd_wp_chatbot_messenger_label'));
                
                if( is_array( $wildcard_support ) && isset( $wildcard_support[$language] ) ){
                    echo qcld_choose_random($wildcard_support[$language]);
                }else{
                    echo qcld_choose_random($wildcard_support);
                }
                ?></span>

                <?php endif; ?>
            
            </li>

            <li>
                <?php if(get_option('enable_wp_chatbot_whats')=='1'): ?>
                <span class="qcld-chatbot-wildcard qc_draggable_item"  data-wildcart="whatsapp"><?php 
                    $whatsapp = maybe_unserialize(get_option('qlcd_wp_chatbot_whats_label'));
                    if( is_array( $whatsapp ) && isset( $whatsapp[$language] ) ){
                        echo qcld_choose_random($whatsapp[$language]);
                    }else{
                        echo qcld_choose_random($whatsapp);
                    }
                ?></span>
                <?php endif; ?>
            
            </li>

            <li>
                <?php if(get_option('disable_wp_chatbot_feedback')==''): ?>
                <span class="qcld-chatbot-suggest-email qc_draggable_item"><?php 
                $send_us_email = maybe_unserialize(get_option('qlcd_wp_send_us_email'));
                if( is_array( $send_us_email ) && isset( $send_us_email[$language] ) ){
                    echo $send_us_email[$language];
                }else{
                    echo $send_us_email;
                }
                ?></span>
                <?php endif; ?>
            
            </li>

            <li>
                <?php if(get_option('disable_wp_leave_feedback')==''): ?>
                <span class="qcld-chatbot-suggest-email wpbd_feedback qc_draggable_item"><?php 
                
                $leave_feedback = maybe_unserialize(get_option('qlcd_wp_leave_feedback'));
                if( is_array( $leave_feedback ) && isset( $leave_feedback[$language] ) ){
                    echo $leave_feedback[$language];
                }else{
                    echo $leave_feedback;
                }
                ?></span>
                <?php endif; ?>
            
            </li>

            <li>
                <?php if(get_option('disable_good_bye')==''): ?>
                <span class="qcld-chatbot-default wpbd_good_bye qc_draggable_item"><?php 
                
                $leave_feedback = maybe_unserialize(get_option('qlcd_wp_good_bye'));
                if( is_array( $leave_feedback ) && isset( $leave_feedback[$language] ) ){
                    echo $leave_feedback[$language];
                }else{
                    echo ($leave_feedback!=''?$leave_feedback:'GoodBye');
                }
                ?></span>
                <?php endif; ?>
            
            </li>

            <li>
                <?php if(get_option('disable_wp_chatbot_call_gen')==''): ?>
                <span class="qcld-chatbot-suggest-phone qc_draggable_item" ><?php 
                    $support_phone = maybe_unserialize(get_option('qlcd_wp_chatbot_support_phone'));
                    if( is_array( $support_phone ) && isset( $support_phone[$language] ) ){
                        echo $support_phone[$language];
                    }else{
                        echo $support_phone;
                    } 
                ?></span>
                <?php endif; ?>
            
            </li>
            
            <?php if(get_option('disable_str_categories')=='' && class_exists('Qcld_str_pro')):?>
            
            <li>
                
                <span class="qcld-chatbot-wildcard wpbd_str_categories qc_draggable_item" ><?php 
                $str_category = maybe_unserialize(get_option('qlcd_wp_str_category'));
                if( is_array( $str_category ) && isset( $str_category[$language] ) ){
                    echo $str_category[$language];
                }else{
                    echo ($str_category!=''?$str_category:'STR Categories');
                } 
                ?></span>
                
            
            </li>
            
            <?php endif; ?>

            <?php
        
           
            if(get_option('disable_voice_message')=='' && ((is_plugin_active( 'voice-message-addon/wpbotvoicemessage.php' ) || (in_array( "WPBot Voice Module",get_option( 'wpbot_master_addons')['active'])) ) || (in_array( "WPBot Voice Module",get_option( 'wpbot_master_addons')['active'])) )):?>
            
                <li>  

                    <span class="qcld-chatbot-wildcard wpbd_voice_message qc_draggable_item" ><?php 
                    $str_category = maybe_unserialize(get_option('qlcd_wp_voice_message'));
                    if( is_array( $str_category ) && isset( $str_category[$language] ) ){
                        echo $str_category[$language];
                    }else{
                        echo ($str_category!=''?$str_category:'Voice Message');
                    } 
                    ?></span>

                </li>
            <?php endif; ?>

            <?php 
                if(function_exists('qcpd_wpwc_addon_lang_init')){
                    do_action('qcld_wpwc_start_menu_option_woocommerce', $language);
                }

            ?>

        </ul>

        <?php 
        $ai_df = get_option('enable_wp_chatbot_dailogflow');
        $custom_intent_labels = maybe_unserialize( get_option('qlcd_wp_custon_intent_label'));
        if($ai_df==1 && isset($custom_intent_labels[0]) && trim($custom_intent_labels[0])!=''):
        ?>
        <p>Custom Intents</p>
        <ul>

            <?php foreach($custom_intent_labels as $custom_intent_label): ?>
                <li>
                <span class="qcld-chatbot-custom-intent qc_draggable_item" data-text="<?php echo $custom_intent_label ?>" ><?php echo $custom_intent_label ?></span>

                </li>
            <?php endforeach; ?>
            
        </ul>
        <?php endif; ?>

        <?php 
        $qlcd_wp_custon_menu = maybe_unserialize( get_option('qlcd_wp_custon_menu'));
        $qlcd_wp_custon_menu_link = maybe_unserialize( get_option('qlcd_wp_custon_menu_link'));
        $qlcd_wp_custon_menu_link_type = maybe_unserialize( get_option('qlcd_wp_custon_menu_type'));
        $qlcd_wp_custon_menu_checkbox = maybe_unserialize( get_option('qlcd_wp_custon_menu_checkbox'));

        if(isset($qlcd_wp_custon_menu[0]) && trim($qlcd_wp_custon_menu[0])!=''):
        ?>
        <p>Custom Button</p>
        <ul>

            <?php foreach($qlcd_wp_custon_menu as $key=>$value): ?>
                <li>
                <span class="qcld-chatbot-wildcard qcld-chatbot-buttonlink qc_draggable_item" data-link="<?php echo (isset($qlcd_wp_custon_menu_link[$key])?$qlcd_wp_custon_menu_link[$key]:''); ?>" data-target="<?php echo (isset($qlcd_wp_custon_menu_checkbox[$key])?$qlcd_wp_custon_menu_checkbox[$key]:'') ?>" data-type="<?php echo isset($qlcd_wp_custon_menu_link_type[$key])?$qlcd_wp_custon_menu_link_type[$key]:'link'; ?>" ><?php echo $value ?></span>

                </li>
            <?php endforeach; ?>
            
        </ul>
        <?php endif; ?>
        
        <?php if(class_exists('Qcld_kbx_support')): ?>
        <p>KBX Support Ticket Button</p>
        <ul>

    <?php 
    if(get_option('qcld_support_page_id') && get_option('qcld_support_page_id')!=''){
    $kbx_page_id = get_option('qcld_support_page_id');
    }else{
    $kbx_page_id = get_page_by_title('Support Ticket for KBX');
    }
    if($kbx_page_id!=''){
    $support_page = get_post( $kbx_page_id ); 
    $support_page_url = get_permalink($kbx_page_id);
    ?>
                <li>
                <span class="qcld-chatbot-wildcard qcld-chatbot-buttonlink qc_draggable_item" data-link="<?php echo ($support_page_url); ?>" data-target="<?php echo (1); ?>" ><?php 
                
                $ticket_label = get_option('qlcd_open_ticket_label');
                if( is_array( $ticket_label ) && isset( $ticket_label[$language] ) ){
                    echo $ticket_label[$language];
                }else{
                    echo ($ticket_label==''?$ticket_label:'Open a Ticket');
                } 
                ?></span>

                </li>
            
    <?php } ?>                                                    
        </ul>
        <?php endif; ?>

        
        <?php
        if(class_exists('Qcformbuilder_Forms_Admin')){
            global $wpdb;

            $results = $wpdb->get_results("SELECT * FROM ". $wpdb->prefix."wfb_forms where 1 and type='primary'");
            if(!empty($results)){
            ?>
            <p>Conversational Form</p>
            <ul>
            <?php
                foreach($results as $result){
                    $form = maybe_unserialize($result->config);
                ?>
                    <li><span class="qcld-chatbot-wildcard qcld-chatbot-form qc_draggable_item" data-form="<?php echo $form['ID']; ?>" ><?php echo $form['name']; ?></span></li>
                <?php
                }
                ?>
            </ul>
            <?php
            }
        }
        ?>

        <?php
            $results = qc_wpbot_simple_response_intent();
            global $wpdb;

            if(!empty($results)){
            ?>
            <p>Simple Text Response Intent</p>
            <ul>
            <?php
                foreach($results as $result){
                    
                ?>
                    <li><span class="qcld-chatbot-wildcard qcld_simple_txt_response qc_draggable_item" ><?php echo $result; ?></span></li>
                <?php
                }
                ?>
            </ul>
            <?php
            }
        
        ?>
        <?php 
        $table = $wpdb->prefix.'wpbot_response_category';
        if ( $wpdb->get_var("SHOW TABLES LIKE '$table'") == $table ) {
            $categories = $wpdb->get_results("select * from $table where 1 and custom=''");
            if ( ! empty( $categories ) && class_exists('Qcld_str_pro') ) {
                ?>
                <p>Simple Text Response Categories</p>
                <ul>
                    <?php 
                    foreach( $categories as $category ) {
                        ?>
                        <li><span class="qcld-chatbot-wildcard qcld_simple_txt_response qc_draggable_item" ><?php echo $category->name; ?></span></li>
                        <?php
                    }
                    ?>
                </ul>
                <?php
            }
        }
        ?>
        <?php

            $cx = false;
            $alanguage = get_option('qlcd_wp_chatbot_dialogflow_agent_language');
            if( $alanguage && is_array( $alanguage ) && array_key_exists( $language, $alanguage ) ){
                $alanguage = $alanguage[$language];
                $cx = true;
            }
            //project ID
            $project_ID = get_option('qlcd_wp_chatbot_dialogflow_project_id');
            if( $project_ID && is_array( $project_ID ) && array_key_exists( $language, $project_ID ) && $cx ){
                $project_ID = $project_ID[$language];
            }else{
                $cx = false;
            }
            // Service Account Key json file
            $JsonFileContents = get_option('qlcd_wp_chatbot_dialogflow_project_key');
            if( $JsonFileContents && is_array( $JsonFileContents ) && array_key_exists( $language, $JsonFileContents ) && $cx ){
                $JsonFileContents = $JsonFileContents[$language];
            }else{
                $cx = false;
            }

            $dialogflow_cx = maybe_unserialize(get_option( 'qlcd_wp_chatbot_dialogflow_cx' ));
            if( $dialogflow_cx && is_array( $dialogflow_cx ) && array_key_exists( $language, $dialogflow_cx ) && $cx ){
                $dialogflow_cx = $dialogflow_cx[$language];
            }else{
                $cx = false;
            }

            if( $cx ){
            ?>
            <p>Dialogflow CX</p>
            <ul>
                <?php
               $agents = qcld_wpbot_df_cx_agent(true, $language);
                if( is_array( $agents ) && isset($agents['agents']) ){
                    foreach($agents['agents'] as $agent){
                        
                    ?>
                        <li><span class="qcld-chatbot-wildcard qcld_wpbot_df_cx_agent qc_draggable_item" data-agent-name="<?php echo esc_attr( $agent['name'] ); ?>" data-agent-diaplay-name="<?php echo esc_attr( $agent['displayName'] ); ?>" data-agent-defaultlanguagecode="<?php echo esc_attr( $agent['defaultLanguageCode'] ); ?>" data-agent-timezone="<?php echo esc_attr( $agent['timeZone'] ); ?>" ><?php echo esc_html( $agent['displayName'] ); ?></span></li>
                    <?php
                    }
                    ?>
                </ul>
            <?php
                }
            }
            

        ?>

    <?php
    }

    /**
     * Render retargeting message fields
     * 
     */
    public function render_retmsg_field( $title, $key ){
        if( function_exists( 'qcld_wpbotml' ) ){
            do_action( 'ml_render_retmsg', $title, $key );
        } else {
        ?>
            <h4 class="qc-opt-title"><?php echo $title; ?> </h4>
            <?php 
            $finalkey = $key.'['.get_wpbot_locale().']';
            $exit_intent_settings = array('textarea_name' =>
                $finalkey,
                'textarea_rows' => 20,
                'editor_height' => 100,
                'disabled' => 'disabled',
                'media_buttons' => false,
                'tinymce'       => array(
                    'toolbar1'      => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,link,unlink',)
            );
            
            $ret_intent_message = maybe_unserialize( get_option($key) );
            if( is_array( $ret_intent_message ) && isset( $ret_intent_message[get_wpbot_locale()] )){
                $ret_intent_message = $ret_intent_message[get_wpbot_locale()];
            }
            wp_editor(html_entity_decode(stripslashes( $ret_intent_message )), $key.'_'.get_wpbot_locale(), $exit_intent_settings); 
        
        }
    }

    public function render_dialogflow(){
        if( function_exists( 'qcld_wpbotml' ) ){
            do_action( 'ml_render_dialogflow' );
        } else {
        
        $project_id = maybe_unserialize(get_option( 'qlcd_wp_chatbot_dialogflow_project_id' ));
        if( $project_id && is_array( $project_id ) && array_key_exists( get_wpbot_locale(), $project_id ) ){
            $project_id = $project_id[get_wpbot_locale()];
        }

        $private_key = maybe_unserialize(get_option( 'qlcd_wp_chatbot_dialogflow_project_key' ));
        if( $private_key && is_array( $private_key ) && array_key_exists( get_wpbot_locale(), $private_key ) ){
            $private_key = $private_key[get_wpbot_locale()];
        }

        $default_reply = maybe_unserialize(get_option( 'qlcd_wp_chatbot_dialogflow_defualt_reply' ));
        if( $default_reply && is_array( $default_reply ) && array_key_exists( get_wpbot_locale(), $default_reply ) ){
            $default_reply = $default_reply[get_wpbot_locale()];
        }

        $dialogflow_cx = maybe_unserialize(get_option( 'qlcd_wp_chatbot_dialogflow_cx' ));
        if( $dialogflow_cx && is_array( $dialogflow_cx ) && array_key_exists( get_wpbot_locale(), $dialogflow_cx ) ){
            $dialogflow_cx = $dialogflow_cx[get_wpbot_locale()];
        }

        $agent_language = maybe_unserialize(get_option( 'qlcd_wp_chatbot_dialogflow_agent_language' ));
        if( $agent_language && is_array( $agent_language ) && array_key_exists( get_wpbot_locale(), $agent_language ) ){
            $agent_language = $agent_language[get_wpbot_locale()];
        }
    ?>
        <!-- Dialogflow V2 Configuration -->
        <div class="form-group">
            <h4 class="qc-opt-title"><?php echo esc_html__('DialogFlow Project ID', 'wpchatbot'); ?></h4>
            <p>You can follow the <a href="https://www.youtube.com/watch?v=qY-EHFY2wH8" target="_blank">tutorial</a> to get the Project ID. </p>
            <input type="text" class="form-control qc-opt-dcs-font"
                    name="qlcd_wp_chatbot_dialogflow_project_id[<?php echo get_wpbot_locale(); ?>]"
                    value="<?php echo $project_id; ?>" placeholder="<?php echo esc_html__('DialogFlow Project ID', 'wpchatbot'); ?>">
        </div>


        <?php 
        $placeholderPrivatekey = '{
            "type": "service_account",
            "project_id": "PLACEYOUROWNID",
            "private_key_id": "31e300128..........c48",
            "private_key": "-----BEGIN PRIVATE KEY-----\nTHIS IS A DEMO PRIVATE KEY to SHOW HOW IT SHOULD LOOK. Replace with ACTUAL KEY.+OdT09MGEdAjlgSF2HMDA3fl8Ey4dmTxRfAN9No6G3Ugs3BrpZHfY\nSviWzS4JQ0GkCubcJc0DzJ8AqG6xX7E3SfKpdtKEn1eYV7sfQL3C2lm2lTj6nWdt\nxrkhJVHn61kxfPAWChnkdPa5EbMNFnV5mN5rhwaOxR+tEjW9nWBjVFG0NMnOMWF4\nsu6QJVjQMtI99jPBCid1r4XV/sPABSXh8dscWdMinGhZfuCjF4sOGHUUaw+VDGb6\nZpPOh65nw5fsdOHETsb4BN/LW72Khux+870Ig4jkuLIN3PnSF9QfwO8U2qTG5sZK\nn5nxhT9zAgMBAAECggEAX1NSWRGnrcVsu6n1jn9xUpzvxyy+CJe1Z1DvHo1tmHNS\n0Q8OI/Y........THIS IS A DEMO PRIVATE KEY to SHOW HOW IT SHOULD LOOK. Replace with your own key......................................paqQKBgQCJ\nvNCZIHpLGVqwiw4SVYgZW2i+VsZ78sOw0SuuhjZNmOlGjpalbQCjKs9l5dSz5t5D\nVleJVyriFaXyvVty/iF6orqTgv0EhcLO2RI9KSrTpbOXcIkgeunAhRM3oloxSndt\n98H3f1xRvTLIm1enERLkOyGHmm7nWFV0BQWD+CxeCwKBgDtBGn+uBgNgZjSaLnkJ\noemAoIBN6aD4+QWduPldRgTilH6ABQ26SL+t4sa9jbAtkMuD/hWOMLBqmz98tfCC\ndy6cPghea+b0S7lj/wmUaDA1Vmz7luCLm+lO+fe3K6WIlEhAP/9MXVH90Sj6CllF\nAn4stWzIKHrRKA3lIvgJv+9W\n-----END PRIVATE KEY-----\n",
            "client_email": "dialogflow-evysjn@wpbotpro.iam.gserviceaccount.com",
            "client_id": "1026.....032997",
            "auth_uri": "https://accounts.google.com/o/oauth2/auth",
            "token_uri": "https://oauth2.googleapis.com/token",
            "auth_provider_x509_cert_url": "https://www.googleapis.com/oauth2/v1/certs",
            "client_x509_cert_url": "https://www.googleapis.com/robot/v1/metadata/x509/dialogflow-evysjn%40wpbotpro.iam.gserviceaccount.com"
        }';
        ?>

        <div class="form-group">
            <h4 class="qc-opt-title"><?php echo esc_html__('Private Key', 'wpchatbot'); ?></h4>
            <p>Put your google service account's private key JSON string here. You can follow the <a href="https://www.youtube.com/watch?v=qY-EHFY2wH8" target="_blank">tutorial</a> to get private key JSON file. </p>
            <textarea class="form-control" rows="20" name="qlcd_wp_chatbot_dialogflow_project_key[<?php echo get_wpbot_locale(); ?>]" placeholder='<?php echo $placeholderPrivatekey; ?>'><?php echo $private_key; ?></textarea>
        </div>

        <!-- End Dialogflow V2 Configuration -->
        

        <div class="form-group">
            <h4 class="qc-opt-title"><?php echo esc_html__('DialogFlow Defualt reply', 'wpchatbot'); ?></h4>
            <input type="text" class="form-control qc-opt-dcs-font"
                    name="qlcd_wp_chatbot_dialogflow_defualt_reply[<?php echo get_wpbot_locale(); ?>]"
                    value="<?php echo $default_reply; ?>" placeholder="<?php echo esc_html__('DialogFlow defualt reply', 'wpchatbot'); ?>">
        </div>
        
        <div class="form-group">
            <h4 class="qc-opt-title"><?php echo esc_html__('DialogFlow Agent Language (Ex: en)', 'wpchatbot'); ?></h4>
            <input type="text" class="form-control qc-opt-dcs-font"
                    name="qlcd_wp_chatbot_dialogflow_agent_language[<?php echo get_wpbot_locale(); ?>]"
                    value="<?php echo $agent_language; ?>" placeholder="<?php echo esc_html__('DialogFlow Agent Language', 'wpchatbot'); ?>">
        </div>

        <div class="form-group">
            <h4 class="qc-opt-title"><?php echo esc_html__('Enable Dialogflow CX', 'wpchatbot'); ?></h4>
            <input type="checkbox" id="qlcd_wp_chatbot_dialogflow_cx[<?php echo get_wpbot_locale(); ?>]" class="form-control qc-opt-dcs-font"
                    name="qlcd_wp_chatbot_dialogflow_cx[<?php echo get_wpbot_locale(); ?>]"
                    value="1" <?php echo ($dialogflow_cx==1?'checked':''); ?> />
            
             <label for="qlcd_wp_chatbot_dialogflow_cx[<?php echo get_wpbot_locale(); ?>]"><?php echo esc_html__('Enable Dialogflow CX', 'wpchatbot'); ?> </label>
        </div>
        <br>
        <div class="form-group">
            <h4 class="qc-opt-title"><?php echo esc_html__('Please Click the Button Below to Test Dialogflow Connection.', 'wpchatbot'); ?> </h4>
            <p style="color:red"><?php echo esc_html__('*Save settings before pressing Test Dialogflow Connection', 'wpchatbot'); ?><br><?php echo esc_html__('*You must have owner permission for the service account your are using in Dialogflow agent.', 'wpchatbot'); ?></p>
            <div class="cxsc-settings-blocks">
            <button class="btn btn-primary qc_wpbot_df_status" data-language="<?php echo get_wpbot_locale(); ?>" >Test Dialogflow Connection</button>
                <div class="qcwp_df_status"></div>
            </div>
        </div>
    <?php
        }
    }

    public static function entities() {
        global $wpdb;
        $table = $wpdb->prefix.'wpbot_response_entities';
		$results = $wpdb->get_results("select * from $table where 1 ");

        $entities = array(
            'default' => array(
                '@name' => array(
                    'entity' => '@name'
                ),
                '@age' => array(
                    'entity' => '@age'
                ),
                '@number' => array(
                    'entity' => '@number'
                ),
                '@date' => array(
                    'entity' => '@date'
                ),
                '@date-of-birth' => array(
                    'entity' => '@date-of-birth'
                ),
                '@place' => array(
                    'entity' => '@place'
                ),
                '@day' => array(
                    'entity' => '@day'
                ),
                '@email' => array(
                    'entity' => '@email'
                ),
                '@color' => array(
                    'entity' => '@color'
                ),
            ),
        );

        if ( ! empty( $results ) ) {
            foreach( $results as $result ) {
                $entities['custom'][$result->entity] = array(
                    'entity' => $result->entity,
                    'synonyms' => $result->synonyms
                );
            }
        }

        return $entities;
    }
}
