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
$headline = get_field('headline');
$subHeadline = get_field('sub_headline');
$cards = get_field('cards');
$revLayout = get_field('reverse_layout');
$color = get_field('color');

if($revLayout === true) : 
	$rightCol = 'order-first';
	$leftCol = 'order-last';
else : 
	$rightCol = 'order-last';
	$leftCol = 'order-first';
endif;


$divideBackground = get_field('divide_background');
$dividedBackgroundColor = get_field('divided_background_color');

include(dirname(__DIR__).'/include/section-padding.php');
include(dirname(__DIR__).'/include/background-image.php');
include(dirname(__DIR__).'/include/divide-background.php');

//update headline color
if($dividedBackgroundColor === 'lightblue' || $dividedBackgroundColor === 'medblue' || $dividedBackgroundColor === 'darkblue' || $dividedBackgroundColor === 'lightblueg' || $dividedBackgroundColor === 'medblueg' || $dividedBackgroundColor === 'darkblueg'):
	$textColor = 'style="color: var(--wp--preset--color--fl-white);"';
endif;

// Create id attribute allowing for custom "anchor" value and section classes.
include(dirname(__DIR__).'/include/section-id.php');
$sectionClass = 'content-layout-6 ' . $sectionPadding;
include(dirname(__DIR__).'/include/section-classes.php');
?>

<?php include(dirname(__DIR__).'/clone/background-pattern.php'); ?>
<?php include(dirname(__DIR__).'/clone/background-image.php'); ?>


	<div class="container h-100">
		<div class="row justify-content-center">
      <div class="col-12">
				<?php if ($headline): echo '<h2 '. $textColor .'>'. $headline .'</h2>'; endif; ?>
				<?php if ($subHeadline): echo '<h3 '. $textColor .'>'. $subHeadline .'</h3>'; endif; ?>
			</div>
		</div>
		<div class="row g-0 mt-3" style="margin: 0 -15px; ">
			<div class="col-12 col-md-4 p-0 m-0 <?php echo $leftCol; ?>">

				<?php if( have_rows('cards') ): ?>
					<?php 
					if( $cards ) :
						$first_row = $cards[0];
						$image = $first_row['image'];
						$title = $first_row['title'];
						$description = $first_row['description'];
						$button = $first_row['button'];
						if (!empty($button)) :
							$link_url = $button['url'];
							$link_title = $button['title'];
							$link_target = $button['target'] ? $button['target'] : '_self';
						endif;

					?>
						<div class="card  h-md-100">
							<?php if ($image) : ?>
								<div class="card-img-top">
								<img src="<?php echo $image['url']; ?>"  alt="...">
								</div>
							<?php endif; ?>
							<div class="card-body card-body-<?php echo $color; ?>">
								<div class="bar bar-green"></div>
								<?php if ($title) : ?>
									<h5 class="card-title"><?php echo $title; ?></h5>
								<?php endif; ?>
								<?php if ($description) : ?>
									<p class="card-text"><?php echo $description; ?></p>
								<?php endif; ?>
								<?php if (!empty($button)) : ?>
									<div class="wp-block-buttons">
									<div class="wp-block-button">
									<a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
									</div></div>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
				<?php endif; ?>

			</div>
			<div class="col-12 col-md-8 d-flex flex-wrap flex-grow <?php echo $rightCol; ?>">
				<?php if( have_rows('cards') ): ?>
					<!-- <div class="col-6 card-rest d-flex flex-wrap flex-fill"> -->
					<?php $i = 0; while( have_rows('cards') ) : the_row(); $i++; if ($i != 1) :
							$image = get_sub_field('image');
							$title = get_sub_field('title');
							$description = get_sub_field('description');
							$button = get_sub_field('button');
							if (!empty($button)) : 
								$link_url = $button['url'];
								$link_title = $button['title'];
								$link_target = $button['target'] ? $button['target'] : '_self';
							endif;
					?>
					<div class="col-12 col-md-6 p-0 m-0 ">
						<div class="card h-100 ">
							<?php if ($image) : ?>
								<img src="<?php echo $image['url']; ?>" class="card-img-top" alt="...">
							<?php endif; ?>
							<div class="card-body card-body-<?php echo $color; ?>">
								<div class="bar bar-green"></div>
								<?php if ($title) : ?>
									<h4 class="card-title"><?php echo $title; ?></h4>
								<?php endif; ?>
								<?php if ($description) : ?>
									<?php echo $description; ?>
								<?php endif; ?>
								<?php if (!empty($button)) : ?>
									<div class="wp-block-buttons">
										<div class="wp-block-button">
											<a class="wp-block-button__link wp-element-button" href="<?php echo $link_url; ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
										</div>
									</div>
								<?php endif; ?>
							</div>
						</div>
								</div>
					<?php endif; endwhile; ?>
				<!-- </div> -->
				<?php endif; ?>

				</div>
		</div>

		<div class="row mt-5 justify-content-center">
			<div class="col-12">
					<InnerBlocks />
				</div>
		</div>

	</div>
	
	<?php if ($divideBackground) : ?>
  	<div class="content-layout-6-top  <?php echo $divideBGColor; ?>"></div>
	<?php endif; ?>

</section>
