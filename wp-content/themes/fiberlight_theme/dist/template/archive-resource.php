<?php
/**
 * @package WordPress
 * @subpackage Fiberlight Theme
 */

  $postType = 'resource';
  $archiveTitle = get_field('resource_title', 'option');
  $postHeroImage = get_field('resource_hero', 'option');

  include(dirname(__DIR__).'/template-parts/archive-query.php'); 
  include(dirname(__DIR__).'/template-parts/archive-title.php'); 
  include(dirname(__DIR__).'/template-parts/archive-hero.php'); 
  include(dirname(__DIR__).'/template-parts/archive-list.php'); 

?>
