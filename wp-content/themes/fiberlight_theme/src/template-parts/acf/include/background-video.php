<?php if ($backgroundType === 'video') : ?>
	<div class="background-video-wrap">
		<div id="bgVideoPlayer-<?php echo $block['id']; ?>" class="background-video"></div>		
	</div>	
<?php endif; ?>

<?php if ($backgroundType == 'video' && $deskVideoType == 'vimeo') : ?>
		<script src="https://player.vimeo.com/api/player.js"></script>
		<script>
			var videoID = '<?php echo $deskVimeoID; ?>';
			var options<?php echo $block['id']; ?> = {
				id: videoID,
				background: true,
				loop: true,
				controls: false,
				autoplay: true,
				muted: true,
				height: '100'
			};
			jQuery(document).ready(function(){
					let player<?php echo $block['id']; ?> = new Vimeo.Player('bgVideoPlayer-<?php echo $block['id']; ?>', options<?php echo $block['id']; ?>);
					player<?php echo $block['id']; ?>.play();
			});
		</script>
<?php endif; ?>

<?php if ($backgroundType == 'video' && $deskVideoType == 'youtube') : ?>
	<script>
			var tag = document.createElement('script');

			tag.src = "https://www.youtube.com/iframe_api";
			var firstScriptTag = document.getElementsByTagName('script')[0];
			firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

			var player<?php echo $block['id']; ?>;
			function onYouTubeIframeAPIReady() {
				var videoID = '<?php echo $deskYouTubeID; ?>';
				player<?php echo $block['id']; ?> = new YT.Player('bgVideoPlayer-<?php echo $block['id']; ?>', {
					autoplay: 1, // Auto-play the video on load
					disablekb: 1,
					controls: 0, // Hide pause/play buttons in player
					modestbranding: 1, // Hide the Youtube Logo
					loop: 1, // Run the video in a loop
					fs: 0, // Hide the full screen button
					rel: 0,
					enablejsapi: 1,
					videoId: videoID,
						events: {
						'onReady': onPlayerReady,
						}
				});
			}
			function onPlayerReady(event) {
				player<?php echo $block['id']; ?>.mute();
				player<?php echo $block['id']; ?>.playVideo();
			}
	</script>
<?php endif; ?>