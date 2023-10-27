<?php
/**
 * @package WordPress
 * @subpackage Fiberlight Theme
 */

$backgroundImage = get_field('404_background_image', 'option');
$backgroundImageMobile = get_field('404_background_image_mobile', 'option');
$backgroundImageAlt = $backgroundImage['alt'];
$message = get_field('404_message', 'option');
$messageLocation = get_field('404_message_location', 'option');

if ($messageLocation == 'offsetleft') :
  $align = 'justify-content-start';
else :
  $align = 'justify-content-center';
endif;
?>

<section id="error-page" class="error-page" >
  <?php if ($backgroundImage || $backgroundImageMobile): ?>
    <div class="background-image">
      <picture>
        <?php if ($backgroundImageMobile): ?>
          <source srcset="<?php echo responsive_image( $backgroundImageMobile, 'bg-full-height-xs' ); ?>" media="(max-width: 575.98px)">
        <?php endif; ?>
        <source srcset="<?php echo responsive_image( $backgroundImage, 'bg-full-height-md' ); ?>" media="(max-width: 991.98px)">
        <source srcset="<?php echo responsive_image( $backgroundImage, 'bg-full-height-lg' ); ?>" media="(max-width: 1199.98px)">
        <source srcset="<?php echo responsive_image( $backgroundImage, 'bg-full-height-xl' ); ?>" media="(max-width: 1399.98px)">
        <img src="<?php echo responsive_image( $backgroundImage, 'bg-full-height-xxl' ); ?>" class="img-fluid" alt="<?php echo $objectImageAlt; ?>" loading="eager" >
      </picture>
    </div>
  <?php endif; ?>

  <div class="container" >
    <div class="row align-items-start justify-content-center">
      <div class="col-12 col-md-8 col-lg-6 text-center">
        <div class="search">
          <?php get_search_form(); ?>
        </div>
      </div>
    </div>
  </div>

  <div class="container" >
    <div class="row align-items-start <?php echo $align; ?>">
      <div class="col-12 col-md-7 text-center">
          <div class="the-message">
            <?php  
              echo $message; 
            ?>
            <h4 class="error mt-2">404 not found</h4>
          </div>
      </div>
    </div>
  </div>

</section>
