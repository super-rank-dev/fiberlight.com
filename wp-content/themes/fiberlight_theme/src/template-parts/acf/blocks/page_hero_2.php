<?php
/**
 * Page Hero 2
 */


 // Load custom field values.
$heroType = get_field('hero_type');
$headline = get_field('headline');
$breadcrumbs = get_field('breadcrumb');
$heroImage = get_field('background_image');
$heroImageAlt = $heroImage['alt'];
$heroImageMobile = get_field('background_image_mobile');
$backgroundPattern = get_field('background_pattern');

if ($headline || have_rows('breadcrumbs')) : 
	$containerHeadline = 'container-headline';
endif;

if ($heroType === 'light'):
	$heroTypeClass = 'content-block content-block-light has-background has-fl-tan-background-color has-fl-tan-background';
else:
	$heroTypeClass = 'content-block has-background has-fl-dark-blue-background-color has-fl-dark-blue-background';
endif;

include(dirname(__DIR__).'/include/hero-image.php');

// Create id attribute allowing for custom "anchor" value and section classes.
include(dirname(__DIR__).'/include/section-id.php');
$sectionClass = 'page-hero-2';
include(dirname(__DIR__).'/include/section-classes.php');
?>

<?php include(dirname(__DIR__).'/clone/background-pattern.php'); ?>
<?php include(dirname(__DIR__).'/clone/hero-image.php'); ?>


	<div class="container <?php echo $containerHeadline; ?>">

		<div class="row mb-5">
			<div class="col-6">
				<?php  
					if ($breadcrumbs) : 
						include(dirname(__DIR__).'/include/breadcrumb.php'); 
					endif; 
				  echo '<h1 class="pb-5">'. $headline .'</h1>'; 
				?>
			</div>
		</div>

		<div class="row w-100 align-items-start">
			<div class="col-12" style="position: relative;">
        <div class="content-block-outline"></div>
        <div class="<?php echo $heroTypeClass; ?>">
				  <InnerBlocks />
        </div>
			</div>
		</div>
	</div>


</section>