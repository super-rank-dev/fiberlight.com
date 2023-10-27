<?php
require_once ('functions/theming/theme-assets-enqueue.php');         // Enqueue CSS and JS
require_once ('functions/theming/theme-support.php');                // Theme Support
require_once ('functions/theming/optional-plugins.php');             // Functions to add different scripts to the page
require_once ('functions/theming/menu-walker.php');

require_once ('functions/basic/security.php');                       // Security helpers
require_once ('functions/basic/remove-plugin-update-nag.php');       // Only nag activated plugins
require_once ('functions/basic/no-rss.php');                         // No RSS for static sites

require_once ('functions/admin/wp-admin-menu-classes.php');          // Ability to edit admin menu
require_once ('functions/admin/editor-style.php');                   // Load the site css as the editor style
require_once ('functions/admin/admin-panel.php');                    // Custom splash panel
require_once ('functions/admin/admin-styles.php');                   // Custom admin css styling
require_once ('functions/admin/admin-custom-pages.php');

require_once ('functions/admin/admin-functions.php');                // Custom functions and plugins
require_once ('functions/admin/admin-cleanup.php');                  // Cleanup Admin Area
require_once ('functions/admin/no-theme-edit.php');                  // Remove ability to edit themes via wp
require_once ('functions/admin/hide-admin-menu.php');                // Hide unused menu items

require_once ('functions/custom/custom-functions.php');              // Custom functions
require_once ('functions/custom/custom-posts.php');                  // Register new post types
require_once ('functions/custom/custom-fields.php');
require_once ('functions/custom/custom-taxonomies.php');
require_once ('functions/custom/custom-admin-menu.php');
require_once ('functions/custom/custom-menus.php');                 // Custom Fields
require_once ('functions/custom/custom-image-sizes.php');            // Custom Image Sizes & Post Thumbnails

require_once ('functions/custom/custom-tinymce-base-edit.php');      // Cleans up tinymce
require_once ('functions/custom/custom-tinymce-items.php');          // Add additional tinymce menu items
require_once ('functions/custom/custom-body-class.php');             // Cleanup body class names and add custom

require_once ('functions/theming/theme-typekit.php');                // Typekit

require_once ('functions/theming/acf-clone-groups.php');
// Functions for default behavior or clone groups

require_once ('functions/custom/theme-specific.php');                // This is where custom theme functions go
