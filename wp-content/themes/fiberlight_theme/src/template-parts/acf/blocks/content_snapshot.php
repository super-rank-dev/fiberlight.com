<?php
/**
 * Content Snapshot
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
$colorTheme = get_field('color_theme');
$content = get_field('content');
$breadcrumbs = get_field('breadcrumbs_breadcrumbs');
$image = get_field('image');

include(dirname(__DIR__).'/include/section-padding.php');
include(dirname(__DIR__).'/include/background-image.php');

 // Create id attribute allowing for custom "anchor" value and section classes.
 include(dirname(__DIR__).'/include/section-id.php');
 $sectionClass = 'content-snapshot ' . $sectionPadding;
 include(dirname(__DIR__).'/include/section-classes.php');

?>

<?php include(dirname(__DIR__).'/clone/background-pattern.php'); ?>
<?php include(dirname(__DIR__).'/clone/background-image.php'); ?>

	<div class="container h-100">
		<div class="row justify-content-center align-items-start">
			<div class="col-12 col-lg-6 order-last order-lg-first mt-4 mt-lg-0">
				<div class="content">
					<InnerBlocks />
				</div>
			</div>
			<div class="col-12 col-lg-6 order-first order-lg-last">
				<div class="snapshot snapshot-<?php echo $colorTheme; ?>">
					<div class="row">
						<div class="col-12 col-md-8">
							<?php if( have_rows('breadcrumbs_breadcrumbs') ): ?>
								<?php echo '<div id="'. esc_attr($id) .'" class="breadcrumbs">'; ?>
									<?php
										while( have_rows('breadcrumbs_breadcrumbs') ) : the_row();

										$label = get_sub_field('label');
										$link = get_sub_field('link');

										if($link) :
										$link_url = $link['url'];
										$link_target = $link['target'] ? $link['target'] : '_self';
										endif;

									?>
										<div class="item">
											<?php 
												if($link) : echo '<a href="'. $link_url .'" target="'. $link_target .'">'; endif; 
												echo $label; 
												if($link): echo '</a>'; endif;
											?>
										</div>
									<?php endwhile; ?>
								</div>
							<?php endif; ?>
								<?php if ($headline) : echo '<h2>'. $headline .'</h2>'; endif; ?>
								<?php if ($subHeadline) : echo '<h3>'. $subHeadline .'</h3>'; endif; ?>
								<?php if ($content) : echo $content; endif; ?>
						</div>	
						<div class="col-12 col-md-4">
							<div class="picture-wrap pt-3 pt-md-0">

							<?php if (is_admin()) : ?>
								<?php if ($image) : ?>
								<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"
										class="img-fluid" loading="lazy" />
										<?php endif; ?>
							<?php else : ?>
								<?php if ($image) : ?>
								<picture>
									<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"
										class="img-fluid" loading="lazy" />
								</picture>
								<?php endif; ?>
							<?php endif; ?>


							</div>
						</div>
					</div>
				</div>
				<?php if( have_rows('stats') ): ?>
									<?php echo '<div class="row stats-row">'; ?>
										<?php
											while( have_rows('stats') ) : the_row();

											$number = get_sub_field('number');
											$description = get_sub_field('description');

										?>
											<div class="col-4 p-0 p-md-2">
												<div class="stats stats-<?php echo $colorTheme; ?> text-center">
													<?php if ($number) : echo '<span class="number">'. $number .'</span>'; endif; ?>
													<?php if ($description) : echo '<span class="description">'. $description .'</span>'; endif; ?>
												</div>
											</div>
										<?php endwhile; ?>
									</div>
								<?php endif; ?>
			</div>
		</div>
	</div>
</section>