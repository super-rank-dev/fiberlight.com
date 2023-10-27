<?php
function aor_register_menus() {
  register_nav_menus(
    array(
    'menu-header' => __('Main Menu'),
    'menu-utility' => __('Utility Menu'),
    'footer-solutions' => __( 'Footer Solutions'),
    'footer-quick-links' => __( 'Footer Quick Links')
    )
  );
}

add_action('init', 'aor_register_menus');

