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

include(dirname(__DIR__).'/include/background-image.php');

// Create id attribute allowing for custom "anchor" value and section classes.
include(dirname(__DIR__).'/include/section-id.php');
$sectionClass = 'full-page-custom ' . $sectionPadding;
include(dirname(__DIR__).'/include/section-classes.php');

?>

<?php include(dirname(__DIR__).'/clone/background-pattern.php'); ?>
<?php include(dirname(__DIR__).'/clone/background-image.php'); ?>

<div class="container h-100">
	<div class="row justify-content-center align-items-center h-100" style="margin: -40px 0px 0px">
		<div class="col-12 col-md-10 col-lg-8">
			<InnerBlocks />
		</div>
		</div>
	</div>
</section>

