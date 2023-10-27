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
$image3 = get_field('image_3');
$layout = get_field('reverse_layout');

if ($layout):
  $leftClasses = 'col-12 col-md-6 order-first order-md-last';
  $rightClasses = 'col-12 col-md-6 content-col content-col-first order-last order-md-first pe-5 mt-5 mt-md-0';
  $image02col = 'col-6 order-last';
  $image03col = 'col-6 order-first';
  $image02class = 'picture-wrap picture-wrap-02 order-last';
  $image03class = 'picture-wrap picture-wrap-03 order-first';
else:
  $leftClasses = 'col-12 col-md-6 order-first';
  $rightClasses = 'col-12 col-md-6 content-col content-col-last order-last mt-5 mt-md-0';
  $image02col = 'col-6 order-first';
  $image03col = 'col-6 order-last';
  $image02class = 'picture-wrap picture-wrap-02';
  $image03class = 'picture-wrap picture-wrap-03';
endif; 

include(dirname(__DIR__).'/include/background-image.php');
include(dirname(__DIR__).'/include/section-padding.php');

// Create id attribute allowing for custom "anchor" value and section classes.
//include(dirname(__DIR__).'/include/section-id.php');
$sectionClass = 'content-layout-2 ' . $sectionPadding;
include(dirname(__DIR__).'/include/section-classes.php');

?>

<?php include(dirname(__DIR__).'/clone/background-pattern.php'); ?>
<?php include(dirname(__DIR__).'/clone/background-image.php'); ?>



	<div class="container">
		<div class="row justify-content-center align-items-center">
			<div class="<?php echo $leftClasses; ?>">
        <div class="row g-0">
          <div class="col-12">
            <?php if ($image): ?>
              <div class="picture-wrap picture-wrap-01">
              <?php if(is_admin()) : ?>
                  <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"
                    class="img-fluid image-01" loading="lazy" />
                <?php else : ?>
                  <picture>
                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"
                      class="img-fluid image-01 <?php if ($layout) : echo 'image-01-rev'; endif; ?>" loading="lazy" />
                  </picture>
                <?php endif; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
        <div class="row g-3 g-md-0 px-3 px-md-0">
          <div class="<?php echo $image02col; ?>">
            <?php if ($image2): ?>
              <div class="<?php echo $image02class; ?>">
                    <img src="<?php echo esc_url($image2['url']); ?>" alt="<?php echo esc_attr($image2['alt']); ?>"
                      class="img-fluid image-02 <?php if ($layout) : echo 'image-02-rev'; endif; ?>" loading="lazy" />
              </div>
            <?php endif; ?>
          </div>
          <div class="<?php echo $image03col; ?>">
            <?php if ($image3): ?>
              <div class="<?php echo $image03class; ?>">
                      <img src="<?php echo esc_url($image3['url']); ?>" alt="<?php echo esc_attr($image3['alt']); ?>"
                        class="img-fluid image-03 <?php if ($layout) : echo 'image-03-rev'; endif; ?>" loading="lazy" />
              </div>
            <?php endif; ?>
          </div>
        </div>
			</div>
      <div class="<?php echo $rightClasses; ?>">
        <InnerBlocks />
      </div>
    </div>
	</div>
</section>