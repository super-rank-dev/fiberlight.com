<?php
if( function_exists('acf_add_options_page') ) {
  acf_add_options_page(array(
    'page_title'  => 'Options',
    'menu_title'  => 'Options',
    'menu_slug'   => 'options',
    'capability'  => 'manage_options',
    'redirect'    => false
  ));
}
