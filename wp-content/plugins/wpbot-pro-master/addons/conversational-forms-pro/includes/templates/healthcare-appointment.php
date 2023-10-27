<?php 

return array (
  '_last_updated' => 'Tue, 18 Feb 2020 12:00:55 +0000',
  'ID' => 'CF5e451c15e4e72',
  'wfb_version' => '1.0.0',
  'name' => 'Healthcare Appointment',
  'command' => 'healthcare appointment',
  'layout_grid' => 
  array (
    'fields' => 
    array (
      'fld_330007' => '1:1',
      'fld_8389952' => '1:1',
      'fld_8941046' => '1:1',
      'fld_5548876' => '1:1',
      'fld_2933801' => '1:1',
      'fld_2739691' => '1:1',
      'fld_1155455' => '1:1',
      'fld_7090955' => '1:1',
      'fld_750874' => '1:1',
      'fld_8091030' => '1:1',
      'fld_845320' => '1:1',
      'fld_956191' => '1:1',
      'fld_6518476' => '1:1',
      'fld_7584862' => '1:1',
      'fld_5172212' => '1:1',
      'fld_9747502' => '1:1',
      'fld_4882058' => '1:1',
      'fld_4064590' => '1:1',
      'fld_7140221' => '1:1',
      'fld_7584164' => '1:1',
      'fld_600553' => '1:1',
      'fld_4206668' => '1:1',
      'fld_1364858' => '1:1',
      'fld_3245651' => '1:1',
      'fld_8084010' => '1:1',
      'fld_2794345' => '1:1',
      'fld_6362406' => '1:1',
      'fld_602638' => '1:1',
      'fld_7674672' => '1:1',
      'fld_5008097' => '1:1',
      'fld_2151130' => '1:1',
      'fld_9620558' => '1:1',
      'fld_934190' => '1:1',
      'fld_6225307' => '1:1',
      'fld_7544851' => '1:1',
      'fld_4690311' => '1:1',
      'fld_8473951' => '1:1',
      'fld_4419938' => '1:1',
      'fld_6016377' => '1:1',
      'fld_4151106' => '1:1',
      'fld_3312615' => '1:1',
      'fld_4471823' => '1:1',
      'fld_8741992' => '1:1',
      'fld_2532832' => '1:1',
      'fld_4915610' => '1:1',
      'fld_7082646' => '1:1',
      'fld_4019904' => '1:1',
      'fld_6302065' => '1:1',
      'fld_9551718' => '1:1',
      'fld_9798293' => '1:1',
      'fld_4673747' => '1:1',
      'fld_4930878' => '1:1',
      'fld_1396371' => '1:1',
      'fld_4661510' => '1:1',
      'fld_5422010' => '1:1',
      'fld_1493063' => '1:1',
      'fld_7441539' => '1:1',
      'fld_230749' => '1:1',
      'fld_714158' => '1:1',
      'fld_1116380' => '1:1',
      'fld_7279921' => '1:1',
      'fld_5501118' => '1:1',
      'fld_2258378' => '1:1',
      'fld_1185994' => '1:1',
      'fld_8901701' => '1:1',
      'fld_8526977' => '1:1',
      'fld_9560023' => '1:1',
      'fld_6061190' => '1:1',
    ),
    'structure' => '12',
  ),
  'fields' => 
  array (
    'fld_330007' => 
    array (
      'ID' => 'fld_330007',
      'type' => 'html',
      'label' => 'Hi , welcome back.',
      'slug' => 'hi_welcome_back',
      'additional' => '',
      'conditions' => 
      array (
        'type' => '',
      ),
      'config' => 
      array (
        'default' => 'Hi , welcome back.',
      ),
    ),
    'fld_8389952' => 
    array (
      'ID' => 'fld_8389952',
      'type' => 'html',
      'label' => 'I can help find a suitable doctor for you.',
      'slug' => 'i_can_help_find_a_suitable_doctor_for_you',
      'additional' => '',
      'conditions' => 
      array (
        'type' => '',
      ),
      'config' => 
      array (
        'default' => 'I can help find a suitable doctor for you.',
      ),
    ),
    'fld_8941046' => 
    array (
      'ID' => 'fld_8941046',
      'type' => 'dropdown',
      'label' => 'Choose an option to begin.',
      'slug' => 'choose_an_option_to_begin',
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
          'opt1373930' => 
          array (
            'calc_value' => 'Find Doctors',
            'value' => 'Find Doctors',
            'label' => 'Find Doctors',
          ),
          'opt1523857' => 
          array (
            'calc_value' => 'About Us',
            'value' => 'About Us',
            'label' => 'About Us',
          ),
          'opt1699727' => 
          array (
            'calc_value' => 'Talk to Us!',
            'value' => 'Talk to Us!',
            'label' => 'Talk to Us!',
          ),
        ),
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_5548876' => 
    array (
      'ID' => 'fld_5548876',
      'type' => 'html',
      'label' => 'This is a generic write up that talks about the company and the products/services it provides.',
      'slug' => 'this_is_a_generic_write_up_that_talks_about_the_company_and_the_productsservices_it_provides',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_873507101997030',
      ),
      'config' => 
      array (
        'default' => 'This is a generic write up that talks about the company and the products/services it provides.',
      ),
    ),
    'fld_2933801' => 
    array (
      'ID' => 'fld_2933801',
      'type' => 'dropdown',
      'label' => 'There is a long history to the making of the company and its product has been successful with a wide variety of customers.',
      'slug' => 'there_is_a_long_history_to_the_making_of_the_company_and_its_product_has_been_successful_with_a_wide_variety_of_customers',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_873507101997030',
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
          'opt2057822' => 
          array (
            'calc_value' => 'Contact Us',
            'value' => 'Contact Us',
            'label' => 'Contact Us',
          ),
          'opt1191094' => 
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
    'fld_2739691' => 
    array (
      'ID' => 'fld_2739691',
      'type' => 'html',
      'label' => 'We have experienced specialist doctors and physicians to provide consulting for all your healthcare needs.',
      'slug' => 'we_have_experienced_specialist_doctors_and_physicians_to_provide_consulting_for_all_your_healthcare_needs',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_86294968078248',
      ),
      'config' => 
      array (
        'default' => 'We have experienced specialist doctors and physicians to provide consulting for all your healthcare needs.',
      ),
    ),
    'fld_1155455' => 
    array (
      'ID' => 'fld_1155455',
      'type' => 'dropdown',
      'label' => 'Find the right specialist from the options below:',
      'slug' => 'find_the_right_specialist_from_the_options_below',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_86294968078248',
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
          'opt1683966' => 
          array (
            'calc_value' => 'General Medicine',
            'value' => 'General Medicine',
            'label' => 'General Medicine',
          ),
          'opt1901915' => 
          array (
            'calc_value' => 'Paediatrics',
            'value' => 'Paediatrics',
            'label' => 'Paediatrics',
          ),
          'opt1496168' => 
          array (
            'calc_value' => 'Ophthalmology',
            'value' => 'Ophthalmology',
            'label' => 'Ophthalmology',
          ),
          'opt1653980' => 
          array (
            'calc_value' => 'Didn\'t find anything suitable?',
            'value' => 'Didn\'t find anything suitable?',
            'label' => 'Didn\'t find anything suitable?',
          ),
        ),
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_7090955' => 
    array (
      'ID' => 'fld_7090955',
      'type' => 'dropdown',
      'label' => 'We have the best Doctors & Physicians who can provide you the best healthcare treatment.',
      'slug' => 'we_have_the_best_doctors_physicians_who_can_provide_you_the_best_healthcare_treatment_general_medicine',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_823163645342455',
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
          'opt1203235' => 
          array (
            'calc_value' => 'Book Appointment',
            'value' => 'Book Appointment',
            'label' => 'Book Appointment',
          ),
          'opt1544452' => 
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
    'fld_750874' => 
    array (
      'ID' => 'fld_750874',
      'type' => 'html',
      'label' => 'I can help you book an appointment with the doctor.',
      'slug' => 'i_can_help_you_book_an_appointment_with_the_doctor_general_medicine',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_2326068630393423',
      ),
      'config' => 
      array (
        'default' => 'I can help you book an appointment with the doctor.',
      ),
    ),
    'fld_8091030' => 
    array (
      'ID' => 'fld_8091030',
      'type' => 'html',
      'label' => 'Before we move ahead, I need some information from you.',
      'slug' => 'before_we_move_ahead_i_need_some_information_from_you_general_medicine',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_2326068630393423',
      ),
      'config' => 
      array (
        'default' => 'Before we move ahead, I need some information from you.',
      ),
    ),
    'fld_845320' => 
    array (
      'ID' => 'fld_845320',
      'type' => 'text',
      'label' => 'Please help me with your name?',
      'slug' => 'please_help_me_with_your_name_general_medicine',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_2326068630393423',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_956191' => 
    array (
      'ID' => 'fld_956191',
      'type' => 'email',
      'label' => 'Also, your email ID, please?',
      'slug' => 'also_your_email_id_please_general_medicine',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_2326068630393423',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_6518476' => 
    array (
      'ID' => 'fld_6518476',
      'type' => 'number',
      'label' => 'And your phone number?',
      'slug' => 'and_your_phone_number_general_medicine',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_2326068630393423',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_7584862' => 
    array (
      'ID' => 'fld_7584862',
      'type' => 'dropdown',
      'label' => 'What is the best time to contact you? (Choose the most suitable option)',
      'slug' => 'what_is_the_best_time_to_contact_you_choose_the_most_suitable_option',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_2326068630393423',
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
          'opt1363206' => 
          array (
            'calc_value' => 'Morning (9am to 12pm)',
            'value' => 'Morning (9am to 12pm)',
            'label' => 'Morning (9am to 12pm)',
          ),
          'opt1346002' => 
          array (
            'calc_value' => 'Afternoon (12pm to 3pm)',
            'value' => 'Afternoon (12pm to 3pm)',
            'label' => 'Afternoon (12pm to 3pm)',
          ),
          'opt1533622' => 
          array (
            'calc_value' => 'Evening (3pm to 6pm)',
            'value' => 'Evening (3pm to 6pm)',
            'label' => 'Evening (3pm to 6pm)',
          ),
          'opt1345642' => 
          array (
            'calc_value' => 'Anytime',
            'value' => 'Anytime',
            'label' => 'Anytime',
          ),
        ),
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_5172212' => 
    array (
      'ID' => 'fld_5172212',
      'type' => 'html',
      'label' => 'Thanks for providing all the details.',
      'slug' => 'thanks_for_providing_all_the_details_general_medicine',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_5262682958437671',
      ),
      'config' => 
      array (
        'default' => 'Thanks for providing all the details. ',
      ),
    ),
    'fld_9747502' => 
    array (
      'ID' => 'fld_9747502',
      'type' => 'html',
      'label' => 'Our team will get in touch with you shortly to fix the appointment time. Have a good day!',
      'slug' => 'our_team_will_get_in_touch_with_you_shortly_to_fix_the_appointment_time_have_a_good_day_general_medicine',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_5262682958437671',
      ),
      'config' => 
      array (
        'default' => 'Our team will get in touch with you shortly to fix the appointment time.
<br>
Have a good day!',
      ),
    ),
    'fld_4882058' => 
    array (
      'ID' => 'fld_4882058',
      'type' => 'html',
      'label' => 'Thanks for providing all the details.',
      'slug' => 'thanks_for_providing_all_the_details_general_medicine_afternoon',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_5063269698669073',
      ),
      'config' => 
      array (
        'default' => 'Thanks for providing all the details. ',
      ),
    ),
    'fld_4064590' => 
    array (
      'ID' => 'fld_4064590',
      'type' => 'html',
      'label' => 'Our team will get in touch with you shortly to fix the appointment time. Have a good day!',
      'slug' => 'our_team_will_get_in_touch_with_you_shortly_to_fix_the_appointment_time_have_a_good_day_general_medicine_afternoon',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_5063269698669073',
      ),
      'config' => 
      array (
        'default' => 'Our team will get in touch with you shortly to fix the appointment time.
<br>
Have a good day!',
      ),
    ),
    'fld_7140221' => 
    array (
      'ID' => 'fld_7140221',
      'type' => 'html',
      'label' => 'Thanks for providing all the details.',
      'slug' => 'thanks_for_providing_all_the_details_general_medicine_evening',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_7734993591376834',
      ),
      'config' => 
      array (
        'default' => 'Thanks for providing all the details. ',
      ),
    ),
    'fld_7584164' => 
    array (
      'ID' => 'fld_7584164',
      'type' => 'html',
      'label' => 'Our team will get in touch with you shortly to fix the appointment time. Have a good day!',
      'slug' => 'our_team_will_get_in_touch_with_you_shortly_to_fix_the_appointment_time_have_a_good_day_general_medicine_evening',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_7734993591376834',
      ),
      'config' => 
      array (
        'default' => 'Our team will get in touch with you shortly to fix the appointment time.
<br>
Have a good day!',
      ),
    ),
    'fld_600553' => 
    array (
      'ID' => 'fld_600553',
      'type' => 'html',
      'label' => 'Thanks for providing all the details.',
      'slug' => 'thanks_for_providing_all_the_details_general_medicine_anytime',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_3973465117961900',
      ),
      'config' => 
      array (
        'default' => 'Thanks for providing all the details. ',
      ),
    ),
    'fld_4206668' => 
    array (
      'ID' => 'fld_4206668',
      'type' => 'html',
      'label' => 'Our team will get in touch with you shortly to fix the appointment time. Have a good day!',
      'slug' => 'our_team_will_get_in_touch_with_you_shortly_to_fix_the_appointment_time_have_a_good_day_general_medicine_anytime',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_3973465117961900',
      ),
      'config' => 
      array (
        'default' => 'Our team will get in touch with you shortly to fix the appointment time.
<br>
Have a good day!',
      ),
    ),
    'fld_1364858' => 
    array (
      'ID' => 'fld_1364858',
      'type' => 'dropdown',
      'label' => 'We have the best Doctors & Physicians who can provide you the best healthcare treatment.',
      'slug' => 'we_have_the_best_doctors_physicians_who_can_provide_you_the_best_healthcare_treatment_peadiatices',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_8593824248049606',
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
          'opt1203235' => 
          array (
            'calc_value' => 'Book Appointment',
            'value' => 'Book Appointment',
            'label' => 'Book Appointment',
          ),
          'opt1544452' => 
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
    'fld_3245651' => 
    array (
      'ID' => 'fld_3245651',
      'type' => 'html',
      'label' => 'I can help you book an appointment with the doctor.',
      'slug' => 'i_can_help_you_book_an_appointment_with_the_doctor_padrietcess',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_2982370987444845',
      ),
      'config' => 
      array (
        'default' => 'I can help you book an appointment with the doctor.',
      ),
    ),
    'fld_8084010' => 
    array (
      'ID' => 'fld_8084010',
      'type' => 'html',
      'label' => 'Before we move ahead, I need some information from you.',
      'slug' => 'before_we_move_ahead_i_need_some_information_from_you_pedireiact',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_2982370987444845',
      ),
      'config' => 
      array (
        'default' => 'Before we move ahead, I need some information from you.',
      ),
    ),
    'fld_2794345' => 
    array (
      'ID' => 'fld_2794345',
      'type' => 'text',
      'label' => 'Please help me with your name?',
      'slug' => 'please_help_me_with_your_nameparadiacts',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_2982370987444845',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_6362406' => 
    array (
      'ID' => 'fld_6362406',
      'type' => 'email',
      'label' => 'Also, your email ID, please?',
      'slug' => 'also_your_email_id_please_paradiacts',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_2982370987444845',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_602638' => 
    array (
      'ID' => 'fld_602638',
      'type' => 'number',
      'label' => 'And your phone number?',
      'slug' => 'and_your_phone_number_paediatrics',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_2982370987444845',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_7674672' => 
    array (
      'ID' => 'fld_7674672',
      'type' => 'dropdown',
      'label' => 'What is the best time to contact you? (Choose the most suitable option)',
      'slug' => 'what_is_the_best_time_to_contact_you_choose_the_most_suitable_option_paediatrics',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_2982370987444845',
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
          'opt1363206' => 
          array (
            'calc_value' => 'Morning (9am to 12pm)',
            'value' => 'Morning (9am to 12pm)',
            'label' => 'Morning (9am to 12pm)',
          ),
          'opt1346002' => 
          array (
            'calc_value' => 'Afternoon (12pm to 3pm)',
            'value' => 'Afternoon (12pm to 3pm)',
            'label' => 'Afternoon (12pm to 3pm)',
          ),
          'opt1533622' => 
          array (
            'calc_value' => 'Evening (3pm to 6pm)',
            'value' => 'Evening (3pm to 6pm)',
            'label' => 'Evening (3pm to 6pm)',
          ),
          'opt1345642' => 
          array (
            'calc_value' => 'Anytime',
            'value' => 'Anytime',
            'label' => 'Anytime',
          ),
        ),
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_5008097' => 
    array (
      'ID' => 'fld_5008097',
      'type' => 'html',
      'label' => 'Thanks for providing all the details.',
      'slug' => 'thanks_for_providing_all_the_details_',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_8081433595091975',
      ),
      'config' => 
      array (
        'default' => 'Thanks for providing all the details. ',
      ),
    ),
    'fld_2151130' => 
    array (
      'ID' => 'fld_2151130',
      'type' => 'html',
      'label' => 'Our team will get in touch with you shortly to fix the appointment time. Have a good day!',
      'slug' => 'our_team_will_get_in_touch_with_you_shortly_to_fix_the_appointment_time_have_a_good_day_pead_monrn',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_8081433595091975',
      ),
      'config' => 
      array (
        'default' => 'Our team will get in touch with you shortly to fix the appointment time.
<br>
Have a good day!',
      ),
    ),
    'fld_9620558' => 
    array (
      'ID' => 'fld_9620558',
      'type' => 'html',
      'label' => 'Thanks for providing all the details.',
      'slug' => 'thanks_for_providing_all_the_details_after_noones',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_312775905513447',
      ),
      'config' => 
      array (
        'default' => 'Thanks for providing all the details. ',
      ),
    ),
    'fld_934190' => 
    array (
      'ID' => 'fld_934190',
      'type' => 'html',
      'label' => 'Our team will get in touch with you shortly to fix the appointment time. Have a good day!',
      'slug' => 'our_team_will_get_in_touch_with_you_shortly_to_fix_the_appointment_time_have_a_good_day_after_noones',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_312775905513447',
      ),
      'config' => 
      array (
        'default' => 'Our team will get in touch with you shortly to fix the appointment time.
<br>
Have a good day!',
      ),
    ),
    'fld_6225307' => 
    array (
      'ID' => 'fld_6225307',
      'type' => 'html',
      'label' => 'Thanks for providing all the details.',
      'slug' => 'thanks_for_providing_all_the_details_pedirot_evening',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_6089262293365856',
      ),
      'config' => 
      array (
        'default' => 'Thanks for providing all the details. ',
      ),
    ),
    'fld_7544851' => 
    array (
      'ID' => 'fld_7544851',
      'type' => 'html',
      'label' => 'Our team will get in touch with you shortly to fix the appointment time. Have a good day!',
      'slug' => 'our_team_will_get_in_touch_with_you_shortly_to_fix_the_appointment_time_have_a_good_day_pedirot_evening',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_6089262293365856',
      ),
      'config' => 
      array (
        'default' => 'Our team will get in touch with you shortly to fix the appointment time.
<br>
Have a good day!',
      ),
    ),
    'fld_4690311' => 
    array (
      'ID' => 'fld_4690311',
      'type' => 'html',
      'label' => 'Thanks for providing all the details.',
      'slug' => 'thanks_for_providing_all_the_details_pedriotes_anytime',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_1018364286638372',
      ),
      'config' => 
      array (
        'default' => 'Thanks for providing all the details. ',
      ),
    ),
    'fld_8473951' => 
    array (
      'ID' => 'fld_8473951',
      'type' => 'html',
      'label' => 'Our team will get in touch with you shortly to fix the appointment time. Have a good day!',
      'slug' => 'our_team_will_get_in_touch_with_you_shortly_to_fix_the_appointment_time_have_a_good_day_pedriotes_anytime',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_1018364286638372',
      ),
      'config' => 
      array (
        'default' => 'Our team will get in touch with you shortly to fix the appointment time.
<br>
Have a good day!',
      ),
    ),
    'fld_4419938' => 
    array (
      'ID' => 'fld_4419938',
      'type' => 'dropdown',
      'label' => 'We have the best Doctors & Physicians who can provide you the best healthcare treatment.',
      'slug' => 'we_have_the_best_doctors_physicians_who_can_provide_you_the_best_healthcare_treatment_ent',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_5786081640129109',
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
          'opt1203235' => 
          array (
            'calc_value' => 'Book Appointment',
            'value' => 'Book Appointment',
            'label' => 'Book Appointment',
          ),
          'opt1544452' => 
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
    'fld_6016377' => 
    array (
      'ID' => 'fld_6016377',
      'type' => 'html',
      'label' => 'I can help you book an appointment with the doctor.',
      'slug' => 'i_can_help_you_book_an_appointment_with_the_doctor_ophtha',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_203214827178321',
      ),
      'config' => 
      array (
        'default' => 'I can help you book an appointment with the doctor.',
      ),
    ),
    'fld_4151106' => 
    array (
      'ID' => 'fld_4151106',
      'type' => 'html',
      'label' => 'Before we move ahead, I need some information from you.',
      'slug' => 'before_we_move_ahead_i_need_some_information_from_you_ophtha',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_203214827178321',
      ),
      'config' => 
      array (
        'default' => 'Before we move ahead, I need some information from you.',
      ),
    ),
    'fld_3312615' => 
    array (
      'ID' => 'fld_3312615',
      'type' => 'text',
      'label' => 'Please help me with your name?',
      'slug' => 'please_help_me_with_your_name_ophtha',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_203214827178321',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_4471823' => 
    array (
      'ID' => 'fld_4471823',
      'type' => 'email',
      'label' => 'Also, your email ID, please?',
      'slug' => 'also_your_email_id_please_ophtha',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_203214827178321',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_8741992' => 
    array (
      'ID' => 'fld_8741992',
      'type' => 'number',
      'label' => 'And your phone number?',
      'slug' => 'and_your_phone_number_ophtha',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_203214827178321',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_2532832' => 
    array (
      'ID' => 'fld_2532832',
      'type' => 'dropdown',
      'label' => 'What is the best time to contact you? (Choose the most suitable option)',
      'slug' => 'what_is_the_best_time_to_contact_you_choose_the_most_suitable_option_ophtha',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_203214827178321',
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
          'opt1363206' => 
          array (
            'calc_value' => 'Morning (9am to 12pm)',
            'value' => 'Morning (9am to 12pm)',
            'label' => 'Morning (9am to 12pm)',
          ),
          'opt1346002' => 
          array (
            'calc_value' => 'Afternoon (12pm to 3pm)',
            'value' => 'Afternoon (12pm to 3pm)',
            'label' => 'Afternoon (12pm to 3pm)',
          ),
          'opt1533622' => 
          array (
            'calc_value' => 'Evening (3pm to 6pm)',
            'value' => 'Evening (3pm to 6pm)',
            'label' => 'Evening (3pm to 6pm)',
          ),
          'opt1345642' => 
          array (
            'calc_value' => 'Anytime',
            'value' => 'Anytime',
            'label' => 'Anytime',
          ),
        ),
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_4915610' => 
    array (
      'ID' => 'fld_4915610',
      'type' => 'html',
      'label' => 'Thanks for providing all the details.',
      'slug' => 'thanks_for_providing_all_the_details_ophtha_envening',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_54914885565845',
      ),
      'config' => 
      array (
        'default' => 'Thanks for providing all the details. ',
      ),
    ),
    'fld_7082646' => 
    array (
      'ID' => 'fld_7082646',
      'type' => 'html',
      'label' => 'Our team will get in touch with you shortly to fix the appointment time. Have a good day!',
      'slug' => 'our_team_will_get_in_touch_with_you_shortly_to_fix_the_appointment_time_have_a_good_day_ophtha_morining',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_54914885565845',
      ),
      'config' => 
      array (
        'default' => 'Our team will get in touch with you shortly to fix the appointment time.
<br>
Have a good day!',
      ),
    ),
    'fld_4019904' => 
    array (
      'ID' => 'fld_4019904',
      'type' => 'html',
      'label' => 'Thanks for providing all the details.',
      'slug' => 'thanks_for_providing_all_the_details_opha_afternoon',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_5805433192674627',
      ),
      'config' => 
      array (
        'default' => 'Thanks for providing all the details. ',
      ),
    ),
    'fld_6302065' => 
    array (
      'ID' => 'fld_6302065',
      'type' => 'html',
      'label' => 'Our team will get in touch with you shortly to fix the appointment time. Have a good day!',
      'slug' => 'our_team_will_get_in_touch_with_you_shortly_to_fix_the_appointment_time_have_a_good_day_opha_afternoon',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_5805433192674627',
      ),
      'config' => 
      array (
        'default' => 'Our team will get in touch with you shortly to fix the appointment time.
<br>
Have a good day!',
      ),
    ),
    'fld_9551718' => 
    array (
      'ID' => 'fld_9551718',
      'type' => 'html',
      'label' => 'Thanks for providing all the details.',
      'slug' => 'thanks_for_providing_all_the_details_ophatha_eveningss',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_9208712994896788',
      ),
      'config' => 
      array (
        'default' => 'Thanks for providing all the details. ',
      ),
    ),
    'fld_9798293' => 
    array (
      'ID' => 'fld_9798293',
      'type' => 'html',
      'label' => 'Our team will get in touch with you shortly to fix the appointment time. Have a good day!',
      'slug' => 'our_team_will_get_in_touch_with_you_shortly_to_fix_the_appointment_time_have_a_good_day_ophatha_eveningss',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_9208712994896788',
      ),
      'config' => 
      array (
        'default' => 'Our team will get in touch with you shortly to fix the appointment time.
<br>
Have a good day!',
      ),
    ),
    'fld_4673747' => 
    array (
      'ID' => 'fld_4673747',
      'type' => 'html',
      'label' => 'Thanks for providing all the details.',
      'slug' => 'thanks_for_providing_all_the_details_ophtha_anything',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_2171271059238139',
      ),
      'config' => 
      array (
        'default' => 'Thanks for providing all the details. ',
      ),
    ),
    'fld_4930878' => 
    array (
      'ID' => 'fld_4930878',
      'type' => 'html',
      'label' => 'Our team will get in touch with you shortly to fix the appointment time. Have a good day!',
      'slug' => 'our_team_will_get_in_touch_with_you_shortly_to_fix_the_appointment_time_have_a_good_day_ophtha_anything',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_2171271059238139',
      ),
      'config' => 
      array (
        'default' => 'Our team will get in touch with you shortly to fix the appointment time.
<br>
Have a good day!',
      ),
    ),
    'fld_1396371' => 
    array (
      'ID' => 'fld_1396371',
      'type' => 'html',
      'label' => 'No problem! Help me with a few details about you and I will have someone from my team contact you right away..',
      'slug' => 'no_problem_help_me_with_a_few_details_about_you_and_i_will_have_someone_from_my_team_contact_you_right_away',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_7564566655522706',
      ),
      'config' => 
      array (
        'default' => 'No problem! Help me with a few details about you and I will have someone from my team contact you right away..',
      ),
    ),
    'fld_4661510' => 
    array (
      'ID' => 'fld_4661510',
      'type' => 'text',
      'label' => 'What is your Name?',
      'slug' => 'what_is_your_name_talk_to_us',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_7564566655522706',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_5422010' => 
    array (
      'ID' => 'fld_5422010',
      'type' => 'email',
      'label' => 'What is your Email ID?',
      'slug' => 'what_is_your_email_id_talk_to_us',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_7564566655522706',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_1493063' => 
    array (
      'ID' => 'fld_1493063',
      'type' => 'number',
      'label' => 'What is your phone number?',
      'slug' => 'what_is_your_phone_number_talk_to_us',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_7564566655522706',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_7441539' => 
    array (
      'ID' => 'fld_7441539',
      'type' => 'html',
      'label' => 'Thanks for provide all the details. Our team will get in touch with you shortly.',
      'slug' => 'thanks_for_provide_all_the_details_our_team_will_get_in_touch_with_you_shortly_',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_7564566655522706',
      ),
      'config' => 
      array (
        'default' => 'Thanks for provide all the details. Our team will get in touch with you shortly. 
<br>
Have a good day!',
      ),
    ),
    'fld_230749' => 
    array (
      'ID' => 'fld_230749',
      'type' => 'html',
      'label' => 'No problem! Help me with a few details about you and I will have someone from my team contact you right away..',
      'slug' => 'no_problem_help_me_with_a_few_details_about_you_and_i_will_have_someone_from_my_team_contact_you_right_awayfsafasdf',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_2622080765835307',
      ),
      'config' => 
      array (
        'default' => 'No problem! Help me with a few details about you and I will have someone from my team contact you right away..',
      ),
    ),
    'fld_714158' => 
    array (
      'ID' => 'fld_714158',
      'type' => 'text',
      'label' => 'What is your Name?',
      'slug' => 'what_is_your_namefsafasdf',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_2622080765835307',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_1116380' => 
    array (
      'ID' => 'fld_1116380',
      'type' => 'email',
      'label' => 'What is your Email ID?',
      'slug' => 'what_is_your_email_idfsafasdf',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_2622080765835307',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_7279921' => 
    array (
      'ID' => 'fld_7279921',
      'type' => 'number',
      'label' => 'What is your phone number?',
      'slug' => 'what_is_your_phone_numberasdfasdf',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_2622080765835307',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_5501118' => 
    array (
      'ID' => 'fld_5501118',
      'type' => 'html',
      'label' => 'Thanks for provide all the details. Our team will get in touch with you shortly.',
      'slug' => 'thanks_for_provide_all_the_details_our_team_will_get_in_touch_with_you_shortly_hfdhdfgh',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_2622080765835307',
      ),
      'config' => 
      array (
        'default' => 'Thanks for provide all the details. Our team will get in touch with you shortly. 
<br>
Have a good day!',
      ),
    ),
    'fld_2258378' => 
    array (
      'ID' => 'fld_2258378',
      'type' => 'dropdown',
      'label' => 'Didn\'t find anything suitable?',
      'slug' => 'didnt_find_anything_suitable_options',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_7121007920451025',
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
          'opt2072868' => 
          array (
            'calc_value' => 'Contact Us',
            'value' => 'Contact Us',
            'label' => 'Contact Us',
          ),
          'opt1951905' => 
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
    'fld_1185994' => 
    array (
      'ID' => 'fld_1185994',
      'type' => 'html',
      'label' => 'No problem! Help me with a few details about you and I will have someone from my team contact you right away..',
      'slug' => 'no_problem_help_me_with_a_few_details_about_you_and_i_will_have_someone_from_my_team_contact_you_right_away_contact_us_suitable',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_3895842216454627',
      ),
      'config' => 
      array (
        'default' => 'No problem! Help me with a few details about you and I will have someone from my team contact you right away..',
      ),
    ),
    'fld_8901701' => 
    array (
      'ID' => 'fld_8901701',
      'type' => 'text',
      'label' => 'What is your Name?',
      'slug' => 'what_is_your_name_contact_us_suitable',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_3895842216454627',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_8526977' => 
    array (
      'ID' => 'fld_8526977',
      'type' => 'email',
      'label' => 'What is your Email ID?',
      'slug' => 'what_is_your_email_id_contact_us_suitable',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_3895842216454627',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_9560023' => 
    array (
      'ID' => 'fld_9560023',
      'type' => 'number',
      'label' => 'What is your phone number?',
      'slug' => 'what_is_your_phone_number_contact_us_suitable',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_3895842216454627',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_6061190' => 
    array (
      'ID' => 'fld_6061190',
      'type' => 'html',
      'label' => 'Thanks for provide all the details. Our team will get in touch with you shortly.',
      'slug' => 'thanks_for_provide_all_the_details_our_team_will_get_in_touch_with_you_shortly_contact_us_suitable',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_3895842216454627',
      ),
      'config' => 
      array (
        'default' => 'Thanks for provide all the details. Our team will get in touch with you shortly. 
<br>
Have a good day!',
      ),
    ),
  ),
  'mailer' => 
  array (
    'on_insert' => 1,
    'sender_name' => 'Chatbot Forms Notification',
    'sender_email' => '',
    'recipients' => '',
    'email_subject' => 'Healthcare - Appointment Selector',
  ),
  'conditional_groups' => 
  array (
    'conditions' => 
    array (
      'con_86294968078248' => 
      array (
        'id' => 'con_86294968078248',
        'name' => 'Find Doctors',
        'type' => 'show',
        'fields' => 
        array (
          'cl2736357638739664' => 'fld_8941046',
        ),
        'group' => 
        array (
          'rw6583092981454204' => 
          array (
            'cl2736357638739664' => 
            array (
              'parent' => 'rw6583092981454204',
              'field' => 'fld_8941046',
              'compare' => 'is',
              'value' => 'opt1373930',
            ),
          ),
        ),
      ),
      'con_873507101997030' => 
      array (
        'id' => 'con_873507101997030',
        'name' => 'About Us',
        'type' => 'show',
        'fields' => 
        array (
          'cl9751698546725578' => 'fld_8941046',
        ),
        'group' => 
        array (
          'rw1798619716575662' => 
          array (
            'cl9751698546725578' => 
            array (
              'parent' => 'rw1798619716575662',
              'field' => 'fld_8941046',
              'compare' => 'is',
              'value' => 'opt1523857',
            ),
          ),
        ),
      ),
      'con_7564566655522706' => 
      array (
        'id' => 'con_7564566655522706',
        'name' => 'Talk to us',
        'type' => 'show',
        'fields' => 
        array (
          'cl1825793434323480' => 'fld_8941046',
        ),
        'group' => 
        array (
          'rw3891776613479157' => 
          array (
            'cl1825793434323480' => 
            array (
              'parent' => 'rw3891776613479157',
              'field' => 'fld_8941046',
              'compare' => 'is',
              'value' => 'opt1699727',
            ),
          ),
        ),
      ),
      'con_2622080765835307' => 
      array (
        'id' => 'con_2622080765835307',
        'name' => 'Contact Us from about us',
        'type' => 'show',
        'fields' => 
        array (
          'cl9449302414383739' => 'fld_2933801',
        ),
        'group' => 
        array (
          'rw382784625061552' => 
          array (
            'cl9449302414383739' => 
            array (
              'parent' => 'rw382784625061552',
              'field' => 'fld_2933801',
              'compare' => 'is',
              'value' => 'opt2057822',
            ),
          ),
        ),
      ),
      'con_7121007920451025' => 
      array (
        'id' => 'con_7121007920451025',
        'name' => 'Didn\'t find anything suitable?',
        'type' => 'show',
        'fields' => 
        array (
          'cl5724181379809424' => 'fld_1155455',
        ),
        'group' => 
        array (
          'rw2513398027158176' => 
          array (
            'cl5724181379809424' => 
            array (
              'parent' => 'rw2513398027158176',
              'field' => 'fld_1155455',
              'compare' => 'is',
              'value' => 'opt1653980',
            ),
          ),
        ),
      ),
      'con_823163645342455' => 
      array (
        'id' => 'con_823163645342455',
        'name' => 'General Medicine',
        'type' => 'show',
        'fields' => 
        array (
          'cl1377090794530676' => 'fld_1155455',
        ),
        'group' => 
        array (
          'rw3775079512253035' => 
          array (
            'cl1377090794530676' => 
            array (
              'parent' => 'rw3775079512253035',
              'field' => 'fld_1155455',
              'compare' => 'is',
              'value' => 'opt1683966',
            ),
          ),
        ),
      ),
      'con_8593824248049606' => 
      array (
        'id' => 'con_8593824248049606',
        'name' => 'Paediatrics',
        'type' => 'show',
        'fields' => 
        array (
          'cl7109248010921720' => 'fld_1155455',
        ),
        'group' => 
        array (
          'rw967417391851319' => 
          array (
            'cl7109248010921720' => 
            array (
              'parent' => 'rw967417391851319',
              'field' => 'fld_1155455',
              'compare' => 'is',
              'value' => 'opt1901915',
            ),
          ),
        ),
      ),
      'con_5286449257531914' => 
      array (
        'id' => 'con_5286449257531914',
        'name' => 'ENT',
        'type' => 'show',
        'fields' => 
        array (
          'cl7576060216252851' => 'fld_1155455',
        ),
        'group' => 
        array (
          'rw3194910823476192' => 
          array (
            'cl7576060216252851' => 
            array (
              'parent' => 'rw3194910823476192',
              'field' => 'fld_1155455',
              'compare' => 'is',
              'value' => 'opt1361993',
            ),
          ),
        ),
      ),
      'con_5786081640129109' => 
      array (
        'id' => 'con_5786081640129109',
        'name' => 'Ophthalmology',
        'type' => 'show',
        'fields' => 
        array (
          'cl6323123563667932' => 'fld_1155455',
        ),
        'group' => 
        array (
          'rw8416010723795537' => 
          array (
            'cl6323123563667932' => 
            array (
              'parent' => 'rw8416010723795537',
              'field' => 'fld_1155455',
              'compare' => 'is',
              'value' => 'opt1496168',
            ),
          ),
        ),
      ),
      'con_2326068630393423' => 
      array (
        'id' => 'con_2326068630393423',
        'name' => 'Book Appointment -- general medicine',
        'type' => 'show',
        'fields' => 
        array (
          'cl763503131456921' => 'fld_7090955',
        ),
        'group' => 
        array (
          'rw3887465943034892' => 
          array (
            'cl763503131456921' => 
            array (
              'parent' => 'rw3887465943034892',
              'field' => 'fld_7090955',
              'compare' => 'is',
              'value' => 'opt1203235',
            ),
          ),
        ),
      ),
      'con_5262682958437671' => 
      array (
        'id' => 'con_5262682958437671',
        'name' => 'Morning (9am to 12pm) -- general medicine',
        'type' => 'show',
        'fields' => 
        array (
          'cl5759357431630812' => 'fld_7584862',
        ),
        'group' => 
        array (
          'rw9773459494732087' => 
          array (
            'cl5759357431630812' => 
            array (
              'parent' => 'rw9773459494732087',
              'field' => 'fld_7584862',
              'compare' => 'is',
              'value' => 'opt1363206',
            ),
          ),
        ),
      ),
      'con_5063269698669073' => 
      array (
        'id' => 'con_5063269698669073',
        'name' => 'Afternoon (12pm to 3pm) -- general medicine',
        'type' => 'show',
        'fields' => 
        array (
          'cl3160740736621206' => 'fld_7584862',
        ),
        'group' => 
        array (
          'rw8731321618625160' => 
          array (
            'cl3160740736621206' => 
            array (
              'parent' => 'rw8731321618625160',
              'field' => 'fld_7584862',
              'compare' => 'is',
              'value' => 'opt1346002',
            ),
          ),
        ),
      ),
      'con_7734993591376834' => 
      array (
        'id' => 'con_7734993591376834',
        'name' => 'Evening (3pm to 6pm) -- general medicine',
        'type' => 'show',
        'fields' => 
        array (
          'cl9364033131812602' => 'fld_7584862',
        ),
        'group' => 
        array (
          'rw9959826227846112' => 
          array (
            'cl9364033131812602' => 
            array (
              'parent' => 'rw9959826227846112',
              'field' => 'fld_7584862',
              'compare' => 'is',
              'value' => 'opt1533622',
            ),
          ),
        ),
      ),
      'con_3973465117961900' => 
      array (
        'id' => 'con_3973465117961900',
        'name' => 'Anytime -- general medicine',
        'type' => 'show',
        'fields' => 
        array (
          'cl5699705335921735' => 'fld_7584862',
        ),
        'group' => 
        array (
          'rw6149598060120752' => 
          array (
            'cl5699705335921735' => 
            array (
              'parent' => 'rw6149598060120752',
              'field' => 'fld_7584862',
              'compare' => 'is',
              'value' => 'opt1345642',
            ),
          ),
        ),
      ),
      'con_2982370987444845' => 
      array (
        'id' => 'con_2982370987444845',
        'name' => 'Book Appointment -- Paediatrics',
        'type' => 'show',
        'fields' => 
        array (
          'cl8746894444584431' => 'fld_1364858',
        ),
        'group' => 
        array (
          'rw1826289297984931' => 
          array (
            'cl8746894444584431' => 
            array (
              'parent' => 'rw1826289297984931',
              'field' => 'fld_1364858',
              'compare' => 'is',
              'value' => 'opt1203235',
            ),
          ),
        ),
      ),
      'con_8081433595091975' => 
      array (
        'id' => 'con_8081433595091975',
        'name' => 'Morning (9am to 12pm) -- Paediatics',
        'type' => 'show',
        'fields' => 
        array (
          'cl5695878870106647' => 'fld_7674672',
        ),
        'group' => 
        array (
          'rw968702550749089' => 
          array (
            'cl5695878870106647' => 
            array (
              'parent' => 'rw968702550749089',
              'field' => 'fld_7674672',
              'compare' => 'is',
              'value' => 'opt1363206',
            ),
          ),
        ),
      ),
      'con_312775905513447' => 
      array (
        'id' => 'con_312775905513447',
        'name' => 'Afternoon (12pm to 3pm) -- Paediatics',
        'type' => 'show',
        'fields' => 
        array (
          'cl1374019273762146' => 'fld_7674672',
        ),
        'group' => 
        array (
          'rw8995452815297698' => 
          array (
            'cl1374019273762146' => 
            array (
              'parent' => 'rw8995452815297698',
              'field' => 'fld_7674672',
              'compare' => 'is',
              'value' => 'opt1346002',
            ),
          ),
        ),
      ),
      'con_6089262293365856' => 
      array (
        'id' => 'con_6089262293365856',
        'name' => 'Evening (3pm to 6pm) -- Paediatics',
        'type' => 'show',
        'fields' => 
        array (
          'cl446756651587410' => 'fld_7674672',
        ),
        'group' => 
        array (
          'rw3941840826162882' => 
          array (
            'cl446756651587410' => 
            array (
              'parent' => 'rw3941840826162882',
              'field' => 'fld_7674672',
              'compare' => 'is',
              'value' => 'opt1533622',
            ),
          ),
        ),
      ),
      'con_1018364286638372' => 
      array (
        'id' => 'con_1018364286638372',
        'name' => 'Anytime -- Paediatics',
        'type' => 'show',
        'fields' => 
        array (
          'cl6137900826908366' => 'fld_7674672',
        ),
        'group' => 
        array (
          'rw2764222326648089' => 
          array (
            'cl6137900826908366' => 
            array (
              'parent' => 'rw2764222326648089',
              'field' => 'fld_7674672',
              'compare' => 'is',
              'value' => 'opt1345642',
            ),
          ),
        ),
      ),
      'con_203214827178321' => 
      array (
        'id' => 'con_203214827178321',
        'name' => 'Book Appointment -- Ophthalmology',
        'type' => 'show',
        'fields' => 
        array (
          'cl4392231717267709' => 'fld_4419938',
        ),
        'group' => 
        array (
          'rw613134566569320' => 
          array (
            'cl4392231717267709' => 
            array (
              'parent' => 'rw613134566569320',
              'field' => 'fld_4419938',
              'compare' => 'is',
              'value' => 'opt1203235',
            ),
          ),
        ),
      ),
      'con_54914885565845' => 
      array (
        'id' => 'con_54914885565845',
        'name' => 'Morning (9am to 12pm) -- Ophthalmology',
        'type' => 'show',
        'fields' => 
        array (
          'cl3936536497123280' => 'fld_2532832',
        ),
        'group' => 
        array (
          'rw823294610297975' => 
          array (
            'cl3936536497123280' => 
            array (
              'parent' => 'rw823294610297975',
              'field' => 'fld_2532832',
              'compare' => 'is',
              'value' => 'opt1363206',
            ),
          ),
        ),
      ),
      'con_5805433192674627' => 
      array (
        'id' => 'con_5805433192674627',
        'name' => 'Afternoon (12pm to 3pm) -- Ophthalmology',
        'type' => 'show',
        'fields' => 
        array (
          'cl313596133189908' => 'fld_2532832',
        ),
        'group' => 
        array (
          'rw2689080486010235' => 
          array (
            'cl313596133189908' => 
            array (
              'parent' => 'rw2689080486010235',
              'field' => 'fld_2532832',
              'compare' => 'is',
              'value' => 'opt1346002',
            ),
          ),
        ),
      ),
      'con_9208712994896788' => 
      array (
        'id' => 'con_9208712994896788',
        'name' => 'Evening (3pm to 6pm) -- Ophthalmology',
        'type' => 'show',
        'fields' => 
        array (
          'cl5540617549047212' => 'fld_2532832',
        ),
        'group' => 
        array (
          'rw1463423470767092' => 
          array (
            'cl5540617549047212' => 
            array (
              'parent' => 'rw1463423470767092',
              'field' => 'fld_2532832',
              'compare' => 'is',
              'value' => 'opt1533622',
            ),
          ),
        ),
      ),
      'con_2171271059238139' => 
      array (
        'id' => 'con_2171271059238139',
        'name' => 'Anytime -- Ophthalmology',
        'type' => 'show',
        'fields' => 
        array (
          'cl6666541341629266' => 'fld_2532832',
        ),
        'group' => 
        array (
          'rw4292531243541121' => 
          array (
            'cl6666541341629266' => 
            array (
              'parent' => 'rw4292531243541121',
              'field' => 'fld_2532832',
              'compare' => 'is',
              'value' => 'opt1345642',
            ),
          ),
        ),
      ),
      'con_3895842216454627' => 
      array (
        'id' => 'con_3895842216454627',
        'name' => 'Contact Us Didn\'t find anything suitable?',
        'type' => 'show',
        'fields' => 
        array (
          'cl3650169067644307' => 'fld_2258378',
        ),
        'group' => 
        array (
          'rw1937112445465553' => 
          array (
            'cl3650169067644307' => 
            array (
              'parent' => 'rw1937112445465553',
              'field' => 'fld_2258378',
              'compare' => 'is',
              'value' => 'opt2072868',
            ),
          ),
        ),
      ),
    ),
  ),
  'privacy_exporter_enabled' => false,
  'version' => '1.0.0',
);