<?php
/**
 * @package WordPress
 * @subpackage Fiberlight Theme
 */

$backgroundImage = get_field('search_background_image', 'option');
$backgroundImageMobile = get_field('search_background_image_mobile', 'option');
$backgroundImageAlt = $backgroundImage['alt'];

?>

<section id="search-hero" class="search-hero half-height">
  <?php if ($backgroundImage || $backgroundImageMobile): ?>
    <div class="background-image">
      <picture>
        <?php if ($backgroundImageMobile): ?>
          <source srcset="<?php echo responsive_image( $backgroundImageMobile, 'bg-half-height-xs' ); ?>" media="(max-width: 575.98px)">
        <?php endif; ?>
        <source srcset="<?php echo responsive_image( $backgroundImage, 'bg-half-height-md' ); ?>" media="(max-width: 991.98px)">
        <source srcset="<?php echo responsive_image( $backgroundImage, 'bg-half-height-lg' ); ?>" media="(max-width: 1199.98px)">
        <source srcset="<?php echo responsive_image( $backgroundImage, 'bg-half-height-xl' ); ?>" media="(max-width: 1399.98px)">
        <img src="<?php echo responsive_image( $backgroundImage, 'bg-half-height-xxl' ); ?>" class="img-fluid" alt="<?php echo $objectImageAlt; ?>" loading="eager" >
      </picture>
    </div>
  <?php endif; ?>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-md-8 col-lg-6">
      <div class="search">
          <?php get_search_form(); ?>
        </div>
      </div>
    </div>
  </div>
</section>


<section id="search-page" class="search-page">
  <div class="container">
    <?php if (have_posts()) : ?>
    <div class="row">
      <div class="col-12">
        <h3>Results</h3>
          <?php while (have_posts()) : the_post(); 
            $postType = get_post_type();
            $excerpt = get_the_excerpt();
          ?>
            <article <?php post_class() ?>>
              <h4 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4>
              <?php if ($excerpt) : echo '<p>'. $excerpt .'</p>'; endif; ?>
             <div class="post-type"><?php echo $postType; ?></div>
            </article>
          <?php endwhile; ?>
        <?php else : ?>
          <h2>No posts found. Try a different search?</h2>
        <?php endif; ?>
      </div>
    </div>
    <div id="search-nav" class="row text-center">
      <div class="col-12">
        <?php
        the_posts_pagination( array(
          'mid_size'  => 2,
          'prev_text' => __( 'Back', 'textdomain' ),
          'next_text' => __( 'Next', 'textdomain' ),
        ) );
        ?>
      </div>
    </div>
  </div>
</section>


