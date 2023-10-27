
<div class="wp-chatbot-wrap">

<form action="<?php echo esc_attr($action); ?>" method="POST" id="wp-chatbot-admin-form"
      enctype="multipart/form-data">
    <div class="container form-container">
        <header class="wp-chatbot-admin-header">
            <div class="row">
                <div class="col-sm-6">
                    <h2><?php echo esc_html__('Extended Interface', 'wpchatbot'); ?><?php echo get_option('wp_chatbot_index_meta'); ?></h2>
                </div>
                <div class="col-sm-6 text-right wp-chatbot-version">
                <?php qcld_wpbot_load_additional_validation_required(); ?>
                </div>
            </div>
        </header>
        <section class="wp-chatbot-tab-container-inner">
            <div class="wp-chatbot-tabs wp-chatbot-tabs-style-flip">
                <nav>
                    <ul>
                        
                        <li tab-data="startmenu"><a href="<?php echo esc_attr($action); ?>&tab=startmenu">
                            <span class="wpwbot-admin-tab-icon">
                                <i class="fa fa-toggle-on"> </i>
                            </span>
                            <span class="wpwbot-admin-tab-name"> <?php echo esc_html__('Start Menu', 'wpchatbot'); ?></span>
                        </a></li>

                        <li tab-data="languages"><a href="<?php echo esc_attr($action); ?>&tab=languages">
                            <span class="wpwbot-admin-tab-icon">
                                <i class="fa fa-toggle-on"> </i>
                            </span>
                            <span class="wpwbot-admin-tab-name"> <?php echo esc_html__('Language Center', 'wpchatbot'); ?></span>
                        </a></li>


                    </ul>
                </nav>
                <div class="content-wrap">
                    
                    
                    <section id="section-flip-2">
                    <?php 
                    wp_enqueue_style('qcld-wp-chatbot-common-style', QCLD_wpCHATBOT_PLUGIN_URL . '/css/common-style.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
                    ?>
                        <div class="top-section">
                            
                            <div class="row">
                                <div class="col-xs-12">
                                    <h4 class="qc-opt-title"> <?php echo esc_html__('Enable Extended Interface', 'botstartmenu'); ?> </h4>
                                    <div class="cxsc-settings-blocks">
                                        <input value="1" id="enable_extended_interface" type="checkbox"
                                                name="enable_extended_interface" <?php echo(get_option('enable_extended_interface') == 1 ? 'checked' : ''); ?>>
                                        <label for="enable_extended_interface"><?php echo esc_html__('Enable Extended Interface', 'botstartmenu'); ?> </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <h4 class="qc-opt-title"> <?php echo esc_html__('Enable Start Conversation Section', 'botstartmenu'); ?> </h4>
                                    <div class="cxsc-settings-blocks">
                                        <input value="1" id="enable_start_conversation" type="checkbox"
                                                name="enable_start_conversation" <?php echo(get_option('enable_start_conversation') == 1 ? 'checked' : ''); ?>>
                                        <label for="enable_start_conversation"><?php echo esc_html__('Enable start conversation section', 'botstartmenu'); ?> </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="startmenu_conversation_priority" <?php echo(get_option('enable_start_conversation') == 1 ? 'style="display:block"' : 'style="display:none"') ?> >
                                <div class="col-xs-12">
                                    <h4 class="qc-opt-title"> <?php echo esc_html__('Start Conversation Priority', 'botstartmenu'); ?> </h4>
                                    <div class="cxsc-settings-blocks">
                                        <input value="1" id="start_conversation_priority" type="number"
                                                name="start_conversation_priority" <?php echo(get_option('start_conversation_priority') ? get_option('start_conversation_priority') : '1'); ?>>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-xs-12">
                                    <h4 class="qc-opt-title"> <?php echo esc_html__('Enable Search Section', 'botstartmenu'); ?> </h4>
                                    <div class="cxsc-settings-blocks">
                                        <input value="1" id="enable_search_section" type="checkbox"
                                                name="enable_search_section" <?php echo(get_option('enable_search_section') == 1 ? 'checked' : ''); ?>>
                                        <label for="enable_search_section"><?php echo esc_html__('Enable search section', 'botstartmenu'); ?> </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="startmenu_search_priority" <?php echo(get_option('enable_search_section') == 1 ? 'style="display:block"' : 'style="display:none"') ?> >
                                <div class="col-xs-12">
                                    <h4 class="qc-opt-title"> <?php echo esc_html__('Start Conversation Priority', 'botstartmenu'); ?> </h4>
                                    <div class="cxsc-settings-blocks">
                                        <input value="<?php echo(get_option('search_section_priority') ? get_option('search_section_priority') : '2'); ?>" id="search_section_priority" type="number"
                                                name="search_section_priority" >
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-xs-12">
                                    <h4 class="qc-opt-title"> <?php echo esc_html__('Enable Integration Buttons', 'botstartmenu'); ?> </h4>
                                    <div class="cxsc-settings-blocks">
                                        <input value="1" id="enable_integration_button_section" type="checkbox"
                                                name="enable_integration_button_section" <?php echo(get_option('enable_integration_button_section') == 1 ? 'checked' : ''); ?>>
                                        <label for="enable_integration_button_section"><?php echo esc_html__('Enable integration buttons', 'botstartmenu'); ?> </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="integration_button_priority" <?php echo(get_option('enable_integration_button_section') == 1 ? 'style="display:block"' : 'style="display:none"') ?> >
                                <div class="col-xs-12">
                                    <h4 class="qc-opt-title"> <?php echo esc_html__('Integration Buttons Priority', 'botstartmenu'); ?> </h4>
                                    <div class="cxsc-settings-blocks">
                                        <input value="<?php echo(get_option('integration_button_priority') ? get_option('integration_button_priority') : '3'); ?>" id="integration_button_priority" type="number"
                                                name="integration_button_priority" >
                                    </div>
                                </div>
                            </div>

                            <?php if(function_exists( 'qcpd_wpwc_checking_dependencies' )): ?>
                            <hr>

                            <div class="row">
                                <div class="col-xs-12">
                                    <h4 class="qc-opt-title"> <?php echo esc_html__('Enable Product Section', 'botstartmenu'); ?> </h4>
                                    <div class="cxsc-settings-blocks">
                                        <input value="1" id="enable_product_section" type="checkbox"
                                                name="enable_product_section" <?php echo(get_option('enable_product_section') == 1 ? 'checked' : ''); ?>>
                                        <label for="enable_product_section"><?php echo esc_html__('Enable product Section', 'botstartmenu'); ?> </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="startmenu_product_section" <?php echo(get_option('enable_product_section') == 1 ? 'style="display:block"' : 'style="display:none"') ?> >

                                <div class="col-xs-12">
                                    <h4 class="qc-opt-title"> <?php echo esc_html__('Product Section Priority', 'botstartmenu'); ?> </h4>
                                    <div class="cxsc-settings-blocks">
                                        <input value="<?php echo(get_option('product_section_priority') ? get_option('product_section_priority') : '3'); ?>" id="product_section_priority" type="number"
                                                name="product_section_priority" >
                                    </div>
                                </div>

                                <div class="col-xs-12">
                                    <br>
                                    <h4 class="qc-opt-title"> <?php echo esc_html__('Select Product type', 'botstartmenu'); ?> </h4>
                                    <div class="cxsc-settings-blocks">
                                        <select name="startmenu_product_type" id="startmenu_product_type">
                                            <option value="latest" <?php echo (get_option( 'startmenu_product_type' ) && get_option( 'startmenu_product_type' ) == 'latest'?'selected="selected"':''); ?>>Latest Product</option>
                                            <option value="featured" <?php echo (get_option( 'startmenu_product_type' ) && get_option( 'startmenu_product_type' ) == 'featured'?'selected="selected"':''); ?>>Featured Product</option>
                                            <option value="sale" <?php echo (get_option( 'startmenu_product_type' ) && get_option( 'startmenu_product_type' ) == 'sale'?'selected="selected"':''); ?>>On Sale Product</option>
                                            
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xs-12">
                                    <br>
                                    <h4 class="qc-opt-title"> <?php echo esc_html__('Number of Products to Show', 'botstartmenu'); ?> </h4>
                                    <div class="cxsc-settings-blocks">
                                        <input value="<?php echo(get_option('startmenu_number_of_product') ? get_option('startmenu_number_of_product') : '4'); ?>" id="startmenu_number_of_product" type="number"
                                                name="startmenu_number_of_product" >
                                    </div>
                                </div>

                            </div>
                            <?php endif; ?>

                            <hr>

                            <div class="row">
                                <div class="col-xs-12">
                                    <h4 class="qc-opt-title"> <?php echo esc_html__('Enable Article/Blog Post Section', 'botstartmenu'); ?> </h4>
                                    <div class="cxsc-settings-blocks">
                                        <input value="1" id="enable_blog_section" type="checkbox"
                                                name="enable_blog_section" <?php echo(get_option('enable_blog_section') == 1 ? 'checked' : ''); ?>>
                                        <label for="enable_blog_section"><?php echo esc_html__('Enable article or blog post section', 'botstartmenu'); ?> </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="startmenu_blog_priority" <?php echo(get_option('enable_blog_section') == 1 ? 'style="display:block"' : 'style="display:none"') ?> >

                                <div class="col-xs-12">
                                    <h4 class="qc-opt-title"> <?php echo esc_html__('Article or Blog Section Priority', 'botstartmenu'); ?> </h4>
                                    <div class="cxsc-settings-blocks">
                                        <input value="<?php echo(get_option('blog_section_priority') ? get_option('blog_section_priority') : '4'); ?>" id="blog_section_priority" type="number"
                                                name="blog_section_priority" >
                                    </div>
                                </div>
                                
                                <div class="col-xs-12">
                                    <br>
                                    <h4 class="qc-opt-title"> <?php echo esc_html__('Select Post type', 'botstartmenu'); ?> </h4>
                                    <div class="cxsc-settings-blocks">
                                        <select name="blog_post_type" id="blog_post_type">
                                            <option value="post" <?php echo (get_option( 'blog_post_type' ) && get_option( 'blog_post_type' ) == 'post'?'selected="selected"':''); ?>>post</option>
                                            <option value="page" <?php echo (get_option( 'blog_post_type' ) && get_option( 'blog_post_type' ) == 'page'?'selected="selected"':''); ?>>page</option>
                                            <?php 
                                            $get_cpt_args = array(
                                                'public'   => true,
                                                '_builtin' => false
                                            );
                                            $post_types = get_post_types( $get_cpt_args, 'object' );
                                            foreach( $post_types as $post_type ){
                                                echo '<option value="' . $post_type->name . '" '.(get_option( 'blog_post_type' ) && get_option( 'blog_post_type' ) == $post_type->name?'selected="selected"':'').' > '. $post_type->name .' </option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xs-12">
                                    <br>
                                    <h4 class="qc-opt-title"> <?php echo esc_html__('Query post by Specific IDs', 'botstartmenu'); ?> </h4>
                                    <div class="cxsc-settings-blocks">
                                        <input value="<?php echo(get_option('blog_post_ids') ? get_option('blog_post_ids') : ''); ?>" id="blog_post_ids" type="text"
                                                name="blog_post_ids" >
                                        <small><i>Set comma seperated list of IDs (10, 22, 23 etc). Leave blank for default.</i></small>
                                    </div>
                                </div>

                                <div class="col-xs-12">
                                    <br>
                                    <h4 class="qc-opt-title"> <?php echo esc_html__('Number of Post to Show', 'botstartmenu'); ?> </h4>
                                    <div class="cxsc-settings-blocks">
                                        <input value="<?php echo(get_option('blog_number_of_post') ? get_option('blog_number_of_post') : '5'); ?>" id="blog_number_of_post" type="number"
                                                name="blog_number_of_post" >
                                    </div>
                                </div>
                                
                                <div class="col-xs-12">
                                    <br>
                                    <h4 class="qc-opt-title"> <?php echo esc_html__('Post Display Orderby', 'botstartmenu'); ?> </h4>
                                    <div class="cxsc-settings-blocks">
                                        <select name="blog_post_display_orderby" id="blog_post_display_orderby">
                                            <option value="title" <?php echo (get_option('blog_post_display_orderby')=='title'?'selected="selected"':''); ?>>Title</option>
                                            <option value="ID" <?php echo (get_option('blog_post_display_orderby')=='ID'?'selected="selected"':''); ?>>ID</option>
                                            <option value="date" <?php echo (get_option('blog_post_display_orderby')=='date'?'selected="selected"':''); ?>>Date</option>
                                            <option value="modified" <?php echo (get_option('blog_post_display_orderby')=='modified'?'selected="selected"':''); ?>>Modified Date</option>
                                            <option value="rand" <?php echo (get_option('blog_post_display_orderby')=='rand'?'selected="selected"':''); ?>>Random</option>
                                            <option value="menu_order" <?php echo (get_option('blog_post_display_orderby')=='menu_order'?'selected="selected"':''); ?>>Menu Order</option>
                                            <option value="none" <?php echo (get_option('blog_post_display_orderby')=='none'?'selected="selected"':''); ?>>None</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-xs-12">
                                    <br>
                                    <h4 class="qc-opt-title"> <?php echo esc_html__('Post Display Order', 'botstartmenu'); ?> </h4>
                                    <div class="cxsc-settings-blocks">
                                        <select name="blog_post_display_order">
                                            <option value="ASC" <?php echo (get_option('blog_post_display_order')=='ASC'?'selected="selected"':''); ?>>Ascending</option>
                                            <option value="DESC" <?php echo (get_option('blog_post_display_order')=='DESC'?'selected="selected"':''); ?>>Descending</option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-xs-12">
                                    <h4 class="qc-opt-title"> <?php echo esc_html__('Enable Start Menu Buttons', 'botstartmenu'); ?> </h4>
                                    <div class="cxsc-settings-blocks">
                                        <input value="1" id="enable_buttons_section" type="checkbox"
                                                name="enable_buttons_section" <?php echo(get_option('enable_buttons_section') == 1 ? 'checked' : ''); ?>>
                                        <label for="enable_buttons_section"><?php echo esc_html__('Enable start menu buttons section', 'botstartmenu'); ?> </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="startmenu_buttons" <?php echo(get_option('enable_buttons_section') == 1 ? 'style="display:block"' : 'style="display:none"') ?>>
                                            
                                <div class="col-xs-12">
                                    <h4 class="qc-opt-title"> <?php echo esc_html__('Buttons Priority', 'botstartmenu'); ?> </h4>
                                    <div class="cxsc-settings-blocks">
                                        <input value="<?php echo(get_option('button_section_priority') ? get_option('button_section_priority') : '5'); ?>" id="button_section_priority" type="number"
                                                name="button_section_priority" >
                                    </div>
                                </div>

                                <div class="qcld_wpbot_startmenu_area col-xs-12">
                                    <?php 
                                        $menu_order = maybe_unserialize( get_option('qc_wpbot_start_menu_order') );
                                        if( $menu_order && isset( $menu_order[get_wpbot_locale()] )){
                                            $menu_order = $menu_order[get_wpbot_locale()];
                                        }

                                        // if no lang found then set it to empty.
                                        if ( is_array( $menu_order ) ) {
                                            $menu_order = '';
                                        }

                                    ?>
                                    <br>
                                    <h4 class="qc-opt-title"> <?php echo esc_html__('Buttons Sorting & Customization Area', 'botstartmenu'); ?> </h4>
                                    <p style="color:red">*After making changes in the settings, please clear browser cache and cookies before reloading the page or open a new Incognito window (Ctrl+Shit+N in chrome).</p>
                                    <p>In this section you can control the UI of the buttons.<br>
    To adjust the Active Buttons ordering just drag it up or down. To add a button in Active Buttons section simply drag a button from Available Buttons and drop it to Active Buttons. To remove a button from Active Buttons simple drag the button and drop it to Available Buttons or double click on the button element.</p>

                                    <p style="color:red">* After making any changes to buttons label, You must have to remove the button from "Active Button" and add it back from "Available Button".</p>
                                    <div class="qc_menu_setup_area">

                                        <div class="qc_menu_area">
                                            <h3>Active Buttons</h3>
                                            
                                            <div class="qc_menu_area_container qc_menu_area_sort" id="qc_menu_area">

                                                <?php echo ( $menu_order && $menu_order !='' ? stripslashes($menu_order) : ''); ?>

                                            </div>
                                        </div>

                                        <div class="qc_menu_list_area" >
                                            <h3>Available Buttons</h3>
                                            
                                            <div class="qc_menu_list_container">
                                                <p>Predefined Intents</p>
                                            
                                                <?php qcld_bot_startmenu()->helper->render_start_menu(get_wpbot_locale()); ?>

                                            </div>

                                        </div>
                                    
                                    </div>
                                    
                                    <input class="qc_wpbot_start_menu_order" type="hidden" name="qc_wpbot_start_menu_order[<?php echo get_wpbot_locale(); ?>]" value='<?php echo ( $menu_order && $menu_order !=''?stripslashes($menu_order):''); ?>' />
                                </div>
                            </div>
                        </div>
                    </section>

                    <section id="section-flip-1">
                        
                        <div class="wp-chatbot-language-center-summmery">
                            
                        </div>
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#wp-chatbot-lng-general"><?php echo esc_html__('General', 'botstartmenu'); ?></a></li>

                        </ul>
                        <div class="tab-content">
                            <div id="wp-chatbot-lng-general" class="tab-pane fade in active">
                                <div class="top-section">
                                    <div class="row">
                                        <div class="col-xs-12" id="wp-chatbot-language-section">
                                            <br>
                                            <div class="form-group">
                                                <?php
                                                $featured_product_welcome_options = maybe_unserialize(get_option(qcld_bot_startmenu()->settings['qlcd_wp_chatbot_startmenu_hi']['key']));
                                                $featured_product_welcome_option = qcld_bot_startmenu()->settings['qlcd_wp_chatbot_startmenu_hi']['key'];
                                                $featured_product_welcome_text = qcld_bot_startmenu()->settings['qlcd_wp_chatbot_startmenu_hi']['default'];
                                                qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($featured_product_welcome_options, $featured_product_welcome_option, $featured_product_welcome_text);
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <?php
                                                $featured_product_welcome_options = maybe_unserialize(get_option(qcld_bot_startmenu()->settings['qlcd_wp_chatbot_startmenu_promo']['key']));
                                                $featured_product_welcome_option = qcld_bot_startmenu()->settings['qlcd_wp_chatbot_startmenu_promo']['key'];
                                                $featured_product_welcome_text = qcld_bot_startmenu()->settings['qlcd_wp_chatbot_startmenu_promo']['default'];
                                                qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($featured_product_welcome_options, $featured_product_welcome_option, $featured_product_welcome_text);
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <?php
                                                $featured_product_welcome_options = maybe_unserialize(get_option(qcld_bot_startmenu()->settings['qlcd_wp_chatbot_startmenu_conversation']['key']));
                                                $featured_product_welcome_option = qcld_bot_startmenu()->settings['qlcd_wp_chatbot_startmenu_conversation']['key'];
                                                $featured_product_welcome_text = qcld_bot_startmenu()->settings['qlcd_wp_chatbot_startmenu_conversation']['default'];
                                                qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($featured_product_welcome_options, $featured_product_welcome_option, $featured_product_welcome_text);
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <?php
                                                $featured_product_welcome_options = maybe_unserialize(get_option(qcld_bot_startmenu()->settings['qlcd_wp_chatbot_startmenu_click_to_chat']['key']));
                                                $featured_product_welcome_option = qcld_bot_startmenu()->settings['qlcd_wp_chatbot_startmenu_click_to_chat']['key'];
                                                $featured_product_welcome_text = qcld_bot_startmenu()->settings['qlcd_wp_chatbot_startmenu_click_to_chat']['default'];
                                                qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($featured_product_welcome_options, $featured_product_welcome_option, $featured_product_welcome_text);
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <?php
                                                $featured_product_welcome_options = maybe_unserialize(get_option(qcld_bot_startmenu()->settings['qlcd_wp_chatbot_startmenu_start_conversation']['key']));
                                                $featured_product_welcome_option = qcld_bot_startmenu()->settings['qlcd_wp_chatbot_startmenu_start_conversation']['key'];
                                                $featured_product_welcome_text = qcld_bot_startmenu()->settings['qlcd_wp_chatbot_startmenu_start_conversation']['default'];
                                                qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($featured_product_welcome_options, $featured_product_welcome_option, $featured_product_welcome_text);
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <?php
                                                $featured_product_welcome_options = maybe_unserialize(get_option(qcld_bot_startmenu()->settings['qlcd_wp_chatbot_startmenu_find_ansers']['key']));
                                                $featured_product_welcome_option = qcld_bot_startmenu()->settings['qlcd_wp_chatbot_startmenu_find_ansers']['key'];
                                                $featured_product_welcome_text = qcld_bot_startmenu()->settings['qlcd_wp_chatbot_startmenu_find_ansers']['default'];
                                                qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($featured_product_welcome_options, $featured_product_welcome_option, $featured_product_welcome_text);
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <?php
                                                $featured_product_welcome_options = maybe_unserialize(get_option(qcld_bot_startmenu()->settings['qlcd_wp_chatbot_startmenu_search_articles']['key']));
                                                $featured_product_welcome_option = qcld_bot_startmenu()->settings['qlcd_wp_chatbot_startmenu_search_articles']['key'];
                                                $featured_product_welcome_text = qcld_bot_startmenu()->settings['qlcd_wp_chatbot_startmenu_search_articles']['default'];
                                                qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($featured_product_welcome_options, $featured_product_welcome_option, $featured_product_welcome_text);
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        
                    </section>
                </div>
                
            </div>
            <footer class="wp-chatbot-admin-footer">
                <div class="row">
                    <div class="text-left col-sm-3 col-sm-offset-3">
                        
                    </div>
                    <div class="text-right col-sm-6">
                        <input type="submit" class="btn btn-primary submit-button" name="submit"
                               id="submit" value="<?php echo esc_html__('Save Settings', 'wpchatbot'); ?>"/>
                    </div>
                </div>
                <!--                    row-->
            </footer>
        </section>
        
    </div>
</form>
</div>
