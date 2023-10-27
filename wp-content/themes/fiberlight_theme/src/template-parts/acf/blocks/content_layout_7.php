<?php
/**
 * Content Layout 7
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

 // Load custom field values.
$backgroundImage = get_field('background_image');
$backgroundImageMobile = get_field('background_image_mobile');
$backgroundPattern = get_field('background_pattern');
$image = get_field('image');
$padding = get_field('padding');

$divideBackground = get_field('divide_background');
$dividedBackgroundColor = get_field('divided_background_color');

include(dirname(__DIR__).'/include/section-padding.php');
include(dirname(__DIR__).'/include/background-image.php');
include(dirname(__DIR__).'/include/divide-background.php');


// Create id attribute allowing for custom "anchor" value and section classes.
include(dirname(__DIR__).'/include/section-id.php');
$sectionClass = 'content-layout-7 ' . $sectionPadding;
include(dirname(__DIR__).'/include/section-classes.php');
?>

<?php include(dirname(__DIR__).'/clone/background-pattern.php'); ?>
<?php include(dirname(__DIR__).'/clone/background-image.php'); ?>


	<div class="container">
		<div class="row justify-content-center align-items-center g-0">
			<div class="col-12 col-md-3">
        <div class="image-wrap">
        <picture>
          <source srcset="<?php echo responsive_image( $image, 'image-fluid-xs' ); ?>" media="(max-width: 575.98px)">
          <source srcset="<?php echo responsive_image( $image, 'image-fluid-md' ); ?>" media="(max-width: 991.98px)">
          <source srcset="<?php echo responsive_image( $image, 'image-fluid-lg' ); ?> " media="(max-width: 1199.98px)">
          <source srcset="<?php echo responsive_image( $image, 'image-fluid-xl' ); ?>" media="(max-width: 1399.98px)">
          <img src="<?php echo responsive_image( $image, 'image-fluid-xxl' ); ?>" class="img-fluid" alt="<?php echo $imageALT; ?>" loading="lazy" >
        </picture>
        </div>
			</div>
			<div class="col-12 col-md-8">
        <div class="content has-background has-fl-dark-blue-background-color has-fl-dark-blue-background">
				  <InnerBlocks />
        </div>
			</div>
		</div>
	</div>
	
	<?php if ($divideBackground) : ?>
  	<div class="content-layout-7-top  <?php echo $divideBGColor; ?>"></div>
	<?php endif; ?>

</section>
