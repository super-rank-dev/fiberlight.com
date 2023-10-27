<?php
// Dereg GF scripts
//add_action("gform_enqueue_scripts", "aor_deregister_scripts");
function aor_deregister_scripts(){
  wp_deregister_script("jquery");
}

// Load vendor js
if( !is_admin()){
  function aor_enqueue_scripts() {
    wp_deregister_script('jquery');
    
    
    
    wp_register_script('jquery', (get_template_directory_uri() . "/scripts/jquery.min.js"), array(), '1.10.2');
    wp_enqueue_script('jquery');

    //wp_register_script('modernizr', (get_template_directory_uri() . "/scripts/modernizr.min.js"), array(), '2.8.2', true);
    //wp_enqueue_script('modernizr');

    //wp_deregister_script('foundation');
    //wp_register_script('foundation', (get_template_directory_uri() . "/scripts/foundation.min.js"), array(), '6.2.3', true);
    //wp_enqueue_script('foundation');
    
    wp_register_script('javascript', (get_template_directory_uri() . "/scripts/javascript.min.js"), array(), '1', true);
    wp_enqueue_script('javascript');
  }

  add_action('wp_enqueue_scripts', 'aor_enqueue_scripts');
}

// Load theme js & css
add_action( 'wp_enqueue_scripts', 'aor_theme_js_css' );
function aor_theme_js_css() {
  wp_enqueue_style( 'stylesheet', get_template_directory_uri() . '/styles/style.css' );
  //wp_enqueue_script( 'application', get_template_directory_uri() . '/scripts/application.min.js', array(), '1.0.0', true );

  if (get_field('google_fonts','options')):

	  while(has_sub_field('google_fonts','options')):

      wp_enqueue_style( get_sub_field('font_name'), get_sub_field('font_url') );

	  endwhile;

  endif;
  // change the fonts here

  wp_enqueue_style( 'stylesheet', get_template_directory_uri() . '/styles/style.css' );
}

// Register icons
add_action('wp_head', 'aor_theme_favicons');
function aor_theme_favicons() {

  if ( get_field('favicon', 'options' ) ) :
    echo '<link rel="shortcut icon" type="image/x-icon" href="'. get_field('favicon','options')['url'] . '"/>';
  endif;

}

// Add First Meaningful Paint CSS
add_action('wp_head', 'aor_first_meaningful_paint');
function aor_first_meaningful_paint() {
?>
  
<style>
<?php include get_template_directory() . '/styles/first-meaningful-paint.css'; ?>
</style>
  
<?php
}
