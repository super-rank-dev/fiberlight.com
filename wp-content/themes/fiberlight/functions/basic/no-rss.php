<?php
// no rss feed for static sites
function aor_disable_feed() {
  wp_die( __('No feed available,please visit our <a href="'. get_bloginfo('url') .'">homepage</a>!') );
}

add_action('do_feed', 'aor_disable_feed', 1);
add_action('do_feed_rdf', 'aor_disable_feed', 1);
add_action('do_feed_rss', 'aor_disable_feed', 1);
add_action('do_feed_rss2', 'aor_disable_feed', 1);
add_action('do_feed_atom', 'aor_disable_feed', 1);
