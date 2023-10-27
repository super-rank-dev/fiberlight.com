<?php
/**
 * @package WordPress
 * @subpackage Fiberlight Theme
 */

get_template_part('dist/template-parts/header'); 


if ( is_front_page() ):
  get_template_part( 'dist/template/front-page' );
elseif ( !is_front_page() && is_home() ) :
  get_template_part( 'dist/template/blog' );
elseif ( is_page() ) :
  get_template_part( 'dist/template/page' );
elseif ( is_search() ):
  get_template_part( 'dist/template/search' );
elseif ( is_404() ):
  get_template_part( 'dist/template/error' );
elseif ( is_post_type_archive() ):
  $postType = $wp_query->query['post_type'];
  get_template_part( 'dist/template/archive-' . $postType );
elseif ( is_singular() ):
  $postType = get_post_type();
  get_template_part( 'dist/template/single-' . $postType );
  else :
    echo "Blank";
endif;


get_template_part('dist/template-parts/footer'); ?>


