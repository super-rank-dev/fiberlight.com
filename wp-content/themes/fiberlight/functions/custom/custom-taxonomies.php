<?php
/*
this is a function that serves as a very quick way to set up a new taxonomy with some default settings. to use it, uncomment the action below.
*/

function aor_custom_taxonomy_init() {

  aor_custom_taxonomy('Position', 'Positions', array('team-member') );
  aor_custom_taxonomy('Solution', 'Solutions', array('success-story', 'tech-spec', 'product-brief', 'resource') );
  aor_custom_taxonomy('Industry', 'Industries', array('success-story', 'tech-spec', 'product-brief', 'resource') );
  aor_custom_taxonomy('Region', 'Regions', array('success-story') );
  aor_custom_taxonomy('State', 'States', array('coverage-map') );
  aor_custom_taxonomy('Type', 'Types', array('resource', 'success-story') );

}
add_action('init', 'aor_custom_taxonomy_init');

function aor_custom_taxonomy($singular, $plural, $custom_posts_array) {
  $labels = array(
    'name'                       => $plural,
    'singular_name'              => $singular,
    'menu_name'                  => $plural,
    'all_items'                  => 'All ' . $plural,
    'parent_item'                => 'Parent ' . $singular,
    'parent_item_colon'          => 'Parent ' . $singular . ':',
    'new_item_name'              => 'New Item ' . $singular,
    'add_new_item'               => 'Add New ' . $singular,
    'edit_item'                  => 'Edit ' . $singular,
    'update_item'                => 'Update ' . $singular,
    'view_item'                  => 'View ' . $singular,
    'separate_items_with_commas' => 'Separate ' . $plural . ' with commas',
    'add_or_remove_items'        => 'Add or remove ' . $plural,
    'choose_from_most_used'      => 'Choose from the most used',
    'popular_items'              => 'Popular ' . $plural,
    'search_items'               => 'Search ' . $plural,
    'not_found'                  => 'Not Found',
    'no_terms'                   => 'No ' . $plural,
    'items_list'                 => 'Items list',
    'items_list_navigation'      => 'Items list navigation',
  );
  $args = array(
    'labels'                     => $labels,
    'hierarchical'               => true,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
  );
  register_taxonomy( $singular, $custom_posts_array, $args );
}