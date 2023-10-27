<?php
/**
 * Content Layout 8
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

 // Load custom field values.
$backgroundImage = get_field('background_image');
$backgroundPattern = get_field('background_pattern');
$image1 = get_field('image_1');
$image2 = get_field('image_2');
$image3 = get_field('image_3');
$padding = get_field('padding');


include(dirname(__DIR__).'/include/section-padding.php');
include(dirname(__DIR__).'/include/background-image.php');


// Create id attribute allowing for custom "anchor" value and section classes.
include(dirname(__DIR__).'/include/section-id.php');
$sectionClass = 'content-layout-10 ' . $sectionPadding;
include(dirname(__DIR__).'/include/section-classes.php');
?>

<?php include(dirname(__DIR__).'/clone/background-pattern.php'); ?>
<?php include(dirname(__DIR__).'/clone/background-image.php'); ?>

	<div class="container">
		<div class="row justify-content-center">
      <div class="col-12 col-md-4 d-flex" style="position: relative;">
        <div class="content align-self-center">
          <InnerBlocks />    
        </div>    
        <div class="darken"></div>
        <div class="image-wrap ">
          <picture>
            <img src="<?php echo esc_url($image1['url']); ?>" alt="<?php echo esc_attr($image1['alt']); ?>"
              class="img-fluid" loading="lazy" />
          </picture>
        </div>
      </div>
      <div class="col-12 col-md-4 d-none d-md-block">
        <div class="image-wrap">
          <picture>
            <img src="<?php echo esc_url($image2['url']); ?>" alt="<?php echo esc_attr($image2['alt']); ?>"
              class="img-fluid" loading="lazy" />
          </picture>
        </div>
      </div>
      <div class="col-12 col-md-4 d-none d-md-block">
        <div class="image-wrap">
          <picture>
            <img src="<?php echo esc_url($image3['url']); ?>" alt="<?php echo esc_attr($image3['alt']); ?>"
              class="img-fluid" loading="lazy" />
          </picture>
        </div>
      </div>
		</div>
	</div>
</section>
