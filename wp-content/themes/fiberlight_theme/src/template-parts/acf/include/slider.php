<?php if ( is_admin() ) : ?>
  <!-- Add message in Admin -->
  <div class="row justify-content-center">
    <div class="col-6 text-center">
      <div class="alert alert-primary" role="alert">Will display <?php echo $numberOfSlides; ?> of the news and blog posts by date descending</div>
    </div>
  </div>
<?php endif; ?>
   
<?php if ( !is_admin() ) : ?>
<div class="row mt-3 mt-md-0 g-0">
  <div class="col-12 g-0">
    <div class="page-slider-slides">
      <?php  
        while ( $latestPosts->have_posts() ) : $latestPosts->the_post();  
          $subHeading = get_field('subheading', get_the_ID());
          $featured = get_field('featured', get_the_ID());
          $theExcerpt = wp_trim_words( get_the_content(), 60, '...' );

          if (get_field('image', get_the_ID())) :
            $featuredImage = get_field('image', get_the_ID());
            $featuredImageALT = $featuredImage['alt'];
          else :
            $featuredImage = get_field('featured_image', 'options');
            $featuredImageALT = $featuredImage['alt'];
          endif;
      ?>
        
        <div class="slide mb-3 h-100 ">
              <div class="slide-date-wrap">
                <span class="day"><?php echo get_the_date( 'D' ); ?></span>
                <span class="day-num"><?php echo get_the_date( 'd' ); ?></span>
                <span class="year"><?php echo get_the_date( 'y' ); ?></span>
              </div>

              <div class="slide-img-wrap">
                <a href="<?php the_permalink(); ?>" aria-label="<?php the_title(); ?>">
                  <picture>
                    <source srcset="<?php echo responsive_image( $featuredImage, 'slider-xs' ); ?>" media="(max-width: 575.98px)">
                    <source srcset="<?php echo responsive_image( $featuredImage, 'slider-lg' ); ?>" media="(max-width: 991.98px)">
                    <img src="<?php echo responsive_image( $featuredImage, 'slider-xxl' ); ?>" class="img-fluid" alt="<?php echo $featuredImageALT; ?>" loading="lazy" >
                  </picture>
                </a>
              </div>

              <div class="slide-body">
                <?php if($featured) : echo '<div class="category">Featured</div>'; endif; ?>
                <div class="title"><?php the_title(); ?></div>
                <?php if ($subHeading) : echo '<div class="sub-title">'. $subHeading .'</div>'; endif; ?>
                <a href="<?php the_permalink(); ?>" class="btn-slide d-none d-md-inline-block" aria-label="Read more about <?php the_title(); ?>">Read More</a>
              </div>
              
              <a href="<?php the_permalink(); ?>" class="btn-slide d-block d-md-none" aria-label="Read more about <?php the_title(); ?>">Read More</a>
        </div>
      
      <?php endwhile; wp_reset_query();  ?>
    </div>

    <div id="hero-slider-dots" class="slider-dots"></div>
    <div class="slider-controls">
      <div class="slider-controls-arrow">
        <div class="slider-arrow"></div>
      </div>
    </div>

</div>
<?php endif; ?>