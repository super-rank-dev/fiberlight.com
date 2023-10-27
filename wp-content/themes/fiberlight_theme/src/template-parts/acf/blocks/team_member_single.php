<?php
/**
 * Team Member Single
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Load custom field values.
$teamMember = get_field('team_member');
$permalink = get_the_permalink( $teamMember->ID );
$name = get_the_title( $teamMember->ID );
$title = get_field( 'title', $teamMember->ID );
$region = get_field( 'region', $teamMember->ID );

$department = wp_get_object_terms( $teamMember->ID, 'Department' );

$linkedIn = get_field( 'linkedin_url', $teamMember->ID );
$email = get_field( 'email_address', $teamMember->ID );
$bio = get_field( 'bio', $teamMember->ID );

$headshot = get_field( 'headshot', $teamMember->ID );
$headshotALT = $headshot['alt'];

preg_match('/<p>(.*?)<\/p>/s', $bio, $bioPara);


include(dirname(__DIR__).'/include/section-padding.php');
include(dirname(__DIR__).'/include/background-image.php');

 // Create id attribute allowing for custom "anchor" value and section classes.
 include(dirname(__DIR__).'/include/section-id.php');
 $sectionClass = 'team-member-single ' . $sectionPadding;
 include(dirname(__DIR__).'/include/section-classes.php');

?>

<?php include(dirname(__DIR__).'/clone/background-pattern.php'); ?>
<?php include(dirname(__DIR__).'/clone/background-image.php'); ?>

	<div class="container">
    <div class="row justify-content-center g-0" style="position: relative;">
      <div class="col-12 col-md-3" style="position: relative; z-index: 10;">
        <div class="image-wrap">
          <picture>
            <source srcset="<?php echo responsive_image( $headshot, 'headshot-single-block-xs' ); ?>" media="(max-width: 575.98px)">
            <source srcset="<?php echo responsive_image( $headshot, 'headshot-single-block-md-2x' ); ?>" media="(max-width: 991.98px)">
            <source srcset="<?php echo responsive_image( $headshot, 'headshot-single-block-lg' ); ?>" media="(max-width: 1199.98px)">
            <source srcset="<?php echo responsive_image( $headshot, 'headshot-single-block-xl' ); ?>" media="(max-width: 1399.98px)">
            <img src="<?php echo responsive_image( $headshot, 'headshot-single-block-xxl' ); ?>" class="img-fluid" alt="<?php echo $headshotALT; ?>" loading="lazy" >
          </picture>
        </div> 
      </div>
      <div class="col-12 col-md-8 col-lg-7" style="position: relative; z-index: 5;">
        <div class="row mt-0 mt-md-3 mt-lg-4" >
          <div class="col-12" >
            <div class="box-name">
            <h2><?php echo $name; ?></h2>
            <?php 
                  if ($title) : 
                    echo '<p class="title">';
                    echo $title; 
                    echo '</p>';
                  endif;

                  if ($department || $region) : 
                    echo '<p class="title department">';
                    foreach ($department as $departments){
                      echo '<span class="department-item">'. $departments->name .'</span>';
                    }
                    if ($region && $department) : 
                      echo ', '. $region; 
                    else : 
                      echo $region; 
                    endif; 
                    echo '</p>'; 
                  endif; 
                ?>
            </div>
          </div>
        </div>
        <div class="row" >
          <div class="col-12">
            <div class="box-description" >
              <?php echo $bioPara[0]; ?>
              <a href="<?php echo $permalink; ?>" class="box-description-btn"><?php echo the_field('team_member_button_text', 'option'); ?></a>

              <?php if ($linkedIn) : ?>
                <a href="<?php echo $linkedIn; ?>" target="_blank">
                  <img src="/wp-content/themes/fiberlight_theme/dist/images/icon_linkedin.svg" class="icon">
                </a>
              <?php endif; ?>

              <?php if ($email) : ?>
                <a href="mailto:<?php echo $email; ?>" target="_blank">
                  <img src="/wp-content/themes/fiberlight_theme/dist/images/icon_email.svg" class="icon">
                </a>
              <?php endif; ?>



            </div>
          </div>
        </div>            
      </div>
    </div>
	</div>
</section>