<?php
/**
 * Content Layout 8
 */

 // Load custom field values.
$backgroundImage = get_field('background_image');
$backgroundPattern = get_field('background_pattern');
$image = get_field('image');
$layout = get_field('layout');
$padding = get_field('padding');

if($layout == 'half') :
  $rightCol = "col-12 col-md-6";
  $leftCol = "col-12 col-md-6";
else : 
  $rightCol = "col-12 col-md-8";
  $leftCol = "col-12 col-md-4";
endif;

include(dirname(__DIR__).'/include/section-padding.php');
include(dirname(__DIR__).'/include/background-image.php');


// Create id attribute allowing for custom "anchor" value and section classes.
include(dirname(__DIR__).'/include/section-id.php');
$sectionClass = 'content-layout-9 ' . $sectionPadding;
include(dirname(__DIR__).'/include/section-classes.php');
?>

<?php include(dirname(__DIR__).'/clone/background-pattern.php'); ?>
<?php include(dirname(__DIR__).'/clone/background-image.php'); ?>

	<div class="container">
		<div class="row justify-content-center">
      <div class="<?php echo $leftCol; ?>">
        <div class="image-wrap">
          <picture>
            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"
              class="img-fluid" loading="lazy" />
          </picture>
        </div>
      </div>
			<div class="<?php echo $rightCol; ?> d-flex ">
        <div class="content align-self-center has-background has-fl-dark-blue-background-color has-fl-dark-blue-background">
          <InnerBlocks />    
        </div>    
			</div>
		</div>
	</div>
</section>
