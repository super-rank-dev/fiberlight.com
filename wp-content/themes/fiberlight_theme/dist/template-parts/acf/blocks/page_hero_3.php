<?php
/**
 * Page Hero 3
 */


 // Load custom field values.
$headline = get_field('headline');
$breadcrumbs = get_field('breadcrumb');
$subHeadline = get_field('sub_headline');
$backgroundImage = get_field('background_image');
$objectFitDesk = get_field('object_fit_desktop');
$objectPositionDesk = get_field('object_position_desktop');
$backgroundImageMobile = get_field('background_image_mobile');
$backgroundPattern = get_field('background_pattern');
$overlay = get_field('overlay');
$image = get_field('image');
$size = get_field('size');

if($size === 'fullheight'):
  $sectionClasses = "full-height";
  $containerClasses = "container h-100";
  $rowClasses = "row justify-content-center align-items-center h-100";
  $colClassesLeft = "col-12 col-md-10 col-lg-8 text-center";
  $colClassesRight = "d-none";
else:
  $sectionClasses = "half-height";
  $containerClasses = "container h-100";
  $rowClasses = "row justify-content-center align-items-center h-100 text-start";
  $colClassesLeft = "col-12 col-md-8 col-lg-6";
  $colClassesRight = "col-12 col-md-4 col-lg-6 text-center";
endif;

include(dirname(__DIR__).'/include/background-image.php');


 // Create id attribute allowing for custom "anchor" value and section classes.
include(dirname(__DIR__).'/include/section-id.php');
$sectionClass = 'page-hero-3';
include(dirname(__DIR__).'/include/section-classes.php');
?>

<?php include(dirname(__DIR__).'/clone/background-pattern.php'); ?>
<?php 
	if($size === 'fullheight'):
		include(dirname(__DIR__).'/clone/background-image.php'); 
	else : 
		include(dirname(__DIR__).'/clone/background-image-darken.php'); 
	endif;
?>

	<div class="<?php echo $containerClasses; ?>">
		<div class="<?php echo $rowClasses; ?>">
			<div class="<?php echo $colClassesLeft; ?>">
					<?php  
						if ($breadcrumbs) : 
							echo '<div style="display: block;">';
							include(dirname(__DIR__).'/include/breadcrumb.php'); 
							echo '</div>';
						endif; 
				  ?>
					<?php 
						if ($headline || $subHeadline) : 
							echo '<div class="headline-wrap">'; 
							echo '<h1 class="headline">';
								if ($headline) : echo $headline; endif;
								if ($subHeadline) : echo '<span class="sub-headline">'. $subHeadline .'</span>'; endif;
							echo '</h1>';
							echo '</div>'; 
						endif; 
					?>
					<InnerBlocks />
			</div>
			<div class="<?php echo $colClassesRight; ?>">
      <?php if ($image && $size === 'halfheight'): ?>
						<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class="hero-image img-fluid " />
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>