<?php
/**
 * Content Layout 8
 */

 // Load custom field values.
$heroImage = get_field('background_image');
$heroImageMobile = get_field('background_image_mobile');
$backgroundPattern = get_field('background_pattern');
$image = get_field('image');
$padding = get_field('padding');

include(dirname(__DIR__).'/include/section-padding.php');
include(dirname(__DIR__).'/include/background-image.php');


// Create id attribute allowing for custom "anchor" value and section classes.
include(dirname(__DIR__).'/include/section-id.php');
$sectionClass = 'content-layout-8 ' . $sectionPadding;
include(dirname(__DIR__).'/include/section-classes.php');
?>

	<div class="container">
		<div class="row justify-content-center align-items-center">
			<div class="col-12" style="position: relative;">
        <?php include(dirname(__DIR__).'/clone/background-pattern.php'); ?>
        <?php include(dirname(__DIR__).'/clone/hero-image.php'); ?>
        <div class="inner-block">
          <InnerBlocks />
        </div>
			</div>
		</div>
	</div>
</section>
