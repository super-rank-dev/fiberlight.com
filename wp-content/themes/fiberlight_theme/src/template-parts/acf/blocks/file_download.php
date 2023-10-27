<?php
/**
 * Content Custom
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
$padding = get_field('padding');
$download = get_field('download_file');
$downloadURL = $download['url'];
// $downloadTitle = $download['title'];

$downloadLabel = get_field('download_button_label');
$downloadIcon = get_field('download_icon');
$downloadIconURL = $downloadIcon['url'];
$downloadIconAlt = $downloadIcon['alt'];

include(dirname(__DIR__).'/include/section-padding.php');
include(dirname(__DIR__).'/include/background-image.php');

 // Create id attribute allowing for custom "anchor" value and section classes.
 include(dirname(__DIR__).'/include/section-id.php');
 $sectionClass = 'file-download ' . $sectionPadding;
 include(dirname(__DIR__).'/include/section-classes.php');

?>

<?php include(dirname(__DIR__).'/clone/background-pattern.php'); ?>
<?php include(dirname(__DIR__).'/clone/background-image.php'); ?>

	<div class="container">
		<div class="row justify-content-center align-items-start align-items-lg-center">
			<div class="col pe-3 pe-lg-4 text-center text-md-start">
        <InnerBlocks />
			</div>
			<div class="col-12 col-md-4 col-auto text-center the-download mt-4 mt-md-0">
				<?php if ($downloadIcon) : ?>
					<a href="<?php echo $downloadURL; ?>">
					<?php echo '<img src="'. $downloadIconURL .'" class="icon_download" alt="'. $downloadTitle .'" >';  ?>
					</a>
				<?php else : ?>
					<a href="<?php echo $downloadURL; ?>" download>
						<?php echo '<img src="/wp-content/themes/fiberlight_theme/dist/images/icon_downlaod.svg" class="icon_download" alt="'. $downloadTitle  .'">'; ?>
					</a>
				<?php endif; ?>
			 <?php //if ($downloadTitle) : echo '<p>'. $downloadTitle .'</p>'; endif; ?>
			 <div class="wp-block-buttons">
				<div class="wp-block-button">
					<a href="<?php echo $downloadURL; ?>" target="_blank" class="wp-block-button__link">
						<?php if ($downloadLabel) : echo $downloadLabel; else : echo 'Download'; endif; ?>
					</a>
				</div>
			</div>
		</div>
	</div>
</section>