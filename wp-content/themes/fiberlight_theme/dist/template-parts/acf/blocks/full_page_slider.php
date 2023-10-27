<?php
/**
 * Full Page Slider
 */

// Load custom field values.
$backgroundImage = get_field('background_image');
$backgroundPattern = get_field('background_patterns');

$args = array(  
  'post_type' => 'news',
  'post_status' => 'publish',
  'posts_per_page' => 3, 
  'orderby' => 'date', 
  'order' => 'DESC', 
);

$latestPosts = new WP_Query( $args ); 
  
// Load custom field values.
$backgroundImage = get_field('background_image');
$backgroundImageMobile = get_field('background_image_mobile');
$backgroundPattern = get_field('background_pattern');

include(dirname(__DIR__).'/include/background-image.php');

// Create id attribute allowing for custom "anchor" value and section classes.
include(dirname(__DIR__).'/include/section-id.php');
$sectionClass = 'full-page-slider';
include(dirname(__DIR__).'/include/section-classes.php');
?>

<?php include(dirname(__DIR__).'/clone/background-pattern.php'); ?>
<?php include(dirname(__DIR__).'/clone/background-image.php'); ?>


  <div class="container-fluid h-100 p-0">

      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12 col-md-12">
            <InnerBlocks />
          </div>
        </div>
        <div class="row justify-content-center">

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
          <div class="col-12 col-md-4 pb-3 pb-md-0">
            <div class="card card-news  h-100">
              <a href="<?php the_permalink(); ?>" aria-label="<?php the_title(); ?>">
              <div class="card-news-image">
                  <picture>
                    <source srcset="<?php echo responsive_image( $featuredImage, 'news-card-xxl' ); ?>" media="(max-width: 575.98px)">
                    <source srcset="<?php echo responsive_image( $featuredImage, 'news-card-md' ); ?>" media="(max-width: 767.98px)">
                    <img src="<?php echo responsive_image( $featuredImage, 'news-card-xxl' ); ?>" class="img-fluid" alt="<?php echo $featuredImageALT; ?>" loading="lazy" >
                  </picture>
                </a>
              </div>
              
              <div class="card-body card-news-body">
                <h4 class="title"><?php the_title(); ?></h4>
                
              </div>
              
              <div class="card-footer card-news-footer">
                  <div class="wp-block-buttons align-self-end">
                  <div class="wp-block-button">
                    <a href="<?php the_permalink(); ?>" class="wp-block-button__link wp-element-button" aria-label="<?php the_title(); ?>">Read more</a>
                  </div>
                </div>
              </div>
            </div>
          </div>

        <?php endwhile; wp_reset_query();  ?>   






        </div> 

      </div>


      <?php wp_reset_postdata();  ?>
  </div>
</section>