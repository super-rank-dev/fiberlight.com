<?php

return array (
  '_last_updated' => 'Fri, 04 Oct 2019 11:08:22 +0000',
  'ID' => 'simple-survey',
  'wfb_version' => '1.0.0',
  'name' => 'Simple Survey',
  'command' => 'Simple Survey',
  'layout_grid' => 
  array (
    'fields' => 
    array (
      'fld_8892617' => '1:1',
      'fld_9656816' => '1:1',
      'fld_7138687' => '1:1',
      'fld_7982226' => '1:1',
      'fld_2514720' => '1:1',
    ),
    'structure' => '12',
  ),
  'fields' => 
  array (
    'fld_8892617' => 
    array (
      'ID' => 'fld_8892617',
      'type' => 'text',
      'label' => 'What is your name?',
      'slug' => 'what_is_your_name',
      'conditions' => 
      array (
        'type' => '',
      ),
    ),
    'fld_9656816' => 
    array (
      'ID' => 'fld_9656816',
      'type' => 'text',
      'label' => 'How did you hear about us?',
      'slug' => 'how_did_you_hear_about_us',
      'conditions' => 
      array (
        'type' => '',
      ),
    ),
    'fld_7138687' => 
    array (
      'ID' => 'fld_7138687',
      'type' => 'text',
      'label' => 'Are you marketing/advertising on facebook?',
      'slug' => 'are_you_marketingadvertising_on_facebook',
      'conditions' => 
      array (
        'type' => '',
      ),
    ),
    'fld_7982226' => 
    array (
      'ID' => 'fld_7982226',
      'type' => 'dropdown',
      'label' => 'What interest you most about Facebook Messenger marketing? ',
      'slug' => 'what_interest_you_most_about_facebook_messaging_',
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
        'orderby_tax' => 'count',
        'orderby_post' => 'ID',
        'order' => 'ASC',
        'default' => '',
        'option' => 
        array (
          'opt1310373' => 
          array (
            'calc_value' => '',
            'value' => 'Chat Blasting',
            'label' => 'Chat Blasting',
          ),
          'opt2074045' => 
          array (
            'calc_value' => '',
            'value' => 'Facebook Chatbots',
            'label' => 'Facebook Chatbots',
          ),
        ),
      ),
    ),
    'fld_2514720' => 
    array (
      'ID' => 'fld_2514720',
      'type' => 'html',
      'label' => 'html__fld_2514720',
      'slug' => 'html__fld_2514720',
      'conditions' => 
      array (
        'type' => '',
      ),
      'config' => 
      array (
        'default' => 'Thank you for giving us the information.',
      ),
    ),
  ),
  'mailer' => 
  array (
    'on_insert' => 1,
    'sender_name' => 'Chatbot Forms Notification',
    'sender_email' => '',
    'recipients' => '',
    'email_subject' => 'Simple Survey',
  ),
  'conditional_groups' => 
  array (
    'fields' => 
    array (
    ),
    'magic' => NULL,
  ),
  'version' => '1.0.0',
);