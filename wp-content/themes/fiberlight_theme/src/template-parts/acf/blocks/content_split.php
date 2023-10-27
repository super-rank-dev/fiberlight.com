<?php
/**
 * Content Split Col
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
$secColumn = get_field('2nd_column_content');
$secText = get_field('2nd_column_text');
$fullWidth = get_field('full_width');
$reverseLayout = get_field('reverse_layout');
$fullHeight = get_field('full_image_height');
$image = get_field('image');

if ($fullWidth === true):
  $container = 'container-fluid';
else:
  $container = 'container';
endif;

if ($reverseLayout):
  $leftClasses = 'col-12 col-md-6 ps-5 order-last';
  $rightClasses = 'col-12 col-md-6 order-first';
  $pictureClasses = 'picture-wrap-left';
else:
  $leftClasses = 'col-12 col-md-6 pe-5 order-first';
  $rightClasses = 'col-12 col-md-6 order-last';
  $pictureClasses = 'picture-wrap-right';
endif;

if ($fullHeight):
  $sectionClasses = 'full-image-height';
  $contentPad = 'contentPad';
else:
  $sectionClasses = '';
endif;

include(dirname(__DIR__).'/include/section-padding.php');
include(dirname(__DIR__).'/include/background-image.php');

// Create id attribute allowing for custom "anchor" value and section classes.
include(dirname(__DIR__).'/include/section-id.php');
$sectionClass = 'content-split ' . $sectionPadding;
include(dirname(__DIR__).'/include/section-classes.php');
?>

<?php include(dirname(__DIR__).'/clone/background-pattern.php'); ?>
<?php include(dirname(__DIR__).'/clone/background-image.php'); ?>

	<div class="<?php echo $container; ?>">
		<div class="row">
			<div class="<?php echo $leftClasses; ?> <?php echo $contentPad; ?>">
        <InnerBlocks />
			</div>
      <div class="<?php echo $rightClasses; ?>" >

            <?php if ($secColumn == 'image'): ?>
							<div class="picture-wrap <?php echo $pictureClasses; ?>">
                <?php if ($image): ?>
                  <picture>
                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"
                      class="img-fluid " loading="lazy" />
                  </picture>
                <?php endif; ?>
							</div>
						<?php endif; ?>
            <?php if ($secColumn == 'text'): ?>
              <?php echo $secText; ?>
            <?php endif; ?>

			</div>
    </div>
</section>