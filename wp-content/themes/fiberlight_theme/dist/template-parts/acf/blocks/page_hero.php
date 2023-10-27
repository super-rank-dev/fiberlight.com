<?php
/**
 * Page Hero
 */


 // Load custom field values.
$backgroundType = get_field('background_type');
$heroImage = get_field('background_image');
$heroImageMobile = get_field('background_image_mobile');

$deskVideoType = get_field('desktop_video_type');
$deskVimeoID = get_field('desktop_vimeo_id');
$deskYouTubeID = get_field('desktop_youtube_id');

$objectFitDesk = get_field('object_fit_desktop');
$objectPositionDesk = get_field('object_position_desktop');

$image = get_field('image');

$backgroundPattern = get_field('background_pattern');
$size = get_field('size');

if($size === 'fullheight'):
  if($image) : 
		$sectionClasses = "full-height";
		$containerClasses = "container h-100";
		$rowClasses = "row justify-content-start align-items-center h-100";
	else : 
		$sectionClasses = "full-height";
		$containerClasses = "container h-100";
		$rowClasses = "row justify-content-start align-items-center h-100";
	endif;
else:
	$containerClasses = "container h-100";
	$sectionClasses = "half-height";
  $rowClasses = "row justify-content-center align-items-center h-100";
endif;


 // Create id attribute allowing for custom "anchor" value and section classes.
 include(dirname(__DIR__).'/include/section-id.php');
$sectionClass = 'page-hero';
include(dirname(__DIR__).'/include/section-classes.php');

?>

		<?php include(dirname(__DIR__).'/clone/background-pattern.php'); ?>

		<div class="darken"></div>
	

		<?php if ($backgroundType == 'image') : ?>

			<?php if (is_admin()) : ?>
				<div class="background-image">
					<?php if ($size === 'fullheight') : ?>
						<img src="<?php echo responsive_image( $heroImage, 'bg-full-height-xxl' );?>" alt="<?php echo $heroImage['alt']; ?>" />
					<?php else : ?>
						<img src="<?php echo responsive_image( $heroImage, 'bg-half-height-xxl' );?>" alt="<?php echo $heroImage['alt']; ?>" />
					<?php endif; ?>
				</div>
			<?php else : ?>
				<?php if ($size === 'fullheight') : ?>
					<div class="background-image">
						<picture>
								<?php if ($heroImageMobile): ?>
									<source srcset="<?php echo responsive_image( $heroImageMobile, 'bg-full-height-xs' ); ?>" media="(max-width: 575.98px)">
								<?php endif; ?>
								<source srcset="<?php echo responsive_image( $heroImage, 'bg-full-height-md' ); ?>" media="(max-width: 991.98px)">
								<source srcset="<?php echo responsive_image( $heroImage, 'bg-full-height-lg' ); ?>" media="(max-width: 1199.98px)">
								<source srcset="<?php echo responsive_image( $heroImage, 'bg-full-height-xl' ); ?>" media="(max-width: 1399.98px)">
								<img src="<?php echo responsive_image( $heroImage, 'bg-full-height-xxl' );?>" alt="<?php echo $heroImage['alt']; ?>" style="<?php if($objectPositionDesk) : echo 'object-position: '. $objectPositionDesk .';'; endif; if($objectFitDesk) : echo 'object-fit: '. $objectFitDesk .';'; endif; ?>" alt="<?php echo $heroImageAlt; ?>" loading="eager" />
						</picture>	
					</div>	
				<?php else : ?>
					<div class="background-image">
						<picture>
								<?php if ($heroImageMobile): ?>
									<source srcset="<?php echo responsive_image( $heroImageMobile, 'bg-full-height-xs' ); ?>" media="(max-width: 575.98px)">
								<?php endif; ?>
								<source srcset="<?php echo responsive_image( $heroImage, 'bg-half-height-md' ); ?>" media="(max-width: 991.98px)">
								<source srcset="<?php echo responsive_image( $heroImage, 'bg-half-height-lg' ); ?>" media="(max-width: 1199.98px)">
								<source srcset="<?php echo responsive_image( $heroImage, 'bg-half-height-xl' ); ?>" media="(max-width: 1399.98px)">
								<img src="<?php echo responsive_image( $heroImage, 'bg-half-height-xxl' ); ?>" alt="<?php echo $heroImage['alt']; ?>" style="<?php if($objectPositionDesk) : echo 'object-position: '. $objectPositionDesk .';'; endif; if($objectFitDesk) : echo 'object-fit: '. $objectFitDesk .';'; endif; ?>" alt="<?php echo $heroImageAlt; ?>" loading="eager" />
						</picture>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		<?php endif; ?>

		<?php include(dirname(__DIR__).'/include/background-video.php'); ?>



	<div class="<?php echo $containerClasses; ?>">
		<div class="row justify-content-center align-items-center h-100">
				<div class="col-12">
					<div class="row justify-content-start align-items-center h-100">
						<div class="col-12 col-md-8 col-lg-6 h-100">
							<InnerBlocks />
						</div>
						<?php if ($image) : ?>
						<div class="col-12 col-md-4 col-lg-6 text-center">
							<img src="<?php echo $image['url']; ?>" class="img-fluid" />
						</div>
						<?php endif; ?>
					</div>
				</div>
		</div>
	</div>
</section>