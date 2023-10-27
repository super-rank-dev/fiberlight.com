<?php
/*
// remove defaulted body classes
add_filter('body_class', 'aor_body_class', 10, 2);
function aor_body_class($wp_classes, $extra_classes) {
    // list of the only WP generated classes allowed
   $whitelist = array('home', 'page', 'page-parent', 'page-child', 'single-post', 'error404');

   // filter the body classes
   $wp_classes = array_intersect($wp_classes, $whitelist);

   // add the extra classes back untouched
   return array_merge($wp_classes, (array) $extra_classes);
}


// add classes based on template name
add_filter('body_class','aor_custom_class_names');
function aor_custom_class_names($c) {
   is_page_template('page-templates/page-builder.php') ? $c[] = 'page-builder' : null;
   return $c;
}
**/
?>
