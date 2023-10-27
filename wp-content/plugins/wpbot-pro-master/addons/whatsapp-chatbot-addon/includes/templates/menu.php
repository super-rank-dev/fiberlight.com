<?php

wp_register_style('qlcd-wp-chatbot-admin-style', QCLD_wpCHATBOT_PLUGIN_URL . 'css/admin-style.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
wp_enqueue_style('qlcd-wp-chatbot-admin-style');
wp_enqueue_script('jquery');
wp_enqueue_script('jquery-ui-core');
wp_enqueue_script( 'jquery-ui-draggable' );
wp_enqueue_script( 'jquery-ui-droppable' );
wp_enqueue_style( 'wp-color-picker');
wp_enqueue_script( 'wp-color-picker');
wp_enqueue_script( 'jquery-ui-sortable');
wp_register_script('qcld-wp-chatbot-qcpickertm-js', QCLD_wpCHATBOT_PLUGIN_URL . 'js/jquery.timepicker.js', array('jquery'), true);
wp_register_script('qcld-wp-chatbot-admin-js', QCLD_wpCHATBOT_PLUGIN_URL . '/js/qcld-wp-chatbot-admin.js', array('jquery', 'jquery-ui-core','jquery-ui-sortable','wp-color-picker','qcld-wp-chatbot-qcpickertm-js'), true);
wp_enqueue_script('qcld-wp-chatbot-admin-js');
 wp_register_style('qcld-wp-chatbot-common-style', QCLD_wpCHATBOT_PLUGIN_URL . 'css/common-style.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
wp_enqueue_style('qcld-wp-chatbot-common-style');
ob_start();
?>
<div class="swpm-admin-menu-wrap">
    <form action="" method="POST">

    <?php 
    if( function_exists( 'qcld_wpbotml' ) ){
        do_action( 'ml_render_start_menu_wa' );
    } else {
    ?>

    <div class="qcld_messenger_menu_setup">
    
        <h2>Menu Sorting & Customization Area</h2>
        
        <p>In this section you can control the UI of the menu.<br>
To adjust the Active Menu ordering just drag it up or down. To add a menu item in Active Menu simply drag a menu item from Available Menu and drop it to Active Menu . To remove a menu item from Active Menu simple drag the menu item and drop it to Available Menu.</p>

        <p style="color:red">* After making any changes to buttons label, You must have to remove the button from "Active Menu" and add it back from "Available Menu Items".</p>
        <div class="qc_menu_setup_area">

            <div class="qc_menu_area">
                <h3>Active menu</h3>
                
                <div class="qc_menu_area_container qc_menu_area_sort" id="qc_menu_area">

                    <?php 
                    
                    $menu_order = maybe_unserialize(get_option('qc_wpbot_wa_menu_order'));
                    if( $menu_order && isset( $menu_order[get_wpbot_locale()] )){
                        $menu_order = $menu_order[get_wpbot_locale()];
                    }
                    $menu_order = maybe_unserialize($menu_order);
                    
                    if( ! is_array( $menu_order ) && strpos($menu_order, 'span') === false ){
                        $menu_order = '';
                    }
                    if( ! is_array( $menu_order ) && $menu_order != '' ){
                        echo stripslashes($menu_order);
                    }
                    
                    ?>

                </div>
            </div>

            <div class="qc_menu_list_area" >
                <h3>Available Menu items</h3>
                
                <div class="qc_menu_list_container">
                <p>Predefined Intents</p>
                
                <?php 
                
                    if( function_exists( 'qcld_wpbot' ) && property_exists( qcld_wpbot(), 'helper' ) && ( qcld_wpbot()->helper instanceof Qcld_WPBot_Helper ) && method_exists( qcld_wpbot()->helper,'render_start_menu' ) ):
                        
                ?>
                    <?php qcld_wpbot()->helper->render_start_menu(get_locale()); ?>
                <?php else: 
                    
                    ?>
                
                <ul>

                    <li>
                        <span class="qcld-chatbot-default wpbd_subscription qc_draggable_item"><?php echo get_option('qlcd_wp_email_subscription'); ?></span>
                    </li>
                    
                    <li>
                        <?php if(get_option('disable_wp_chatbot_site_search')==''): ?>
                            <span class="qcld-chatbot-site-search qc_draggable_item" ><?php echo get_option('qlcd_wp_site_search'); ?></span>
                        <?php endif; ?>
                    
                    </li>
                    <li>
                        <?php if(get_option('disable_wp_chatbot_faq')==''): ?>
                        <span class="qcld-chatbot-wildcard qc_draggable_item"  data-wildcart="support"><?php echo get_option('qlcd_wp_chatbot_wildcard_support'); ?></span>
                        <?php endif; ?>
                    
                    </li>

                    <li>
                        <?php if(get_option('disable_wp_chatbot_feedback')==''): ?>
                        <span class="qcld-chatbot-suggest-email qc_draggable_item"><?php echo get_option('qlcd_wp_send_us_email'); ?></span>
                        <?php endif; ?>
                    
                    </li>

                    <li>
                        <?php if(get_option('disable_wp_leave_feedback')==''): ?>
                        <span class="qcld-chatbot-suggest-email wpbd_feedback qc_draggable_item"><?php echo get_option('qlcd_wp_leave_feedback'); ?></span>
                        <?php endif; ?>
                    
                    </li>

                    <li>
                        <?php if(get_option('disable_wp_chatbot_call_gen')==''): ?>
                        <span class="qcld-chatbot-suggest-phone qc_draggable_item" ><?php echo get_option('qlcd_wp_chatbot_support_phone'); ?></span>
                        <?php endif; ?>
                    
                    </li>

                    <?php 
                        if(function_exists('qcpd_wpwc_addon_lang_init')){
                            do_action('qcld_wpwc_start_menu_option_woocommerce');
                        }

                    ?>

                </ul>

                <?php 
                $ai_df = get_option('enable_wp_chatbot_dailogflow');
                $custom_intent_labels = unserialize( get_option('qlcd_wp_custon_intent_label'));
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
                if(class_exists('Qcformbuilder_Forms_Admin')){
                    global $wpdb;

                    $results = $wpdb->get_results("SELECT * FROM ". $wpdb->prefix."wfb_forms where 1 and type='primary'");
                    if(!empty($results)){
                    ?>
                    <p>Conversational Form</p>
                    <ul>
                    <?php
                        foreach($results as $result){
                            $form = unserialize($result->config);
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
                <?php endif; ?>

                </div>

            </div>
        
        </div>
        
        <input class="qc_wpbot_menu_order" type="hidden" name="qc_wpbot_wa_menu_order[<?php echo get_wpbot_locale(); ?>]" value='<?php echo ( ! is_array( $menu_order ) && $menu_order != '' ? stripslashes($menu_order) : '' ); ?>' />
    
    </div>
    <div style="clear:both"></div>
    <?php } ?>
    <?php submit_button(); ?>
    </form>

</div>
<style type="text/css">
.qcld_messenger_menu_setup{width:900px}
</style>
<?php 
$content = ob_get_clean();
echo $content;