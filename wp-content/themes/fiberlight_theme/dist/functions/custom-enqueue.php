<?php

function theme_styles() 
{

  wp_enqueue_style('fl-main', get_template_directory_uri() .'/dist/css/main.min.css', array(), THEME_VERSION, 'all' );
  wp_enqueue_script('fl-vendors', get_template_directory_uri() . '/dist/js/vendors.min.js', array('jquery'), THEME_VERSION, true );
  wp_enqueue_script('fl-main', get_template_directory_uri() . '/dist/js/main.min.js', array('jquery'), THEME_VERSION, true );

  if ( is_front_page() ) {
    wp_enqueue_style('fl-front-page', get_template_directory_uri() .'/dist/css/template/front-page.min.css', array(), THEME_VERSION, 'all' );
    wp_enqueue_script('fl-front-page', get_template_directory_uri() . '/dist/js/front-page.min.js', array('jquery'), THEME_VERSION, true );
  }

  if ( (!is_front_page() && is_home()) || is_archive() ) {
    wp_enqueue_style('fl-blog', get_template_directory_uri() .'/dist/css/template/blog.min.css', array(), THEME_VERSION, 'all' );
    // wp_enqueue_script('fl-front-page', get_template_directory_uri() . '/dist/js/front-page.min.js', array('jquery'), THEME_VERSION, false );
  }

  if ( is_page() && !is_front_page() ) {
    wp_enqueue_style('fl-page', get_template_directory_uri() .'/dist/css/template/page.min.css', array(), THEME_VERSION, 'all' );
    // wp_enqueue_script('fl-page', get_template_directory_uri() . '/dist/js/page.min.js', array('jquery'), THEME_VERSION, true );
  }

  if ( is_singular() && !is_front_page() ) {
    wp_enqueue_style('fl-single', get_template_directory_uri() .'/dist/css/template/single.min.css', array(), THEME_VERSION, 'all' );
    // wp_enqueue_script('fl-page', get_template_directory_uri() . '/dist/js/page.min.js', array('jquery'), THEME_VERSION, true );
  }

  if ( is_404() ) {
    wp_enqueue_style('fl-error', get_template_directory_uri() .'/dist/css/template/error.min.css', array(), THEME_VERSION, 'all' );
  }

  if ( is_search() ) {
    wp_enqueue_style('fl-error', get_template_directory_uri() .'/dist/css/template/search.min.css', array(), THEME_VERSION, 'all' );
  }

  if ( is_singular( $post_types = 'team-member' ) ) {
    wp_enqueue_style('fl-team-member', get_template_directory_uri() .'/dist/css/template/single-team-member.min.css', array(), THEME_VERSION, 'all' );
  }



}
add_action( 'wp_enqueue_scripts', 'theme_styles' );

function enqueuing_admin_scripts(){
  wp_enqueue_style('admin-css', get_template_directory_uri().'/dist/css/admin.min.css');
  //wp_enqueue_script('admin-vimeo', 'https://player.vimeo.com/api/player.js');
}
add_action( 'admin_enqueue_scripts', 'enqueuing_admin_scripts' );

