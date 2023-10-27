<?php

add_action('pre_get_posts', 'nfg_query_offset', 1 );
function nfg_query_offset(&$query) {
	if ( ! $query->is_home() ) {
		return;
	}
	// define the offset here
	$offset = 1;
	$ppp = get_option('posts_per_page');
	if ( $query->is_paged ) {
		$page_offset = $offset + ( ($query->query_vars['paged']-1) * $ppp );
		$query->set('offset', $page_offset );
	}
	else {
		$query->set('offset',$offset);
	}
}

// function nfg_adjust_offset_pagination($found_posts, $query) {
// 	// define the offset here
//     $offset = 1;
// 	if ( $query->is_home() ) {
// 		return $found_posts - $offset;
// 	}
// 	return $found_posts;
// }
// add_filter('found_posts', 'nfg_adjust_offset_pagination', 1, 2 );