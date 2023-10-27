<?php
/**
 * Video
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
$posterImage = get_field('poster_image');
$videoType = get_field('video_type');
$vimeoEmbedID = get_field('vimeo_embed_id');
$youtubeEmbedID = get_field('youtube_embed_id');

include(dirname(__DIR__).'/include/section-padding.php');
include(dirname(__DIR__).'/include/background-image.php');

// Create id attribute allowing for custom "anchor" value and section classes.
include(dirname(__DIR__).'/include/section-id.php');
$sectionClass = 'video ' . $sectionPadding;
include(dirname(__DIR__).'/include/section-classes.php');
?>

<?php include(dirname(__DIR__).'/clone/background-pattern.php'); ?>
<?php include(dirname(__DIR__).'/clone/background-image.php'); ?>

	<div class="container">
		<div class="row align-items-center justify-content-center">
			<div class="col-12 col-lg-3 order-last order-lg-first">
				<div class="video-description has-background has-fl-light-blue-background-color has-fl-light-blue-background">
        <div class="bar bar-green"></div>
					<InnerBlocks />
				</div>
			</div>
			<div class="col-12 col-lg-8 order-first order-lg-last">
				<div id="video-wrap-<?php echo $block['id']; ?>" class="embed-responsive embed-responsive-16by9 video-wrap">
					<?php if ($posterImage): ?>
						<div id="btn-play-icon-<?php echo $block['id']; ?>" class="btn-play-icon"></div>
						<div id="darken-<?php echo $block['id']; ?>" class="darken"></div>
						<div id="picture-wrap-<?php echo $block['id']; ?>" class="picture-wrap">
							<picture>
								<img src="<?php echo esc_url($posterImage['url']); ?>" alt="<?php echo esc_attr($posterImage['alt']); ?>"
									class="img-fluid" loading="lazy" />
							</picture>
						</div>
					<?php endif; ?>

					<?php if ($videoType == 'vimeo' && isset($vimeoEmbedID) && !is_admin()) : ?>
						<div data-vimeo-id="<?php echo $vimeoEmbedID; ?>" data-vimeo-width="100%" id="myVimeoVideo-<?php echo $block['id']; ?>" class="embed-responsive-item vimeo-video"></div>
					<?php endif; ?>

					<?php if ($videoType == 'youtube') : ?>
						<div class="embed-responsive embed-responsive-16by9">
							<div id="player" class="embed-responsive-item vimeo-video"></div>
						</div>
					<?php endif; ?>

				</div>
			</div>
    </div>
</section>


<?php if ($videoType == 'vimeo' && isset($vimeoEmbedID)) : ?>
	<script src="https://player.vimeo.com/api/player.js"></script>
	<script>
		jQuery(document).ready(function(){
			jQuery("#video-wrap-<?php echo $block['id']; ?>").click(function(){
				jQuery("#picture-wrap-<?php echo $block['id']; ?>").hide();
				jQuery("#btn-play-icon-<?php echo $block['id']; ?>").hide();
				jQuery("#darken-<?php echo $block['id']; ?>").hide();
				let player = new Vimeo.Player('myVimeoVideo-<?php echo $block['id']; ?>');
				player.play();
			});
		});
	</script>
<?php endif; ?>

<?php if ($videoType == 'youtube') : ?>
	<script>
		  // 1. This code loads the IFrame Player API code asynchronously.
			var tag = document.createElement('script');

			tag.src = "https://www.youtube.com/iframe_api";
			var firstScriptTag = document.getElementsByTagName('script')[0];
			firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

			// 2. This function creates an <iframe> (and YouTube player)
			//    after the API code downloads.
			var player;
			function onYouTubeIframeAPIReady() {
				 var videoID = '<?php echo $youtubeEmbedID; ?>';
					player = new YT.Player('player', {
							height: '390',
							width: '640',
							videoId: videoID,
							rel: 0,
							events: {
							'onReady': onPlayerReady,
							}
					});
			}

			function onPlayerReady(event) {
				jQuery("#video-wrap-<?php echo $block['id']; ?>").click(function(){
					jQuery("#picture-wrap-<?php echo $block['id']; ?>").hide();
					jQuery("#btn-play-icon-<?php echo $block['id']; ?>").hide();
					jQuery("#darken-<?php echo $block['id']; ?>").hide();
					player.playVideo();
				});
			}


	</script>
<?php endif; ?>