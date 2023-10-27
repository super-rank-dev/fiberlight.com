<?php 

return array (
  '_last_updated' => 'Tue, 01 Oct 2019 09:18:32 +0000',
  'ID' => 'bmr-calculator',
  'wfb_version' => '1.0.0',
  'name' => 'BMR Calculator',
  'command' => 'BMR',
  'layout_grid' => 
  array (
    'fields' => 
    array (
      'fld_6884671' => '1:1',
      'fld_8932904' => '1:1',
      'fld_3862867' => '1:1',
      'fld_8430126' => '1:1',
      'fld_5569683' => '1:1',
      'fld_127633' => '1:1',
      'fld_8458147' => '1:1',
      'fld_2594618' => '1:1',
      'fld_504733' => '1:1',
      'fld_8527998' => '1:1',
      'fld_9439022' => '1:1',
      'fld_3979129' => '1:1',
      'fld_3820706' => '1:1',
      'fld_3377000' => '1:1',
      'fld_1008651' => '1:1',
      'fld_6358808' => '1:1',
    ),
    'structure' => '12',
  ),
  'fields' => 
  array (
    'fld_6884671' => 
    array (
      'ID' => 'fld_6884671',
      'type' => 'html',
      'label' => 'Welcome Message',
      'slug' => 'html_fld_6884671',
      'conditions' => 
      array (
        'type' => '',
      ),
      'config' => 
      array (
        'default' => 'Welcome To our BMR & Calorie calculator!',
      ),
    ),
    'fld_8932904' => 
    array (
      'ID' => 'fld_8932904',
      'type' => 'dropdown',
      'label' => 'What is your gender?',
      'slug' => 'what_is_your_gender',
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
          'opt1285013' => 
          array (
            'calc_value' => 'Male',
            'value' => 'Male',
            'label' => 'Male',
          ),
          'opt1319330' => 
          array (
            'calc_value' => 'Female',
            'value' => 'Female',
            'label' => 'Female',
          ),
        ),
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_3862867' => 
    array (
      'ID' => 'fld_3862867',
      'type' => 'number',
      'label' => 'What is your weight in KG?',
      'slug' => 'what_is_your_weight_in_kg',
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
    'fld_8430126' => 
    array (
      'ID' => 'fld_8430126',
      'type' => 'hidden',
      'label' => 'matrix weight constant',
      'slug' => 'matrix_weight_constant',
      'conditions' => 
      array (
        'type' => '',
      ),
      'config' => 
      array (
        'default' => 10,
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_5569683' => 
    array (
      'ID' => 'fld_5569683',
      'type' => 'number',
      'label' => 'What is your height in cm?',
      'slug' => 'what_is_your_height_in_cm',
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
    'fld_127633' => 
    array (
      'ID' => 'fld_127633',
      'type' => 'hidden',
      'label' => 'matrix height constant',
      'slug' => 'matrix_height_constant',
      'conditions' => 
      array (
        'type' => '',
      ),
      'config' => 
      array (
        'default' => 6.25,
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_8458147' => 
    array (
      'ID' => 'fld_8458147',
      'type' => 'number',
      'label' => 'What is your age in years?',
      'slug' => 'what_is_your_age',
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
    'fld_2594618' => 
    array (
      'ID' => 'fld_2594618',
      'type' => 'hidden',
      'label' => 'matrix age constant',
      'slug' => 'matrix_age_constant',
      'conditions' => 
      array (
        'type' => '',
      ),
      'config' => 
      array (
        'default' => 5,
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_504733' => 
    array (
      'ID' => 'fld_504733',
      'type' => 'hidden',
      'label' => 'matrix male constant',
      'slug' => 'matrix_male_constant',
      'conditions' => 
      array (
        'type' => 'con_5505955376904729',
      ),
      'config' => 
      array (
        'default' => 5,
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_8527998' => 
    array (
      'ID' => 'fld_8527998',
      'type' => 'hidden',
      'label' => 'matrix female constant',
      'slug' => 'matrix_female_constant',
      'conditions' => 
      array (
        'type' => 'con_483537721133843',
      ),
      'config' => 
      array (
        'default' => 161,
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_9439022' => 
    array (
      'ID' => 'fld_9439022',
      'type' => 'calculation',
      'label' => 'Calculate BMR Value',
      'slug' => 'calculate_bmr_value_male',
      'conditions' => 
      array (
        'type' => 'con_9403466769230205',
      ),
      'config' => 
      array (
        'before' => 'Your BMR is',
        'after' => '',
        'formular' => ' ( fld_8430126*fld_3862867 ) + ( fld_127633*fld_5569683 ) - ( fld_2594618*fld_8458147 ) +fld_504733',
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
                  'field' => 'fld_8430126',
                ),
                1 => 
                array (
                  'operator' => '*',
                  'field' => 'fld_3862867',
                ),
              ),
            ),
            1 => 
            array (
              'operator' => '+',
            ),
            2 => 
            array (
              'lines' => 
              array (
                0 => 
                array (
                  'operator' => '+',
                  'field' => 'fld_127633',
                ),
                1 => 
                array (
                  'operator' => '*',
                  'field' => 'fld_5569683',
                ),
              ),
            ),
            3 => 
            array (
              'operator' => '-',
            ),
            4 => 
            array (
              'lines' => 
              array (
                0 => 
                array (
                  'operator' => '+',
                  'field' => 'fld_2594618',
                ),
                1 => 
                array (
                  'operator' => '*',
                  'field' => 'fld_8458147',
                ),
              ),
            ),
            5 => 
            array (
              'operator' => '+',
            ),
            6 => 
            array (
              'lines' => 
              array (
                0 => 
                array (
                  'operator' => '+',
                  'field' => 'fld_504733',
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
    'fld_3979129' => 
    array (
      'ID' => 'fld_3979129',
      'type' => 'calculation',
      'label' => 'Calculate BMR Value',
      'slug' => 'calculate_bmr_value_female',
      'conditions' => 
      array (
        'type' => 'con_6518678538202287',
      ),
      'config' => 
      array (
        'before' => 'Your BMR is',
        'after' => '',
        'formular' => ' ( fld_8430126*fld_3862867 ) + ( fld_127633*fld_5569683 ) - ( fld_2594618*fld_8458147 ) -fld_8527998',
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
                  'field' => 'fld_8430126',
                ),
                1 => 
                array (
                  'operator' => '*',
                  'field' => 'fld_3862867',
                ),
              ),
            ),
            1 => 
            array (
              'operator' => '+',
            ),
            2 => 
            array (
              'lines' => 
              array (
                0 => 
                array (
                  'operator' => '+',
                  'field' => 'fld_127633',
                ),
                1 => 
                array (
                  'operator' => '*',
                  'field' => 'fld_5569683',
                ),
              ),
            ),
            3 => 
            array (
              'operator' => '-',
            ),
            4 => 
            array (
              'lines' => 
              array (
                0 => 
                array (
                  'operator' => '+',
                  'field' => 'fld_2594618',
                ),
                1 => 
                array (
                  'operator' => '*',
                  'field' => 'fld_8458147',
                ),
              ),
            ),
            5 => 
            array (
              'operator' => '-',
            ),
            6 => 
            array (
              'lines' => 
              array (
                0 => 
                array (
                  'operator' => '+',
                  'field' => 'fld_8527998',
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
    'fld_3820706' => 
    array (
      'ID' => 'fld_3820706',
      'type' => 'html',
      'label' => 'html__fld_3820706',
      'slug' => 'html_fld_3820706',
      'conditions' => 
      array (
        'type' => '',
      ),
      'config' => 
      array (
        'default' => '<h2>Activity Level</h2>
<ul>
<li><b>1.2</b> -> If you are sedentary (little or no exercise)</li>
<li><b>1.375</b> -> If you are lightly active (light exercise or sports 1-3 days/week)</li>
<li><b>1.55</b> -> If you are moderately active (moderate exercise 3-5 days/week)</li>
<li><b>1.725</b> -> If you are very active (hard exercise 6-7 days/week)</li>
<li><b>1.9</b> -> If you are super active (very hard exercise and a physical job)</li>
</ul>',
      ),
    ),
    'fld_3377000' => 
    array (
      'ID' => 'fld_3377000',
      'type' => 'dropdown',
      'label' => 'Please select your activity level',
      'slug' => 'please_select_your_activity_level',
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
          'opt1281529' => 
          array (
            'calc_value' => 1.2,
            'value' => 1.2,
            'label' => 1.2,
          ),
          'opt1817719' => 
          array (
            'calc_value' => 1.375,
            'value' => 1.375,
            'label' => 1.375,
          ),
          'opt1132879' => 
          array (
            'calc_value' => 1.55,
            'value' => 1.55,
            'label' => 1.55,
          ),
          'opt1737865' => 
          array (
            'calc_value' => 1.725,
            'value' => 1.725,
            'label' => 1.725,
          ),
          'opt2044239' => 
          array (
            'calc_value' => 1.9,
            'value' => 1.9,
            'label' => 1.9,
          ),
        ),
        'email_identifier' => 0,
        'personally_identifying' => 0,
      ),
    ),
    'fld_1008651' => 
    array (
      'ID' => 'fld_1008651',
      'type' => 'calculation',
      'label' => 'Calorie Calculation',
      'slug' => 'calorie_calculation_male',
      'conditions' => 
      array (
        'type' => 'con_841481853948283',
      ),
      'config' => 
      array (
        'before' => 'Your total ',
        'after' => ' Calories required.',
        'formular' => ' ( fld_9439022*fld_3377000 ) ',
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
                  'field' => 'fld_9439022',
                ),
                1 => 
                array (
                  'operator' => '*',
                  'field' => 'fld_3377000',
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
    'fld_6358808' => 
    array (
      'ID' => 'fld_6358808',
      'type' => 'calculation',
      'label' => 'Calorie Calculation',
      'slug' => 'calorie_calculation_female',
      'conditions' => 
      array (
        'type' => 'con_6996611498667324',
      ),
      'config' => 
      array (
        'before' => 'Your total ',
        'after' => ' Calories required in a day.',
        'formular' => ' ( fld_3979129*fld_3377000 ) ',
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
                  'field' => 'fld_3979129',
                ),
                1 => 
                array (
                  'operator' => '*',
                  'field' => 'fld_3377000',
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
    'email_subject' => 'BMR Calculator',
  ),
  'conditional_groups' => 
  array (
    'conditions' => 
    array (
      'con_5505955376904729' => 
      array (
        'id' => 'con_5505955376904729',
        'name' => 'Male constant',
        'type' => 'show',
        'fields' => 
        array (
          'cl9613241020649412' => 'fld_8932904',
        ),
        'group' => 
        array (
          'rw2946284927370137' => 
          array (
            'cl9613241020649412' => 
            array (
              'parent' => 'rw2946284927370137',
              'field' => 'fld_8932904',
              'compare' => 'is',
              'value' => 'opt1285013',
            ),
          ),
        ),
      ),
      'con_483537721133843' => 
      array (
        'id' => 'con_483537721133843',
        'name' => 'Female Constant',
        'type' => 'show',
        'fields' => 
        array (
          'cl9890693061877503' => 'fld_8932904',
        ),
        'group' => 
        array (
          'rw911857811340647' => 
          array (
            'cl9890693061877503' => 
            array (
              'parent' => 'rw911857811340647',
              'field' => 'fld_8932904',
              'compare' => 'is',
              'value' => 'opt1319330',
            ),
          ),
        ),
      ),
      'con_9403466769230205' => 
      array (
        'id' => 'con_9403466769230205',
        'name' => 'BMR Matrix Male',
        'type' => 'show',
        'fields' => 
        array (
          'cl669878610002212' => 'fld_8932904',
        ),
        'group' => 
        array (
          'rw4478690216184989' => 
          array (
            'cl669878610002212' => 
            array (
              'parent' => 'rw4478690216184989',
              'field' => 'fld_8932904',
              'compare' => 'is',
              'value' => 'opt1285013',
            ),
          ),
        ),
      ),
      'con_6518678538202287' => 
      array (
        'id' => 'con_6518678538202287',
        'name' => 'BMR Matrix Female',
        'type' => 'show',
        'fields' => 
        array (
          'cl8072942881891872' => 'fld_8932904',
        ),
        'group' => 
        array (
          'rw4885543081769956' => 
          array (
            'cl8072942881891872' => 
            array (
              'parent' => 'rw4885543081769956',
              'field' => 'fld_8932904',
              'compare' => 'is',
              'value' => 'opt1319330',
            ),
          ),
        ),
      ),
      'con_841481853948283' => 
      array (
        'id' => 'con_841481853948283',
        'name' => 'Calorie Matrix Male',
        'type' => 'show',
        'fields' => 
        array (
          'cl33502052846067' => 'fld_8932904',
        ),
        'group' => 
        array (
          'rw7664412186581242' => 
          array (
            'cl33502052846067' => 
            array (
              'parent' => 'rw7664412186581242',
              'field' => 'fld_8932904',
              'compare' => 'is',
              'value' => 'opt1285013',
            ),
          ),
        ),
      ),
      'con_6996611498667324' => 
      array (
        'id' => 'con_6996611498667324',
        'name' => 'Calorie Matrix Female',
        'type' => 'show',
        'fields' => 
        array (
          'cl9925870615148496' => 'fld_8932904',
        ),
        'group' => 
        array (
          'rw7661972839207607' => 
          array (
            'cl9925870615148496' => 
            array (
              'parent' => 'rw7661972839207607',
              'field' => 'fld_8932904',
              'compare' => 'is',
              'value' => 'opt1319330',
            ),
          ),
        ),
      ),
    ),
  ),
  'privacy_exporter_enabled' => false,
  'version' => '1.0.0',
);