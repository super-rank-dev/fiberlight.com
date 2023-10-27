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
$bumpUp = get_field('bump_up');
$fullWidth = get_field('full_width');
$padding = get_field('padding');

if ($fullWidth === true):
  $container = 'container-fluid';
else:
  $container = 'container';
endif;

if ($bumpUp === true):
  $bumpUpRowClass = 'bump-up pt-4 p-3 p-md-4 p-lg-5 justify-content-center';
  $bumpUpColClass = 'col-12';
else:
  $bumpUpRowClass = '';
  $bumpUpColClass = 'col-12';
endif;

include(dirname(__DIR__).'/include/section-padding.php');
include(dirname(__DIR__).'/include/background-image.php');

 // Create id attribute allowing for custom "anchor" value and section classes.
 include(dirname(__DIR__).'/include/section-id.php');
 $sectionClass = 'content-custom ' . $sectionPadding;
 include(dirname(__DIR__).'/include/section-classes.php');

?>

<?php include(dirname(__DIR__).'/clone/background-pattern.php'); ?>
<?php include(dirname(__DIR__).'/clone/background-image.php'); ?>

	<div class="<?php echo $container; ?>">
		<div class="row <?php echo $bumpUpRowClass; ?>">
			<div class="<?php echo $bumpUpColClass; ?>">
        <InnerBlocks />
			</div>
    </div>
</section>