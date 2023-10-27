<?php
$argsLatest = array(
  'paged' => null,
  'posts_per_page' => 1,
  'offset' => 0,
  'orderby' => 'post_date',
  'order' => 'DESC',
  'post_type' => $postType,
  'ignore_sticky_posts' => 1,
  'post_status' => 'publish'
);
$latestPost = new WP_Query( $argsLatest );

$current_page = get_query_var('paged');
$current_page = max( 1, $current_page );

$per_page = get_option( 'posts_per_page' );
$offset_start = 1;
$offset = ( $current_page - 1 ) * $per_page + $offset_start;

$argsPosts = array(
  'posts_per_page' => $per_page,
  'paged' => $current_page,
  'offset'  => $offset,
  'orderby' => 'post_date',
  'order' => 'DESC',
  'post_type' => $postType,
  'post_status' => 'publish',
);
$allPosts = new WP_Query( $argsPosts );

if(is_paged()):
  $noPad = 'blog-list-title-no-pad';
  $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
  $pageNumber = '- Page '. $paged;
else:
  $noPad = '';
  $paged = '';
endif;

$archivePage = 'Y';
$headerColor = get_field('header_color_resources', 'option');
if ($headerColor == 'dark') : $adjustHeader = 'makeHeaderDark'; endif;

?>