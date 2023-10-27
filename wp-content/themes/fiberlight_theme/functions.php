<?php
/**
 * @package WordPress
 * @subpackage Fiberlight Theme
 */


$theme = wp_get_theme();
define('THEME_VERSION', $theme->Version);

function fiberlight_setup() {
  // Add support for editor styles.
    add_theme_support( 'editor-styles' );

    // Enqueue editor styles.
	    add_editor_style( 'dist/css/main.min.css' );
}
add_action( 'after_setup_theme', 'fiberlight_setup' );



// Enqueue
require_once get_theme_file_path( 'dist/functions/custom-enqueue.php' );
// ACF
require_once get_theme_file_path( 'dist/functions/acf.php' );
// ACF Blocks
require_once get_theme_file_path( 'dist/functions/acf-blocks.php' );
// ACF Blocks
require_once get_theme_file_path( 'dist/functions/custom-block-categories.php' );
// Custom Post Types
require_once get_theme_file_path( 'dist/functions/custom-post-types.php' );
// Custom Taxonomy
require_once get_theme_file_path( 'dist/functions/custom-taxonomy.php' );
// Images
require_once get_theme_file_path( 'dist/functions/custom-images.php' );
// Pagination
//require_once get_theme_file_path( 'dist/functions/custom-pagination.php' );

// Changing excerpt length
function new_excerpt_length($length) {
  return 20;
  }
  add_filter('excerpt_length', 'new_excerpt_length');
   
  // Changing excerpt more
  function new_excerpt_more($more) {
  return '';
  }
  add_filter('excerpt_more', 'new_excerpt_more');


