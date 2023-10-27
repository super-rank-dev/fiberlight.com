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
$image = get_field('image');
$image2 = get_field('image_2');

$blockTitle1 = get_field('block_1_title');
$block1Subtitle = get_field('block_1_sub_title');
$blockText1 = get_field('block_1_text');
$color = get_field('color');

include(dirname(__DIR__).'/include/section-padding.php');
include(dirname(__DIR__).'/include/background-image.php');


// Create id attribute allowing for custom "anchor" value and section classes.
include(dirname(__DIR__).'/include/section-id.php');
$sectionClass = 'content-layout-4 ' . $sectionPadding;
include(dirname(__DIR__).'/include/section-classes.php');

?>

<?php include(dirname(__DIR__).'/clone/background-pattern.php'); ?>
<?php include(dirname(__DIR__).'/clone/background-image.php'); ?>


	<div class="container h-100">
		<div class="row align-items-start justify-content-center g-2 g-md-0 h-100">
      <div class="col-4 col-md-3">
					<div class="picture-wrap-img-01">
						<?php if ($image): ?>
								<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"
									class="img-fluid" loading="lazy" />
						<?php endif; ?>
					</div>
			</div>
			<div class="col-8 col-md-6">
				<div class="picture-wrap-img-02">
					<?php if ($image2): ?>
							<img src="<?php echo esc_url($image2['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class="img-fluid" loading="lazy" />
					<?php endif; ?>
				</div>
			</div>
			<div class="col-12 col-md-3">
        <div class="content-block content-block-<?php echo $color; ?>">
          <?php if ($blockTitle1) : echo '<h2>'. $blockTitle1 .'</h2>'; endif; ?>
          <?php if ($block1Subtitle) : echo '<h3 class="subtitle">'. $block1Subtitle .'</h3>'; endif; ?>
          <?php if ($blockText1) : echo $blockText1; endif; ?>
        </div>
			</div>
		</div>
	</div>
	<div class="container container-bottom">
		<div class="row align-items-start justify-content-center">
			<div class="col-12">
				<InnerBlocks />
			</div>
		</div>


	</div>

  <div class="content-layout-4-top"></div>

</section>

