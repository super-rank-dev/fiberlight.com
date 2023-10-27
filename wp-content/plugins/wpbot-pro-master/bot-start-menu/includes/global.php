<?php

$startmenu_settings = array(
    'qlcd_wp_chatbot_startmenu_hi' => array(
        'key'   => 'qlcd_wp_chatbot_startmenu_hi',
        'default'   => __('Hi  ✋', 'botstartmenu' ),
        'db'    => maybe_serialize( array( get_wpbot_locale() => array( __('Hi  ✋', 'botstartmenu' ) ) ) )
    ),
    'qlcd_wp_chatbot_startmenu_promo' => array(
        'key'   => 'qlcd_wp_chatbot_startmenu_promo',
        'default'   => __('We help your business grow by connecting you to your customers.', 'botstartmenu' ),
        'db'    => maybe_serialize( array( get_wpbot_locale() => array( __('We help your business grow by connecting you to your customers.', 'botstartmenu' ) ) ) )
    ),
    'qlcd_wp_chatbot_startmenu_conversation' => array(
        'key'   => 'qlcd_wp_chatbot_startmenu_conversation',
        'default'   => __('Start A Conversation', 'botstartmenu' ),
        'db'    => maybe_serialize( array( get_wpbot_locale() => array( __('Start A Conversation', 'botstartmenu' ) ) ) )
    ),
    'qlcd_wp_chatbot_startmenu_click_to_chat' => array(
        'key'   => 'qlcd_wp_chatbot_startmenu_click_to_chat',
        'default'   => __('Click here to chat with me!', 'botstartmenu' ),
        'db'    => maybe_serialize( array( get_wpbot_locale() => array( __('Click here to chat with me!', 'botstartmenu' ) ) ) )
    ),
    'qlcd_wp_chatbot_startmenu_start_conversation' => array(
        'key'   => 'qlcd_wp_chatbot_startmenu_start_conversation',
        'default'   => __('Start Conversation', 'botstartmenu' ),
        'db'    => maybe_serialize( array( get_wpbot_locale() => array( __('Start Conversation', 'botstartmenu' ) ) ) )
    ),
    'qlcd_wp_chatbot_startmenu_find_ansers' => array(
        'key'   => 'qlcd_wp_chatbot_startmenu_find_ansers',
        'default'   => __('Search our website now', 'botstartmenu' ),
        'db'    => maybe_serialize( array( get_wpbot_locale() => array( __('Search our website now', 'botstartmenu' ) ) ) )
    ),
    'qlcd_wp_chatbot_startmenu_search_articles' => array(
        'key'   => 'qlcd_wp_chatbot_startmenu_search_articles',
        'default'   => __('Search our articles', 'botstartmenu' ),
        'db'    => maybe_serialize( array( get_wpbot_locale() => array( __('Search our articles', 'botstartmenu' ) ) ) )
    ),
    'qc_wpbot_start_menu_order' => array(
        'key'   => 'qc_wpbot_start_menu_order',
        'default'   => '',
        'db'    => maybe_serialize( array( get_wpbot_locale() => '' ) )
    ),
    'enable_start_conversation' => array(
        'key'   => 'enable_start_conversation',
        'default'   => '1',
        'db'   => '1'
    ),
    'start_conversation_priority' => array(
        'key'   => 'start_conversation_priority',
        'default'   => '1',
        'db'   => '1'
    ),
    'enable_search_section' => array(
        'key'   => 'enable_search_section',
        'default'   => '1',
        'db'   => '1'
    ),
    'search_section_priority' => array(
        'key'   => 'search_section_priority',
        'default'   => '2',
        'db'   => '2'
    ),
    'enable_integration_button_section' => array(
        'key'   => 'enable_integration_button_section',
        'default'   => '1',
        'db'   => '1'
    ),
    'integration_button_priority' => array(
        'key'   => 'integration_button_priority',
        'default'   => '3',
        'db'   => '3'
    ),
    'enable_product_section' => array(
        'key'   => 'enable_product_section',
        'default'   => '1',
        'db'   => '1'
    ),
    'product_section_priority' => array(
        'key'   => 'product_section_priority',
        'default'   => '3',
        'db'   => '3'
    ),
    'startmenu_product_type' => array(
        'key'   => 'startmenu_product_type',
        'default'   => 'latest',
        'db'   => 'latest'
    ),
    'startmenu_number_of_product' => array(
        'key'   => 'startmenu_number_of_product',
        'default'   => '4',
        'db'   => '4'
    ),'enable_blog_section' => array(
        'key'   => 'enable_blog_section',
        'default'   => '1',
        'db'   => '1'
    ),
    'blog_section_priority' => array(
        'key'   => 'blog_section_priority',
        'default'   => '4',
        'db'   => '4'
    ),
    'blog_post_type' => array(
        'key'   => 'blog_post_type',
        'default'   => 'post',
        'db'   => 'post'
    ),'blog_post_ids' => array(
        'key'   => 'blog_post_ids',
        'default'   => '',
        'db'   => ''
    ),
    'blog_number_of_post' => array(
        'key'   => 'blog_number_of_post',
        'default'   => '5',
        'db'   => '5'
    ),
    'blog_post_display_orderby' => array(
        'key'   => 'blog_post_display_orderby',
        'default'   => 'menu_order',
        'db'   => 'menu_order'
    ),
    'blog_post_display_order' => array(
        'key'   => 'blog_post_display_order',
        'default'   => 'ASC',
        'db'   => 'ASC'
    ),
    'enable_buttons_section' => array(
        'key'   => 'enable_buttons_section',
        'default'   => '1',
        'db'   => '1'
    ),
    'button_section_priority' => array(
        'key'   => 'button_section_priority',
        'default'   => '5',
        'db'   => '5'
    ),
    'enable_extended_interface' => array(
        'key'   => 'enable_extended_interface',
        'default'   => '',
        'db'   => ''
    )
);
return apply_filters( 'chatbot_startmenu_settings', $startmenu_settings );