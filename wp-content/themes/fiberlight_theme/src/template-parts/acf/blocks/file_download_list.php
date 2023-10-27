<?php
 // Load custom field values.
$backgroundImage = get_field('background_image');
$backgroundImageMobile = get_field('background_image_mobile');
$backgroundPattern = get_field('background_pattern');
$padding = get_field('padding');

include(dirname(__DIR__).'/include/section-padding.php');
include(dirname(__DIR__).'/include/background-image.php');

 // Create id attribute allowing for custom "anchor" value and section classes.
 include(dirname(__DIR__).'/include/section-id.php');
 $sectionClass = 'file-download-list ' . $sectionPadding;
 include(dirname(__DIR__).'/include/section-classes.php');
?>

<?php include(dirname(__DIR__).'/clone/background-pattern.php'); ?>
<?php include(dirname(__DIR__).'/clone/background-image.php'); ?>

	<div class="container">
		<div class="row p-4">

      <?php if( have_rows('download_list') ): while( have_rows('download_list') ) : the_row(); 
        
        $download = get_sub_field('download_file');
        $downloadURL = $download['url'];
        $downloadLabel = get_sub_field('download_button_label');
        $downloadIcon = get_sub_field('download_icon');
        $downloadIconURL = $downloadIcon['url'];
        $downloadIconAlt = $downloadIcon['alt'];
            
      ?>
        <div class="col-12 col-md-4 text-center pt-3">
          <a href="<?php echo $downloadURL; ?>" target="_blank">
          <div class="the-download text-center h-100">
            <?php if ($downloadIcon) : ?>
              <?php echo '<img src="'. $downloadIconURL .'" class="icon_download" alt="'. $downloadTitle .'" >';  ?>
            <?php else : ?>
                <?php echo '<img src="/wp-content/themes/fiberlight_theme/dist/images/icon_downlaod.svg" class="icon_download" alt="'. $downloadTitle  .'">'; ?>
            <?php endif; ?>
            <h5><?php echo $downloadLabel; ?></h5>
            <hr class="wp-block-separator has-css-opacity" >
          </div>
          </a>
        </div>
      <?php endwhile; endif; ?>
		</div>
	</div>
</section>