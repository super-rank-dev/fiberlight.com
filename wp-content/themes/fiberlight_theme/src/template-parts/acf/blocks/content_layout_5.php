<?php
/**
 * Hero Full Page
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
$reverseLayout = get_field('reverse_layout');
$overlayAbove = get_field('overlay_above');
$image = get_field('image');
$divideBackground = get_field('divide_background');
$dividedBackgroundColor = get_field('divided_background_color');

if ($overlayAbove):
	$overlaySection = 'overlay-above';
else:
	$overlaySection = '';
endif; 

if ($reverseLayout):
  $leftClasses = 'col-12 col-md-6 order-last';
  $rightClasses = 'col-12 col-md-6 order-first';
	$contentBlock = 'content-block content-block-left';
	$pictureWrapOutline = 'picture-wrap-outline picture-wrap-outline-right';
else:
  $leftClasses = 'col-12 col-md-5 order-first';
  $rightClasses = 'col-12 col-md-6 order-last';
	$contentBlock = 'content-block content-block-right';
	$pictureWrapOutline = 'picture-wrap-outline picture-wrap-outline-left';
endif; 

include(dirname(__DIR__).'/include/section-padding.php');
include(dirname(__DIR__).'/include/background-image.php');
include(dirname(__DIR__).'/include/divide-background.php');

// Create id attribute allowing for custom "anchor" value and section classes.
include(dirname(__DIR__).'/include/section-id.php');
$sectionClass = 'content-layout-5 ' . $overlaySection; $sectionPadding;
include(dirname(__DIR__).'/include/section-classes.php');

?>

<?php include(dirname(__DIR__).'/clone/background-pattern.php'); ?>
<?php include(dirname(__DIR__).'/clone/background-image.php'); ?>


	<div class="container h-100">
		<div class="row d-flex  justify-content-center g-0 h-100">
      <div class="<?php echo $leftClasses; ?>" style="position: relative;">
					<div class="<?php echo $pictureWrapOutline; ?>"></div>
					<div class="picture-wrap">
						<?php if ($image): ?>
							<picture>
								<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"
									class="img-fluid" loading="lazy" />
							</picture>
						<?php endif; ?>
					</div>
			</div>
			<div class="<?php echo $rightClasses; ?>">
				<div class="<?php echo $contentBlock; ?>">
					<InnerBlocks />
				</div>
			</div>
		</div>
	</div>
	
	<?php if ($divideBackground) : ?>
  	<div class="content-layout-5-bottom <?php echo $divideBGColor; ?>">
	</div>
	<?php endif; ?>

</section>

