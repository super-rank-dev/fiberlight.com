<?php 

return array (
  '_last_updated' => 'Fri, 04 Oct 2019 10:29:52 +0000',
  'ID' => 'simple-contact',
  'wfb_version' => '1.0.0',
  'name' => 'Simple Contact',
  'command' => 'simple contact',
  'layout_grid' => 
  array (
    'fields' => 
    array (
      'fld_1641958' => '1:1',
      'fld_370333' => '1:1',
      'fld_2418666' => '1:1',
      'fld_1338092' => '1:1',
      'fld_2746516' => '1:1',
      'fld_5369089' => '1:1',
      'fld_952197' => '1:1',
      'fld_3261701' => '1:1',
    ),
    'structure' => '12',
  ),
  'fields' => 
  array (
    'fld_1641958' => 
    array (
      'ID' => 'fld_1641958',
      'type' => 'text',
      'label' => 'Please tell me what is your name?',
      'slug' => 'please_tell_me_what_is_your_name',
      'conditions' => 
      array (
        'type' => '',
      ),
    ),
    'fld_370333' => 
    array (
      'ID' => 'fld_370333',
      'type' => 'html',
      'label' => 'html__fld_370333',
      'slug' => 'html__fld_370333',
      'conditions' => 
      array (
        'type' => '',
      ),
      'config' => 
      array (
        'default' => 'Nice to meet you %name%!',
      ),
    ),
    'fld_1338092' => 
    array (
      'ID' => 'fld_1338092',
      'type' => 'email',
      'label' => 'What is your email address %name%?',
      'slug' => 'email_address',
      'conditions' => 
      array (
        'type' => '',
      ),
    ),
    'fld_2418666' => 
    array (
      'ID' => 'fld_2418666',
      'type' => 'html',
      'label' => 'We need your email address',
      'slug' => 'html__fld_2418666',
      'conditions' => 
      array (
        'type' => '',
      ),
      'config' => 
      array (
        'default' => 'We need your email address. So we can get back to you. No worries we do not spam. You can see our privacy policy.',
      ),
    ),
    'fld_2746516' => 
    array (
      'ID' => 'fld_2746516',
      'type' => 'html',
      'label' => 'Thank you for sharing email',
      'slug' => 'html__fld_2746516',
      'conditions' => 
      array (
        'type' => '',
      ),
      'config' => 
      array (
        'default' => 'Thank you %name% for sharing your email address. We need your phone number too.',
      ),
    ),
    'fld_5369089' => 
    array (
      'ID' => 'fld_5369089',
      'type' => 'number',
      'label' => 'What is your phone number?',
      'slug' => 'what_is_your_phone_number',
      'conditions' => 
      array (
        'type' => '',
      ),
    ),
    'fld_952197' => 
    array (
      'ID' => 'fld_952197',
      'type' => 'text',
      'label' => 'What is your query?',
      'slug' => 'what_is_your_query',
      'conditions' => 
      array (
        'type' => '',
      ),
    ),
    'fld_3261701' => 
    array (
      'ID' => 'fld_3261701',
      'type' => 'html',
      'label' => 'thank you for giving the information',
      'slug' => 'html__fld_3261701',
      'conditions' => 
      array (
        'type' => '',
      ),
      'config' => 
      array (
        'default' => 'Thank you again for giving all required information. We will get back to you very soon.',
      ),
    ),
  ),
  'mailer' => 
  array (
    'on_insert' => 1,
    'sender_name' => 'Chatbot Forms Notification',
    'sender_email' => '',
    'recipients' => '',
    'email_subject' => 'Simple Contact',
  ),
  'conditional_groups' => 
  array (
    'fields' => 
    array (
    ),
    'magic' => NULL,
  ),
  'variables' => 
  array (
    'keys' => 
    array (
      0 => 'name',
    ),
    'values' => 
    array (
      0 => '%please_tell_me_what_is_your_name%',
    ),
    'types' => 
    array (
      0 => 'static',
    ),
  ),
  'version' => '1.0.0',
);