<?php if(!is_paged()): ?>
<section id="blog-list-hero" class="blog-list-hero">
  <div class="container">
    <?php
      if( $latestPost->have_posts()) :	while( $latestPost->have_posts()) : $latestPost->the_post();

      if (get_field('header_image')) :
        $featuredImage = get_field('header_image');
        $featuredImageALT = $featuredImage['alt'];
      else :
        $featuredImage =  get_field('featured_image', 'options');
        $featuredImageALT = $featuredImage['alt'];
      endif;
      
      
      $theExcerpt = wp_trim_words( get_the_content(), 60, '...' );

      ?>

    <div class="row">
      <div class="col-12">
        <div class="featured-image-wrapper">
          <a href="<?php the_permalink(); ?>">
            <picture>
              <source srcset="<?php echo responsive_image( $featuredImage, 'blog-list-hero-xs' ); ?>" media="(max-width: 575.98px)">
              <source srcset="<?php echo responsive_image( $featuredImage, 'blog-list-hero-md' ); ?>" media="(max-width: 991.98px)">
              <source srcset="<?php echo responsive_image( $featuredImage, 'blog-list-hero-lg' ); ?>" media="(max-width: 1199.98px)">
              <source srcset="<?php echo responsive_image( $featuredImage, 'blog-list-hero-xl' ); ?>" media="(max-width: 1399.98px)">
              <img src="<?php echo responsive_image( $featuredImage, 'blog-list-hero-xxl' ); ?>" class="img-fluid" alt="<?php echo $featuredImageALT; ?>" loading="lazy" >
            </picture>
          </a>
        </div>
        <div class="content-wrapper has-background has-fl-gradient-light-light-blue-gradient-background">
          <div class="row justify-content-center">
            <div class="col-12 col-md-9">
              <h2><?php the_title(); ?></h2>
              <?php the_excerpt() ?>
              <div class="wp-block-buttons">
                <div class="wp-block-button">
                  <a href="<?php the_permalink(); ?>" class="wp-block-button__link">Read More</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
      endwhile;  
      wp_reset_postdata(); 
      endif; 
    ?>
  </div>
</section>
<?php endif; ?>