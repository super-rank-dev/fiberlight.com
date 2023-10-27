<?php

class Qcld_WA_Response
{

    /**
     * Request
     *
     * @var object Qcld_WA_Request
     * 
     * @since 1.0.0
     */
    private $request = '';

    /**
     * Menu Items
     * 
     * @since 1.0.0
     *
     * @var array
     */
    private $menu_items = array();

    /**
     * Faqs
     * 
     * @since 1.0.0
     *
     * @var array
     */
    private $faqs = array();

    public function __construct( Qcld_WA_Request $request ) {
        $this->request = $request;
        $this->menu_items = qcld_wa_getmenuitems();
        $this->faqs = maybe_unserialize( qcld_wa_get_option( 'support_query' ));
        $this->handle_response();
    }

    private function handle_response() {

        if ( $this->request->getSmsStatus() === 'received' ) {

            //handle message
            $message = trim( $this->request->getBody() );

            //start menu
            if ( 
                strtolower( $message ) == 'menu' || 
                strtolower( $message ) == 'help' || 
                strtolower( $message ) == 'start' || 
                strtolower( $message ) == '/start' || 
                strtolower( $message ) == strtolower( qcld_wa_get_option( 'qlcd_wp_chatbot_sys_key_help' ) ) 
            ) {
                qcld_wa_showstartmenu( $this->request );
            }

            
            // Convert number to command for start menu
            $message = $this->convert_number_to_command( $message );

            // Email Subscription intent handleing
            if ( qcld_wa_get_transient( $this->request->getWaId() . '_wa_subscription' ) && qcld_wa_get_transient( $this->request->getWaId() . '_wa_subscription' ) == 1 ) {
                if ( filter_var( $message, FILTER_VALIDATE_EMAIL ) ) {
                    qcld_wa_emailsubscription( $this->request, 2 );
                } else {
                    qcld_wa_emailsubscription( $this->request );
                }
                
            }

            // Send feedback, Email intent handleing step 2
            if ( qcld_wa_get_transient( $this->request->getWaId() . '_wa_feedback' ) && qcld_wa_get_transient( $this->request->getWaId() . '_wa_feedback' ) == 1 ) {
                if ( filter_var( $message, FILTER_VALIDATE_EMAIL ) ) {
                    qcld_wa_set_transient( $this->request->getWaId() . '_wa_feedback_email', $message );
                    qcld_wa_sendusemail( $this->request , 2 );
                    
                } else {
                    qcld_wa_sendusemail( $this->request );
                }
            }

            // Send feedback, Email intent handleing step 3
            if( qcld_wa_get_transient( $this->request->getWaId() . '_wa_feedback' ) && qcld_wa_get_transient( $this->request->getWaId() . '_wa_feedback' ) == 2 ) {
                qcld_wa_set_transient( $this->request->getWaId() . '_wa_feedback_msg', $message );
                qcld_wa_sendusemail( $this->request, 3 );
                
            }

            //faq response
            if ( qcld_wa_get_transient( $this->request->getWaId() . '_wa_faq' ) && qcld_wa_get_transient( $this->request->getWaId() . '_wa_faq' ) == 1 ) {
                qcld_wa_faq( $this->request, 'show_answer', $message );
            }

            //phone intent second option
            if ( qcld_wa_get_transient( $this->request->getWaId() . '_wa_phone' ) && qcld_wa_get_transient( $this->request->getWaId() . '_wa_phone' ) == 1 ) {
                qcld_wa_callmeback( $this->request, 2 );
            }

            // Handling site search intent
            if ( qcld_wa_get_transient( $this->request->getWaId() . '_wa_sitesearch' ) && qcld_wa_get_transient( $this->request->getWaId() . '_wa_sitesearch' ) == 1 ) {

                qcld_wa_sitesearch( $this->request, 2 );
                
            }

            // Email subscription intent
            if ( strtolower( $message ) == strtolower( qcld_wa_get_option( 'qlcd_wp_email_subscription' ) ) ) {
                qcld_wa_emailsubscription( $this->request );
            }

            // Send Us email intent trigger when button click
            if ( strtolower( $message ) == strtolower( qcld_wa_get_option( 'qlcd_wp_send_us_email' ) ) || strtolower( $message ) == strtolower( qcld_wa_get_option( 'qlcd_wp_leave_feedback' ) ) ) {
                qcld_wa_sendusemail( $this->request );
            }

            //Handle Phone callback
            if ( strtolower( $message ) == strtolower( qcld_wa_get_option( 'qlcd_wp_chatbot_support_phone' ) ) ) {
                qcld_wa_callmeback( $this->request );
            }

            //code for faq
            if ( strtolower( $message ) == strtolower( qcld_wa_get_option( 'qlcd_wp_chatbot_wildcard_support' ) ) || strtolower( $message ) == strtolower( qcld_wa_get_option( 'qlcd_wp_chatbot_sys_key_support' ) ) ) {
                qcld_wa_faq( $this->request, 'show_question' );
                
            }

            //Site search intent
            if ( strtolower( $message ) == strtolower( qcld_wa_get_option( 'qlcd_wp_site_search' ) != '' ? qcld_wa_get_option( 'qlcd_wp_site_search' ) : 'Site Search' ) ) {
                            
                qcld_wa_sitesearch( $this->request );
                

            }

            //handle conversationl form
            if( qcld_wa_get_transient( $this->request->getWaId() . '_wa_conversational_form') && qcld_wa_get_transient( $this->request->getWaId() . '_wa_conversational_form')!=''){
				qcld_wa_handle_cfb_next($this->request, $message );
                exit;
			}

            //Conversational form builder
            if ( class_exists('qcld_wb_Chatbot') ) {
                $ccommands = array_map( 'qc_wa_nestedLowercase', qc_get_formbuilder_form_commands() );
                $cformid = qc_get_formbuilder_form_ids();
                $cforms = array_map( 'qc_wa_nestedLowercase', qc_get_formbuilder_forms() );
                $get_formidby_keyword = qc_wa_findformid( $ccommands, $cforms, $cformid, strtolower( $message ) );
                if ( ! empty( $cformid ) && in_array( $get_formidby_keyword, $cformid ) ) {
                    qcld_wa_handle_formbuilder_response( $this->request, $get_formidby_keyword );
                }
            }

            //STR Categories intent
            if ( strtolower( $message ) == strtolower( qcld_wa_get_option( 'qlcd_wp_str_category' ) != '' ? qcld_wa_get_option( 'qlcd_wp_str_category' ) : 'STR Categories' ) ) {
                qcld_wa_strcategories( $this->request );
            }

            //STR Category if matched
            if ( in_array( strtolower( $message ), array_map( 'strtolower', get_str_categories() ) ) ) {
                qcld_wa_strcategory( $this->request, $message );
            }

            // Woocommerce intents
            if ( function_exists( 'qcld_wpwc_chatboot_plugin_init' ) ) {

                
                if ( qcld_wa_get_transient( $this->request->getWaId() . '_wa_order_email' ) && qcld_wa_get_transient( $this->request->getWaId() . '_wa_order_email' ) == 1 ) {

                    if ( filter_var( $message, FILTER_VALIDATE_EMAIL ) ) {
                        qcld_wa_product_order( $this->request, $message, 2 );
                    } else {
                        qcld_wa_product_order( $this->request, $message, 1 );
                    }

                }
                // order product
                // send the information to admin
                if ( qcld_wa_get_transient( $this->request->getWaId() . '_wa_product_showing' ) && qcld_wa_get_transient( $this->request->getWaId() . '_wa_product_showing' ) == 1 && qcld_wa_is_number( $message ) ) {
                    $message = $this->convert_number_to_command( $message, true );
                    qcld_wa_product_order( $this->request, $message, 1 );
                }
                
                if ( qcld_wa_get_transient( $this->request->getWaId() . '_wa_product_search' ) && qcld_wa_get_transient( $this->request->getWaId() . '_wa_product_search' ) == 1 ) {
                    qcld_wa_product_search( $this->request, $message, 2 );
                }
                
                // Asking email for order status
                if ( qcld_wa_get_transient( $this->request->getWaId() . '_wa_order_status' ) && qcld_wa_get_transient( $this->request->getWaId() . '_wa_order_status' ) == 1 ) {

                    if ( filter_var( $message, FILTER_VALIDATE_EMAIL ) ) {

                        qcld_wa_order_status( $this->request, $message, 2 );

                    } else {

                        qcld_wa_order_status( $this->request, $message, 1 );

                    }
                    
                }

                // Asking order id for order status
                if ( qcld_wa_get_transient( $this->request->getWaId() . '_wa_order_status' ) && qcld_wa_get_transient( $this->request->getWaId() . '_wa_order_status' ) == 2 ) {
                    qcld_wa_order_status( $this->request, $message, 3 );
                }

                // Product Search
                if ( in_array( strtolower( $message ), array_map( 'strtolower', qcld_wa_get_option( 'qlcd_wp_chatbot_wildcard_product' ) ) )  ) {
                    qcld_wa_product_search( $this->request, $message, 1 );
                }
                
                // Order status check
                if ( in_array( strtolower( $message ), array_map( 'strtolower', qcld_wa_get_option( 'qlcd_wp_chatbot_wildcard_order' ) ) )  ) {
                    qcld_wa_order_status( $this->request, $message, 1 );
                }
                
                
                // Sale product
                if ( in_array( strtolower( $message ), array_map( 'strtolower', qcld_wa_get_option( 'qlcd_wp_chatbot_sale_products' ) ) )  ) {
                    qcld_wa_sale_products( $this->request, $message );
                }
                
                
                // featured product
                if ( in_array( strtolower( $message ), array_map( 'strtolower', qcld_wa_get_option( 'qlcd_wp_chatbot_featured_products' ) ) )  ) {
                    qcld_wa_featured_products( $this->request, $message );
                }

            }

            //Find STR Responses and send
            qcld_wa_findstrresponses( $this->request, $message );
            // openai response
            if( qcld_wa_get_option( 'ai_enabled' ) == 1){
                qcld_wa_handle_openai($this->request, $message );
            }
            // dailogflow
            if( qcld_wa_get_option( 'enable_wp_chatbot_dailogflow' ) && qcld_wa_get_option( 'enable_wp_chatbot_dailogflow' ) == 1 && qcld_wa_get_option( 'wp_chatbot_df_api' ) && qcld_wa_get_option( 'wp_chatbot_df_api' )=='v2' ){
				//get reply for the msg from df
				qcld_wa_handle_dialogflow( $this->request, $message );
				
			}

            /*
            //Language switch

            
            */

        }
    }

    /**
     * Convert Number to string
     *
     * @param string $message
     * @return string $message
     */
    private function convert_number_to_command( $message, $internal = false ) {

        if ( strlen( $message ) > 2 ) {
            return $message;
        }

        // For internal call
        if ( $internal ) {
            if (
                qcld_wa_get_transient( $this->request->getWaId() . '_wa_product_showing' ) &&
                qcld_wa_get_transient( $this->request->getWaId() . '_wa_product_buttons' ) &&
                is_array( qcld_wa_get_transient( $this->request->getWaId() . '_wa_product_buttons' ) ) &&
                qcld_wa_is_number( $message )
    
            ) {
                $buttons = qcld_wa_get_transient( $this->request->getWaId() . '_wa_product_buttons' );
                if ( isset( $buttons[ $message - 1 ] ) && ! empty( $buttons[ $message - 1 ] ) ) {
                    $message = $buttons[ $message - 1 ];
                    qcld_wa_delete_transient( $this->request->getWaId() . '_wa_product_buttons' );
                    qcld_wa_delete_transient( $this->request->getWaId() . '_wa_product_showing' );
                }
            }

            return $message;
        }
        
        if ( 
            qcld_wa_get_transient( $this->request->getWaId() . '_start_menu' ) && 
            qcld_wa_is_number( $message ) && 
            isset( $this->menu_items[ $message - 1 ] ) &&
            ! empty( $this->menu_items[ $message - 1 ] ) 
        ) {
            $message = $this->menu_items[ $message - 1 ];
            qcld_wa_delete_transient( $this->request->getWaId() . '_start_menu' );
        }

        if ( 
            qcld_wa_get_transient( $this->request->getWaId() . '_faq_menu' ) && 
            qcld_wa_is_number( $message ) && 
            isset( $this->faqs[ $message - 1 ] ) &&
            ! empty( $this->faqs[ $message - 1 ] ) 
        ) {
            $message = $this->faqs[ $message - 1 ];
            qcld_wa_delete_transient( $this->request->getWaId() . '_faq_menu' );
        }

        if (
            qcld_wa_get_transient( $this->request->getWaId() . '_wa_cf_buttons' ) &&
            is_array( qcld_wa_get_transient( $this->request->getWaId() . '_wa_cf_buttons' ) ) &&
            qcld_wa_is_number( $message )

        ) {
            $buttons = qcld_wa_get_transient( $this->request->getWaId() . '_wa_cf_buttons' );
            if ( isset( $buttons[ $message - 1 ] ) && ! empty( $buttons[ $message - 1 ] ) ) {
                $message = $buttons[ $message - 1 ];
                qcld_wa_delete_transient( $this->request->getWaId() . '_wa_cf_buttons' );
            }
        }

        if (
            qcld_wa_get_transient( $this->request->getWaId() . '_wa_str_buttons' ) &&
            is_array( qcld_wa_get_transient( $this->request->getWaId() . '_wa_str_buttons' ) ) &&
            qcld_wa_is_number( $message )

        ) {
            $buttons = qcld_wa_get_transient( $this->request->getWaId() . '_wa_str_buttons' );
            if ( isset( $buttons[ $message - 1 ] ) && ! empty( $buttons[ $message - 1 ] ) ) {
                $message = $buttons[ $message - 1 ];
                qcld_wa_delete_transient( $this->request->getWaId() . '_wa_str_buttons' );
            }
        }

        if (
            qcld_wa_get_transient( $this->request->getWaId() . '_wa_df_buttons' ) &&
            is_array( qcld_wa_get_transient( $this->request->getWaId() . '_wa_df_buttons' ) ) &&
            qcld_wa_is_number( $message )

        ) {
            $buttons = qcld_wa_get_transient( $this->request->getWaId() . '_wa_df_buttons' );
            if ( isset( $buttons[ $message - 1 ] ) && ! empty( $buttons[ $message - 1 ] ) ) {
                $message = $buttons[ $message - 1 ];
                qcld_wa_delete_transient( $this->request->getWaId() . '_wa_df_buttons' );
            }
        }

        return $message;
    }
    
}
