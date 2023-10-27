<?php
/**
 * Content Layout 1
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */


$termsState = get_terms( array( 'taxonomy' => 'State', 'hide_empty' => true, 'order' => 'ASC', 'orderby' => 'name' ));


// Load custom field values.
$backgroundImage = get_field('background_image');
$backgroundImageMobile = get_field('background_image_mobile');
$backgroundPattern = get_field('background_pattern');
$headline = get_field('headline');
$subHeadline = get_field('sub_headline');
$image = get_field('image');

include(dirname(__DIR__).'/include/background-image.php');
include(dirname(__DIR__).'/include/section-padding.php');

 // Create id attribute allowing for custom "anchor" value and section classes.
 include(dirname(__DIR__).'/include/section-id.php');
 $sectionClass = 'content-layout-1 ' . $sectionPadding;
 include(dirname(__DIR__).'/include/section-classes.php');

?>

<?php include(dirname(__DIR__).'/clone/background-pattern.php'); ?>
<?php include(dirname(__DIR__).'/clone/background-image.php'); ?>

	<div class="container h-100">
		<div class="row justify-content-start align-items-start align-items-md-center align-items-lg-start h-100">
			<div class="col-12">

				<div class="row justify-content-start align-items-start">
					<div class="col-12 col-md-8">
						<?php if ($image): ?>
							<div class="picture-wrap">
									<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo $image['alt']; ?>"
										class="img-fluid" loading="lazy" />
							</div>
						<?php endif; ?>
					</div>
					<div class="col-12 col-md-4 ">

					
						<div class="accordion" id="accordion-coverage-map">
						<?php if ($subHeadline) : echo '<h3>'. $subHeadline .'</h3>'; endif; ?>
							<?php foreach ( $termsState as $term ) : ?>
							<div class="accordion-item">
								<h2 class="accordion-header" id="heading-<?php echo $term->slug; ?>">
									<a class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $term->slug; ?>" aria-expanded="false" aria-controls="collapse-<?php echo $term->slug; ?>" role="button">
										<?php echo $term->name; ?>
									</a>
								</h2>
								<div id="collapse-<?php echo $term->slug; ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?php echo $term->slug; ?>" data-bs-parent="#accordion-coverage-map" role="region">
									<div class="accordion-body">

										<?php
											// WP_Query arguments
											$args = array(
												'post_type'              => array( 'coverage-map' ),
												'post_status'            => array( 'publish' ),
												'nopaging'               => true,
												'posts_per_page'         => '-1',
												'order'                  => 'ASC',
												'orderby'                => 'title',
												'tax_query' => array(
															array(
																	'taxonomy' => 'State',
																	'field' => 'slug',
																	'terms' => $term->slug,
															),
													),
											);
											
											// The Query
											$query = new WP_Query( $args );
										?>

										<?php if ( $query->have_posts() )  : ?>
										<div class="row">
											<?php while ( $query->have_posts() ) : $query->the_post(); ?>
												<div class="col-12 col-lg-6">
													<a href="<?php echo the_permalink(); ?>"><?php echo the_title(); ?></a>
												</div>
											<?php endwhile; ?>
										</div>
										<?php endif;
											// Restore original Post Data
											wp_reset_postdata();
										?>

									
									</div>
								</div>
							</div>
							<?php endforeach; ?>
						</div>

					</div>
				</div>
				<div class="row justify-content-center align-items-start mt-0 mt-md-4">
					<div class="col-12 col-md-5">
						<?php if ($headline): echo '<h2>'. $headline .'</h2>'; endif; ?>
					</div>
					<div class="col-12 col-md-7">
						<InnerBlocks />
					</div>
				</div>

			</div>
		</div>

	</div>
</section>