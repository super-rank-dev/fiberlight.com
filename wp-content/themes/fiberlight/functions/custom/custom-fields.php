<?php
// load acf
include_once('custom-fields/acf/acf.php');

// Load an options page
include_once('custom-fields/options-init.php' );

// load style
add_filter('acf/settings/path', 'aor_acf_settings_path');
function aor_acf_settings_path( $path ) {
  $path = get_stylesheet_directory() . '/functions/custom/custom-fields/acf/';
  return $path;
}

// load settings
add_filter('acf/settings/dir', 'aor_acf_settings_dir');
function aor_acf_settings_dir( $dir ) {
  $dir = get_stylesheet_directory_uri() . '/functions/custom/custom-fields/acf/';
  return $dir;
}


/* custom save point
add_filter('acf/settings/save_json', 'aor_acf_json_save_point');
function aor_acf_json_save_point( $path ) {
  // update path
  $path = get_stylesheet_directory() . '/functions/custom/custom-fields/json';
  // return
  return $path;
}

// custom load path
add_filter('acf/settings/load_json', 'aor_acf_json_load_point');
function aor_acf_json_load_point( $paths ) {
  // remove original path (optional)
  unset($paths[0]);
  // append path
  $paths[] = get_stylesheet_directory() . '/functions/custom/custom-fields/json';
  // return
  return $paths;
}
*/

// confirm row delete for acf
function aor_acf_confirm_row_delete() { ?>
    <script type="text/javascript">
    (function($) {

        acf.add_action('ready', function(){

            $('body').on('click', 'li.acf-fc-show-on-hover a.acf-icon.-minus.small', function( e ){

                return confirm("Do you really want to delete this row?");

            });

        });

    })(jQuery);
    </script>

    <?php
}
add_action('acf/input/admin_head', 'aor_acf_confirm_row_delete');
