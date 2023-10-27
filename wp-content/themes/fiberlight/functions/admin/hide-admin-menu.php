<?php
add_action('aor_admin_menu', 'remove_admin_menu_items');

add_action('admin_menu','aor_admin_menu');
function aor_admin_menu() {
  rename_admin_menu_section('Posts','Posts');
  remove_admin_menu_section('edit-comments.php');
  // remove_admin_menu_section('edit.php?post_type=page');
}

function aor_custom_menu_order($menu_ord) {
  if (!$menu_ord) return true;
  return array(
    'index.php', // Dashboard
    'edit.php?post_type=custom',
    'separator1', // First separator
    'edit.php', // Posts
    'edit.php?post_type=page',
    'separator2', // Second separator
    'upload.php', // Media
  );
}
add_filter('custom_menu_order', 'aor_custom_menu_order');
add_filter('menu_order', 'aor_custom_menu_order');
