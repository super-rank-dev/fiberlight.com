<?php

return array (
  '_last_updated' => 'Fri, 04 Oct 2019 12:04:27 +0000',
  'ID' => 'CF5d9731813ca62',
  'wfb_version' => '1.0.0',
  'name' => 'Room Area Calculator',
  'command' => 'room area',
  'layout_grid' => 
  array (
    'fields' => 
    array (
      'fld_3436416' => '1:1',
      'fld_5576349' => '1:1',
      'fld_1199327' => '1:1',
      'fld_9887523' => '1:1',
      'fld_87574' => '1:1',
      'fld_1517789' => '1:1',
    ),
    'structure' => '12',
  ),
  'fields' => 
  array (
    'fld_3436416' => 
    array (
      'ID' => 'fld_3436416',
      'type' => 'dropdown',
      'label' => 'How do you want to calculate the room area?',
      'slug' => 'how_do_you_want_to_calculate_the_room_area',
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
          'opt1542903' => 
          array (
            'calc_value' => '',
            'value' => 'Inch',
            'label' => 'Inch',
          ),
          'opt1771147' => 
          array (
            'calc_value' => '',
            'value' => 'Foot',
            'label' => 'Foot',
          ),
        ),
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_5576349' => 
    array (
      'ID' => 'fld_5576349',
      'type' => 'number',
      'label' => 'What is the Length in %unit%?',
      'slug' => 'what_is_the_length_in_unit',
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
    'fld_1199327' => 
    array (
      'ID' => 'fld_1199327',
      'type' => 'number',
      'label' => 'What is the Width in %unit%',
      'slug' => 'what_is_the_width_in_unit',
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
    'fld_9887523' => 
    array (
      'ID' => 'fld_9887523',
      'type' => 'hidden',
      'label' => 'Inch to foot constant',
      'slug' => 'inch_to_foot_constant',
      'conditions' => 
      array (
        'type' => '',
      ),
      'config' => 
      array (
        'default' => 12,
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_87574' => 
    array (
      'ID' => 'fld_87574',
      'type' => 'calculation',
      'label' => 'Calculate Room Area in Foot',
      'slug' => 'calculate_room_area_in_foot',
      'conditions' => 
      array (
        'type' => 'con_5503921735588553',
      ),
      'config' => 
      array (
        'before' => 'Room Area is ',
        'after' => ' Square Footage',
        'formular' => ' ( fld_5576349*fld_1199327 ) ',
        'config' => 
        array (
          'group' => 
          array (
            0 => 
            array (
              'lines' => 
              array (
                0 => 
                array (
                  'operator' => '+',
                  'field' => 'fld_5576349',
                ),
                1 => 
                array (
                  'operator' => '*',
                  'field' => 'fld_1199327',
                ),
              ),
            ),
          ),
        ),
        'manual_formula' => '',
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_1517789' => 
    array (
      'ID' => 'fld_1517789',
      'type' => 'calculation',
      'label' => 'Calculate Room area in Inch',
      'slug' => 'calculate_room_area_in_inch',
      'conditions' => 
      array (
        'type' => 'con_6362905869429415',
      ),
      'config' => 
      array (
        'before' => 'Room area is ',
        'after' => ' Square Footage',
        'formular' => ' ( fld_5576349/fld_9887523 ) * ( fld_1199327/fld_9887523 ) ',
        'config' => 
        array (
          'group' => 
          array (
            0 => 
            array (
              'lines' => 
              array (
                0 => 
                array (
                  'operator' => '+',
                  'field' => 'fld_5576349',
                ),
                1 => 
                array (
                  'operator' => '/',
                  'field' => 'fld_9887523',
                ),
              ),
            ),
            1 => 
            array (
              'operator' => '*',
            ),
            2 => 
            array (
              'lines' => 
              array (
                0 => 
                array (
                  'operator' => '+',
                  'field' => 'fld_1199327',
                ),
                1 => 
                array (
                  'operator' => '/',
                  'field' => 'fld_9887523',
                ),
              ),
            ),
          ),
        ),
        'manual_formula' => '',
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
  ),
  'mailer' => 
  array (
    'on_insert' => 1,
    'sender_name' => 'Chatbot Forms Notification',
    'sender_email' => '',
    'recipients' => '',
    'email_subject' => 'Room Area Calculator',
  ),
  'conditional_groups' => 
  array (
    'conditions' => 
    array (
      'con_6362905869429415' => 
      array (
        'id' => 'con_6362905869429415',
        'name' => 'Room area in inch',
        'type' => 'show',
        'fields' => 
        array (
          'cl5645278523054865' => 'fld_3436416',
        ),
        'group' => 
        array (
          'rw7448176792525754' => 
          array (
            'cl5645278523054865' => 
            array (
              'parent' => 'rw7448176792525754',
              'field' => 'fld_3436416',
              'compare' => 'is',
              'value' => 'opt1542903',
            ),
          ),
        ),
      ),
      'con_5503921735588553' => 
      array (
        'id' => 'con_5503921735588553',
        'name' => 'Room area in Foot',
        'type' => 'show',
        'group' => 
        array (
          'rw5635012772474611' => 
          array (
            'cl2934998342200705' => 
            array (
              'parent' => 'rw5635012772474611',
              'field' => 'fld_3436416',
              'compare' => 'is',
              'value' => 'opt1771147',
            ),
          ),
        ),
        'fields' => 
        array (
          'cl2934998342200705' => 'fld_3436416',
        ),
      ),
    ),
  ),
  'variables' => 
  array (
    'keys' => 
    array (
      0 => 'unit',
    ),
    'values' => 
    array (
      0 => '%how_do_you_want_to_calculate_the_room_area%',
    ),
    'types' => 
    array (
      0 => 'static',
    ),
  ),
  'privacy_exporter_enabled' => false,
  'version' => '1.0.0',
);