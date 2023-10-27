<?php

//Hide ACF outside of development
// if($_SERVER['REMOTE_ADDR']!='127.0.0.1'){
//     add_filter('acf/settings/show_admin', '__return_false');
// }


add_action('acf/input/admin_head', 'my_acf_admin_head');
function my_acf_admin_head() {
?>
<link rel="stylesheet" href="<?php echo get_bloginfo( 'stylesheet_directory' ); ?>/dist/css/acf/acf-admin.min.css">


<?php
  
}

add_filter('acf/settings/save_json', 'my_acf_json_save_point');
 
function my_acf_json_save_point( $path ) {
    // update path
    $path = get_stylesheet_directory() . '/src/acf-json';
    // return
    return $path;
}
add_filter('acf/settings/load_json', 'my_acf_json_load_point');

function my_acf_json_load_point( $paths ) { 
    // remove original path (optional)
    unset($paths[0]);
    // append path
    $paths[] = get_stylesheet_directory() . '/dist/acf-json';
    // return
    return $paths;
    
}

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Theme General Settings',
		'menu_title'	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'redirect'		=> false
	));
    acf_add_options_page(array(
		'page_title' 	=> 'Theme Navigation',
		'menu_title'	=> 'Theme Navigation',
		'menu_slug' 	=> 'theme-navigation',
		'redirect'		=> false
	));
}
