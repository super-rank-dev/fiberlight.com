<?php

add_theme_support( 'post-thumbnails' );

add_action( 'after_setup_theme', 'fl_custom_add_image_sizes' );

function fl_custom_add_image_sizes() {

  //Image Sizes for Full Height Background Images
  add_image_size( 'bg-full-height-xxl', 1920, 1080, array( 'center', 'center' ) );
  add_image_size( 'bg-full-height-xl', 1366, 768, array( 'center', 'center' ) );
  add_image_size( 'bg-full-height-lg', 1280, 1024, array( 'center', 'center' ) );
  add_image_size( 'bg-full-height-md', 768, 1024, array( 'center', 'center' ) );
  add_image_size( 'bg-full-height-xs', 562, 1218, array( 'center', 'center' ) );

  //Image Sizes for Half Height Background Images
  add_image_size( 'bg-half-height-xxl', 1920, 604, array( 'center', 'center' ) );
  add_image_size( 'bg-half-height-xl', 1366, 384, array( 'center', 'center' ) );
  add_image_size( 'bg-half-height-lg', 1280, 512, array( 'center', 'center' ) );
  add_image_size( 'bg-half-height-md', 768, 512, array( 'center', 'center' ) );
  add_image_size( 'bg-half-height-xs', 562, 609, array( 'center', 'center' ) );

  //Team Member Single Page Headshot
  add_image_size( 'headshot-single-xxl', 236, 260, array( 'center', 'top' ) );
  add_image_size( 'headshot-single-xl', 199, 230, array( 'center', 'top' ) );
  add_image_size( 'headshot-single-md', 141, 160, array( 'center', 'top' ) );
  add_image_size( 'headshot-single-xs', 291, 360, array( 'center', 'top' ) );

  //Team Member Block Single
  add_image_size( 'headshot-single-block-xxl', 324, 360, array( 'center', 'top' ) );
  add_image_size( 'headshot-single-block-xl', 279, 310, array( 'center', 'top' ) );
  add_image_size( 'headshot-single-block-lg', 234, 260, array( 'center', 'top' ) );
  add_image_size( 'headshot-single-block-md', 174, 194, array( 'center', 'top' ) );
  add_image_size( 'headshot-single-block-xs', 351, 392, array( 'center', 'top' ) );

  //Team Member Block List
  add_image_size( 'headshot-list-block-xxl', 175, 195, array( 'center', 'top' ) );
  add_image_size( 'headshot-list-block-xl', 150, 167, array( 'center', 'top' ) );
  add_image_size( 'headshot-list-block-lg', 140, 164, array( 'center', 'top' ) );
  add_image_size( 'headshot-list-block-md', 102, 120, array( 'center', 'top' ) );


  //Blog List Hero
  add_image_size( 'blog-list-hero-xxl', 1232, 400, array( 'center', 'center' ) );
  add_image_size( 'blog-list-hero-xl', 1061, 400, array( 'center', 'center' ) );
  add_image_size( 'blog-list-hero-lg', 890, 400, array( 'center', 'center' ) );
  add_image_size( 'blog-list-hero-md', 662, 400, array( 'center', 'center' ) );
  add_image_size( 'blog-list-hero-xs', 334, 206, array( 'center', 'center' ) );

  //Blog List
  add_image_size( 'blog-list-xxl', 633, 340, array( 'center', 'center' ) );
  add_image_size( 'blog-list-xl', 543, 340, array( 'center', 'center' ) );
  add_image_size( 'blog-list-lg', 453, 340, array( 'center', 'center' ) );
  add_image_size( 'blog-list-md', 333, 340, array( 'center', 'center' ) );
  add_image_size( 'blog-list-xs', 351, 140, array( 'center', 'center' ) );

  //Slider List
  add_image_size( 'slider-xxl', 252, 372, array( 'center', 'center' ) );
  add_image_size( 'slider-lg', 190, 262, array( 'center', 'center' ) );
  add_image_size( 'slider-xs', 345, 140, array( 'center', 'center' ) );

  //News Card
  add_image_size( 'news-card-xxl', 416, 170, array( 'center', 'center' ) );
  add_image_size( 'news-card-md', 216, 90, array( 'center', 'center' ) );
  add_image_size( 'news-card-xs', 315, 140, array( 'center', 'center' ) );

  //Image Fluid
  add_image_size( 'image-fluid-xxl', 1920, FALSE );
  add_image_size( 'image-fluid-xl', 1400, FALSE );
  add_image_size( 'image-fluid-lg', 1200, FALSE );
  add_image_size( 'image-fluid-md', 993, FALSE );
  add_image_size( 'image-fluid-xs', 575, FALSE );


  //Image Sizes for Full Page Stats Right Side Image
  add_image_size( 'hero-slide-stats-xxl', 636, 300, TRUE );
  add_image_size( 'hero-slide-stats-xs', 366, 200, TRUE );

  add_image_size( 'scroll-hero-xxl', 0, 350, FALSE );

  //ACF Image Preview
  add_image_size( 'acf-image-preview', 0, 200, FALSE );


}


function responsive_image( $image, $image_size ) {
  if ($image && $image_size){
    $imageSize = $image_size;
    $imagePath = $image['sizes'][ $imageSize ];
    return $imagePath;
  }
}