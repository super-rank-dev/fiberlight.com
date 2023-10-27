<?php


function custom_post_init() {
  // add_simple_post_type("Case Study", "Case Studies", "case-study", "case-studies", false, true);
  add_simple_post_type("Coverage Map", "Coverage Maps", "coverage-map", "coverage-maps", false, true, false);
  add_simple_post_type("News", "News", "news", "news", true, true, false);
  add_simple_post_type("Resource", "Resources", "resource", "resources", true, true, false);
  add_simple_post_type("Services", "Services", "service", "services", false, false, true);
  add_simple_post_type("Stat", "Stats", "stat", "stats", false, false, true);
  add_simple_post_type("Success Story", "Success Stories", "success-story", "success-stories", true, true, false);
  add_simple_post_type("Team Member", "Team Members", "team-member", "team-members", false, false, false);
  add_simple_post_type("Testimonial", "Testimonials", "testimonial", "testimonials", false, false, true);
}
add_action('init', 'custom_post_init');

function add_simple_post_type($singular, $plural, $post_type_name, $slug, $archive, $block, $search) {

  if ( $slug == null ) {
    $slug = $post_type_name;
  }

  $labels = array(
    'name' => $singular,
    'singular_name' => $singular,
    'menu_name' => $plural,
    'add_new' => 'Add ' . $singular . '',
    'add_new_item' => 'Add New ' . $singular . '',
    'edit' => 'Edit',
    'edit_item' => 'Edit ' . $singular . '',
    'new_item' => 'New ' . $singular . '',
    'view' => 'View ' . $singular . '',
    'view_item' => 'View ' . $singular . '',
    'search_items' => 'Find ' . $plural . '',
    'not_found' => 'No ' . $plural . ' Found',
    'not_found_in_trash' => 'No ' . $plural . ' Found in Trash',
    'parent' => 'Parent ' . $singular . '',
  );

  $args = array( 'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array('slug' => $slug,'with_front' => false),
    // 'rewrite' => array('slug' => $slug),
    'capability_type' => 'post',
    'hierarchical' => true,
    'has_archive' => $archive,
    'exclude_from_search' => $search,
    'menu_position' => null,
    'show_in_rest' => $block,
    'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'revisions', 'page-attributes' )
  );

  register_post_type( $post_type_name , $args );
  flush_rewrite_rules();
}


/*
use the following function to add a customized post type

function add_advanced_post_type()) {

  $singuler = "Example";
  $plural = "Examples";
  $post_type_name = "example"

  $labels = array(
    'name' => $singular,
    'singular_name' => $singular,
    'menu_name' => $singular,
    'add_new' => 'Add ' . $singular . '',
    'add_new_item' => 'Add New ' . $singular . '',
    'edit' => 'Edit',
    'edit_item' => 'Edit ' . $singular . '',
    'new_item' => 'New ' . $singular . '',
    'view' => 'View ' . $singular . '',
    'view_item' => 'View ' . $singular . '',
    'search_items' => 'Add ' . $plural . '',
    'not_found' => 'No ' . $plural . ' Found',
    'not_found_in_trash' => 'No ' . $plural . ' Found in Trash',
    'parent' => 'Parent ' . $singular . '',
  );

  $args = array( 'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array( 'title' )
  );

  register_post_type( $post_type_name , $args );
  flush_rewrite_rules();

}
add_action('init', 'add_advanced_post_type');
*/
