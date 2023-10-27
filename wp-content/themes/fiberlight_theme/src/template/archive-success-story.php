<?php
/**
 * @package WordPress
 * @subpackage Fiberlight Theme
 */

  $postType = 'success-story';
  $archiveTitle = get_field('success_story_title', 'option');
  $postHeroImage = get_field('success_story_hero', 'option');

  include(dirname(__DIR__).'/template-parts/archive-query.php'); 
  include(dirname(__DIR__).'/template-parts/archive-title.php'); 
  include(dirname(__DIR__).'/template-parts/archive-hero.php'); 
  include(dirname(__DIR__).'/template-parts/archive-list.php'); 

?>
