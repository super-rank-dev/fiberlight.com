<?php
  $backgroundType = get_field('background_type');
  $deskVideoType = get_field('desktop_video_type');
  $deskVimeoID = get_field('desktop_vimeo_id');
  $deskYouTubeID = get_field('desktop_youtube_id');

  $objectFitDesk = get_field('object_fit_desktop');
  $objectPositionDesk = get_field('object_position_desktop');
  $objectWidthDesk = get_field('object_width_desktop');
  $objectHeightDesk = get_field('object_height_desktop');
  $objectFitMobile = get_field('object_fit_mobile');
  $objectPositionMobile = get_field('object_position_mobile');
  $objectWidthMobile = get_field('object_width_mobile');
  $objectHeightMobile = get_field('object_height_mobile');
?>

<?php 
  if ($objectFitDesk || $objectPositionDesk || $objectWidthDesk || $objectHeightDesk) : 
    echo '<style>';
    echo '@media (min-width: 576px) { .override-bg-'. $block['id'] .'{';
    if ($objectFitDesk): echo 'object-fit: '. $objectFitDesk .'!important;'; endif;
    if ($objectPositionDesk): echo 'object-position: '. $objectPositionDesk .'!important;'; endif;
    if ($objectWidthDesk): echo 'width: '. $objectWidthDesk .'!important;'; endif;
    if ($objectHeightDesk): echo 'height: '. $objectHeightDesk .'!important;'; endif;
    echo '}}';
    echo '</style>';
  endif;
  if ($objectFitMobile || $objectPositionMobile || $objectWidthMobile || $objectHeightMobile) : 
    echo '<style>';
    echo '@media (max-width: 575.98px) { .override-bg-'. $block['id'] .'{';
    if ($objectFitMobile): echo 'object-fit: '. $objectFitMobile .'!important;'; endif;
    if ($objectPositionMobile): echo 'object-position: '. $objectPositionMobile .'!important;'; endif;
    if ($objectWidthMobile): echo 'width: '. $objectWidthMobile .'!important;'; endif;
    if ($objectHeightMobile): echo 'height: '. $objectHeightMobile .'!important;'; endif;
    echo '}}';
    echo '</style>';
  endif;
?>

<?php if ($backgroundType == 'image') : ?>
  <?php if ($backgroundImage || $backgroundImageMobile): ?>
    <div class="darken"></div>
    <?php if (is_admin()) : ?>
      <div class="background-image">
        <img src="<?php echo $backgroundImage['url']; ?>" alt="<?php echo $backgroundImage['alt']; ?>" />
      </div>
    <?php else : ?>
      <div class="background-image">
        <picture>
          <?php if ($backgroundImageMobile): ?>
            <source srcset="<?php echo responsive_image( $backgroundImageMobile, 'bg-full-height-xs' ); ?>" media="(max-width: 575.98px)">
          <?php endif; ?>
          <source srcset="<?php echo responsive_image( $backgroundImage, 'bg-full-height-md' ); ?>" media="(max-width: 991.98px)">
          <source srcset="<?php echo responsive_image( $backgroundImage, 'bg-full-height-lg' ); ?>" media="(max-width: 1199.98px)">
          <source srcset="<?php echo responsive_image( $backgroundImage, 'bg-full-height-xl' ); ?>" media="(max-width: 1399.98px)">
          <img src="<?php echo responsive_image( $backgroundImage, 'bg-full-height-xxl' ); ?>" class="img-fluid override-bg-<?php echo $block['id']; ?>" loading="lazy" alt="<?php echo $backgroundImage['alt']; ?>">
        </picture>
      </div>
    <?php endif; ?>
  <?php endif; ?>
<?php endif; ?>

<?php include(dirname(__DIR__).'/include/background-video.php'); ?>