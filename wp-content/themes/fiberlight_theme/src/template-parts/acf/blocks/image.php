<?php
/**
 * Image
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

  // Load custom field values.
  $moveUp = get_field('move_section_up');
  $image = get_field('image');
  $imageALT = $image['alt'];
  $imageW = $image['width'];
  $imageH = $image['height'];
  $imageMobile = get_field('image_mobile');
  $imageMobileALT = $imageMobile['alt'];
  $imageMobileW = $imageMobile['width'];
  $imageMobileH = $imageMobile['height'];

  if($moveUp){
    $sectionPadding = 'move-up';
  }

  include(dirname(__DIR__).'/include/section-padding.php');

  
 // Create id attribute allowing for custom "anchor" value and section classes.
 include(dirname(__DIR__).'/include/section-id.php');
 $sectionClass = 'image ' . $sectionPadding;
 include(dirname(__DIR__).'/include/section-classes.php');

?>

	<section class="image-section container-fluid p-0">
		<div class="row">
			<div class="col-12">
        <?php if (is_admin()) : ?>
          <img src="<?php echo responsive_image( $image, 'image-fluid-xxl' ); ?>" class="img-fluid" alt="<?php echo $imageALT; ?>" width="<?php echo $imageW; ?>" height="<?php echo $imageH; ?>" loading="lazy" >
        <?php else : ?>
          <div class="image-wrap">
            <picture>
              <?php if ($imageMobile) : ?>
                <source srcset="<?php echo responsive_image( $imageMobile, 'image-fluid-xs' ); ?>" media="(max-width: 575.98px)">
              <?php else :  ?>
                <source srcset="<?php echo responsive_image( $image, 'image-fluid-xs' ); ?>" media="(max-width: 575.98px)">
              <?php endif; ?>
              <source srcset="<?php echo responsive_image( $image, 'image-fluid-md-2x' ); ?>" media="(max-width: 991.98px)">
              <source srcset="<?php echo responsive_image( $image, 'image-fluid-lg' ); ?>" media="(max-width: 1199.98px)">
              <source srcset="<?php echo responsive_image( $image, 'image-fluid-xl' ); ?>" media="(max-width: 1399.98px)">
              <img src="<?php echo responsive_image( $image, 'image-fluid-xxl' ); ?>" class="img-fluid" alt="<?php echo $imageALT; ?>" width="<?php echo $imageW; ?>" height="<?php echo $imageH; ?>" loading="lazy" >
            </picture>
          </div>
        <?php endif; ?>
			</div>
    </div>
</section>
