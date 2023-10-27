<?php
/**
 * Full Page Slider
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */


// Load custom field values.
$backgroundImage = get_field('background_image');
$backgroundPattern = get_field('background_patterns');
$thePostTypes = get_field('post_type');
$numberOfSlides = get_field('number_of_slides');

$args = array(  
  'post_type' => array($thePostTypes[0], $thePostTypes[1], $thePostTypes[2], $thePostTypes[3]),
  'post_status' => 'publish',
  'posts_per_page' => $numberOfSlides, 
  'orderby' => 'date', 
  'order' => 'DESC', 
);

$latestPosts = new WP_Query( $args ); 
  

// Load custom field values.
$backgroundImage = get_field('background_image');
$backgroundImageMobile = get_field('background_image_mobile');
$backgroundPattern = get_field('background_pattern');

include(dirname(__DIR__).'/include/section-padding.php');
include(dirname(__DIR__).'/include/background-image.php');

// Create id attribute allowing for custom "anchor" value and section classes.
include(dirname(__DIR__).'/include/section-id.php');
$sectionClass = 'page-slider ' . $sectionPadding;
include(dirname(__DIR__).'/include/section-classes.php');
?>

<?php include(dirname(__DIR__).'/clone/background-pattern.php'); ?>
<?php include(dirname(__DIR__).'/clone/background-image.php'); ?>



      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12 col-md-11">
            <InnerBlocks />
          </div>
        </div>

        <?php include(dirname(__DIR__).'/include/slider.php'); ?>



</section>