<?php

$subHeading = get_field('subheading');
$singlePage = 'Y';

if (get_field('header_image') || get_field('header_image_tablet') || get_field('header_image_mobile')) :
  $heroImage = get_field('header_image');
  $heroImageTablet = get_field('hero_image_tablet');
  $heroImageMobile = get_field('header_image_mobile');
  $heroImageAlt = $heroImage['alt'];

  $objectFitDesktop = get_field('object_fit_desktop');
  $objectFitTablet = get_field('object_fit_tablet');
  $objectFitMobile = get_field('object_fit_mobile');
  $objectPositionDesktop = get_field('object_position_desktop');
  $objectPositionTablet = get_field('object_position_tablet');
  $objectPositionMobile = get_field('object_position_mobile');

else:
  $heroImage = get_field('featured_image', 'options');
  $heroImageAlt = $heroImage['alt'];
endif;
	
 ?>

<article <?php post_class() ?> id="post-<?php the_ID(); ?>">

  <section class="post-hero has-fl-tan-background-color has-background">
    <?php include(dirname(__DIR__).'/template-parts/acf/clone/hero-image.php'); ?>
    <div class="container h-100">
      <div class="row align-items-end align-items-md-center h-100">
        <div class="col-12 col-md-7 col-lg-6">
          <div class="title-wrap text-center text-md-start">
            <p class="date"><?php the_time('l, F jS, Y' ); ?></p>
            <h1><?php the_title(); ?></h1>
            <?php if ($subHeading) : echo '<h3 class="subheading">'. $subHeading .'</h3>'; endif; ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class="post-content has-fl-tan-background-color has-background">

            <?php the_content('<p class="serif">Hmm, there is no content here.</p>'); ?>

</div>
  <?php endwhile; endif; ?>
</article>
