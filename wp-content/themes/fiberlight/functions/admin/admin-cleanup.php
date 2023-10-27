<?php
// Remove Dashboard Metaboxes
add_action('admin_init', 'aor_remove_dashboard_widgets');
function aor_remove_dashboard_widgets() {
  remove_meta_box('dashboard_right_now', 'dashboard', 'normal');        // right now
  remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');  // recent comments
  remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');   // incoming links
  remove_meta_box('dashboard_plugins', 'dashboard', 'normal');          // plugins
  remove_meta_box('dashboard_quick_press', 'dashboard', 'normal');      // quick press
  remove_meta_box('dashboard_recent_drafts', 'dashboard', 'normal');    // recent drafts
  remove_meta_box('dashboard_primary', 'dashboard', 'normal');          // wordpress blog
  remove_meta_box('dashboard_secondary', 'dashboard', 'normal');        // other wordpress news
  remove_meta_box('dashboard_activity', 'dashboard', 'normal');         // dashboard activity
  remove_meta_box('yoast_db_widget', 'dashboard', 'normal');            // Yoast's SEO Plugin Widget
}

// legacy remove meta
add_action( 'admin_menu' , 'aor_remove_metaboxes' );
function aor_remove_metaboxes() {
 remove_meta_box( 'postcustom' , 'page' , 'normal' );        //removes custom fields for page
 remove_meta_box( 'commentstatusdiv' , 'page' , 'normal' );  //removes comments status for page
 remove_meta_box( 'commentsdiv' , 'page' , 'normal' );       //removes comments for page
 remove_meta_box( 'authordiv' , 'page' , 'normal' );         //removes author for page
}

// Remove Smilies
add_filter('option_use_smilies','aor_remove_smileys',99,1);
function aor_remove_smileys($bool) {
  return false;
}

// Remove emoji
function disable_wp_emoji() {
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
  // filter to remove TinyMCE emojis
  add_filter( 'tiny_mce_plugins', 'disable_emoji_tinymce' );
}
add_action( 'init', 'disable_wp_emoji' );

function disable_emoji_tinymce( $plugins ) {
  if ( is_array( $plugins ) ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
  } else {
    return array();
  }
}

// Better SEO via TINYMce
add_filter('tiny_mce_before_init', 'aor_custom_tinymce' );
function aor_custom_tinymce($init) {
  // Add block format elements you want to show in dropdown
  $init['theme_advanced_blockformats'] = 'p,h2,h3,h4';
  $init['theme_advanced_disable'] = 'strikethrough,underline,pre,h1,help,separator,numlist,forecolor,justifyfull';
  return $init;
}

// remove junk from head
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'start_post_rel_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'adjacent_posts_rel_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

add_action('init', 'aor_rm_headlink');
function aor_rm_headlink() {
  remove_action('wp_head', 'rsd_link');
  remove_action('wp_head', 'wlwmanifest_link');
  remove_action('wp_head', 'index_rel_link');
  remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
}

add_filter( 'next_post_rel_link', 'aor_disable_stuff' );
function aor_disable_stuff( $data ) {
  return false;
}

// Remove Widgets
add_action('widgets_init', 'aor_unregister_default_wp_widgets', 1);
function aor_unregister_default_wp_widgets() {
  unregister_widget('WP_Widget_Calendar');
  unregister_widget('WP_Widget_Archives');
  unregister_widget('WP_Widget_Links');
  unregister_widget('WP_Widget_Meta');
  unregister_widget('WP_Widget_Categories');
  unregister_widget('WP_Widget_Recent_Posts');
  unregister_widget('WP_Widget_Recent_Comments');
  unregister_widget('WP_Widget_RSS');
  unregister_widget('WP_Widget_Tag_Cloud');
}

//  Stop WordPress from using the sticky class, and style WordPress sticky posts using the .wp-sticky class instead
function aor_remove_sticky_class($classes) {
  if(in_array('sticky', $classes)) {
    $classes = array_diff($classes, array("sticky"));
    $classes[] = 'wp-sticky';
  }

  return $classes;
}
add_filter('post_class','aor_remove_sticky_class');
