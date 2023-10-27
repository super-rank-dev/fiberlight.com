<?php
/**
 * @package WordPress
 * @subpackage Fiberlight Theme
 */

  $postType = 'post';
  $archiveTitle = get_field('blog_title', 'option');
  $postHeroImage = get_field('blog_hero', 'option');

  include(dirname(__DIR__).'/template-parts/archive-query-blog.php'); 
  include(dirname(__DIR__).'/template-parts/archive-title.php'); 
  include(dirname(__DIR__).'/template-parts/archive-hero.php'); 
  include(dirname(__DIR__).'/template-parts/archive-list.php'); 

?>
