<?php
/**
 * @package WordPress
 * @subpackage Fiberlight Theme
 */

  // Load custom field values.
  $title = get_field('title');
  $linkedIn = get_field('linkedin_url');
  $bio = get_field('bio');
  $teamPage = get_field('team_member_page', 'options');

  $headshot = get_field('headshot');
  $headshotALT = $headshot['alt'];

  $heroImage = get_field('team_member_hero_image', 'options');
  $heroImageALT = $heroImage['alt'];

 ?>

<article <?php post_class() ?> id="post-<?php the_ID(); ?>">

  <section class="post-hero has-fl-dark-blue-background">
    <?php
      include(dirname(__DIR__).'/template-parts/acf/clone/hero-image.php');
    ?>
  </section>

  <section class="team-member has-fl-tan-background-color has-background">
    <div class="container move-up">
      <div class="row justify-content-center">
        <div class="col-12 col-xl-10" style="position: relative;">
          <div class="team-member-box">
            <div class="team-member-box-outline d-none d-md-block"></div>
            <div class="team-member-box-content">
              <div class="row justify-content-center">
                <div class="col-12">
                  <div id="breadcrumbs" class="breadcrumbs">
                    <div class="item">Company</div>
                    <div class="item"><a href="<?php echo $teamPage; ?>">Leadership & BOD</a></div>
                  </div>
                </div>
              </div>
              <div class="row justify-content-start">
                <div class="col-12 col-md-3 order-2 order-md-1">
                  <div class="image-wrap">
                    <picture>
                      <source srcset="<?php echo responsive_image( $headshot, 'headshot-single-xs' ); ?>" media="(max-width: 575.98px)">
                      <source srcset="<?php echo responsive_image( $headshot, 'headshot-single-md' ); ?>" media="(max-width: 991.98px)">
                      <source srcset="<?php echo responsive_image( $headshot, 'headshot-single-xl' ); ?>" media="(max-width: 1399.98px)">
                      <img src="<?php echo responsive_image( $headshot, 'headshot-single-xxl' ); ?>" class="img-fluid" alt="<?php echo $headshotALT; ?>" loading="lazy" >
                    </picture>
                  </div> 
                </div>
                <div class="col-12 col-md-9 order-1 order-md-2">
                  <h1><?php the_title(); ?></h1>
                  <p class="title"><?php echo $title; ?></p>

                </div>
              </div>
            </div>
          </div>

          <div class="row mt-4">
            <div class="col-12 col-md-3 pe-md-0 pt-3 pt-md-0 text-center text-md-end order-2 order-md-1">
              <a href="<?php echo $teamPage; ?>" class="team-member-btn">All Team Members</a>
            </div>
            <div class="col-12 col-md-9 order-1 order-md-2">
              <div class="team-member-box-text">
                <?php echo $bio; ?>
              </div>

            </div>
          </div>
          





            
        </div>
      </div>

      

    </div>
  </section>

</article>