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
$title = get_field('title');
$subTitle = get_field('sub_title');

$blockTitle1 = get_field('block_1_title');
$blockText1 = get_field('block_1_text');
$blockLink1 = get_field('block_1_link');
if (!empty($blockLink1)) :
  $link_1_url = $blockLink1['url'];
  $link_1_title = $blockLink1['title'];
  $link_1_target = $blockLink1['target'] ? $blockLink1['target'] : '_self';
endif;

$blockTitle2 = get_field('block_2_title');
$blockText2 = get_field('block_2_text');
$blockLink2 = get_field('block_2_link');
if (!empty($blockLink2)) :
  $link_2_url = $blockLink2['url'];
  $link_2_title = $blockLink2['title'];
  $link_2_target = $blockLink2['target'] ? $blockLink2['target'] : '_self';
endif;



$leftClasses = 'col-12 col-md-6 pe-5 order-first';
$rightClasses = 'col-12 col-md-6 ps-5 order-last';

include(dirname(__DIR__).'/include/section-padding.php');
include(dirname(__DIR__).'/include/background-image.php');

// Create id attribute allowing for custom "anchor" value and section classes.
include(dirname(__DIR__).'/include/section-id.php');
$sectionClass = 'content-layout-3 ' . $sectionPadding;
include(dirname(__DIR__).'/include/section-classes.php');

?>

<?php include(dirname(__DIR__).'/clone/background-pattern.php'); ?>
<?php include(dirname(__DIR__).'/clone/background-image.php'); ?>


	<div class="container">
		<div class="row justify-content-start align-items-start">
      <div class="col-1 d-none d-md-block"></div>
			<div class="col-12 col-md-10 col-lg-7">
        <?php if ($title) : echo '<h2>'. $title .'</h2>'; endif; ?>
        <?php if ($subTitle) : echo '<h3>'. $subTitle .'</h3>'; endif; ?>
      </div>
    </div>
	</div>
	<div class="container-fluid p-4 p-md-0">
		<div class="row row-items justify-content-start justify-content-md-end mt-3 mt-md-5 d-flex">
      <div class="col-12 col-md-3 order-2 order-md-1 content-block content-block-blue pt-4 pt-md-5 px-3 px-md-4 pb-3 pb-md-4 mb-4 mb-md-0">
        <div class="bar bar-green"></div>
        <?php if ($blockTitle1) : echo '<h4>'. $blockTitle1 .'</h4>'; endif; ?>
        <?php if ($blockText1) : echo '<p>'. $blockText1 .'</p>'; endif; ?>
        <?php if (!empty($blockLink1)) : ?>
          <div class="wp-block-buttons wp-block-buttons-sm">
            <div class="wp-block-button">
              <a class="wp-block-button__link wp-element-button" href="<?php echo $link_1_url; ?>" target="<?php echo esc_attr( $link_1_target ); ?>"><?php echo esc_html( $link_1_title ); ?></a>
            </div>
          </div>
        <?php endif; ?>
      </div>
      <div class="col-12 col-md-2 order-1 order-md-2">
        <?php if ($image): ?>
          <div class="picture-wrap">
              <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"
                class="img-fluid" loading="lazy" />
          </div>
        <?php endif; ?>
      </div>
      <div class="col-12 col-md-3 order-4 order-md-3 content-block content-block-blue pt-4 pt-md-5 px-3 px-md-4 pb-3 pb-md-4 ">
        <div class="bar bar-green"></div>
        <?php if ($blockTitle2) : echo '<h4>'. $blockTitle2 .'</h4>'; endif; ?>
        <?php if ($blockText2) : echo '<p>'. $blockText2 .'</p>'; endif; ?>
        <?php if (!empty($blockLink2)) : ?>
          <div class="wp-block-buttons wp-block-buttons-sm">
            <div class="wp-block-button">
              <a class="wp-block-button__link wp-element-button" href="<?php echo $link_2_url; ?>" target="<?php echo esc_attr( $link_2_target ); ?>"><?php echo esc_html( $link_2_title ); ?></a>
            </div>
          </div>
        <?php endif; ?>
      </div>
      <div class="col-12 col-md-1 order-3 order-md-4">
        <?php if ($image2): ?>
          <div class="picture-wrap">
              <img src="<?php echo esc_url($image2['url']); ?>" alt="<?php echo esc_attr($image2['alt']); ?>"
                class="img-fluid" loading="lazy" />
          </div>
        <?php endif; ?>
      </div>
    </div>
	</div>

  <div class="content-layout-3-bottom" >
  <div class="container-fluid p-md-0">
      <div class="row justify-content-end">
        <div class="col-12 col-md-8 col-lg-6 p-md-0">
          <InnerBlocks />
        </div>
        <div class="col-1 col-lg-3"></div>

      </div>
    </div>
</div>

</section>

