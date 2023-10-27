<?php
/*
this is a function that serves as a very quick way to set up a new post type with some default settings. to use it, uncomment the action below. for more customization, create a new function based on the function below called aor_add_advanced_post_type
*/

function aor_custom_post_init() {
  aor_add_simple_post_type("News", "News", "news", "company/news", true);
  aor_add_simple_post_type("Team Member", "Team Members", "team-member", "company/team-members", false);
  aor_add_simple_post_type("Testimonial", "Testimonials", "testimonial", "testimonials", false);
  aor_add_simple_post_type("Success Story", "Success Stories", "success-story", "resources/success-stories", false);
  //aor_add_simple_post_type("Product Brief", "Product Briefs", "product-brief", "product-briefs", false);
  //aor_add_simple_post_type("Tech Spec", "Tech Specs", "tech-spec", "tech-specs", false);
  aor_add_simple_post_type("Resource", "Resources", "resource", "resource", false);
  aor_add_simple_post_type("Coverage Map", "Coverage Maps", "coverage-map", "coverage-maps", false);
}
add_action('init', 'aor_custom_post_init');

function aor_add_simple_post_type($singular, $plural, $post_type_name, $slug, $archive) {

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
    'rewrite' => array('slug' => $slug, 'with_front' => false),
    'capability_type' => 'post',
    'hierarchical' => false,
    'has_archive' => $archive,
    'menu_position' => null,
    'supports' => array( 'title', 'editor', 'excerpt' )
  );

  register_post_type( $post_type_name , $args );
  flush_rewrite_rules();
}

/*
use the following function to add a customized post type

function aor_add_advanced_post_type()) {

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
add_action('init', 'aor_add_advanced_post_type');
*/
