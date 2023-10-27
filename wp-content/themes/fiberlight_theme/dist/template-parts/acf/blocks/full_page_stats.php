<?php
/**
 *  Full Page Stats
 *
 */

// Load custom field values.
$backgroundImage = get_field('background_image');
$backgroundImageMobile = get_field('background_image_mobile');
$backgroundPattern = get_field('background_pattern');
$image = get_field('image');
$mediaType = get_field('media_type');
$videoType = get_field('video_type');
$vimeoEmbedID = get_field('vimeo_id');
$youtubeEmbedID = get_field('youtube_id');
// Stats size attributes.
$statsSizeXXL = 'hero-slide-stats-xxl';
$statsImageXXL = $image['sizes'][ $statsSizeXXL ];
$widthXXL = $image['sizes'][ $statsSizeXXL . '-width' ];
$heightXXL = $image['sizes'][ $statsSizeXXL . '-height' ];

include(dirname(__DIR__).'/include/background-image.php');

// Create id attribute allowing for custom "anchor" value and section classes.
include(dirname(__DIR__).'/include/section-id.php');
$sectionClass = 'full-page-stats';
include(dirname(__DIR__).'/include/section-classes.php');
?>

<?php include(dirname(__DIR__).'/clone/background-pattern.php'); ?>
<?php include(dirname(__DIR__).'/clone/background-image.php'); ?>



	<div class="container h-100">
		<div class="row justify-content-center d-flex h-100">
			<div class="col-12 col-md-6 col-lg-5 order-last order-md-first mt-4 mb-4 mt-md-0 mt-md-0 align-self-center">
				<InnerBlocks />
			</div>
			<div class="col-12 col-md-6 col-lg-6 order-first order-md-last align-self-center align-self-lg-start">

				<div id="stats" class="stats break-section-above">
					<?php if( have_rows('stats') ): ?>
						<div class="stat-wrap ">
							<?php
								while( have_rows('stats') ) : the_row();
									$stats = get_sub_field('stat');
									$number = get_field( 'number', $stats->ID );
									$description = get_field( 'description', $stats->ID );
							?>
								<div class="stat-item d-flex d-md-block flex-row justify-content-center">
									<div class="number align-self-center">
										<div class="number-item">
											<?php echo esc_html( $number ); ?>
										</div>
									</div>
									<div class="description align-self-center">
										<?php echo esc_html( $description ); ?>
									</div>
								</div>
							<?php endwhile; ?>
						</div>
					<?php endif; ?>

					<?php if ($mediaType === 'image' && $image): ?>
						<div class="image-wrap pt-3">
							<picture>
								<source media="(max-width: 1399.98px)" srcset="<?php echo esc_url($statsImageXL); ?>" width="<?php echo $widthXL; ?>" height="<?php echo $heightXL; ?>">
								<img src="<?php echo esc_url($statsImageXXL); ?>" alt="<?php echo esc_attr($image['alt']); ?>"
									class="img-fluid break-section-above" width="<?php echo $widthXXL; ?>" height="<?php echo $heightXXL; ?>" loading="lazy" />
							</picture>
						</div>
					<?php endif; ?>

					<?php if ($mediaType === 'video'): ?>
						<div class="embed-responsive embed-responsive-16by9 mt-3">
							<div id="statsVideoPlayer-<?php echo $block['id']; ?>" class="embed-responsive-item vimeo-video"></div>		
						</div>	
					<?php endif; ?>


				</div>
			</div>
		</div>
	</div>
</section>

<?php if ($mediaType === 'video' && $videoType == 'vimeo') : ?>
		<script src="https://player.vimeo.com/api/player.js"></script>
		<script>
			var videoID = '<?php echo $vimeoEmbedID; ?>';
			var options<?php echo $block['id']; ?> = {
				id: videoID,
				controls: true,
				autoplay: false,
			};
			jQuery(document).ready(function(){
					let player<?php echo $block['id']; ?> = new Vimeo.Player('statsVideoPlayer-<?php echo $block['id']; ?>', options<?php echo $block['id']; ?>);
					player<?php echo $block['id']; ?>.play();
			});
		</script>
<?php endif; ?>

<?php if ($mediaType === 'video' && $videoType == 'youtube') : ?>
	<script>
			var tag = document.createElement('script');

			tag.src = "https://www.youtube.com/iframe_api";
			var firstScriptTag = document.getElementsByTagName('script')[0];
			firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

			var player<?php echo $block['id']; ?>;
			function onYouTubeIframeAPIReady() {
				var videoID = '<?php echo $youtubeEmbedID; ?>';
				player<?php echo $block['id']; ?> = new YT.Player('statsVideoPlayer-<?php echo $block['id']; ?>', {
					videoId: videoID,
						events: {
						'onReady': onPlayerReady,
						}
				});
			}
			function onPlayerReady(event) {
				// player<?php echo $block['id']; ?>.mute();
				// player<?php echo $block['id']; ?>.playVideo();
			}
	</script>
<?php endif; ?>