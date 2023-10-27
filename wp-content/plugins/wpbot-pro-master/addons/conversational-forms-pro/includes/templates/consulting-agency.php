<?php 

return array (
  '_last_updated' => 'Tue, 18 Feb 2020 11:32:40 +0000',
  'ID' => 'CF5e46363d33f82',
  'wfb_version' => '1.0.0',
  'name' => 'Consulting Agency',
  'command' => 'consulting agency',
  'layout_grid' => 
  array (
    'fields' => 
    array (
      'fld_3272880' => '1:1',
      'fld_8936116' => '1:1',
      'fld_1407278' => '1:1',
      'fld_9407146' => '1:1',
      'fld_2178743' => '1:1',
      'fld_4772266' => '1:1',
      'fld_9970421' => '1:1',
      'fld_6166114' => '1:1',
      'fld_7899978' => '1:1',
      'fld_6015570' => '1:1',
      'fld_1993225' => '1:1',
      'fld_4470807' => '1:1',
      'fld_6093797' => '1:1',
      'fld_1895589' => '1:1',
      'fld_8996346' => '1:1',
      'fld_608630' => '1:1',
      'fld_9045209' => '1:1',
      'fld_6505475' => '1:1',
      'fld_9009055' => '1:1',
      'fld_270752' => '1:1',
      'fld_7792372' => '1:1',
      'fld_3146290' => '1:1',
      'fld_8634215' => '1:1',
      'fld_1111270' => '1:1',
      'fld_1105466' => '1:1',
      'fld_6350768' => '1:1',
      'fld_2739678' => '1:1',
      'fld_4451628' => '1:1',
      'fld_3758414' => '1:1',
      'fld_9753536' => '1:1',
      'fld_7643863' => '1:1',
      'fld_4385151' => '1:1',
      'fld_9673565' => '1:1',
      'fld_7092620' => '1:1',
    ),
    'structure' => '12',
  ),
  'fields' => 
  array (
    'fld_3272880' => 
    array (
      'ID' => 'fld_3272880',
      'type' => 'html',
      'label' => 'Hi welcome back.',
      'slug' => 'hi_welcome_back',
      'additional' => '',
      'conditions' => 
      array (
        'type' => '',
      ),
      'config' => 
      array (
        'default' => 'Hi, Welcome to our Consulting Agency.',
      ),
    ),
    'fld_8936116' => 
    array (
      'ID' => 'fld_8936116',
      'type' => 'dropdown',
      'label' => 'How can we help you ?',
      'slug' => 'how_can_we_help_you',
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
          'opt1895564' => 
          array (
            'calc_value' => 'How can we help you',
            'value' => 'How can we help you',
            'label' => 'How can we help you',
          ),
          'opt1066656' => 
          array (
            'calc_value' => 'Explore our services',
            'value' => 'Explore our services',
            'label' => 'Explore our services',
          ),
          'opt1070436' => 
          array (
            'calc_value' => 'Who are we',
            'value' => 'Who are we',
            'label' => 'Who are we',
          ),
        ),
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_1407278' => 
    array (
      'ID' => 'fld_1407278',
      'type' => 'html',
      'label' => 'We can help you in a lot of ways. If you let us know what kind of help you need',
      'slug' => 'we_can_help_you_in_a_lot_of_ways_if_you_let_us_know_what_kind_of_help_you_need',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_6371531023303476',
      ),
      'config' => 
      array (
        'default' => 'We can help you in a lot of ways. If you let us know what kind of help you need',
      ),
    ),
    'fld_9407146' => 
    array (
      'ID' => 'fld_9407146',
      'type' => 'html',
      'label' => 'We help businesses with their growth and lead generation, one of our teams focuses on branding and online design of your business. We constantly reach out to our customers and innovate our services and offering.',
      'slug' => 'we_help_businesses_with_their_growth_and_lead_generation_one_of_our_teams_focuses_on_branding_and_online_design_of_your_business_we_constantly_reach_out_to_our_customers_and_innovate_our_services_and_offering',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_6371531023303476',
      ),
      'config' => 
      array (
        'default' => 'We help businesses with their growth and lead generation, one of our teams focuses on branding and online design of your business. 
We constantly reach out to our customers and innovate our services and offering.',
      ),
    ),
    'fld_2178743' => 
    array (
      'ID' => 'fld_2178743',
      'type' => 'dropdown',
      'label' => 'Do you want to see some case studies that we have worked on?',
      'slug' => 'do_you_want_to_see_some_case_studies_that_we_have_worked_on',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_6371531023303476',
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
          'opt1554321' => 
          array (
            'calc_value' => 'YES',
            'value' => 'YES',
            'label' => 'YES',
          ),
          'opt1330349' => 
          array (
            'calc_value' => 'No, Go back',
            'value' => 'No, Go back',
            'label' => 'No, Go back',
          ),
        ),
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_4772266' => 
    array (
      'ID' => 'fld_4772266',
      'type' => 'text',
      'label' => 'Name of your company',
      'slug' => 'name_of_your_company',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_310832683532518',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_9970421' => 
    array (
      'ID' => 'fld_9970421',
      'type' => 'email',
      'label' => 'Your email address',
      'slug' => 'your_email_address',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_310832683532518',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_6166114' => 
    array (
      'ID' => 'fld_6166114',
      'type' => 'number',
      'label' => 'Contact number?',
      'slug' => 'contact_number',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_310832683532518',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_7899978' => 
    array (
      'ID' => 'fld_7899978',
      'type' => 'text',
      'label' => 'Please share your use case briefly',
      'slug' => 'please_share_your_use_case_briefly',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_310832683532518',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_6015570' => 
    array (
      'ID' => 'fld_6015570',
      'type' => 'html',
      'label' => 'Some one from our will get in touch with you.',
      'slug' => 'some_one_from_our_will_get_in_touch_with_you',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_310832683532518',
      ),
      'config' => 
      array (
        'default' => 'Some one from our will get in touch with you.',
      ),
    ),
    'fld_1993225' => 
    array (
      'ID' => 'fld_1993225',
      'type' => 'dropdown',
      'label' => 'Choose an option to begin.',
      'slug' => 'choose_an_option_to_begin',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_598382541041311',
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
          'opt2076659' => 
          array (
            'calc_value' => 'Digital Marketing',
            'value' => 'Digital Marketing',
            'label' => 'Digital Marketing',
          ),
          'opt2056198' => 
          array (
            'calc_value' => 'Brand Design',
            'value' => 'Brand Design',
            'label' => 'Brand Design',
          ),
          'opt1309147' => 
          array (
            'calc_value' => 'Advertising',
            'value' => 'Advertising',
            'label' => 'Advertising',
          ),
        ),
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_4470807' => 
    array (
      'ID' => 'fld_4470807',
      'type' => 'text',
      'label' => 'Name of your company',
      'slug' => 'name_of_your_company_marketing',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_8556727735898436',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_6093797' => 
    array (
      'ID' => 'fld_6093797',
      'type' => 'email',
      'label' => 'Your email address',
      'slug' => 'your_email_address_marketing',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_8556727735898436',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_1895589' => 
    array (
      'ID' => 'fld_1895589',
      'type' => 'number',
      'label' => 'Contact number?',
      'slug' => 'contact_number_marketing',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_8556727735898436',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_8996346' => 
    array (
      'ID' => 'fld_8996346',
      'type' => 'text',
      'label' => 'Please share your use case briefly',
      'slug' => 'please_share_your_use_case_brief_marketingly',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_8556727735898436',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_608630' => 
    array (
      'ID' => 'fld_608630',
      'type' => 'html',
      'label' => 'Some one from our will get in touch with you.',
      'slug' => 'some_one_from_our_will_get_in_touch_with_you_marketing',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_8556727735898436',
      ),
      'config' => 
      array (
        'default' => 'Some one from our will get in touch with you.',
      ),
    ),
    'fld_9045209' => 
    array (
      'ID' => 'fld_9045209',
      'type' => 'text',
      'label' => 'Name of your company',
      'slug' => 'name_of_your_company_brand',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_7060810637645026',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_6505475' => 
    array (
      'ID' => 'fld_6505475',
      'type' => 'email',
      'label' => 'Your email address',
      'slug' => 'your_email_address_brand',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_7060810637645026',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_9009055' => 
    array (
      'ID' => 'fld_9009055',
      'type' => 'number',
      'label' => 'Contact number?',
      'slug' => 'contact_number_brand',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_7060810637645026',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_270752' => 
    array (
      'ID' => 'fld_270752',
      'type' => 'text',
      'label' => 'Please share your use case briefly',
      'slug' => 'please_share_your_use_case_briefly_brand',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_7060810637645026',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_7792372' => 
    array (
      'ID' => 'fld_7792372',
      'type' => 'html',
      'label' => 'Some one from our will get in touch with you.',
      'slug' => 'some_one_from_our_will_get_in_touch_with_you_brand',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_7060810637645026',
      ),
      'config' => 
      array (
        'default' => 'Some one from our will get in touch with you.',
      ),
    ),
    'fld_3146290' => 
    array (
      'ID' => 'fld_3146290',
      'type' => 'text',
      'label' => 'Name of your company',
      'slug' => 'name_of_your_company_advertising',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_382954145031762',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_8634215' => 
    array (
      'ID' => 'fld_8634215',
      'type' => 'email',
      'label' => 'Your email address',
      'slug' => 'your_email_address_advertising',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_382954145031762',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_1111270' => 
    array (
      'ID' => 'fld_1111270',
      'type' => 'number',
      'label' => 'Contact number?',
      'slug' => 'contact_number_advertising',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_382954145031762',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_1105466' => 
    array (
      'ID' => 'fld_1105466',
      'type' => 'text',
      'label' => 'Please share your use case briefly',
      'slug' => 'please_share_your_use_case_briefly_advertising',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_382954145031762',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_6350768' => 
    array (
      'ID' => 'fld_6350768',
      'type' => 'html',
      'label' => 'Some one from our will get in touch with you.',
      'slug' => 'some_one_from_our_will_get_in_touch_with_you_advertising',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_382954145031762',
      ),
      'config' => 
      array (
        'default' => 'Some one from our will get in touch with you.',
      ),
    ),
    'fld_2739678' => 
    array (
      'ID' => 'fld_2739678',
      'type' => 'html',
      'label' => 'We are a boutique agency and we are accountable, autonomous, flexible and personable.',
      'slug' => 'we_are_a_boutique_agency_and_we_are_accountable_autonomous_flexible_and_personable',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_4413831182512037',
      ),
      'config' => 
      array (
        'default' => 'We are a boutique agency and we are accountable, autonomous, flexible and personable.',
      ),
    ),
    'fld_4451628' => 
    array (
      'ID' => 'fld_4451628',
      'type' => 'html',
      'label' => 'We are a ',
      'slug' => 'we_are_a_people_first_agency_we_design_result_oriented_campaigns_and_also_refine_them_to_get_the_best_outcome',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_4413831182512037',
      ),
      'config' => 
      array (
        'default' => 'We are a "People First" agency. We design result-oriented campaigns and also refine them to get the best outcome',
      ),
    ),
    'fld_3758414' => 
    array (
      'ID' => 'fld_3758414',
      'type' => 'dropdown',
      'label' => 'For more information you can get in touch with us',
      'slug' => 'for_more_information_you_can_get_in_touch_with_us',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_4413831182512037',
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
          'opt1647481' => 
          array (
            'calc_value' => 'Get in touch',
            'value' => 'Get in touch',
            'label' => 'Get in touch',
          ),
          'opt1821221' => 
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
    'fld_9753536' => 
    array (
      'ID' => 'fld_9753536',
      'type' => 'text',
      'label' => 'Name of your company',
      'slug' => 'name_of_your_company_who_we_are',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_166790869708135',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_7643863' => 
    array (
      'ID' => 'fld_7643863',
      'type' => 'email',
      'label' => 'Your email address',
      'slug' => 'your_email_address_who_we_are',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_166790869708135',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_4385151' => 
    array (
      'ID' => 'fld_4385151',
      'type' => 'number',
      'label' => 'Contact number?',
      'slug' => 'contact_number_who_we_are',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_166790869708135',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_9673565' => 
    array (
      'ID' => 'fld_9673565',
      'type' => 'text',
      'label' => 'Please share your use case briefly',
      'slug' => 'please_share_your_use_case_briefly_who_we_are',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_166790869708135',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_7092620' => 
    array (
      'ID' => 'fld_7092620',
      'type' => 'html',
      'label' => 'Some one from our will get in touch with you.',
      'slug' => 'some_one_from_our_will_get_in_touch_with_you_who_we_are',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_166790869708135',
      ),
      'config' => 
      array (
        'default' => 'Some one from our will get in touch with you.',
      ),
    ),
  ),
  'mailer' => 
  array (
    'on_insert' => 1,
    'sender_name' => 'Chatbot Forms Notification',
    'sender_email' => '',
    'recipients' => '',
    'email_subject' => 'Consulting Agency',
  ),
  'conditional_groups' => 
  array (
    'conditions' => 
    array (
      'con_6371531023303476' => 
      array (
        'id' => 'con_6371531023303476',
        'name' => 'How can we help you',
        'type' => 'show',
        'fields' => 
        array (
          'cl1947401377921238' => 'fld_8936116',
        ),
        'group' => 
        array (
          'rw4813156942848417' => 
          array (
            'cl1947401377921238' => 
            array (
              'parent' => 'rw4813156942848417',
              'field' => 'fld_8936116',
              'compare' => 'is',
              'value' => 'opt1895564',
            ),
          ),
        ),
      ),
      'con_598382541041311' => 
      array (
        'id' => 'con_598382541041311',
        'name' => 'Explore our services',
        'type' => 'show',
        'fields' => 
        array (
          'cl36039486768038' => 'fld_8936116',
        ),
        'group' => 
        array (
          'rw969681131737341' => 
          array (
            'cl36039486768038' => 
            array (
              'parent' => 'rw969681131737341',
              'field' => 'fld_8936116',
              'compare' => 'is',
              'value' => 'opt1066656',
            ),
          ),
        ),
      ),
      'con_4413831182512037' => 
      array (
        'id' => 'con_4413831182512037',
        'name' => 'Who are we',
        'type' => 'show',
        'fields' => 
        array (
          'cl4894940471660125' => 'fld_8936116',
        ),
        'group' => 
        array (
          'rw931731211719204' => 
          array (
            'cl4894940471660125' => 
            array (
              'parent' => 'rw931731211719204',
              'field' => 'fld_8936116',
              'compare' => 'is',
              'value' => 'opt1070436',
            ),
          ),
        ),
      ),
      'con_310832683532518' => 
      array (
        'id' => 'con_310832683532518',
        'name' => 'Yes- help section',
        'type' => 'show',
        'fields' => 
        array (
          'cl1554969181413178' => 'fld_2178743',
        ),
        'group' => 
        array (
          'rw247634711488399' => 
          array (
            'cl1554969181413178' => 
            array (
              'parent' => 'rw247634711488399',
              'field' => 'fld_2178743',
              'compare' => 'is',
              'value' => 'opt1554321',
            ),
          ),
        ),
      ),
      'con_8556727735898436' => 
      array (
        'id' => 'con_8556727735898436',
        'name' => 'Digital Marketing --service',
        'type' => 'show',
        'fields' => 
        array (
          'cl924109984160602' => 'fld_1993225',
        ),
        'group' => 
        array (
          'rw7628747632644560' => 
          array (
            'cl924109984160602' => 
            array (
              'parent' => 'rw7628747632644560',
              'field' => 'fld_1993225',
              'compare' => 'is',
              'value' => 'opt2076659',
            ),
          ),
        ),
      ),
      'con_7060810637645026' => 
      array (
        'id' => 'con_7060810637645026',
        'name' => 'Brand Design --service',
        'type' => 'show',
        'fields' => 
        array (
          'cl9290012898436388' => 'fld_1993225',
        ),
        'group' => 
        array (
          'rw8915213582809805' => 
          array (
            'cl9290012898436388' => 
            array (
              'parent' => 'rw8915213582809805',
              'field' => 'fld_1993225',
              'compare' => 'is',
              'value' => 'opt2056198',
            ),
          ),
        ),
      ),
      'con_382954145031762' => 
      array (
        'id' => 'con_382954145031762',
        'name' => 'Advertising --service',
        'type' => 'show',
        'fields' => 
        array (
          'cl3661777190790903' => 'fld_1993225',
        ),
        'group' => 
        array (
          'rw1451673182586912' => 
          array (
            'cl3661777190790903' => 
            array (
              'parent' => 'rw1451673182586912',
              'field' => 'fld_1993225',
              'compare' => 'is',
              'value' => 'opt1309147',
            ),
          ),
        ),
      ),
      'con_166790869708135' => 
      array (
        'id' => 'con_166790869708135',
        'name' => 'Get in touch -- who we are',
        'type' => 'show',
        'fields' => 
        array (
          'cl9026551450664269' => 'fld_3758414',
        ),
        'group' => 
        array (
          'rw8268376013191998' => 
          array (
            'cl9026551450664269' => 
            array (
              'parent' => 'rw8268376013191998',
              'field' => 'fld_3758414',
              'compare' => 'is',
              'value' => 'opt1647481',
            ),
          ),
        ),
      ),
    ),
  ),
  'privacy_exporter_enabled' => false,
  'version' => '1.0.0',
);