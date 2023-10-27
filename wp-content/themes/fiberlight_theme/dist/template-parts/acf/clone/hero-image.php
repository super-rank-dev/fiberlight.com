<?php
  $backgroundType = get_field('background_type');
  $deskVideoType = get_field('desktop_video_type');
  $deskVimeoID = get_field('desktop_vimeo_id');
  $deskYouTubeID = get_field('desktop_youtube_id');
?>

<style>
  .single .post-hero .background-image img.override{
    <?php if ($objectFitDesktop): echo 'object-fit: '. $objectFitDesktop .'!important;'; endif; ?>
    <?php if ($objectPositionDesktop): echo 'object-position: '. $objectPositionDesktop .'!important;'; endif; ?>
  }
  @media (max-width: 991.98px) { 
    .single .post-hero .background-image img.override{
      <?php if ($objectFitTablet): echo 'object-fit: '. $objectFitTablet .'!important;'; endif; ?>
      <?php if ($objectPositionTablet): echo 'object-position: '. $objectPositionTablet .'!important;'; endif; ?>
    } 
  }
  @media (max-width: 575.98px) { 
    .single .post-hero .background-image img.override{
    <?php if ($objectFitMobile): echo 'object-fit: '. $objectFitMobile .'!important;'; endif; ?>
    <?php if ($objectPositionMobile): echo 'object-position: '. $objectPositionMobile .'!important;'; endif; ?>
    }
  }
</style>



<?php if ($backgroundType == 'image' || $archivePage = 'Y' || $singlePage = 'Y') : ?>
  <?php if ($heroImage || $heroImageTablet || $heroImageMobile): ?>
    <div class="darken"></div>
    <?php if (is_admin()) : ?>
      <div class="background-image">
        <img src="<?php echo $heroImage['url']; ?>" alt="<?php echo $heroImage['alt']; ?>" />
      </div>
    <?php else : ?>
      <div class="background-image">
        <picture>
          <?php if ($heroImageMobile): ?>
            <source srcset="<?php echo responsive_image( $heroImageMobile, 'bg-half-height-xs' ); ?>" media="(max-width: 575.98px)">
          <?php endif; ?>
          <?php if ($heroImageTablet): ?>
            <source srcset="<?php echo responsive_image( $heroImageTablet, 'bg-half-height-md' ); ?>" media="(max-width: 991.98px)">
          <?php else : ?>
            <source srcset="<?php echo responsive_image( $heroImage, 'bg-half-height-lg' ); ?>" media="(max-width: 991.98px)">
          <?php endif; ?>
          <source srcset="<?php echo responsive_image( $heroImage, 'bg-half-height-lg' ); ?>" media="(max-width: 1199.98px)">
          <source srcset="<?php echo responsive_image( $heroImage, 'bg-half-height-xl' ); ?>" media="(max-width: 1399.98px)">
          <img src="<?php echo responsive_image( $heroImage, 'bg-half-height-xxl' ); ?>" class="img-fluid override" alt="<?php echo $heroImageAlt; ?>" loading="eager" >
        </picture>
      </div>
    <?php endif; ?>
  <?php elseif ($heroImageFeatured) : ?>
    <div class="darken"></div>
    <div class="background-image">
      <picture>
        <source srcset="<?php echo responsive_image( $heroImageFeatured, 'bg-half-height-xs' ); ?>" media="(max-width: 575.98px)">
        <source srcset="<?php echo responsive_image( $heroImageFeatured, 'bg-half-height-md' ); ?>" media="(max-width: 991.98px)">
        <source srcset="<?php echo responsive_image( $heroImageFeatured, 'bg-half-height-lg' ); ?>" media="(max-width: 1199.98px)">
        <source srcset="<?php echo responsive_image( $heroImageFeatured, 'bg-half-height-xl' ); ?>" media="(max-width: 1399.98px)">
        <img src="<?php echo responsive_image( $heroImageFeatured, 'bg-half-height-xxl' ); ?>" class="img-fluid" style="<?php if($objectPositionDesk) : echo 'object-position: '. $objectPositionDesk .';'; endif; if($objectFitDesk) : echo 'object-fit: '. $objectFitDesk .';'; endif; ?>" alt="<?php echo $heroImageAlt; ?>" loading="eager" >
      </picture>
    </div>
  <?php endif; ?>
<?php endif; ?>

<?php include(dirname(__DIR__).'/include/background-video.php'); ?>