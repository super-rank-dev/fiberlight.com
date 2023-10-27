<?php
/**
 * @package WordPress
 * @subpackage Fiberlight Theme
 */

//  $title = get_field('map_title');
// if (get_field('header_image')) :
//   $heroImage = get_field('header_image');
//   $heroImageALT = $heroImage['alt'];
// else:
//   $heroImage = get_field('map_hero', 'options');
//   $heroImageALT = $heroImage['alt'];
// endif;

	
 ?>

<!-- <article <?php post_class() ?> id="post-<?php the_ID(); ?>"> -->

  <!-- <section class="post-hero has-fl-dark-blue-background">
    <?php include(dirname(__DIR__).'/template-parts/acf/clone/hero-image.php'); ?>
    <div class="container h-100">
      <div class="row align-items-center h-100">
        <div class="col-11">
          <p class="date"><?php if ($title) : echo $title; else: echo 'Coverage Map'; endif; ?></p>
          <h1><?php the_title(); ?></h1>
          <?php if ($subHeading) : echo '<h2>'. $subHeading .''; endif; ?>
        </div>
      </div>
    </div>
  </section> -->

  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php the_content('<p class="serif">Hmm, there is no content here.</p>'); ?>
  <?php endwhile; endif; ?>

<!-- </article> -->

