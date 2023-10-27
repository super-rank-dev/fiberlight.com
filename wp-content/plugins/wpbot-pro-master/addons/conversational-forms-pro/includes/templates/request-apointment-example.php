<?php


return array (
  '_last_updated' => 'Fri, 04 Oct 2019 09:57:16 +0000',
  'ID' => 'request-apointment',
  'wfb_version' => '1.0.0',
  'name' => 'Request Appointment',
  'command' => 'appointment',
  'layout_grid' => 
  array (
    'fields' => 
    array (
      'fld_94202' => '1:1',
      'fld_5697393' => '1:1',
      'fld_5468389' => '1:1',
      'fld_4927015' => '1:1',
      'fld_2993507' => '1:1',
      'fld_6899661' => '1:1',
      'fld_1450419' => '1:1',
      'fld_7918592' => '1:1',
      'fld_7008931' => '1:1',
      'fld_1265349' => '1:1',
      'fld_6483313' => '1:1',
      'fld_6066786' => '1:1',
      'fld_8078634' => '1:1',
      'fld_6470195' => '1:1',
      'fld_3733331' => '1:1',
      'fld_827429' => '1:1',
      'fld_4044025' => '1:1',
    ),
    'structure' => '12',
  ),
  'fields' => 
  array (
    'fld_94202' => 
    array (
      'ID' => 'fld_94202',
      'type' => 'text',
      'label' => 'What is your First Name?',
      'slug' => 'first_name',
      'conditions' => 
      array (
        'type' => '',
      ),
      'entry_list' => 1,
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_5697393' => 
    array (
      'ID' => 'fld_5697393',
      'type' => 'text',
      'label' => 'What is your Last Name?',
      'slug' => 'last_name',
      'conditions' => 
      array (
        'type' => '',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_5468389' => 
    array (
      'ID' => 'fld_5468389',
      'type' => 'number',
      'label' => 'What is your Phone Number?',
      'slug' => 'phone_number',
      'conditions' => 
      array (
        'type' => '',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_4927015' => 
    array (
      'ID' => 'fld_4927015',
      'type' => 'email',
      'label' => 'What is your Email Address?',
      'slug' => 'your_email',
      'conditions' => 
      array (
        'type' => '',
      ),
      'entry_list' => 1,
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_2993507' => 
    array (
      'ID' => 'fld_2993507',
      'type' => 'dropdown',
      'label' => 'I prefer to be contacted via:',
      'slug' => 'contact_via',
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
          'opt1142431' => 
          array (
            'calc_value' => 'Phone Call',
            'value' => 'Phone Call',
            'label' => 'Phone Call',
          ),
          'opt1824963' => 
          array (
            'calc_value' => 'Text Message',
            'value' => 'Text Message',
            'label' => 'Text Message',
          ),
          'opt1815012' => 
          array (
            'calc_value' => 'Email',
            'value' => 'Email',
            'label' => 'Email',
          ),
        ),
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_6899661' => 
    array (
      'ID' => 'fld_6899661',
      'type' => 'dropdown',
      'label' => 'I am a:',
      'slug' => 'i_am_a',
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
          'opt1412104' => 
          array (
            'calc_value' => 'New Patient',
            'value' => 'New Patient',
            'label' => 'New Patient',
          ),
          'opt2069139' => 
          array (
            'calc_value' => 'Current Patient',
            'value' => 'Current Patient',
            'label' => 'Current Patient',
          ),
        ),
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_1450419' => 
    array (
      'ID' => 'fld_1450419',
      'type' => 'checkbox',
      'label' => 'What is the reason for your appointment?',
      'slug' => 'reason_for_appointment',
      'conditions' => 
      array (
        'type' => '',
      ),
      'entry_list' => 1,
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
          'opt1899463' => 
          array (
            'calc_value' => 'Cleaning, Exam and/or Xray',
            'value' => 'Cleaning, Exam and/or Xray',
            'label' => 'Cleaning, Exam and/or Xray',
          ),
          'opt1780565' => 
          array (
            'calc_value' => 'Hygiene Appointment',
            'value' => 'Hygiene Appointment',
            'label' => 'Hygiene Appointment',
          ),
          'opt1438698' => 
          array (
            'calc_value' => 'Tooth Pain',
            'value' => 'Tooth Pain',
            'label' => 'Tooth Pain',
          ),
          'opt1989547' => 
          array (
            'calc_value' => 'Previously Diagnosed Dental Need',
            'value' => 'Previously Diagnosed Dental Need',
            'label' => 'Previously Diagnosed Dental Need',
          ),
          'opt2094232' => 
          array (
            'calc_value' => 'Other',
            'value' => 'Other',
            'label' => 'Other',
          ),
        ),
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_7918592' => 
    array (
      'ID' => 'fld_7918592',
      'type' => 'text',
      'label' => 'Please Specify the reason',
      'slug' => 'please_specify_the_reason',
      'conditions' => 
      array (
        'type' => 'con_8498005344304263',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_7008931' => 
    array (
      'ID' => 'fld_7008931',
      'type' => 'dropdown',
      'label' => 'First Choice Day of the Week',
      'slug' => 'first_choice_day_of_the_week',
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
          'opt1408520' => 
          array (
            'calc_value' => 'Monday',
            'value' => 'Monday',
            'label' => 'Monday',
          ),
          'opt1297694' => 
          array (
            'calc_value' => 'Tuesday',
            'value' => 'Tuesday',
            'label' => 'Tuesday',
          ),
          'opt1235697' => 
          array (
            'calc_value' => 'Wednesday',
            'value' => 'Wednesday',
            'label' => 'Wednesday',
          ),
          'opt2021664' => 
          array (
            'calc_value' => 'Thursday',
            'value' => 'Thursday',
            'label' => 'Thursday',
          ),
          'opt1265393' => 
          array (
            'calc_value' => 'Friday',
            'value' => 'Friday',
            'label' => 'Friday',
          ),
        ),
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_1265349' => 
    array (
      'ID' => 'fld_1265349',
      'type' => 'dropdown',
      'label' => 'First Choice Time of Day',
      'slug' => 'first_choice_time_of_day',
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
          'opt1276623' => 
          array (
            'calc_value' => 'Early Morning Between 7 and 9:30 AM',
            'value' => 'Early Morning Between 7 and 9:30 AM',
            'label' => 'Early Morning Between 7 and 9:30 AM',
          ),
          'opt1058279' => 
          array (
            'calc_value' => 'Mid Morning Between 9:30 AM and Noon',
            'value' => 'Mid Morning Between 9:30 AM and Noon',
            'label' => 'Mid Morning Between 9:30 AM and Noon',
          ),
          'opt1764375' => 
          array (
            'calc_value' => 'Early Afternoon Between Noon and 2:30 PM',
            'value' => 'Early Afternoon Between Noon and 2:30 PM',
            'label' => 'Early Afternoon Between Noon and 2:30 PM',
          ),
          'opt1924156' => 
          array (
            'calc_value' => 'Mid Afternoon Between 2:30 and 6 PM',
            'value' => 'Mid Afternoon Between 2:30 and 6 PM',
            'label' => 'Mid Afternoon Between 2:30 and 6 PM',
          ),
        ),
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_6483313' => 
    array (
      'ID' => 'fld_6483313',
      'type' => 'dropdown',
      'label' => 'Second Choice Day of the Week',
      'slug' => 'second_choice_day_of_the_week',
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
          'opt1329466' => 
          array (
            'calc_value' => 'Monday',
            'value' => 'Monday',
            'label' => 'Monday',
          ),
          'opt1117100' => 
          array (
            'calc_value' => 'Tuesday',
            'value' => 'Tuesday',
            'label' => 'Tuesday',
          ),
          'opt1894644' => 
          array (
            'calc_value' => 'Wednesday',
            'value' => 'Wednesday',
            'label' => 'Wednesday',
          ),
          'opt1369890' => 
          array (
            'calc_value' => 'Thursday',
            'value' => 'Thursday',
            'label' => 'Thursday',
          ),
          'opt1473339' => 
          array (
            'calc_value' => 'Friday',
            'value' => 'Friday',
            'label' => 'Friday',
          ),
        ),
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_6066786' => 
    array (
      'ID' => 'fld_6066786',
      'type' => 'dropdown',
      'label' => 'Second Choice Time of Day',
      'slug' => 'second_choice_time_of_day',
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
          'opt1806473' => 
          array (
            'calc_value' => 'Early Morning Between 7 and 9:30 AM',
            'value' => 'Early Morning Between 7 and 9:30 AM',
            'label' => 'Early Morning Between 7 and 9:30 AM',
          ),
          'opt1782703' => 
          array (
            'calc_value' => 'Mid Morning Between 9:30 AM and Noon',
            'value' => 'Mid Morning Between 9:30 AM and Noon',
            'label' => 'Mid Morning Between 9:30 AM and Noon',
          ),
          'opt1672229' => 
          array (
            'calc_value' => 'Early Afternoon Between Noon and 2:30 PM',
            'value' => 'Early Afternoon Between Noon and 2:30 PM',
            'label' => 'Early Afternoon Between Noon and 2:30 PM',
          ),
          'opt1131307' => 
          array (
            'calc_value' => 'Mid Afternoon Between 2:30 and 6 PM',
            'value' => 'Mid Afternoon Between 2:30 and 6 PM',
            'label' => 'Mid Afternoon Between 2:30 and 6 PM',
          ),
        ),
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_8078634' => 
    array (
      'ID' => 'fld_8078634',
      'type' => 'text',
      'label' => 'Please write any relevant info or special request here',
      'slug' => 'please_write_any_relevant_info_or_special_request_here',
      'conditions' => 
      array (
        'type' => '',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_6470195' => 
    array (
      'ID' => 'fld_6470195',
      'type' => 'dropdown',
      'label' => 'How did you heard about us?',
      'slug' => 'how_did_you_heard_about_us',
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
          'opt1653383' => 
          array (
            'calc_value' => 'Search Engine (Google)',
            'value' => 'Search Engine (Google)',
            'label' => 'Search Engine (Google)',
          ),
          'opt1949034' => 
          array (
            'calc_value' => 'Great Online Reviews',
            'value' => 'Great Online Reviews',
            'label' => 'Great Online Reviews',
          ),
          'opt1580490' => 
          array (
            'calc_value' => 'Advertisement in Mail',
            'value' => 'Advertisement in Mail',
            'label' => 'Advertisement in Mail',
          ),
          'opt1357348' => 
          array (
            'calc_value' => 'Referred by a current patient',
            'value' => 'Referred by a current patient',
            'label' => 'Referred by a current patient',
          ),
          'opt1849493' => 
          array (
            'calc_value' => 'Other',
            'value' => 'Other',
            'label' => 'Other',
          ),
        ),
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_3733331' => 
    array (
      'ID' => 'fld_3733331',
      'type' => 'text',
      'label' => 'Who may we thank for referring you?',
      'slug' => 'who_may_we_thank_for_referring_you',
      'conditions' => 
      array (
        'type' => 'con_8661041958363317',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_827429' => 
    array (
      'ID' => 'fld_827429',
      'type' => 'text',
      'label' => 'Please Specify how you heard about us?',
      'slug' => 'please_specify_how_you_heard_about_us',
      'conditions' => 
      array (
        'type' => 'con_904312259763096',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_4044025' => 
    array (
      'ID' => 'fld_4044025',
      'type' => 'html',
      'label' => 'Thank you',
      'slug' => 'thank_you',
      'conditions' => 
      array (
        'type' => '',
      ),
      'config' => 
      array (
        'default' => 'Thank you very much %client_name%. We will contact you soon.',
      ),
    ),
  ),
  'mailer' => 
  array (
    'on_insert' => 1,
    'sender_name' => 'Chatbot Forms Notification',
    'sender_email' => '',
    'recipients' => '',
    'email_subject' => 'Request Appointment',
  ),
  'conditional_groups' => 
  array (
    'conditions' => 
    array (
      'con_8498005344304263' => 
      array (
        'id' => 'con_8498005344304263',
        'name' => 'Appointment Reason',
        'type' => 'show',
        'fields' => 
        array (
          'cl711159672003049' => 'fld_1450419',
        ),
        'group' => 
        array (
          'rw6546410350284800' => 
          array (
            'cl711159672003049' => 
            array (
              'parent' => 'rw6546410350284800',
              'field' => 'fld_1450419',
              'compare' => 'contains',
              'value' => 'opt2094232',
            ),
          ),
        ),
      ),
      'con_8661041958363317' => 
      array (
        'id' => 'con_8661041958363317',
        'name' => 'How did you hear - Current Patient',
        'type' => 'show',
        'fields' => 
        array (
          'cl3235021376498738' => 'fld_6470195',
        ),
        'group' => 
        array (
          'rw8351377020047518' => 
          array (
            'cl3235021376498738' => 
            array (
              'parent' => 'rw8351377020047518',
              'field' => 'fld_6470195',
              'compare' => 'is',
              'value' => 'opt1357348',
            ),
          ),
        ),
      ),
      'con_904312259763096' => 
      array (
        'id' => 'con_904312259763096',
        'name' => 'How did you hear - Other',
        'type' => 'show',
        'fields' => 
        array (
          'cl311246308442505' => 'fld_6470195',
        ),
        'group' => 
        array (
          'rw6556709622145766' => 
          array (
            'cl311246308442505' => 
            array (
              'parent' => 'rw6556709622145766',
              'field' => 'fld_6470195',
              'compare' => 'is',
              'value' => 'opt1849493',
            ),
          ),
        ),
      ),
    ),
  ),
  'variables' => 
  array (
    'keys' => 
    array (
      0 => 'client_name',
    ),
    'values' => 
    array (
      0 => '%first_name%',
    ),
    'types' => 
    array (
      0 => 'static',
    ),
  ),
  'privacy_exporter_enabled' => false,
  'version' => '1.0.0',
);