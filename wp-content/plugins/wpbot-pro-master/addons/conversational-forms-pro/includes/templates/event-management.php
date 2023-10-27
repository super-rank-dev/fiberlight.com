<?php 

return array (
  '_last_updated' => 'Tue, 18 Feb 2020 11:52:38 +0000',
  'ID' => 'CF5e4672864dba3',
  'wfb_version' => '1.0.0',
  'name' => 'Event Management',
  'command' => 'event management',
  'layout_grid' => 
  array (
    'fields' => 
    array (
      'fld_7071501' => '1:1',
      'fld_7244377' => '1:1',
      'fld_3041482' => '1:1',
      'fld_9003210' => '1:1',
      'fld_5030920' => '1:1',
      'fld_1440867' => '1:1',
      'fld_3099161' => '1:1',
      'fld_5902030' => '1:1',
      'fld_4034526' => '1:1',
      'fld_43940' => '1:1',
      'fld_1235908' => '1:1',
      'fld_3792513' => '1:1',
      'fld_6820487' => '1:1',
      'fld_4981789' => '1:1',
      'fld_8498735' => '1:1',
      'fld_4915056' => '1:1',
      'fld_2766734' => '1:1',
      'fld_3029027' => '1:1',
      'fld_9219944' => '1:1',
      'fld_2991557' => '1:1',
      'fld_924394' => '1:1',
      'fld_1626670' => '1:1',
      'fld_710409' => '1:1',
      'fld_5022413' => '1:1',
      'fld_7218532' => '1:1',
      'fld_9690252' => '1:1',
      'fld_2995176' => '1:1',
      'fld_6867592' => '1:1',
      'fld_5472144' => '1:1',
      'fld_2831905' => '1:1',
      'fld_8469812' => '1:1',
      'fld_4178489' => '1:1',
      'fld_5830226' => '1:1',
      'fld_2573337' => '1:1',
      'fld_5138225' => '1:1',
      'fld_5311410' => '1:1',
      'fld_888711' => '1:1',
      'fld_8990236' => '1:1',
      'fld_6531084' => '1:1',
      'fld_3640507' => '1:1',
      'fld_7619998' => '1:1',
    ),
    'structure' => '12',
  ),
  'fields' => 
  array (
    'fld_7071501' => 
    array (
      'ID' => 'fld_7071501',
      'type' => 'html',
      'label' => 'Hi . Welcome!',
      'slug' => 'hi_welcome',
      'additional' => '',
      'conditions' => 
      array (
        'type' => '',
      ),
      'config' => 
      array (
        'default' => 'Hi . Welcome!',
      ),
    ),
    'fld_7244377' => 
    array (
      'ID' => 'fld_7244377',
      'type' => 'html',
      'label' => 'I\'ll help you make good moments turn into wonderful memories!',
      'slug' => 'ill_help_you_make_good_moments_turn_into_wonderful_memories',
      'additional' => '',
      'conditions' => 
      array (
        'type' => '',
      ),
      'config' => 
      array (
        'default' => 'I\'ll help you make good moments turn into wonderful memories!',
      ),
    ),
    'fld_3041482' => 
    array (
      'ID' => 'fld_3041482',
      'type' => 'dropdown',
      'label' => 'What can we help you with?',
      'slug' => 'what_can_we_help_you_with',
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
          'opt1829868' => 
          array (
            'calc_value' => 'Birthday',
            'value' => 'Birthday',
            'label' => 'Birthday',
          ),
          'opt1584689' => 
          array (
            'calc_value' => 'Anniversary',
            'value' => 'Anniversary',
            'label' => 'Anniversary',
          ),
          'opt1781702' => 
          array (
            'calc_value' => 'Wedding',
            'value' => 'Wedding',
            'label' => 'Wedding',
          ),
          'opt1209382' => 
          array (
            'calc_value' => 'Something Else',
            'value' => 'Something Else',
            'label' => 'Something Else',
          ),
        ),
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_9003210' => 
    array (
      'ID' => 'fld_9003210',
      'type' => 'date_picker',
      'label' => 'Birthday is that one day out of 365. Let\'s make it great, together! When is it?',
      'slug' => 'birthday_is_that_one_day_out_of_365_lets_make_it_great_together_when_is_it',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_6321431296793084',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_5030920' => 
    array (
      'ID' => 'fld_5030920',
      'type' => 'text',
      'label' => 'Whose birthday is it?',
      'slug' => 'whose_birthday_is_it',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_6321431296793084',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_1440867' => 
    array (
      'ID' => 'fld_1440867',
      'type' => 'html',
      'label' => 'It\'s about your special one & the ever-growing love! Let\'s make it a beautiful occasion worth remembering!',
      'slug' => 'its_about_your_special_one_amp_the_ever_growing_love_lets_make_it_a_beautiful_occasion_worth_remembering',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_1147639278306432',
      ),
      'config' => 
      array (
        'default' => 'It\'s about your special one &amp; the ever-growing love!
Let\'s make it a beautiful occasion worth remembering!',
      ),
    ),
    'fld_3099161' => 
    array (
      'ID' => 'fld_3099161',
      'type' => 'date_picker',
      'label' => 'When is the Anniversary?',
      'slug' => 'when_is_the_anniversary',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_1147639278306432',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_5902030' => 
    array (
      'ID' => 'fld_5902030',
      'type' => 'text',
      'label' => 'Whose anniversary is it?',
      'slug' => 'whose_anniversary_is_it',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_1147639278306432',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_4034526' => 
    array (
      'ID' => 'fld_4034526',
      'type' => 'html',
      'label' => 'Musings in the background already! THAT ONE DAY OF YOUR LIFE You dream it, We make it',
      'slug' => 'musings_in_the_background_already_that_one_day_of_your_life_you_dream_it_we_make_it',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_7871928342477394',
      ),
      'config' => 
      array (
        'default' => 'Musings in the background already!
THAT ONE DAY OF YOUR LIFE
You dream it, We make it',
      ),
    ),
    'fld_43940' => 
    array (
      'ID' => 'fld_43940',
      'type' => 'date_picker',
      'label' => 'So, when is the big day?',
      'slug' => 'so_when_is_the_big_day',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_7871928342477394',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_1235908' => 
    array (
      'ID' => 'fld_1235908',
      'type' => 'dropdown',
      'label' => 'Get Ready to Play & Be the Best Team Which One Are You?',
      'slug' => 'get_ready_to_play_be_the_best_team_which_one_are_you',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_7871928342477394',
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
          'opt1279636' => 
          array (
            'calc_value' => 'Team Groom',
            'value' => 'Team Groom',
            'label' => 'Team Groom',
          ),
          'opt1931332' => 
          array (
            'calc_value' => 'Team Bride',
            'value' => 'Team Bride',
            'label' => 'Team Bride',
          ),
        ),
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_3792513' => 
    array (
      'ID' => 'fld_3792513',
      'type' => 'html',
      'label' => 'Success parties, personal gatherings & celebrations of new family & business members We help you add to all occasions.',
      'slug' => 'success_parties_personal_gatherings_celebrations_of_new_family_business_members_we_help_you_add_to_all_occasions',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_7800407788860220',
      ),
      'config' => 
      array (
        'default' => 'Success parties, personal gatherings &
celebrations of new family & business members
We help you add to all occasions.',
      ),
    ),
    'fld_6820487' => 
    array (
      'ID' => 'fld_6820487',
      'type' => 'text',
      'label' => 'Please explain your requirement in detail.',
      'slug' => 'please_explain_your_requirement_in_detail',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_7800407788860220',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_4981789' => 
    array (
      'ID' => 'fld_4981789',
      'type' => 'html',
      'label' => 'Just a few more questions to help us get connected with you.',
      'slug' => 'just_a_few_more_questions_to_help_us_get_connected_with_you',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_7800407788860220',
      ),
      'config' => 
      array (
        'default' => 'Just a few more questions to help us get connected with you.',
      ),
    ),
    'fld_8498735' => 
    array (
      'ID' => 'fld_8498735',
      'type' => 'text',
      'label' => 'What is your name?',
      'slug' => 'what_is_your_name',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_7800407788860220',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_4915056' => 
    array (
      'ID' => 'fld_4915056',
      'type' => 'email',
      'label' => 'What is your email ID?',
      'slug' => 'what_is_your_email_id',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_7800407788860220',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_2766734' => 
    array (
      'ID' => 'fld_2766734',
      'type' => 'number',
      'label' => 'Lastly, what is your phone number?',
      'slug' => 'lastly_what_is_your_phone_number',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_7800407788860220',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_3029027' => 
    array (
      'ID' => 'fld_3029027',
      'type' => 'html',
      'label' => 'Thank you for providing us with these details. Our agents will contact you shortly.',
      'slug' => 'thank_you_for_providing_us_with_these_details_our_agents_will_contact_you_shortly',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_7800407788860220',
      ),
      'config' => 
      array (
        'default' => 'Thank you for providing us with these details. Our agents will contact you shortly.',
      ),
    ),
    'fld_9219944' => 
    array (
      'ID' => 'fld_9219944',
      'type' => 'text',
      'label' => 'Please explain your requirement in detail.',
      'slug' => 'please_explain_your_requirement_in_detail_team_grom',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_9936514525772363',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_2991557' => 
    array (
      'ID' => 'fld_2991557',
      'type' => 'html',
      'label' => 'Just a few more questions to help us get connected with you.',
      'slug' => 'just_a_few_more_questions_to_help_us_get_connected_with_you_team_grom',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_9936514525772363',
      ),
      'config' => 
      array (
        'default' => 'Just a few more questions to help us get connected with you.',
      ),
    ),
    'fld_924394' => 
    array (
      'ID' => 'fld_924394',
      'type' => 'text',
      'label' => 'What is your name?',
      'slug' => 'what_is_your_name_team_grom',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_9936514525772363',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_1626670' => 
    array (
      'ID' => 'fld_1626670',
      'type' => 'email',
      'label' => 'What is your email ID?',
      'slug' => 'what_is_your_email_id_team_grom',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_9936514525772363',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_710409' => 
    array (
      'ID' => 'fld_710409',
      'type' => 'number',
      'label' => 'Lastly, what is your phone number?',
      'slug' => 'lastly_what_is_your_phone_number_team_grom',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_9936514525772363',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_5022413' => 
    array (
      'ID' => 'fld_5022413',
      'type' => 'html',
      'label' => 'Thank you for providing us with these details. Our agents will contact you shortly.',
      'slug' => 'thank_you_for_providing_us_with_these_details_our_agents_will_contact_you_shortly_team_grom',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_9936514525772363',
      ),
      'config' => 
      array (
        'default' => 'Thank you for providing us with these details. Our agents will contact you shortly.',
      ),
    ),
    'fld_7218532' => 
    array (
      'ID' => 'fld_7218532',
      'type' => 'html',
      'label' => 'Just a few more questions to help us get connected with you.',
      'slug' => 'just_a_few_more_questions_to_help_us_get_connected_with_you_team_bride',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_6279954492926774',
      ),
      'config' => 
      array (
        'default' => 'Just a few more questions to help us get connected with you.',
      ),
    ),
    'fld_9690252' => 
    array (
      'ID' => 'fld_9690252',
      'type' => 'text',
      'label' => 'What is your name?',
      'slug' => 'what_is_your_name_team_bride',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_6279954492926774',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_2995176' => 
    array (
      'ID' => 'fld_2995176',
      'type' => 'email',
      'label' => 'What is your email ID?',
      'slug' => 'what_is_your_email_id_team_bride',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_6279954492926774',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_6867592' => 
    array (
      'ID' => 'fld_6867592',
      'type' => 'number',
      'label' => 'Lastly, what is your phone number?',
      'slug' => 'lastly_what_is_your_phone_number_team_bride',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_6279954492926774',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_5472144' => 
    array (
      'ID' => 'fld_5472144',
      'type' => 'html',
      'label' => 'Thank you for providing us with these details. Our agents will contact you shortly.',
      'slug' => 'thank_you_for_providing_us_with_these_details_our_agents_will_contact_you_shortly_team_bride',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_6279954492926774',
      ),
      'config' => 
      array (
        'default' => 'Thank you for providing us with these details. Our agents will contact you shortly.',
      ),
    ),
    'fld_2831905' => 
    array (
      'ID' => 'fld_2831905',
      'type' => 'text',
      'label' => 'Describe all your requirements in detail. The more you write, the better we can understand.',
      'slug' => 'describe_all_your_requirements_in_detail_the_more_you_write_the_better_we_can_understand_birthdays',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_6321431296793084',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_8469812' => 
    array (
      'ID' => 'fld_8469812',
      'type' => 'html',
      'label' => 'Just a few more questions to help us get connected with you.',
      'slug' => 'just_a_few_more_questions_to_help_us_get_connected_with_you_birthdays',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_6321431296793084',
      ),
      'config' => 
      array (
        'default' => 'Just a few more questions to help us get connected with you.',
      ),
    ),
    'fld_4178489' => 
    array (
      'ID' => 'fld_4178489',
      'type' => 'text',
      'label' => 'What is your name?',
      'slug' => 'what_is_your_name_birthdays',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_6321431296793084',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_5830226' => 
    array (
      'ID' => 'fld_5830226',
      'type' => 'email',
      'label' => 'What is your email ID?',
      'slug' => 'what_is_your_email_id_birthdays',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_6321431296793084',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_2573337' => 
    array (
      'ID' => 'fld_2573337',
      'type' => 'number',
      'label' => 'Lastly, what is your phone number?',
      'slug' => 'lastly_what_is_your_phone_number_birthdays',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_6321431296793084',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_5138225' => 
    array (
      'ID' => 'fld_5138225',
      'type' => 'html',
      'label' => 'Thank you for providing us with these details. Our agents will contact you shortly.',
      'slug' => 'thank_you_for_providing_us_with_these_details_our_agents_will_contact_you_shortly_birthdays',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_6321431296793084',
      ),
      'config' => 
      array (
        'default' => 'Thank you for providing us with these details. Our agents will contact you shortly.',
      ),
    ),
    'fld_5311410' => 
    array (
      'ID' => 'fld_5311410',
      'type' => 'text',
      'label' => 'Describe all your requirements in detail. The more you write, the better we can understand.',
      'slug' => 'describe_all_your_requirements_in_detail_the_more_you_write_the_better_we_can_understand_anniversarys',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_1147639278306432',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_888711' => 
    array (
      'ID' => 'fld_888711',
      'type' => 'html',
      'label' => 'Just a few more questions to help us get connected with you.',
      'slug' => 'just_a_few_more_questions_to_help_us_get_connected_with_you_anniversarys',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_1147639278306432',
      ),
      'config' => 
      array (
        'default' => 'Just a few more questions to help us get connected with you.',
      ),
    ),
    'fld_8990236' => 
    array (
      'ID' => 'fld_8990236',
      'type' => 'text',
      'label' => 'What is your name?',
      'slug' => 'what_is_your_name_anniversarys',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_1147639278306432',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_6531084' => 
    array (
      'ID' => 'fld_6531084',
      'type' => 'email',
      'label' => 'What is your email ID?',
      'slug' => 'what_is_your_email_id_anniversarys',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_1147639278306432',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_3640507' => 
    array (
      'ID' => 'fld_3640507',
      'type' => 'number',
      'label' => 'Lastly, what is your phone number?',
      'slug' => 'lastly_what_is_your_phone_number_anniversarys',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_1147639278306432',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_7619998' => 
    array (
      'ID' => 'fld_7619998',
      'type' => 'html',
      'label' => 'Thank you for providing us with these details. Our agents will contact you shortly.',
      'slug' => 'thank_you_for_providing_us_with_these_details_our_agents_will_contact_you_shortly_anniversarys',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_1147639278306432',
      ),
      'config' => 
      array (
        'default' => 'Thank you for providing us with these details. Our agents will contact you shortly.',
      ),
    ),
  ),
  'mailer' => 
  array (
    'on_insert' => 1,
    'sender_name' => 'Chatbot Forms Notification',
    'sender_email' => '',
    'recipients' => '',
    'email_subject' => 'Event Management',
  ),
  'conditional_groups' => 
  array (
    'conditions' => 
    array (
      'con_6321431296793084' => 
      array (
        'id' => 'con_6321431296793084',
        'name' => 'Birthday',
        'type' => 'show',
        'fields' => 
        array (
          'cl6712801589650983' => 'fld_3041482',
        ),
        'group' => 
        array (
          'rw4772143579378571' => 
          array (
            'cl6712801589650983' => 
            array (
              'parent' => 'rw4772143579378571',
              'field' => 'fld_3041482',
              'compare' => 'is',
              'value' => 'opt1829868',
            ),
          ),
        ),
      ),
      'con_1147639278306432' => 
      array (
        'id' => 'con_1147639278306432',
        'name' => 'Anniversary',
        'type' => 'show',
        'fields' => 
        array (
          'cl420861944170268' => 'fld_3041482',
        ),
        'group' => 
        array (
          'rw6496767861599772' => 
          array (
            'cl420861944170268' => 
            array (
              'parent' => 'rw6496767861599772',
              'field' => 'fld_3041482',
              'compare' => 'is',
              'value' => 'opt1584689',
            ),
          ),
        ),
      ),
      'con_7871928342477394' => 
      array (
        'id' => 'con_7871928342477394',
        'name' => 'Wedding',
        'type' => 'show',
        'fields' => 
        array (
          'cl9627742247896802' => 'fld_3041482',
        ),
        'group' => 
        array (
          'rw1213103494415311' => 
          array (
            'cl9627742247896802' => 
            array (
              'parent' => 'rw1213103494415311',
              'field' => 'fld_3041482',
              'compare' => 'is',
              'value' => 'opt1781702',
            ),
          ),
        ),
      ),
      'con_7800407788860220' => 
      array (
        'id' => 'con_7800407788860220',
        'name' => 'Something Else',
        'type' => 'show',
        'fields' => 
        array (
          'cl897014009813596' => 'fld_3041482',
        ),
        'group' => 
        array (
          'rw5031412096301917' => 
          array (
            'cl897014009813596' => 
            array (
              'parent' => 'rw5031412096301917',
              'field' => 'fld_3041482',
              'compare' => 'is',
              'value' => 'opt1209382',
            ),
          ),
        ),
      ),
      'con_3964642047650214' => 
      array (
        'id' => 'con_3964642047650214',
        'name' => 'Less than $50 -- Birthday',
        'type' => '',
      ),
      'con_169603068539366' => 
      array (
        'id' => 'con_169603068539366',
        'name' => '$50-$100 -- Birthday',
        'type' => '',
      ),
      'con_2658557839090886' => 
      array (
        'id' => 'con_2658557839090886',
        'name' => 'More than $100 -- Birthday',
        'type' => '',
      ),
      'con_7837397894332193' => 
      array (
        'id' => 'con_7837397894332193',
        'name' => 'Less than $50 -- Anniversary',
        'type' => '',
      ),
      'con_8076242918042504' => 
      array (
        'id' => 'con_8076242918042504',
        'name' => '$50-$100 -- Anniversary',
        'type' => '',
      ),
      'con_767738068139044' => 
      array (
        'id' => 'con_767738068139044',
        'name' => 'More than $100 -- Anniversary',
        'type' => '',
      ),
      'con_9936514525772363' => 
      array (
        'id' => 'con_9936514525772363',
        'name' => 'Team Groom',
        'type' => 'show',
        'fields' => 
        array (
          'cl592760217594078' => 'fld_1235908',
        ),
        'group' => 
        array (
          'rw2096287166250477' => 
          array (
            'cl592760217594078' => 
            array (
              'parent' => 'rw2096287166250477',
              'field' => 'fld_1235908',
              'compare' => 'is',
              'value' => 'opt1279636',
            ),
          ),
        ),
      ),
      'con_6279954492926774' => 
      array (
        'id' => 'con_6279954492926774',
        'name' => 'Team Bride',
        'type' => 'show',
        'fields' => 
        array (
          'cl109357351392894' => 'fld_1235908',
        ),
        'group' => 
        array (
          'rw531819671100203' => 
          array (
            'cl109357351392894' => 
            array (
              'parent' => 'rw531819671100203',
              'field' => 'fld_1235908',
              'compare' => 'is',
              'value' => 'opt1931332',
            ),
          ),
        ),
      ),
    ),
  ),
  'privacy_exporter_enabled' => false,
  'version' => '1.0.0',
);