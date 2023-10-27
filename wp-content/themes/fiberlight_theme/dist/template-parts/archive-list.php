<?php 
  $total_rows = max( 0, $allPosts->found_posts - $offset_start );
  $total_pages = ceil( $total_rows / $per_page );
  if ( $allPosts->have_posts() ) : 
?>
<section id="blog-list" class="blog-list mt-3">
  <div class="container">
    <div class="row">
      <div class="col">
        <h3>Latest Posts <?php echo $pageNumber; ?></h3>
        <?php while( $allPosts->have_posts()) : $allPosts->the_post();

          

            if (get_field('image')) :
              $featuredImage = get_field('image');
              $featuredImageALT = $featuredImage['alt'];
            elseif(get_post_thumbnail_id( $post->ID )):
              $featuredImage = get_post_thumbnail_id( $post->ID );
              $featuredImageALT = get_post_meta($featuredImageID, '_wp_attachment_image_alt', true);
            else :
              $featuredImage = get_field('featured_image', 'options');
              $featuredImageALT = $featuredImage['alt'];
            endif;

          $theExcerpt = wp_trim_words( get_the_content(), 30, '...' );

        ?>
        <div class="blog-item">
          <div class="blog-item-content-wrap">
            <div class="blog-item-image-wrap">
              <a href="<?php the_permalink(); ?>">
              <picture>
                <source srcset="<?php echo responsive_image( $featuredImage, 'blog-list-xs' ); ?>" media="(max-width: 575.98px)">
                <source srcset="<?php echo responsive_image( $featuredImage, 'blog-list-md' ); ?>" media="(max-width: 991.98px)">
                <source srcset="<?php echo responsive_image( $featuredImage, 'blog-list-lg' ); ?>" media="(max-width: 1199.98px)">
                <source srcset="<?php echo responsive_image( $featuredImage, 'blog-list-xl' ); ?>" media="(max-width: 1399.98px)">
                <img src="<?php echo responsive_image( $featuredImage, 'blog-list-xxl' ); ?>" class="img-fluid" alt="<?php echo $featuredImageALT; ?>" loading="lazy" >
              </picture>
              </a>
            </div>
            <div class="blog-item-content-wrap-content">
              <div class="date"><?php the_date( 'm.d.y' ); ?></div>
              <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
              <?php the_excerpt() ?>
              <div class="wp-block-buttons">
                <div class="wp-block-button">
                  <a href="<?php the_permalink(); ?>" class="wp-block-button__link">Read More</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php 
        endwhile; 
        ?>
      </div>
      </div>
    <div class="row pagination g-0">
      <div class="col-12 text-center">
        <?php 
          echo paginate_links( array(
            'total'   => $total_pages,
            'current' => $current_page,
        ) );
         ?>
      </div>
    </div>
  </div>
</section>

<?php    
  wp_reset_postdata(); 
  endif; 
?>