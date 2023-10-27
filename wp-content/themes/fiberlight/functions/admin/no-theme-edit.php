<?php

# Remove theme editor
define( 'DISALLOW_FILE_EDIT', true );

# Make WP use 'direct' dowload method for install/update
define('FS_METHOD', 'direct');


// If you want to lockdown the themes and plugins from pesky admins
if ( file_exists( dirname( __FILE__ ) . '/../../../../../prevent_edit' ) ) {
  define('DISALLOW_FILE_MODS',true);
} else {
 // nothing
}
