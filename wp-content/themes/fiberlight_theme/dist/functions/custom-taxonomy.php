<?php


function custom_taxonomy_init() {

  custom_taxonomy('Department', 'Departments', array('team-member') );
  custom_taxonomy('Solution', 'Solutions', array('success-story') );
  custom_taxonomy('Industries', 'Industries', array('success-story') );
  custom_taxonomy('Region', 'Regions', array('success-story') );
  custom_taxonomy('Type', 'Types', array('success-story') );
  custom_taxonomy('State', 'States', array('coverage-map') );

}
add_action('init', 'custom_taxonomy_init');

function custom_taxonomy($singular, $plural, $custom_posts_array) {
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