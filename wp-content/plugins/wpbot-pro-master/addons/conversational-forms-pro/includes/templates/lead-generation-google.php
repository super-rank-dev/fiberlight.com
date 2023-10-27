<?php 

return array (
  '_last_updated' => 'Tue, 18 Feb 2020 12:10:57 +0000',
  'ID' => 'CF5e466b2d280f0',
  'wfb_version' => '1.0.0',
  'name' => 'Lead Generation Google',
  'command' => 'lead generation google',
  'layout_grid' => 
  array (
    'fields' => 
    array (
      'fld_3770176' => '1:1',
      'fld_3787643' => '1:1',
      'fld_9396049' => '1:1',
      'fld_360925' => '1:1',
      'fld_4111154' => '1:1',
      'fld_8119268' => '1:1',
      'fld_5001700' => '1:1',
      'fld_7020021' => '1:1',
      'fld_6644464' => '1:1',
      'fld_1298262' => '1:1',
      'fld_3549547' => '1:1',
      'fld_7852632' => '1:1',
      'fld_4036182' => '1:1',
      'fld_6509351' => '1:1',
      'fld_7502451' => '1:1',
      'fld_2804809' => '1:1',
      'fld_474171' => '1:1',
      'fld_5379430' => '1:1',
      'fld_4879960' => '1:1',
      'fld_7302456' => '1:1',
      'fld_3365220' => '1:1',
      'fld_3712261' => '1:1',
      'fld_7838080' => '1:1',
      'fld_3051556' => '1:1',
      'fld_7510195' => '1:1',
      'fld_6461673' => '1:1',
      'fld_3911352' => '1:1',
      'fld_8198147' => '1:1',
      'fld_3160578' => '1:1',
      'fld_6181995' => '1:1',
      'fld_6295892' => '1:1',
      'fld_613958' => '1:1',
      'fld_8674647' => '1:1',
      'fld_5553810' => '1:1',
      'fld_5800350' => '1:1',
      'fld_1481817' => '1:1',
    ),
    'structure' => '12',
  ),
  'fields' => 
  array (
    'fld_3770176' => 
    array (
      'ID' => 'fld_3770176',
      'type' => 'html',
      'label' => 'Hi, welcome back to Engati Community Services..',
      'slug' => 'hi_welcome_back_to_engati_community_services',
      'additional' => '',
      'conditions' => 
      array (
        'type' => '',
      ),
      'config' => 
      array (
        'default' => 'Hi, welcome back to Engati Community Services..',
      ),
    ),
    'fld_3787643' => 
    array (
      'ID' => 'fld_3787643',
      'type' => 'html',
      'label' => 'I can assist you in building a chatbot or provide you with a chatbot according to your exact requirements.',
      'slug' => 'i_can_assist_you_in_building_a_chatbot_or_provide_you_with_a_chatbot_according_to_your_exact_requirements',
      'additional' => '',
      'conditions' => 
      array (
        'type' => '',
      ),
      'config' => 
      array (
        'default' => 'I can assist you in building a chatbot or provide you with a chatbot according to your exact requirements.',
      ),
    ),
    'fld_9396049' => 
    array (
      'ID' => 'fld_9396049',
      'type' => 'dropdown',
      'label' => 'Press on the start button to see how can I help you.',
      'slug' => 'press_on_the_start_button_to_see_how_can_i_help_you',
      'additional' => '',
      'conditions' => 
      array (
        'type' => '',
      ),
      'config' => 
      array (
        'auto_type' => '',
        'taxonomy' => 'category',
        'post_type' => 'post',
        'value_field' => 'name',
        'orderby_tax' => 'name',
        'orderby_post' => 'name',
        'order' => 'ASC',
        'default' => '',
        'option' => 
        array (
          'opt1540159' => 
          array (
            'calc_value' => 'Start',
            'value' => 'Start',
            'label' => 'Start',
          ),
          'opt1873622' => 
          array (
            'calc_value' => 'Go Back',
            'value' => 'Go Back',
            'label' => 'Go Back',
          ),
        ),
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_360925' => 
    array (
      'ID' => 'fld_360925',
      'type' => 'dropdown',
      'label' => 'Select your use case from these options.',
      'slug' => 'select_your_use_case_from_these_options',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_6988429042915369',
      ),
      'config' => 
      array (
        'auto_type' => '',
        'taxonomy' => 'category',
        'post_type' => 'post',
        'value_field' => 'name',
        'orderby_tax' => 'name',
        'orderby_post' => 'name',
        'order' => 'ASC',
        'default' => '',
        'option' => 
        array (
          'opt1601438' => 
          array (
            'calc_value' => 'Automobile',
            'value' => 'Automobile',
            'label' => 'Automobile',
          ),
          'opt1755469' => 
          array (
            'calc_value' => 'Banking and Finance',
            'value' => 'Banking and Finance',
            'label' => 'Banking and Finance',
          ),
          'opt1502836' => 
          array (
            'calc_value' => 'E-commerce',
            'value' => 'E-commerce',
            'label' => 'E-commerce',
          ),
          'opt2030900' => 
          array (
            'calc_value' => 'Human Resources',
            'value' => 'Human Resources',
            'label' => 'Human Resources',
          ),
          'opt1853736' => 
          array (
            'calc_value' => 'Custom use case',
            'value' => 'Custom use case',
            'label' => 'Custom use case',
          ),
        ),
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_4111154' => 
    array (
      'ID' => 'fld_4111154',
      'type' => 'html',
      'label' => 'Awesome! To showcase the full functionality of the chatbot and its capabilities, tell us about your company and a little bit about you.',
      'slug' => 'awesome_to_showcase_the_full_functionality_of_the_chatbot_and_its_capabilities_tell_us_about_your_company_and_a_little_bit_about_you',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_1193637660306606',
      ),
      'config' => 
      array (
        'default' => 'Awesome! <br>
To showcase the full functionality of the chatbot and its capabilities, tell us about your company and a little bit about you.',
      ),
    ),
    'fld_8119268' => 
    array (
      'ID' => 'fld_8119268',
      'type' => 'text',
      'label' => 'Please enter your full name',
      'slug' => 'please_enter_your_full_name',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_1193637660306606',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_5001700' => 
    array (
      'ID' => 'fld_5001700',
      'type' => 'email',
      'label' => 'Can you please provide me your email address, so I can send you a document for the chatbot flows and capabilities?',
      'slug' => 'can_you_please_provide_me_your_email_address_so_i_can_send_you_a_document_for_the_chatbot_flows_and_capabilities',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_1193637660306606',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_7020021' => 
    array (
      'ID' => 'fld_7020021',
      'type' => 'text',
      'label' => 'Can you please tell me which company you work for??',
      'slug' => 'can_you_please_tell_me_which_company_you_work_for',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_1193637660306606',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_6644464' => 
    array (
      'ID' => 'fld_6644464',
      'type' => 'text',
      'label' => 'Finally any feature or Integration you want Engati to have?',
      'slug' => 'finally_any_feature_or_integration_you_want_engati_to_have',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_1193637660306606',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_1298262' => 
    array (
      'ID' => 'fld_1298262',
      'type' => 'html',
      'label' => 'Thank you for your Interest in Engati. We will get back to you shortly',
      'slug' => 'thank_you_for_your_interest_in_engati_we_will_get_back_to_you_shortly',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_1193637660306606',
      ),
      'config' => 
      array (
        'default' => 'Thank you for your Interest in Engati. We will get back to you shortly',
      ),
    ),
    'fld_3549547' => 
    array (
      'ID' => 'fld_3549547',
      'type' => 'html',
      'label' => 'Awesome! To showcase the full functionality of the chatbot and its capabilities, tell us about your company and a little bit about you.',
      'slug' => 'awesome_to_showcase_the_full_functionality_of_the_chatbot_and_its_capabilities_tell_us_about_your_company_and_a_little_bit_about_you_banking',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_4174821648104188',
      ),
      'config' => 
      array (
        'default' => 'Awesome! <br>
To showcase the full functionality of the chatbot and its capabilities, tell us about your company and a little bit about you.',
      ),
    ),
    'fld_7852632' => 
    array (
      'ID' => 'fld_7852632',
      'type' => 'text',
      'label' => 'Please enter your full name',
      'slug' => 'please_enter_your_full_name_banking',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_4174821648104188',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_4036182' => 
    array (
      'ID' => 'fld_4036182',
      'type' => 'email',
      'label' => 'Can you please provide me your email address, so I can send you a document for the chatbot flows and capabilities?',
      'slug' => 'can_you_please_provide_me_your_email_address_so_i_can_send_you_a_document_for_the_chatbot_flows_and_capabilities_banking',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_4174821648104188',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_6509351' => 
    array (
      'ID' => 'fld_6509351',
      'type' => 'text',
      'label' => 'Can you please tell me which company you work for??',
      'slug' => 'can_you_please_tell_me_which_company_you_work_for_banking',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_4174821648104188',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_7502451' => 
    array (
      'ID' => 'fld_7502451',
      'type' => 'text',
      'label' => 'Finally any feature or Integration you want Engati to have?',
      'slug' => 'finally_any_feature_or_integration_you_want_engati_to_have_banking',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_4174821648104188',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_2804809' => 
    array (
      'ID' => 'fld_2804809',
      'type' => 'html',
      'label' => 'Thank you for your Interest in Engati. We will get back to you shortly',
      'slug' => 'thank_you_for_your_interest_in_engati_we_will_get_back_to_you_shortly_banking',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_4174821648104188',
      ),
      'config' => 
      array (
        'default' => 'Thank you for your Interest in Engati. We will get back to you shortly',
      ),
    ),
    'fld_474171' => 
    array (
      'ID' => 'fld_474171',
      'type' => 'html',
      'label' => 'Awesome! To showcase the full functionality of the chatbot and its capabilities, tell us about your company and a little bit about you.',
      'slug' => 'awesome_to_showcase_the_full_functionality_of_the_chatbot_and_its_capabilities_tell_us_about_your_company_and_a_little_bit_about_you_ecommerce',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_5022992785188614',
      ),
      'config' => 
      array (
        'default' => 'Awesome! <br>
To showcase the full functionality of the chatbot and its capabilities, tell us about your company and a little bit about you.',
      ),
    ),
    'fld_5379430' => 
    array (
      'ID' => 'fld_5379430',
      'type' => 'text',
      'label' => 'Please enter your full name',
      'slug' => 'please_enter_your_full_name_ecommerce',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_5022992785188614',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_4879960' => 
    array (
      'ID' => 'fld_4879960',
      'type' => 'email',
      'label' => 'Can you please provide me your email address, so I can send you a document for the chatbot flows and capabilities?',
      'slug' => 'can_you_please_provide_me_your_email_address_so_i_can_send_you_a_document_for_the_chatbot_flows_and_capabilities_ecommerce',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_5022992785188614',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_7302456' => 
    array (
      'ID' => 'fld_7302456',
      'type' => 'text',
      'label' => 'Can you please tell me which company you work for??',
      'slug' => 'can_you_please_tell_me_which_company_you_work_for_ecommerce',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_5022992785188614',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_3365220' => 
    array (
      'ID' => 'fld_3365220',
      'type' => 'text',
      'label' => 'Finally any feature or Integration you want Engati to have?',
      'slug' => 'finally_any_feature_or_integration_you_want_engati_to_have_ecommerce',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_5022992785188614',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_3712261' => 
    array (
      'ID' => 'fld_3712261',
      'type' => 'html',
      'label' => 'Thank you for your Interest in Engati. We will get back to you shortly',
      'slug' => 'thank_you_for_your_interest_in_engati_we_will_get_back_to_you_shortly_ecommerce',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_5022992785188614',
      ),
      'config' => 
      array (
        'default' => 'Thank you for your Interest in Engati. We will get back to you shortly',
      ),
    ),
    'fld_7838080' => 
    array (
      'ID' => 'fld_7838080',
      'type' => 'html',
      'label' => 'Awesome! To showcase the full functionality of the chatbot and its capabilities, tell us about your company and a little bit about you.',
      'slug' => 'awesome_to_showcase_the_full_functionality_of_the_chatbot_and_its_capabilities_tell_us_about_your_company_and_a_little_bit_about_you_human',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_3431771144341258',
      ),
      'config' => 
      array (
        'default' => 'Awesome! <br>
To showcase the full functionality of the chatbot and its capabilities, tell us about your company and a little bit about you.',
      ),
    ),
    'fld_3051556' => 
    array (
      'ID' => 'fld_3051556',
      'type' => 'text',
      'label' => 'Please enter your full name',
      'slug' => 'please_enter_your_full_name_human',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_3431771144341258',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_7510195' => 
    array (
      'ID' => 'fld_7510195',
      'type' => 'email',
      'label' => 'Can you please provide me your email address, so I can send you a document for the chatbot flows and capabilities?',
      'slug' => 'can_you_please_provide_me_your_email_address_so_i_can_send_you_a_document_for_the_chatbot_flows_and_capabilities_human',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_3431771144341258',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_6461673' => 
    array (
      'ID' => 'fld_6461673',
      'type' => 'text',
      'label' => 'Can you please tell me which company you work for??',
      'slug' => 'can_you_please_tell_me_which_company_you_work_for_human',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_3431771144341258',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_3911352' => 
    array (
      'ID' => 'fld_3911352',
      'type' => 'text',
      'label' => 'Finally any feature or Integration you want Engati to have?',
      'slug' => 'finally_any_feature_or_integration_you_want_engati_to_have_human',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_3431771144341258',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_8198147' => 
    array (
      'ID' => 'fld_8198147',
      'type' => 'html',
      'label' => 'Thank you for your Interest in Engati. We will get back to you shortly',
      'slug' => 'thank_you_for_your_interest_in_engati_we_will_get_back_to_you_shortly_human',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_3431771144341258',
      ),
      'config' => 
      array (
        'default' => 'Thank you for your Interest in Engati. We will get back to you shortly',
      ),
    ),
    'fld_3160578' => 
    array (
      'ID' => 'fld_3160578',
      'type' => 'html',
      'label' => 'Great! we love customers coming to us with different use cases and I would be happy to help you.',
      'slug' => 'great_we_love_customers_coming_to_us_with_different_use_cases_and_i_would_be_happy_to_help_you',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_588886958498090',
      ),
      'config' => 
      array (
        'default' => 'Great! we love customers coming to us with different use cases and I would be happy to help you.',
      ),
    ),
    'fld_6181995' => 
    array (
      'ID' => 'fld_6181995',
      'type' => 'html',
      'label' => 'Just let me know your use case and a few other details and I will give you a solution for it.',
      'slug' => 'just_let_me_know_your_use_case_and_a_few_other_details_and_i_will_give_you_a_solution_for_it',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_588886958498090',
      ),
      'config' => 
      array (
        'default' => 'Just let me know your use case and a few other details and I will give you a solution for it.',
      ),
    ),
    'fld_6295892' => 
    array (
      'ID' => 'fld_6295892',
      'type' => 'text',
      'label' => 'First your use case',
      'slug' => 'first_your_use_case_custom_work',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_588886958498090',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_613958' => 
    array (
      'ID' => 'fld_613958',
      'type' => 'text',
      'label' => 'Please enter your full name',
      'slug' => 'please_enter_your_full_name_custom_work',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_588886958498090',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_8674647' => 
    array (
      'ID' => 'fld_8674647',
      'type' => 'email',
      'label' => 'Can you please provide me your email address, so I can send you a document for the chatbot flows and capabilities?',
      'slug' => 'can_you_please_provide_me_your_email_address_so_i_can_send_you_a_document_for_the_chatbot_flows_and_capabilities_custom_work',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_588886958498090',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_5553810' => 
    array (
      'ID' => 'fld_5553810',
      'type' => 'text',
      'label' => 'Can you please tell me which company you work for??',
      'slug' => 'can_you_please_tell_me_which_company_you_work_for_custom_work',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_588886958498090',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_5800350' => 
    array (
      'ID' => 'fld_5800350',
      'type' => 'text',
      'label' => 'Finally any feature or Integration you want Engati to have?',
      'slug' => 'finally_any_feature_or_integration_you_want_engati_to_have_custom_work',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_588886958498090',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_1481817' => 
    array (
      'ID' => 'fld_1481817',
      'type' => 'html',
      'label' => 'Thank you for your Interest in Engati. We will get back to you shortly',
      'slug' => 'thank_you_for_your_interest_in_engati_we_will_get_back_to_you_shortly_custom_work',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_588886958498090',
      ),
      'config' => 
      array (
        'default' => 'Thank you for your Interest in Engati. We will get back to you shortly',
      ),
    ),
  ),
  'mailer' => 
  array (
    'on_insert' => 1,
    'sender_name' => 'Chatbot Forms Notification',
    'sender_email' => '',
    'recipients' => '',
    'email_subject' => 'Lead Generation Google',
  ),
  'conditional_groups' => 
  array (
    'conditions' => 
    array (
      'con_6988429042915369' => 
      array (
        'id' => 'con_6988429042915369',
        'name' => 'Start',
        'type' => 'show',
        'fields' => 
        array (
          'cl1892108431218884' => 'fld_9396049',
        ),
        'group' => 
        array (
          'rw9610174416401712' => 
          array (
            'cl1892108431218884' => 
            array (
              'parent' => 'rw9610174416401712',
              'field' => 'fld_9396049',
              'compare' => 'is',
              'value' => 'opt1540159',
            ),
          ),
        ),
      ),
      'con_1193637660306606' => 
      array (
        'id' => 'con_1193637660306606',
        'name' => 'Automobile',
        'type' => 'show',
        'fields' => 
        array (
          'cl11410674488761' => 'fld_360925',
        ),
        'group' => 
        array (
          'rw4119095230682161' => 
          array (
            'cl11410674488761' => 
            array (
              'parent' => 'rw4119095230682161',
              'field' => 'fld_360925',
              'compare' => 'is',
              'value' => 'opt1601438',
            ),
          ),
        ),
      ),
      'con_4174821648104188' => 
      array (
        'id' => 'con_4174821648104188',
        'name' => 'Banking and Finance',
        'type' => 'show',
        'fields' => 
        array (
          'cl556782270449592' => 'fld_360925',
        ),
        'group' => 
        array (
          'rw3764358590782195' => 
          array (
            'cl556782270449592' => 
            array (
              'parent' => 'rw3764358590782195',
              'field' => 'fld_360925',
              'compare' => 'is',
              'value' => 'opt1755469',
            ),
          ),
        ),
      ),
      'con_5022992785188614' => 
      array (
        'id' => 'con_5022992785188614',
        'name' => 'E-commerce',
        'type' => 'show',
        'fields' => 
        array (
          'cl9942320174678709' => 'fld_360925',
        ),
        'group' => 
        array (
          'rw9757346867943452' => 
          array (
            'cl9942320174678709' => 
            array (
              'parent' => 'rw9757346867943452',
              'field' => 'fld_360925',
              'compare' => 'is',
              'value' => 'opt1502836',
            ),
          ),
        ),
      ),
      'con_3431771144341258' => 
      array (
        'id' => 'con_3431771144341258',
        'name' => 'Human Resources',
        'type' => 'show',
        'fields' => 
        array (
          'cl4036080165275836' => 'fld_360925',
        ),
        'group' => 
        array (
          'rw6979785327100087' => 
          array (
            'cl4036080165275836' => 
            array (
              'parent' => 'rw6979785327100087',
              'field' => 'fld_360925',
              'compare' => 'is',
              'value' => 'opt2030900',
            ),
          ),
        ),
      ),
      'con_588886958498090' => 
      array (
        'id' => 'con_588886958498090',
        'name' => 'Custom use case',
        'type' => 'show',
        'fields' => 
        array (
          'cl2755017873045465' => 'fld_360925',
        ),
        'group' => 
        array (
          'rw109085038337760' => 
          array (
            'cl2755017873045465' => 
            array (
              'parent' => 'rw109085038337760',
              'field' => 'fld_360925',
              'compare' => 'is',
              'value' => 'opt1853736',
            ),
          ),
        ),
      ),
    ),
  ),
  'privacy_exporter_enabled' => false,
  'version' => '1.0.0',
);