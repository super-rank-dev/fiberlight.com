<?php

class Qcld_startmenu_actions
{
    public function __construct(){
        add_action( 'render_start_menu', array( $this, 'render_start_menu' ) );
        add_action( 'render_back_to_menu_button', array( $this, 'render_back_to_menu_button' ) );
    }

    /**
     * Render back to menu button
     *
     * @return void
     */
    public function render_back_to_menu_button(){
    ?>

<span class="qcld_back_to_start_menu"><i class="fa fa-home" aria-hidden="true"></i></span>
<?php
    }

    public function get_item_order(){

        $items = array();
        if( get_option( 'enable_start_conversation' ) && get_option( 'enable_start_conversation' ) == 1 ){
            $items['enable_start_conversation'] = array(
                'filename'  => 'start-conversation',
                'priority'  => get_option( 'start_conversation_priority' )
            );
        }

        if( get_option( 'enable_buttons_section' ) && get_option( 'enable_buttons_section' ) == 1 ){
            $items['enable_buttons_section'] = array(
                'filename'  => 'buttons-section',
                'priority'  => get_option( 'button_section_priority' )
            );
        }

        if( get_option( 'enable_integration_button_section' ) && get_option( 'enable_integration_button_section' ) == 1 ){
            $items['enable_integration_button_section'] = array(
                'filename'  => 'integration-buttons',
                'priority'  => get_option( 'integration_button_priority' )
            );
        }

        if( get_option( 'enable_search_section' ) && get_option( 'enable_search_section' ) == 1 ){
            $items['enable_search_section'] = array(
                'filename'  => 'search-section',
                'priority'  => get_option( 'search_section_priority' )
            );
        }
        
        if( get_option( 'enable_product_section' ) && get_option( 'enable_product_section' ) == 1 && function_exists( 'qcpd_wpwc_checking_dependencies' ) && class_exists( 'woocommerce' )){
            $items['enable_product_section'] = array(
                'filename'  => 'product-section',
                'priority'  => get_option( 'product_section_priority' )
            );
        }

        if( get_option( 'enable_blog_section' ) && get_option( 'enable_blog_section' ) == 1 ){
            $items['enable_blog_section'] = array(
                'filename'  => 'blog-section',
                'priority'  => get_option( 'blog_section_priority' )
            );
        }

        usort( $items, array( $this, 'sortByPriority' ) );
        return $items;
    }

    public function sortByPriority( $a, $b ){
        return $a['priority'] - $b['priority'];
    }

    /**
     * Render New start interface in chatbot templates using do_action
     *
     * @return void
     */
    public function render_start_menu(){
        $items = $this->get_item_order();
    ?>
    <div class="wp-chatbot-start-container">
        <div class="wp-chatbot-start-header">
            <div class="wp-chatbot-start-close"><i class="fa fa-times" aria-hidden="true"></i></div>
            <div class="wp-chatbot-start-header-content">
            <h2><?php echo qcld_bot_startmenu()->helper->get_option( 'qlcd_wp_chatbot_startmenu_hi' ); ?></h2>
            <p><?php echo qcld_bot_startmenu()->helper->get_option( 'qlcd_wp_chatbot_startmenu_promo' ); ?></p>
            </div>
            <?php if(get_option('enable_extended_header_animation') == 1) {?>
            <!-- for header animation -->
            <section class="wavemain">
            <div class="wave wave1"></div>
            <div class="wave wave2"></div>
            <div class="wave wave3"></div>
            <div class="wave wave4"></div>
            </section>
            <?php }?>
        </div>
        <div class="wp-chatbot-start-content">
            <div class="wp-chatbot-start-screen">
            <div class="wp-chatbot-start-screen-content">
                <?php 
                                if( ! empty( $items ) ){
                                    foreach( $items as $item ){
                                        include_once QCLD_STRTMENU_PLUGIN_DIR_PATH . 'includes/templates/' . $item['filename'] . '.php';
                                    }
                                }
                            ?>
            </div>
            </div>
        </div>
    </div>
<?php
    }
}

new Qcld_startmenu_actions();
