<?php

 return array (
  '_last_updated' => 'Fri, 04 Oct 2019 11:21:07 +0000',
  'ID' => 'simple-booking',
  'wfb_version' => '1.0.0',
  'name' => 'Simple booking',
  'command' => 'simple booking',
  'layout_grid' => 
  array (
    'fields' => 
    array (
      'fld_185917' => '1:1',
      'fld_6892512' => '1:1',
      'fld_2254781' => '2:1',
      'fld_7900587' => '2:1',
      'fld_9356744' => '3:1',
      'fld_9099709' => '3:1',
      'fld_6496615' => '4:1',
      'fld_5630664' => '4:1',
      'fld_4089741' => '5:1',
      'fld_2148609' => '5:1',
    ),
    'structure' => '12|12|12|12|12',
  ),
  'fields' => 
  array (
    'fld_185917' => 
    array (
      'ID' => 'fld_185917',
      'type' => 'text',
      'label' => 'What is your First Name?',
      'slug' => 'first_name',
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
    'fld_6892512' => 
    array (
      'ID' => 'fld_6892512',
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
    'fld_2254781' => 
    array (
      'ID' => 'fld_2254781',
      'type' => 'text',
      'label' => 'What is your phone number',
      'slug' => 'mobile_number',
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
    'fld_7900587' => 
    array (
      'ID' => 'fld_7900587',
      'type' => 'email',
      'label' => 'What is your email address?',
      'slug' => 'email_address',
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
    'fld_9356744' => 
    array (
      'ID' => 'fld_9356744',
      'type' => 'date_picker',
      'label' => 'When do you want to check in?',
      'slug' => 'check_in_date',
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
    'fld_9099709' => 
    array (
      'ID' => 'fld_9099709',
      'type' => 'date_picker',
      'label' => 'When do you want to check out?',
      'slug' => 'check_out_date',
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
    'fld_6496615' => 
    array (
      'ID' => 'fld_6496615',
      'type' => 'number',
      'label' => 'Number of adults you want to book for?',
      'slug' => 'number_of_adults',
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
    'fld_5630664' => 
    array (
      'ID' => 'fld_5630664',
      'type' => 'number',
      'label' => 'Number of children you want to book for?',
      'slug' => 'number_of_children',
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
    'fld_4089741' => 
    array (
      'ID' => 'fld_4089741',
      'type' => 'text',
      'label' => 'Please write your comments if any?',
      'slug' => 'comments',
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
    'fld_2148609' => 
    array (
      'ID' => 'fld_2148609',
      'type' => 'html',
      'label' => 'html__fld_2148609',
      'slug' => 'html__fld_2148609',
      'conditions' => 
      array (
        'type' => '',
      ),
      'config' => 
      array (
        'default' => 'Thank you! We will contact you very soon.',
      ),
    ),
  ),
  'mailer' => 
  array (
    'on_insert' => 1,
    'sender_name' => 'Chatbot Forms Notification',
    'sender_email' => '',
    'recipients' => '',
    'email_subject' => 'Simple booking',
  ),
  'conditional_groups' => 
  array (
    '_open_condition' => '',
    'magic' => NULL,
  ),
  'privacy_exporter_enabled' => false,
  'version' => '1.0.0',
);
