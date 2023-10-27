<?php 

return array (
  '_last_updated' => 'Tue, 18 Feb 2020 12:05:33 +0000',
  'ID' => 'CF5e43e8c1a1fb2',
  'wfb_version' => '1.0.0',
  'name' => 'HR Recruiter',
  'command' => 'hr recruiter',
  'layout_grid' => 
  array (
    'fields' => 
    array (
      'fld_4905593' => '1:1',
      'fld_881038' => '1:1',
      'fld_7203690' => '1:1',
      'fld_6489847' => '1:1',
      'fld_7104622' => '1:1',
      'fld_8885958' => '1:1',
      'fld_9506823' => '1:1',
      'fld_2414783' => '1:1',
      'fld_7364694' => '1:1',
      'fld_4203257' => '1:1',
      'fld_7166973' => '1:1',
      'fld_8124992' => '1:1',
      'fld_2826749' => '1:1',
      'fld_6255808' => '1:1',
      'fld_477831' => '1:1',
      'fld_8822157' => '1:1',
      'fld_8190087' => '1:1',
      'fld_3286221' => '1:1',
      'fld_7395147' => '1:1',
      'fld_1547268' => '1:1',
      'fld_157279' => '1:1',
      'fld_7632219' => '1:1',
      'fld_2912224' => '1:1',
      'fld_9359269' => '1:1',
      'fld_6549663' => '1:1',
      'fld_2472634' => '1:1',
      'fld_6955589' => '1:1',
      'fld_7020811' => '1:1',
      'fld_3165778' => '1:1',
      'fld_5531939' => '1:1',
      'fld_9397454' => '1:1',
      'fld_927281' => '1:1',
      'fld_9878938' => '1:1',
      'fld_7217806' => '1:1',
      'fld_7087212' => '1:1',
      'fld_1764249' => '1:1',
      'fld_6927853' => '1:1',
      'fld_6935785' => '1:1',
      'fld_2980286' => '1:1',
      'fld_2571757' => '1:1',
      'fld_9474596' => '1:1',
      'fld_9718300' => '1:1',
      'fld_8520338' => '1:1',
      'fld_1100253' => '1:1',
      'fld_5701003' => '1:1',
      'fld_7557333' => '1:1',
      'fld_6250911' => '1:1',
      'fld_9127054' => '1:1',
      'fld_2791217' => '1:1',
      'fld_870868' => '1:1',
      'fld_806764' => '1:1',
      'fld_4278681' => '1:1',
      'fld_8071144' => '1:1',
      'fld_5531520' => '1:1',
      'fld_5377879' => '1:1',
      'fld_3735821' => '1:1',
      'fld_6424611' => '1:1',
      'fld_3317494' => '1:1',
      'fld_4261782' => '1:1',
      'fld_2717249' => '1:1',
      'fld_6662545' => '1:1',
      'fld_5354748' => '1:1',
      'fld_1003346' => '1:1',
      'fld_4370318' => '1:1',
      'fld_2277851' => '1:1',
      'fld_2175171' => '1:1',
      'fld_4535274' => '1:1',
      'fld_388425' => '1:1',
      'fld_4246426' => '1:1',
      'fld_5409926' => '1:1',
      'fld_8402789' => '1:1',
      'fld_2110227' => '1:1',
      'fld_1179373' => '1:1',
      'fld_6259942' => '1:1',
      'fld_3797110' => '1:1',
      'fld_8640105' => '1:1',
      'fld_9070678' => '1:1',
      'fld_8958765' => '1:1',
      'fld_7294767' => '1:1',
      'fld_5002440' => '1:1',
    ),
    'structure' => '12',
  ),
  'fields' => 
  array (
    'fld_4905593' => 
    array (
      'ID' => 'fld_4905593',
      'type' => 'html',
      'label' => 'Hi, Welcome!',
      'slug' => 'hi_welcome',
      'additional' => '',
      'conditions' => 
      array (
        'type' => '',
      ),
      'config' => 
      array (
        'default' => 'Hi, Welcome!',
      ),
    ),
    'fld_881038' => 
    array (
      'ID' => 'fld_881038',
      'type' => 'html',
      'label' => 'I\'m here, your assistant to find the best job for you!',
      'slug' => 'im_here_your_assistant_to_find_the_best_job_for_you',
      'additional' => '',
      'conditions' => 
      array (
        'type' => '',
      ),
      'config' => 
      array (
        'default' => 'I\'m here, your assistant to find the best job for you!',
      ),
    ),
    'fld_7203690' => 
    array (
      'ID' => 'fld_7203690',
      'type' => 'html',
      'label' => 'We are a rapidly growing company and are searching',
      'slug' => 'we_are_a_rapidly_growing_company_and_are_searching',
      'additional' => '',
      'conditions' => 
      array (
        'type' => '',
      ),
      'config' => 
      array (
        'default' => 'We are a rapidly growing company and are searching for awesome talent.  Explore our job postings and find a role that suits you.',
      ),
    ),
    'fld_6489847' => 
    array (
      'ID' => 'fld_6489847',
      'type' => 'dropdown',
      'label' => 'Please choose an option to get started',
      'slug' => 'please_choose_an_option_to_get_started',
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
          'opt1900099' => 
          array (
            'calc_value' => 'Browse Jobs',
            'value' => 'Browse Jobs',
            'label' => 'Browse Jobs',
          ),
          'opt1589859' => 
          array (
            'calc_value' => 'About',
            'value' => 'About',
            'label' => 'About',
          ),
          'opt1334028' => 
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
    'fld_7104622' => 
    array (
      'ID' => 'fld_7104622',
      'type' => 'html',
      'label' => 'Let me show all the current job openings for you to choose from.',
      'slug' => 'let_me_show_all_the_current_job_openings_for_you_to_choose_from',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_642928492308739',
      ),
      'config' => 
      array (
        'default' => 'Let me show all the current job openings for you to choose from.',
      ),
    ),
    'fld_8885958' => 
    array (
      'ID' => 'fld_8885958',
      'type' => 'dropdown',
      'label' => 'Select any one to get more information.',
      'slug' => 'select_any_one_to_get_more_information',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_642928492308739',
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
          'opt1462220' => 
          array (
            'calc_value' => 'Business Development',
            'value' => 'Business Development',
            'label' => 'Business Development',
          ),
          'opt2089776' => 
          array (
            'calc_value' => 'Senior Developer',
            'value' => 'Senior Developer',
            'label' => 'Senior Developer',
          ),
          'opt1886017' => 
          array (
            'calc_value' => 'Project Manager',
            'value' => 'Project Manager',
            'label' => 'Project Manager',
          ),
          'opt1981247' => 
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
    'fld_9506823' => 
    array (
      'ID' => 'fld_9506823',
      'type' => 'dropdown',
      'label' => 'Excellent choice! Select an option below to know more about the role.',
      'slug' => 'excellent_choice_select_an_option_below_to_know_more_about_the_role',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_3944961049020491',
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
          'opt1590125' => 
          array (
            'calc_value' => 'Requirements',
            'value' => 'Requirements',
            'label' => 'Requirements',
          ),
          'opt1105434' => 
          array (
            'calc_value' => 'Skillset',
            'value' => 'Skillset',
            'label' => 'Skillset',
          ),
          'opt1844110' => 
          array (
            'calc_value' => 'Qualifications',
            'value' => 'Qualifications',
            'label' => 'Qualifications',
          ),
        ),
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_2414783' => 
    array (
      'ID' => 'fld_2414783',
      'type' => 'html',
      'label' => 'ROLE REQUIREMENTS:',
      'slug' => 'role_requirements',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_1908476686831589',
      ),
      'config' => 
      array (
        'default' => 'ROLE REQUIREMENTS:

Experience: Fresher / intern

Role: Business development

Positions: 4

Location: Mumbai

Type: Full time internship',
      ),
    ),
    'fld_7364694' => 
    array (
      'ID' => 'fld_7364694',
      'type' => 'dropdown',
      'label' => 'Would you like to apply for this job?',
      'slug' => 'would_you_like_to_apply_for_this_job',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_1908476686831589',
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
          'opt1678559' => 
          array (
            'calc_value' => 'Yes, contact me!',
            'value' => 'Yes, contact me!',
            'label' => 'Yes, contact me!',
          ),
          'opt1924943' => 
          array (
            'calc_value' => 'Go back',
            'value' => 'Go back',
            'label' => 'Go back',
          ),
        ),
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_4203257' => 
    array (
      'ID' => 'fld_4203257',
      'type' => 'html',
      'label' => 'General familiarity with MS Word, email, google docs, excel, powerpoint for presentations',
      'slug' => 'general_familiarity_with_ms_word_email_google_docs_excel_powerpoint_for_presentations',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_9582398531122272',
      ),
      'config' => 
      array (
        'default' => 'SKILLSET REQUIRED

* General familiarity with MS Word, email, google docs, excel, powerpoint for presentations
* General business understanding and various facets in which business decisions are taken
* Excellent interpersonal and communication (both verbal and written) skills
* Analytical skills for market research, competitive analysis and crafting campaigns
* Persistence and diligence behaviour to sell and close out contracts
* Bonus Points for experience working with customers and handling customer inquiries
* People looking to shift from BPO and call center jobs may apply too',
      ),
    ),
    'fld_7166973' => 
    array (
      'ID' => 'fld_7166973',
      'type' => 'dropdown',
      'label' => 'Would you like to apply to this job?',
      'slug' => 'would_you_like_to_apply_to_this_jobs',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_9582398531122272',
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
          'opt1642730' => 
          array (
            'calc_value' => 'Yes, contact me!',
            'value' => 'Yes, contact me!',
            'label' => 'Yes, contact me!',
          ),
          'opt1572255' => 
          array (
            'calc_value' => 'Go back',
            'value' => 'Go back',
            'label' => 'Go back',
          ),
        ),
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_8124992' => 
    array (
      'ID' => 'fld_8124992',
      'type' => 'html',
      'label' => 'This is a generic write up that talks about the company and the products/services it provides.',
      'slug' => 'this_is_a_generic_write_up_that_talks_about_the_company_and_the_productsservices_it_provides',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_2525269189749985',
      ),
      'config' => 
      array (
        'default' => 'This is a generic write up that talks about the company and the products/services it provides.',
      ),
    ),
    'fld_2826749' => 
    array (
      'ID' => 'fld_2826749',
      'type' => 'dropdown',
      'label' => 'There is a long history to the making of the company and its product has been successful with a wide variety of customers.',
      'slug' => 'there_is_a_long_history_to_the_making_of_the_company_and_its_product_has_been_successful_with_a_wide_variety_of_customers',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_2525269189749985',
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
          'opt1435064' => 
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
    'fld_6255808' => 
    array (
      'ID' => 'fld_6255808',
      'type' => 'html',
      'label' => 'No problem! Help me with a few details about you and I will have someone from my team contact you right away..',
      'slug' => 'no_problem_help_me_with_a_few_details_about_you_and_i_will_have_someone_from_my_team_contact_you_right_away',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_306676846118809',
      ),
      'config' => 
      array (
        'default' => 'No problem! Help me with a few details about you and I will have someone from my team contact you right away..',
      ),
    ),
    'fld_477831' => 
    array (
      'ID' => 'fld_477831',
      'type' => 'text',
      'label' => 'What is your Name?',
      'slug' => 'what_is_your_name',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_306676846118809',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_8822157' => 
    array (
      'ID' => 'fld_8822157',
      'type' => 'email',
      'label' => 'What is your Email?',
      'slug' => 'what_is_your_email',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_306676846118809',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_8190087' => 
    array (
      'ID' => 'fld_8190087',
      'type' => 'number',
      'label' => 'What is your Phone Number?',
      'slug' => 'what_is_your_phone_number',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_306676846118809',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_3286221' => 
    array (
      'ID' => 'fld_3286221',
      'type' => 'html',
      'label' => 'Thanks for providing all the details. Our team will get in touch with you shortly.',
      'slug' => 'thanks_for_providing_all_the_details_our_team_will_get_in_touch_with_you_shortly_',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_306676846118809',
      ),
      'config' => 
      array (
        'default' => 'Thanks for providing all the details. Our team will get in touch with you shortly. 

Have a good day ahead!',
      ),
    ),
    'fld_7395147' => 
    array (
      'ID' => 'fld_7395147',
      'type' => 'text',
      'label' => 'No problem! I\'m here to answer any of your questions? Ask away..',
      'slug' => 'no_problem_im_here_to_answer_any_of_your_questions_ask_away',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_9890612756326398',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_1547268' => 
    array (
      'ID' => 'fld_1547268',
      'type' => 'html',
      'label' => 'Our team will get in touch with you shortly.',
      'slug' => 'our_team_will_get_in_touch_with_you_shortly_',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_9890612756326398',
      ),
      'config' => 
      array (
        'default' => 'Our team will get in touch with you shortly. 

Have a good day ahead!',
      ),
    ),
    'fld_157279' => 
    array (
      'ID' => 'fld_157279',
      'type' => 'html',
      'label' => 'QUALIFICATION * Bachelor’s degree in Business or Technology',
      'slug' => 'qualification_bachelors_degree_in_business_or_technology',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_213804711715810',
      ),
      'config' => 
      array (
        'default' => 'QUALIFICATION

* Bachelor’s degree in Business or Technology
* Any certificate program in Digital marketing and / or technical skills is a plus
* Prior experience in Customer handling roles or working in an international call center is a plus',
      ),
    ),
    'fld_7632219' => 
    array (
      'ID' => 'fld_7632219',
      'type' => 'dropdown',
      'label' => 'Excellent choice! Select an option below to know more about the role.',
      'slug' => 'excellent_choice_select_an_option_below_to_know_more_about_the_roleprojectmanager',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_2220240134901797',
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
          'opt1498550' => 
          array (
            'calc_value' => 'Requirements',
            'value' => 'Requirements',
            'label' => 'Requirements',
          ),
          'opt1257240' => 
          array (
            'calc_value' => 'Skillset',
            'value' => 'Skillset',
            'label' => 'Skillset',
          ),
          'opt1783312' => 
          array (
            'calc_value' => 'Qualifications',
            'value' => 'Qualifications',
            'label' => 'Qualifications',
          ),
        ),
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_2912224' => 
    array (
      'ID' => 'fld_2912224',
      'type' => 'html',
      'label' => 'ROLE REQUIREMENTS : Experience: 4 – 6 Years Position : Java development Positions: Multiple Location: Bangalore Type: Full time',
      'slug' => 'role_requirements_experience_4_6_years_position_java_development_positions_multiple_location_bangalore_type_full_time',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_8797403167019325',
      ),
      'config' => 
      array (
        'default' => 'ROLE REQUIREMENTS :

Experience: 4 – 6 Years

Position : Java development

Positions: Multiple

Location: Bangalore

Type: Full time',
      ),
    ),
    'fld_9359269' => 
    array (
      'ID' => 'fld_9359269',
      'type' => 'html',
      'label' => 'skillset_project_manager_info',
      'slug' => 'skillset_project_manager_info',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_9518701135220406',
      ),
      'config' => 
      array (
        'default' => 'TECHNICAL SKILLSET REQUIRED

* 5+ years of professional software development experience
* 4+ years of object-oriented Java / J2EE development
* Full SDLC experience (requirements gathering, architecture, development, QA, etc…)
* Experience with Spring (MVC, IOP/DI, REST, Security) & Hibernate/Spring
* Experience with SOAP / REST web services
* Knowledge of SQL
* Knowledge of No SQL concepts, understanding of Solr, Redis and Mongo DB is desirable
* Understanding concepts of CDN & Content Management
* Must have worked on any one messaging solutions
* Bonus Points for micro service design and development experience
* Bonus points for any mobile development experience
* Used Agile methodology
* Experience leading or working with cross geography teams
* Bonus Points for experience working on Unix, shell scripting; Build Systems
* Experience in performance optimization is an added advantage',
      ),
    ),
    'fld_6549663' => 
    array (
      'ID' => 'fld_6549663',
      'type' => 'html',
      'label' => 'project_manager_QUALIFICATION',
      'slug' => 'project_manager_qualificationss',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_8744591252837930',
      ),
      'config' => 
      array (
        'default' => 'QUALIFICATION:
* A Bachelor’s degree in Computer Science (or equivalent experience)
* M-Tech or advanced degree a plus
* Hackathon participation and accolades are a plus',
      ),
    ),
    'fld_2472634' => 
    array (
      'ID' => 'fld_2472634',
      'type' => 'dropdown',
      'label' => 'Excellent choice! Select an option below to know more about the role.',
      'slug' => 'excellent_choice_select_an_option_below_to_know_more_about_the_role_project_manager',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_2490231045635146',
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
          'opt1612216' => 
          array (
            'calc_value' => 'Requirements',
            'value' => 'Requirements',
            'label' => 'Requirements',
          ),
          'opt1851416' => 
          array (
            'calc_value' => 'Skillset',
            'value' => 'Skillset',
            'label' => 'Skillset',
          ),
          'opt1176714' => 
          array (
            'calc_value' => 'Qualifications',
            'value' => 'Qualifications',
            'label' => 'Qualifications',
          ),
        ),
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_6955589' => 
    array (
      'ID' => 'fld_6955589',
      'type' => 'html',
      'label' => 'ROLE REQUIREMENTS : Experience: 3-4 Years in Project Management with minimum 1 yr experience playing the Scrum Master Position : Agile Scrum Master/ Project Manager Location: Bangalore Type: Full time',
      'slug' => 'role_requirements_experience_3_4_years_in_project_management_with_minimum_1_yr_experience_playing_the_scrum_master_position_agile_scrum_master_project_manager_location_bangalore_type_full_timeprojectsss',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_422514329718167',
      ),
      'config' => 
      array (
        'default' => 'ROLE REQUIREMENTS :

Experience: 3-4 Years in Project Management with minimum 1 yr experience playing the Scrum Master
Position : Agile Scrum Master/ Project Manager
Location: Bangalore
Type: Full time',
      ),
    ),
    'fld_7020811' => 
    array (
      'ID' => 'fld_7020811',
      'type' => 'html',
      'label' => 'TECHNICAL SKILLSET REQUIRED_project_manager',
      'slug' => 'technical_skillset_required_project_manager',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_3843184014338275',
      ),
      'config' => 
      array (
        'default' => 'TECHNICAL SKILLSET REQUIRED
 Degree in Computer Science or related field
 3-4 years of experience in managing IT Projects in an Agile environment
 Advanced knowledge of software development lifecycle
 Strong knowledge of Scrum theory, rules and practices
 Certified Scrum Master is a big plus
 Significant experience in Project Management implementation using agile methodologies
(Iterative, Scrum, Kanban)
 Experience in driving Projects in rapidly changing fast paced agile software development
environments.
 Familiar with Sprint Planning, User Stories, Release Planning, Scrum Ceremonies
Managing projects, Facilitating Requirements Gathering sessions
 Knowledge and/or experience with widely successful Agile techniques: User Stories, ATDD,
TDD, Continuous Integration, Continuous Testing, Pairing, Automated Testing, Agile Games
 Able to manage partners through clear understanding and ability to apply the concepts of risk
management, conflict management, stakeholder management and change management
 Proven ability to lead, monitor and motivate distributed engineering teams and get the most
out of self-organizing them
 Assessing the Scrum Maturity of the team and organization and coaching the team to higher
levels of maturity
 Hands Experience in working on Project management tools like (Jira, Confluence, Trello)
 Professional attitude, with strong attention to detail. Dedicated and pragmatic with regards
to problem solving
 Excellent communication skills both written and verbal  and demonstrates ability to work
independently communicate/understand highly skilled engineering teams with confidence
 Experience in creating various reports and dashboards for stakeholders',
      ),
    ),
    'fld_3165778' => 
    array (
      'ID' => 'fld_3165778',
      'type' => 'html',
      'label' => 'QUALIFICATION Project managers',
      'slug' => 'qualification_project_managers',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_1455128383838501',
      ),
      'config' => 
      array (
        'default' => 'QUALIFICATION:
 A Bachelor’s degree in Computer Science or related field
 3+ years of hands on experience in project/program management out of which 1 yr in Agile
Scrum role
 Solid understanding of Project management principles along with knowledge in agile
preferred
 Formal Training or any certification in Project Management & Scrum practices',
      ),
    ),
    'fld_5531939' => 
    array (
      'ID' => 'fld_5531939',
      'type' => 'dropdown',
      'label' => 'Didn\'t find anything suitable?',
      'slug' => 'didnt_find_anything_suitablesdf',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_9944608346294313',
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
          'opt1532093' => 
          array (
            'calc_value' => 'Contact Us',
            'value' => 'Contact Us',
            'label' => 'Contact Us',
          ),
          'opt1751023' => 
          array (
            'calc_value' => 'About Us',
            'value' => 'About Us',
            'label' => 'About Us',
          ),
        ),
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_9397454' => 
    array (
      'ID' => 'fld_9397454',
      'type' => 'html',
      'label' => 'This is a generic write up that talks about the company and the products/services it provides.',
      'slug' => 'this_is_a_generic_write_up_that_talks_about_the_company_and_the_productsservices_it_providesaboutuss',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_954472451658166',
      ),
      'config' => 
      array (
        'default' => 'This is a generic write up that talks about the company and the products/services it provides.',
      ),
    ),
    'fld_927281' => 
    array (
      'ID' => 'fld_927281',
      'type' => 'html',
      'label' => 'There is a long history to the making of the company and its product has been successful with a wide variety of customers.',
      'slug' => 'there_is_a_long_history_to_the_making_of_the_company_and_its_product_has_been_successful_with_a_wide_variety_of_customerscontact_usseds',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_954472451658166',
      ),
      'config' => 
      array (
        'default' => 'There is a long history to the making of the company and its product has been successful with a wide variety of customers.',
      ),
    ),
    'fld_9878938' => 
    array (
      'ID' => 'fld_9878938',
      'type' => 'html',
      'label' => 'No problem! Help me with a few details about you and I will have someone from my team contact you right away..',
      'slug' => 'no_problem_help_me_with_a_few_details_about_you_and_i_will_have_someone_from_my_team_contact_you_right_away_contact_uss',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_3072390197164155',
      ),
      'config' => 
      array (
        'default' => 'No problem! Help me with a few details about you and I will have someone from my team contact you right away..',
      ),
    ),
    'fld_7217806' => 
    array (
      'ID' => 'fld_7217806',
      'type' => 'text',
      'label' => 'What is your Name?',
      'slug' => 'what_is_your_namesuitable_anything',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_3072390197164155',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_7087212' => 
    array (
      'ID' => 'fld_7087212',
      'type' => 'email',
      'label' => 'What is your Email ID?',
      'slug' => 'what_is_your_email_id_infosses',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_3072390197164155',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_1764249' => 
    array (
      'ID' => 'fld_1764249',
      'type' => 'number',
      'label' => 'What is your phone number?',
      'slug' => 'what_is_your_phone_number_suitable_contact_us',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_3072390197164155',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_6927853' => 
    array (
      'ID' => 'fld_6927853',
      'type' => 'html',
      'label' => 'Thanks for providing all the details. Our team will get in touch with you shortly. Have a good day ahead!',
      'slug' => 'thanks_for_providing_all_the_details_our_team_will_get_in_touch_with_you_shortly_have_a_good_day_ahead_suitable_contact_us',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_3072390197164155',
      ),
      'config' => 
      array (
        'default' => 'Thanks for providing all the details. Our team will get in touch with you shortly. 
<br>
Have a good day ahead!',
      ),
    ),
    'fld_6935785' => 
    array (
      'ID' => 'fld_6935785',
      'type' => 'dropdown',
      'label' => 'Would you like to apply to this job?',
      'slug' => 'would_you_like_to_apply_to_this_job_qualifications_first',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_213804711715810',
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
          'opt1642730' => 
          array (
            'calc_value' => 'Yes, contact me!',
            'value' => 'Yes, contact me!',
            'label' => 'Yes, contact me!',
          ),
          'opt1572255' => 
          array (
            'calc_value' => 'Go back',
            'value' => 'Go back',
            'label' => 'Go back',
          ),
        ),
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_2980286' => 
    array (
      'ID' => 'fld_2980286',
      'type' => 'dropdown',
      'label' => 'Would you like to apply to this job?',
      'slug' => 'would_you_like_to_apply_to_this_job_senior_developer',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_8797403167019325',
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
          'opt1642730' => 
          array (
            'calc_value' => 'Yes, contact me!',
            'value' => 'Yes, contact me!',
            'label' => 'Yes, contact me!',
          ),
          'opt1572255' => 
          array (
            'calc_value' => 'Go back',
            'value' => 'Go back',
            'label' => 'Go back',
          ),
        ),
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_2571757' => 
    array (
      'ID' => 'fld_2571757',
      'type' => 'dropdown',
      'label' => 'Would you like to apply to this job?',
      'slug' => 'would_you_like_to_apply_to_this_job_senior_developer_skillset',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_9518701135220406',
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
          'opt1642730' => 
          array (
            'calc_value' => 'Yes, contact me!',
            'value' => 'Yes, contact me!',
            'label' => 'Yes, contact me!',
          ),
          'opt1572255' => 
          array (
            'calc_value' => 'Go back',
            'value' => 'Go back',
            'label' => 'Go back',
          ),
        ),
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_9474596' => 
    array (
      'ID' => 'fld_9474596',
      'type' => 'dropdown',
      'label' => 'Would you like to apply to this job?',
      'slug' => 'would_you_like_to_apply_to_this_job_senior_developer_qualification',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_8744591252837930',
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
          'opt1642730' => 
          array (
            'calc_value' => 'Yes, contact me!',
            'value' => 'Yes, contact me!',
            'label' => 'Yes, contact me!',
          ),
          'opt1572255' => 
          array (
            'calc_value' => 'Go back',
            'value' => 'Go back',
            'label' => 'Go back',
          ),
        ),
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_9718300' => 
    array (
      'ID' => 'fld_9718300',
      'type' => 'dropdown',
      'label' => 'Would you like to apply to this job?',
      'slug' => 'would_you_like_to_apply_to_this_job_project_manager_requirement',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_422514329718167',
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
          'opt1642730' => 
          array (
            'calc_value' => 'Yes, contact me!',
            'value' => 'Yes, contact me!',
            'label' => 'Yes, contact me!',
          ),
          'opt1572255' => 
          array (
            'calc_value' => 'Go back',
            'value' => 'Go back',
            'label' => 'Go back',
          ),
        ),
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_8520338' => 
    array (
      'ID' => 'fld_8520338',
      'type' => 'dropdown',
      'label' => 'Would you like to apply to this job?',
      'slug' => 'would_you_like_to_apply_to_this_job_project_manager_skillset',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_3843184014338275',
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
          'opt1642730' => 
          array (
            'calc_value' => 'Yes, contact me!',
            'value' => 'Yes, contact me!',
            'label' => 'Yes, contact me!',
          ),
          'opt1572255' => 
          array (
            'calc_value' => 'Go back',
            'value' => 'Go back',
            'label' => 'Go back',
          ),
        ),
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_1100253' => 
    array (
      'ID' => 'fld_1100253',
      'type' => 'dropdown',
      'label' => 'Would you like to apply to this job?',
      'slug' => 'would_you_like_to_apply_to_this_job_project_manager_qualifications',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_1455128383838501',
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
          'opt1642730' => 
          array (
            'calc_value' => 'Yes, contact me!',
            'value' => 'Yes, contact me!',
            'label' => 'Yes, contact me!',
          ),
          'opt1572255' => 
          array (
            'calc_value' => 'Go back',
            'value' => 'Go back',
            'label' => 'Go back',
          ),
        ),
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_5701003' => 
    array (
      'ID' => 'fld_5701003',
      'type' => 'text',
      'label' => 'What is your Name?',
      'slug' => 'what_is_your_name_business_development_requiress',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_7057135516165651',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_7557333' => 
    array (
      'ID' => 'fld_7557333',
      'type' => 'email',
      'label' => 'What is your Email?',
      'slug' => 'what_is_your_email_business_development_requiress',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_7057135516165651',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_6250911' => 
    array (
      'ID' => 'fld_6250911',
      'type' => 'number',
      'label' => 'What is your Phone Number?',
      'slug' => 'what_is_your_phone_number_business_development_requiress',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_7057135516165651',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_9127054' => 
    array (
      'ID' => 'fld_9127054',
      'type' => 'html',
      'label' => 'Thanks for providing all the details. Our team will get in touch with you shortly.',
      'slug' => 'thanks_for_providing_all_the_details_our_team_will_get_in_touch_with_you_shortlybudevreqiremnt',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_7057135516165651',
      ),
      'config' => 
      array (
        'default' => 'Thanks for providing all the details. Our team will get in touch with you shortly. 

Have a good day ahead!',
      ),
    ),
    'fld_2791217' => 
    array (
      'ID' => 'fld_2791217',
      'type' => 'text',
      'label' => 'What is your Name?',
      'slug' => 'what_is_your_name_busi_dev_skillset',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_7595739315604492',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_870868' => 
    array (
      'ID' => 'fld_870868',
      'type' => 'email',
      'label' => 'What is your Email?',
      'slug' => 'what_is_your_emailbusi_dev_skillset',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_7595739315604492',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_806764' => 
    array (
      'ID' => 'fld_806764',
      'type' => 'number',
      'label' => 'What is your Phone Number?',
      'slug' => 'what_is_your_phone_numberbusi_dev_skillset',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_7595739315604492',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_4278681' => 
    array (
      'ID' => 'fld_4278681',
      'type' => 'html',
      'label' => 'Thanks for providing all the details. Our team will get in touch with you shortly.',
      'slug' => 'thanks_for_providing_all_the_details_our_team_will_get_in_touch_with_you_shortlybusi_dev_skillset',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_7595739315604492',
      ),
      'config' => 
      array (
        'default' => 'Thanks for providing all the details. Our team will get in touch with you shortly. 

Have a good day ahead!',
      ),
    ),
    'fld_8071144' => 
    array (
      'ID' => 'fld_8071144',
      'type' => 'text',
      'label' => 'What is your Name?',
      'slug' => 'what_is_your_name_busi_devi_quali',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_36726148901646',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_5531520' => 
    array (
      'ID' => 'fld_5531520',
      'type' => 'email',
      'label' => 'What is your Email?',
      'slug' => 'what_is_your_email_busi_devi_quali',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_36726148901646',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_5377879' => 
    array (
      'ID' => 'fld_5377879',
      'type' => 'number',
      'label' => 'What is your Phone Number?',
      'slug' => 'what_is_your_phone_number_busi_devi_quali',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_36726148901646',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_3735821' => 
    array (
      'ID' => 'fld_3735821',
      'type' => 'html',
      'label' => 'Thanks for providing all the details. Our team will get in touch with you shortly.',
      'slug' => 'thanks_for_providing_all_the_details_busi_devi_quali',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_36726148901646',
      ),
      'config' => 
      array (
        'default' => 'Thanks for providing all the details. Our team will get in touch with you shortly. 

Have a good day ahead!',
      ),
    ),
    'fld_6424611' => 
    array (
      'ID' => 'fld_6424611',
      'type' => 'text',
      'label' => 'What is your Name?',
      'slug' => 'what_is_your_name_senior_develope_reqi',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_134824808203418',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_3317494' => 
    array (
      'ID' => 'fld_3317494',
      'type' => 'email',
      'label' => 'What is your Email?',
      'slug' => 'what_is_your_email_senior_develope_reqi',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_134824808203418',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_4261782' => 
    array (
      'ID' => 'fld_4261782',
      'type' => 'number',
      'label' => 'What is your Phone Number?',
      'slug' => 'what_is_your_phone_number_senior_develope_reqi',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_134824808203418',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_2717249' => 
    array (
      'ID' => 'fld_2717249',
      'type' => 'html',
      'label' => 'Thanks for providing all the details. Our team will get in touch with you shortly.',
      'slug' => 'thanks_for_providing_all_the_details_senior_develope_reqi',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_134824808203418',
      ),
      'config' => 
      array (
        'default' => 'Thanks for providing all the details. Our team will get in touch with you shortly. 

Have a good day ahead!',
      ),
    ),
    'fld_6662545' => 
    array (
      'ID' => 'fld_6662545',
      'type' => 'text',
      'label' => 'What is your Name?',
      'slug' => 'what_is_your_name_senior_develope_skillsetss',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_5837150598874721',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_5354748' => 
    array (
      'ID' => 'fld_5354748',
      'type' => 'email',
      'label' => 'What is your Email?',
      'slug' => 'what_is_your_email_senior_develope_skillsetss',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_5837150598874721',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_1003346' => 
    array (
      'ID' => 'fld_1003346',
      'type' => 'number',
      'label' => 'What is your Phone Number?',
      'slug' => 'what_is_your_phone_number_senior_develope_skillsetss',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_5837150598874721',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_4370318' => 
    array (
      'ID' => 'fld_4370318',
      'type' => 'html',
      'label' => 'Thanks for providing all the details. Our team will get in touch with you shortly.',
      'slug' => 'thanks_for_providing_all_the_details_senior_develope_skillsetss',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_5837150598874721',
      ),
      'config' => 
      array (
        'default' => 'Thanks for providing all the details. Our team will get in touch with you shortly. 

Have a good day ahead!',
      ),
    ),
    'fld_2277851' => 
    array (
      'ID' => 'fld_2277851',
      'type' => 'text',
      'label' => 'What is your Name?',
      'slug' => 'what_is_your_name_senior_devi_qualiticationss',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_442156461959050',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_2175171' => 
    array (
      'ID' => 'fld_2175171',
      'type' => 'email',
      'label' => 'What is your Email?',
      'slug' => 'what_is_your_email_senior_devi_qualiticationss',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_442156461959050',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_4535274' => 
    array (
      'ID' => 'fld_4535274',
      'type' => 'number',
      'label' => 'What is your Phone Number?',
      'slug' => 'what_is_your_pnone_num_senior_devi_qualiticationss',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_442156461959050',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_388425' => 
    array (
      'ID' => 'fld_388425',
      'type' => 'html',
      'label' => 'Thanks for providing all the details. Our team will get in touch with you shortly.',
      'slug' => 'thanks_for_providing_all_the_details_senior_devi_qualiticationss',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_442156461959050',
      ),
      'config' => 
      array (
        'default' => 'Thanks for providing all the details. Our team will get in touch with you shortly. 

Have a good day ahead!',
      ),
    ),
    'fld_4246426' => 
    array (
      'ID' => 'fld_4246426',
      'type' => 'text',
      'label' => 'What is your Name?',
      'slug' => 'what_is_your_name_project_manager_requiressww',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_9048234878022065',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_5409926' => 
    array (
      'ID' => 'fld_5409926',
      'type' => 'email',
      'label' => 'What is your Email?',
      'slug' => 'what_is_your_email_project_manager_requiressww',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_9048234878022065',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_8402789' => 
    array (
      'ID' => 'fld_8402789',
      'type' => 'number',
      'label' => 'What is your Phone Number?',
      'slug' => 'what_is_your_phone_number_project_manager_requiressww',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_9048234878022065',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_2110227' => 
    array (
      'ID' => 'fld_2110227',
      'type' => 'html',
      'label' => 'Thanks for providing all the details. Our team will get in touch with you shortly.',
      'slug' => 'thanks_for_providing_all_the_details_project_manager_requiressww',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_9048234878022065',
      ),
      'config' => 
      array (
        'default' => 'Thanks for providing all the details. Our team will get in touch with you shortly. 

Have a good day ahead!',
      ),
    ),
    'fld_1179373' => 
    array (
      'ID' => 'fld_1179373',
      'type' => 'text',
      'label' => 'What is your Name?',
      'slug' => 'what_is_your_name_project_mana_skills',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_5470506745397590',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_6259942' => 
    array (
      'ID' => 'fld_6259942',
      'type' => 'email',
      'label' => 'What is your Email?',
      'slug' => 'what_is_your_email_project_mana_skills',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_5470506745397590',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_3797110' => 
    array (
      'ID' => 'fld_3797110',
      'type' => 'number',
      'label' => 'What is your Phone Number?',
      'slug' => 'what_is_your_phone_number_project_mana_skills',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_5470506745397590',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_8640105' => 
    array (
      'ID' => 'fld_8640105',
      'type' => 'html',
      'label' => 'Thanks for providing all the details. Our team will get in touch with you shortly.',
      'slug' => 'thanks_for_providing_all_the_details_project_mana_skills',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_5470506745397590',
      ),
      'config' => 
      array (
        'default' => 'Thanks for providing all the details. Our team will get in touch with you shortly. 

Have a good day ahead!',
      ),
    ),
    'fld_9070678' => 
    array (
      'ID' => 'fld_9070678',
      'type' => 'text',
      'label' => 'What is your Name?',
      'slug' => 'what_is_your_name_project_mani_qualifica',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_6272302473899468',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_8958765' => 
    array (
      'ID' => 'fld_8958765',
      'type' => 'email',
      'label' => 'What is your Email?',
      'slug' => 'what_is_your_email_project_mani_qualifica',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_6272302473899468',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_7294767' => 
    array (
      'ID' => 'fld_7294767',
      'type' => 'number',
      'label' => 'What is your Phone Number?',
      'slug' => 'what_is_your_phone_number_project_mani_qualifica',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_6272302473899468',
      ),
      'config' => 
      array (
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_5002440' => 
    array (
      'ID' => 'fld_5002440',
      'type' => 'html',
      'label' => 'Thanks for providing all the details. Our team will get in touch with you shortly.',
      'slug' => 'thanks_for_providing_all_the_details_project_mani_qualifica',
      'additional' => '',
      'conditions' => 
      array (
        'type' => 'con_6272302473899468',
      ),
      'config' => 
      array (
        'default' => 'Thanks for providing all the details. Our team will get in touch with you shortly. 

Have a good day ahead!',
      ),
    ),
  ),
  'mailer' => 
  array (
    'on_insert' => 1,
    'sender_name' => 'Chatbot Forms Notification',
    'sender_email' => '',
    'recipients' => '',
    'email_subject' => 'HR - Recruiter',
  ),
  'conditional_groups' => 
  array (
    'conditions' => 
    array (
      'con_642928492308739' => 
      array (
        'id' => 'con_642928492308739',
        'name' => 'Browse Jobs',
        'type' => 'show',
        'fields' => 
        array (
          'cl3072121371975084' => 'fld_6489847',
        ),
        'group' => 
        array (
          'rw8957534141416002' => 
          array (
            'cl3072121371975084' => 
            array (
              'parent' => 'rw8957534141416002',
              'field' => 'fld_6489847',
              'compare' => 'is',
              'value' => 'opt1900099',
            ),
          ),
        ),
      ),
      'con_3944961049020491' => 
      array (
        'id' => 'con_3944961049020491',
        'name' => 'Business Development',
        'type' => 'show',
        'fields' => 
        array (
          'cl3853338323455242' => 'fld_8885958',
        ),
        'group' => 
        array (
          'rw4130003534262784' => 
          array (
            'cl3853338323455242' => 
            array (
              'parent' => 'rw4130003534262784',
              'field' => 'fld_8885958',
              'compare' => 'is',
              'value' => 'opt1462220',
            ),
          ),
        ),
      ),
      'con_1908476686831589' => 
      array (
        'id' => 'con_1908476686831589',
        'name' => 'Requirements',
        'type' => 'show',
        'fields' => 
        array (
          'cl5334534720556824' => 'fld_9506823',
        ),
        'group' => 
        array (
          'rw8569946425838227' => 
          array (
            'cl5334534720556824' => 
            array (
              'parent' => 'rw8569946425838227',
              'field' => 'fld_9506823',
              'compare' => 'is',
              'value' => 'opt1590125',
            ),
          ),
        ),
      ),
      'con_7057135516165651' => 
      array (
        'id' => 'con_7057135516165651',
        'name' => 'Yes, contact me business develop requirement',
        'type' => 'show',
        'fields' => 
        array (
          'cl9216687871369000' => 'fld_7364694',
        ),
        'group' => 
        array (
          'rw9461883414397194' => 
          array (
            'cl9216687871369000' => 
            array (
              'parent' => 'rw9461883414397194',
              'field' => 'fld_7364694',
              'compare' => 'is',
              'value' => 'opt1678559',
            ),
          ),
        ),
      ),
      'con_9223990947958525' => 
      array (
        'id' => 'con_9223990947958525',
        'name' => 'Go back to Job details',
        'type' => 'show',
        'fields' => 
        array (
          'cl640097318185930' => 'fld_7364694',
        ),
        'group' => 
        array (
          'rw7258829229062378' => 
          array (
            'cl640097318185930' => 
            array (
              'parent' => 'rw7258829229062378',
              'field' => 'fld_7364694',
              'compare' => 'is',
              'value' => 'opt1924943',
            ),
          ),
        ),
      ),
      'con_1833050369591878' => 
      array (
        'id' => 'con_1833050369591878',
        'name' => 'Go back to Job listings',
        'type' => 'show',
        'fields' => 
        array (
          'cl3743069881883656' => 'fld_7364694',
        ),
        'group' => 
        array (
          'rw5183781135364890' => 
          array (
            'cl3743069881883656' => 
            array (
              'parent' => 'rw5183781135364890',
              'field' => 'fld_7364694',
              'compare' => 'is',
              'value' => 'opt2001703',
            ),
          ),
        ),
      ),
      'con_9582398531122272' => 
      array (
        'id' => 'con_9582398531122272',
        'name' => 'Skillset',
        'type' => 'show',
        'fields' => 
        array (
          'cl1543543462991994' => 'fld_9506823',
        ),
        'group' => 
        array (
          'rw5837258425934383' => 
          array (
            'cl1543543462991994' => 
            array (
              'parent' => 'rw5837258425934383',
              'field' => 'fld_9506823',
              'compare' => 'is',
              'value' => 'opt1105434',
            ),
          ),
        ),
      ),
      'con_2525269189749985' => 
      array (
        'id' => 'con_2525269189749985',
        'name' => 'About',
        'type' => 'show',
        'fields' => 
        array (
          'cl382180384426242' => 'fld_6489847',
        ),
        'group' => 
        array (
          'rw5540726075720615' => 
          array (
            'cl382180384426242' => 
            array (
              'parent' => 'rw5540726075720615',
              'field' => 'fld_6489847',
              'compare' => 'is',
              'value' => 'opt1589859',
            ),
          ),
        ),
      ),
      'con_306676846118809' => 
      array (
        'id' => 'con_306676846118809',
        'name' => 'Talk to Us!',
        'type' => 'show',
        'fields' => 
        array (
          'cl9247595658752608' => 'fld_6489847',
        ),
        'group' => 
        array (
          'rw9572373885041351' => 
          array (
            'cl9247595658752608' => 
            array (
              'parent' => 'rw9572373885041351',
              'field' => 'fld_6489847',
              'compare' => 'is',
              'value' => 'opt1334028',
            ),
          ),
        ),
      ),
      'con_9890612756326398' => 
      array (
        'id' => 'con_9890612756326398',
        'name' => 'Ask a Question',
        'type' => 'show',
        'fields' => 
        array (
          'cl5007419674116563' => 'fld_5098008',
        ),
        'group' => 
        array (
          'rw7882585898581467' => 
          array (
            'cl5007419674116563' => 
            array (
              'parent' => 'rw7882585898581467',
              'field' => 'fld_5098008',
              'compare' => 'is',
              'value' => 'opt2017336',
            ),
          ),
        ),
      ),
      'con_213804711715810' => 
      array (
        'id' => 'con_213804711715810',
        'name' => 'QUALIFICATION',
        'type' => 'show',
        'fields' => 
        array (
          'cl2840208618585074' => 'fld_9506823',
        ),
        'group' => 
        array (
          'rw1933359484110224' => 
          array (
            'cl2840208618585074' => 
            array (
              'parent' => 'rw1933359484110224',
              'field' => 'fld_9506823',
              'compare' => 'is',
              'value' => 'opt1844110',
            ),
          ),
        ),
      ),
      'con_2220240134901797' => 
      array (
        'id' => 'con_2220240134901797',
        'name' => 'Senior Developer',
        'type' => 'show',
        'fields' => 
        array (
          'cl3118119431510090' => 'fld_8885958',
        ),
        'group' => 
        array (
          'rw6277350794439932' => 
          array (
            'cl3118119431510090' => 
            array (
              'parent' => 'rw6277350794439932',
              'field' => 'fld_8885958',
              'compare' => 'is',
              'value' => 'opt2089776',
            ),
          ),
        ),
      ),
      'con_2490231045635146' => 
      array (
        'id' => 'con_2490231045635146',
        'name' => 'Project Manager',
        'type' => 'show',
        'fields' => 
        array (
          'cl9064983647642343' => 'fld_8885958',
        ),
        'group' => 
        array (
          'rw1639127430301548' => 
          array (
            'cl9064983647642343' => 
            array (
              'parent' => 'rw1639127430301548',
              'field' => 'fld_8885958',
              'compare' => 'is',
              'value' => 'opt1886017',
            ),
          ),
        ),
      ),
      'con_9944608346294313' => 
      array (
        'id' => 'con_9944608346294313',
        'name' => 'Didn\'t find anything suitable?',
        'type' => 'show',
        'fields' => 
        array (
          'cl8053030255984359' => 'fld_8885958',
        ),
        'group' => 
        array (
          'rw844126945619038' => 
          array (
            'cl8053030255984359' => 
            array (
              'parent' => 'rw844126945619038',
              'field' => 'fld_8885958',
              'compare' => 'is',
              'value' => 'opt1981247',
            ),
          ),
        ),
      ),
      'con_8797403167019325' => 
      array (
        'id' => 'con_8797403167019325',
        'name' => 'senior developer ROLE REQUIREMENTS',
        'type' => 'show',
        'fields' => 
        array (
          'cl334643810629161' => 'fld_7632219',
        ),
        'group' => 
        array (
          'rw6055229940362230' => 
          array (
            'cl334643810629161' => 
            array (
              'parent' => 'rw6055229940362230',
              'field' => 'fld_7632219',
              'compare' => 'is',
              'value' => 'opt1498550',
            ),
          ),
        ),
      ),
      'con_9518701135220406' => 
      array (
        'id' => 'con_9518701135220406',
        'name' => 'senior developer skillset',
        'type' => 'show',
        'fields' => 
        array (
          'cl163492948441040' => 'fld_7632219',
        ),
        'group' => 
        array (
          'rw1757965379832927' => 
          array (
            'cl163492948441040' => 
            array (
              'parent' => 'rw1757965379832927',
              'field' => 'fld_7632219',
              'compare' => 'is',
              'value' => 'opt1257240',
            ),
          ),
        ),
      ),
      'con_8744591252837930' => 
      array (
        'id' => 'con_8744591252837930',
        'name' => 'senior developer Qualifications',
        'type' => 'show',
        'fields' => 
        array (
          'cl8270652398197863' => 'fld_7632219',
        ),
        'group' => 
        array (
          'rw9066614825380710' => 
          array (
            'cl8270652398197863' => 
            array (
              'parent' => 'rw9066614825380710',
              'field' => 'fld_7632219',
              'compare' => 'is',
              'value' => 'opt1783312',
            ),
          ),
        ),
      ),
      'con_422514329718167' => 
      array (
        'id' => 'con_422514329718167',
        'name' => 'project manager ROLE REQUIREMENTS',
        'type' => 'show',
        'fields' => 
        array (
          'cl3915461713863105' => 'fld_2472634',
        ),
        'group' => 
        array (
          'rw7516558740823439' => 
          array (
            'cl3915461713863105' => 
            array (
              'parent' => 'rw7516558740823439',
              'field' => 'fld_2472634',
              'compare' => 'is',
              'value' => 'opt1612216',
            ),
          ),
        ),
      ),
      'con_3843184014338275' => 
      array (
        'id' => 'con_3843184014338275',
        'name' => 'project manager skillset',
        'type' => 'show',
        'fields' => 
        array (
          'cl7821472725456071' => 'fld_2472634',
        ),
        'group' => 
        array (
          'rw9172096081453670' => 
          array (
            'cl7821472725456071' => 
            array (
              'parent' => 'rw9172096081453670',
              'field' => 'fld_2472634',
              'compare' => 'is',
              'value' => 'opt1851416',
            ),
          ),
        ),
      ),
      'con_1455128383838501' => 
      array (
        'id' => 'con_1455128383838501',
        'name' => 'project manager Qualifications',
        'type' => 'show',
        'fields' => 
        array (
          'cl1791769345850478' => 'fld_2472634',
        ),
        'group' => 
        array (
          'rw9344322515178321' => 
          array (
            'cl1791769345850478' => 
            array (
              'parent' => 'rw9344322515178321',
              'field' => 'fld_2472634',
              'compare' => 'is',
              'value' => 'opt1176714',
            ),
          ),
        ),
      ),
      'con_3072390197164155' => 
      array (
        'id' => 'con_3072390197164155',
        'name' => 'Didn\'t find anything suitable? Contact Us',
        'type' => 'show',
        'fields' => 
        array (
          'cl9680925959594553' => 'fld_5531939',
        ),
        'group' => 
        array (
          'rw481685511690058' => 
          array (
            'cl9680925959594553' => 
            array (
              'parent' => 'rw481685511690058',
              'field' => 'fld_5531939',
              'compare' => 'is',
              'value' => 'opt1532093',
            ),
          ),
        ),
      ),
      'con_954472451658166' => 
      array (
        'id' => 'con_954472451658166',
        'name' => 'Didn\'t find anything suitable? About Us',
        'type' => 'show',
        'fields' => 
        array (
          'cl2930975087936968' => 'fld_5531939',
        ),
        'group' => 
        array (
          'rw5363840835012060' => 
          array (
            'cl2930975087936968' => 
            array (
              'parent' => 'rw5363840835012060',
              'field' => 'fld_5531939',
              'compare' => 'is',
              'value' => 'opt1751023',
            ),
          ),
        ),
      ),
      'con_7595739315604492' => 
      array (
        'id' => 'con_7595739315604492',
        'name' => 'Yes, contact me business develop skillset',
        'type' => 'show',
        'fields' => 
        array (
          'cl881013342117058' => 'fld_7166973',
        ),
        'group' => 
        array (
          'rw740383990554032' => 
          array (
            'cl881013342117058' => 
            array (
              'parent' => 'rw740383990554032',
              'field' => 'fld_7166973',
              'compare' => 'is',
              'value' => 'opt1642730',
            ),
          ),
        ),
      ),
      'con_36726148901646' => 
      array (
        'id' => 'con_36726148901646',
        'name' => 'Yes, contact me business develop qualifications',
        'type' => 'show',
        'fields' => 
        array (
          'cl9801428647207511' => 'fld_6935785',
        ),
        'group' => 
        array (
          'rw473644987138391' => 
          array (
            'cl9801428647207511' => 
            array (
              'parent' => 'rw473644987138391',
              'field' => 'fld_6935785',
              'compare' => 'is',
              'value' => 'opt1642730',
            ),
          ),
        ),
      ),
      'con_134824808203418' => 
      array (
        'id' => 'con_134824808203418',
        'name' => 'Yes, contact me senior developer requirements',
        'type' => 'show',
        'fields' => 
        array (
          'cl9047587838566806' => 'fld_2980286',
        ),
        'group' => 
        array (
          'rw8439807673248420' => 
          array (
            'cl9047587838566806' => 
            array (
              'parent' => 'rw8439807673248420',
              'field' => 'fld_2980286',
              'compare' => 'is',
              'value' => 'opt1642730',
            ),
          ),
        ),
      ),
      'con_5837150598874721' => 
      array (
        'id' => 'con_5837150598874721',
        'name' => 'Yes, contact me senior developer skillset',
        'type' => 'show',
        'fields' => 
        array (
          'cl30683265845733' => 'fld_2571757',
        ),
        'group' => 
        array (
          'rw233282967035522' => 
          array (
            'cl30683265845733' => 
            array (
              'parent' => 'rw233282967035522',
              'field' => 'fld_2571757',
              'compare' => 'is',
              'value' => 'opt1642730',
            ),
          ),
        ),
      ),
      'con_442156461959050' => 
      array (
        'id' => 'con_442156461959050',
        'name' => 'Yes, contact me senior developer qualifications',
        'type' => 'show',
        'fields' => 
        array (
          'cl3112702811607511' => 'fld_9474596',
        ),
        'group' => 
        array (
          'rw6583095083605913' => 
          array (
            'cl3112702811607511' => 
            array (
              'parent' => 'rw6583095083605913',
              'field' => 'fld_9474596',
              'compare' => 'is',
              'value' => 'opt1642730',
            ),
          ),
        ),
      ),
      'con_9048234878022065' => 
      array (
        'id' => 'con_9048234878022065',
        'name' => 'Yes, contact me project manager requirements',
        'type' => 'show',
        'fields' => 
        array (
          'cl233834754893197' => 'fld_9718300',
        ),
        'group' => 
        array (
          'rw3165871842544815' => 
          array (
            'cl233834754893197' => 
            array (
              'parent' => 'rw3165871842544815',
              'field' => 'fld_9718300',
              'compare' => 'is',
              'value' => 'opt1642730',
            ),
          ),
        ),
      ),
      'con_5470506745397590' => 
      array (
        'id' => 'con_5470506745397590',
        'name' => 'Yes, contact me project manager skillset',
        'type' => 'show',
        'fields' => 
        array (
          'cl1471904633306564' => 'fld_8520338',
        ),
        'group' => 
        array (
          'rw2001884044891720' => 
          array (
            'cl1471904633306564' => 
            array (
              'parent' => 'rw2001884044891720',
              'field' => 'fld_8520338',
              'compare' => 'is',
              'value' => 'opt1642730',
            ),
          ),
        ),
      ),
      'con_6272302473899468' => 
      array (
        'id' => 'con_6272302473899468',
        'name' => 'Yes, contact me project manager qualifications',
        'type' => 'show',
        'fields' => 
        array (
          'cl8405563488228980' => 'fld_1100253',
        ),
        'group' => 
        array (
          'rw5671565848808276' => 
          array (
            'cl8405563488228980' => 
            array (
              'parent' => 'rw5671565848808276',
              'field' => 'fld_1100253',
              'compare' => 'is',
              'value' => 'opt1642730',
            ),
          ),
        ),
      ),
    ),
  ),
  'privacy_exporter_enabled' => false,
  'version' => '1.0.0',
);