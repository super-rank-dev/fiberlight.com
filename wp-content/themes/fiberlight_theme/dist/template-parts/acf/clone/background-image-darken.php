<?php
  $backgroundType = get_field('background_type');
  $deskVideoType = get_field('desktop_video_type');
  $deskVimeoID = get_field('desktop_vimeo_id');
  $deskYouTubeID = get_field('desktop_youtube_id');
?>

<?php if (($backgroundImage || $backgroundImageMobile) && $backgroundType == 'image'): ?>
  <?php if ($overlay == true) : ?><div class="darken"></div><?php endif; ?>
    <div class="background-image">
    <?php if (is_admin()) : ?>
          <img src="<?php echo $backgroundImage['url']; ?>" alt="<?php echo $backgroundImage['alt']; ?>" />
      <?php else : ?>
        <picture>
          <?php if ($backgroundImageMobile): ?>
            <source srcset="<?php echo responsive_image( $backgroundImageMobile, 'bg-full-height-xs' ); ?>" media="(max-width: 575.98px)">
          <?php endif; ?>
          <source srcset="<?php echo responsive_image( $backgroundImage, 'bg-full-height-md' ); ?>" media="(max-width: 991.98px)">
          <source srcset="<?php echo responsive_image( $backgroundImage, 'bg-full-height-lg' ); ?>" media="(max-width: 1199.98px)">
          <source srcset="<?php echo responsive_image( $backgroundImage, 'bg-full-height-xl' ); ?>" media="(max-width: 1399.98px)">
          <img src="<?php echo responsive_image( $backgroundImage, 'bg-full-height-xxl' ); ?>" class="img-fluid" style="<?php if($objectPositionDesk) : echo 'object-position: '. $objectPositionDesk .';'; endif; if($objectFitDesk) : echo 'object-fit: '. $objectFitDesk .';'; endif; ?>" alt="<?php echo $objectImageAlt; ?>" loading="eager" >
        </picture>
      <?php endif; ?>
    </div>
<?php endif; ?>

<?php include(dirname(__DIR__).'/include/background-video.php'); ?>
