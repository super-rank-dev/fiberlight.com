<?php

return array (
  'ID' => 'simple-survey',
  'wfb_version' => '1.0.0',
  'success' => 'Form has been successfully submitted. Thank you.',
  'db_support' => 1,
  'pinned' => 0,
  'hide_form' => 1,
  'check_honey' => 1,
  'avatar_field' => '',
  'form_ajax' => 1,
  'layout_grid' => 
  array (
    'fields' => 
    array (
      'fld_9829933' => '1:1',
      'fld_3945227' => '2:1',
      'fld_3469576' => '3:1',
      'fld_8082858' => '4:1',
      'fld_5552737' => '5:1',
      'fld_8551920' => '6:1',
      'fld_9886399' => '7:1',
    ),
    'structure' => '12|12|12|12|12|12|12',
  ),
  'fields' => 
  array (
    'fld_9829933' => 
    array (
      'ID' => 'fld_9829933',
      'type' => 'text',
      'label' => 'What is your name?',
      'slug' => 'what_is_your_name',
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
    'fld_3945227' => 
    array (
      'ID' => 'fld_3945227',
      'type' => 'html',
      'label' => 'html__fld_3945227',
      'slug' => 'html_fld_3945227',
      'conditions' => 
      array (
        'type' => '',
      ),
      'config' => 
      array (
        'default' => 'Nice to meet you!',
      ),
    ),
    'fld_3469576' => 
    array (
      'ID' => 'fld_3469576',
      'type' => 'text',
      'label' => 'What is your email address?',
      'slug' => 'what_is_your_email_address',
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
    'fld_8082858' => 
    array (
      'ID' => 'fld_8082858',
      'type' => 'text',
      'label' => 'May I know your phone number?',
      'slug' => 'may_i_know_your_phone_number',
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
    'fld_5552737' => 
    array (
      'ID' => 'fld_5552737',
      'type' => 'dropdown',
      'label' => 'Your gender?',
      'slug' => 'your_gender',
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
          'opt1418512' => 
          array (
            'calc_value' => 0,
            'value' => 'Male',
            'label' => 'Male',
          ),
          'opt1060417' => 
          array (
            'calc_value' => 0,
            'value' => 'Female',
            'label' => 'Female',
          ),
        ),
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_8551920' => 
    array (
      'ID' => 'fld_8551920',
      'type' => 'checkbox',
      'label' => 'Your hobbies?',
      'slug' => 'your_hobbies',
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
          'opt1425104' => 
          array (
            'calc_value' => 0,
            'value' => 'Gardening',
            'label' => 'Gardening',
          ),
          'opt1643836' => 
          array (
            'calc_value' => 0,
            'value' => 'Reading Books',
            'label' => 'Reading Books',
          ),
          'opt1544189' => 
          array (
            'calc_value' => 0,
            'value' => 'Hiking',
            'label' => 'Hiking',
          ),
          'opt1743007' => 
          array (
            'calc_value' => 0,
            'value' => 'Biking',
            'label' => 'Biking',
          ),
        ),
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_9886399' => 
    array (
      'ID' => 'fld_9886399',
      'type' => 'html',
      'label' => 'html__fld_9886399',
      'slug' => 'html_fld_9886399',
      'conditions' => 
      array (
        'type' => '',
      ),
      'config' => 
      array (
        'default' => 'Thank you very much for the information. We will contact you soon. ',
      ),
    ),
  ),
  'conditional_groups' => 
  array (
    'magic' => NULL,
  ),
  'page_names' => 
  array (
  ),
  'settings' => 
  array (
    'responsive' => 
    array (
      'break_point' => 'sm',
    ),
  ),
  'processors' => 
  array (
  ),
  'name' => 'Send Feedback',
  'mailer' => 
  array (
    'on_insert' => 1,
    'sender_name' => 'Chatbot Forms Notification',
    'sender_email' => '',
    'recipients' => '',
    'email_subject' => 'Send Feedback',
  ),
  'hidden' => 0,
  'form_draft' => 0,
  'type' => 'primary',
  '_last_updated' => 'Fri, 04 Oct 2019 10:43:33 +0000',
  'command' => 'feedback',
  'privacy_exporter_enabled' => false,
  'version' => '1.0.0',
);