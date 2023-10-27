<?php
add_filter( 'block_categories_all' , function( $categories ) {

  // Adding a new category.
$categories[] = array(
  'slug'  => 'fiberlight',
  'title' => 'Fiberlight'
);

return $categories;
} );