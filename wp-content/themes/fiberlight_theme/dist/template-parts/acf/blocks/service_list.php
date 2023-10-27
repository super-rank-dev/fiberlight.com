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
$services = get_field('services');
$overlap = get_field('overlap_sections');

include(dirname(__DIR__).'/include/section-padding.php');
include(dirname(__DIR__).'/include/background-image.php');

if ($overlap) : 
	if ($padding === 'no'):
		$sectionOverlap = 'overlapNone';
		
	elseif ($padding === 'half'):
		$sectionOverlap = 'overlapHalf';
	elseif ($padding === 'third'):
		$sectionOverlap = 'overlapThird';
	else:
		$sectionOverlap = 'overlapDefault';
	endif;
endif;


// Create id attribute allowing for custom "anchor" value and section classes.
include(dirname(__DIR__).'/include/section-id.php');
$sectionClass = 'service-list ' . $sectionPadding;
include(dirname(__DIR__).'/include/section-classes.php');
?>


	<?php include(dirname(__DIR__).'/clone/background-pattern.php'); ?>
	<?php include(dirname(__DIR__).'/clone/background-image.php'); ?>


	<div class="services-wrap <?php echo $sectionOverlap; ?>">
		<div class="container">
				<?php if( have_rows('services') ): ?>
					<div class="row  justify-content-start d-flex">
					<?php
						while( have_rows('services') ) : the_row();
							$service = get_sub_field('service');
							$icon = get_field( 'icon', $service->ID );
							$title = get_field( 'title', $service->ID );
							$description = get_field( 'description', $service->ID );
							$page = get_field( 'page', $service->ID );
							if ($page): 
							$link = $page['url'];
							$linkTarget = $page['target'] ? $page['target'] : '_self';
							endif; 
					?>
							<div class="col-12 col-md-6 pt-3 pb-3">
								<div class="card background-tan<?php if( get_row_index() % 2 == 0 ){ echo '-alt'; } ?> h-100">
									<div class="row">
										<div class="col-12 col-md-2 d-none d-md-block">
											<img src="<?php echo $icon['url']; ?>" alt="<?php echo $icon['alt']; ?>" class="img-fluid">
										</div>
										<div class="col-12 col-md-10">
											<h4><?php echo esc_html( $title ); ?></h4>
											<div class="bar bar-green d-block d-md-none"></div>
											<p class="text-center text-md-start"><?php echo esc_html( $description ); ?></p>
											<?php if ($page) : ?>
											<div class="wp-block-buttons">
												<div class="wp-block-button">
													<a href="<?php echo $link; ?>" target="<?php echo $linkTarget; ?>" class="wp-block-button__link" aria-label="<?php echo esc_html( $title ); ?>">Learn More</a>
												</div>
											</div>
											<?php endif; ?>
										</div>
									</div>
								</div>
							</div>
						<?php endwhile; ?>
					</div>
				<?php endif; ?>
		</div>
	</div>	

</section>
