<?php
/**
 * @package WordPress
 * @subpackage Fiberlight Theme
 */
?>

<?php
  $logoDark = get_field('logo_dark', 'option');
  $logoLight = get_field('logo_light', 'option');
  $address = get_field('address', 'option');
  $address2 = get_field('address_2', 'option');
  $city = get_field('city', 'option');
  $state = get_field('state', 'option');
  $postalCode = get_field('postal_code', 'option');
  $phone = get_field('phone', 'option');
  $email = get_field('email', 'option');
  $socialMedia = get_field('social_media', 'option');
  $footerScripts = get_field('footer_scripts', 'option');

  $footerCenterHeader = get_field('footer_center_heading', 'option');
  $footerCenterHeaderLink = get_field('footer_center_link', 'option');
  $footerRightHeader = get_field('footer_right_heading', 'option');
?>

  <footer>
    <div class="container">
      <div class="row gx-5">
        <div class="col-md-4">
          <img src="<?php echo esc_url($logoLight['url']); ?>" alt="<?php echo esc_attr($logoLight['alt']); ?>" id="logo-light" class="logo" width="200" height="45" />
          <div class="contact-info">
            <p>
           <?php
            if($address): echo ''. $address .'<br>'; endif;
            if($address2): echo ''. $address2 .'<br>'; endif;
            if($city): echo ''. $city .', '; endif;
            if($state): echo ''. $state .' '; endif;
            if($postalCode): echo ''. $postalCode .'<br>'; endif;
            if($phone): echo '<a href="tel:'. $phone .'" target="_blank">'. $phone .'</a><br>'; endif;
            if($email): echo '<a href="mailto:'. $email .'" target="_blank">'. $email .'</a>'; endif;
            ?>
            </p>
          

          <?php 
          
            if( have_rows('social_media', 'option') ): 
              echo '<div class="social-media">';

              while( have_rows('social_media', 'option') ) : the_row();
                $platform = get_sub_field('platform');
                $url = get_sub_field('url');
          
                echo '<div class="social-icon">';

                echo '<a href="'. $url .'" target="_blank" aria-label="'. $platform .'">';
                  if($platform === "linkedin"){
                    include(dirname(__DIR__).'/template-parts/components/icon-linkedin.php');
                  }
                  if($platform === "twitter"){
                    include(dirname(__DIR__).'/template-parts/components/icon-twitter.php');
                  }
                echo '</a>';
                echo '</div>';


              endwhile; 
              echo '</div>';
            endif; ?>

          </div>
        </div>
        <div class="col-md-4 px-5 footer-v-rules">

          <?php
            if( have_rows('center_navigation', 'option') ): 
              echo '<ul class="footer-navigation footer-navigation-center">';
              if ($footerCenterHeader && !$footerCenterHeaderLink) : 
                echo '<li><b>'. $footerCenterHeader .'</b></li>'; 
              endif;
              if ($footerCenterHeader && $footerCenterHeaderLink) : 
                $footerCenterHeaderLink_url = $footerCenterHeaderLink['url'];
                $footerCenterHeaderLink_title = $footerCenterHeaderLink['title'];
                $footerCenterHeaderLink_target = $footerCenterHeaderLink['target'] ? $footerCenterHeaderLink['target'] : '_self';

                echo '<li><a href="'. $footerCenterHeaderLink_url .'" class="footer-link" target="'. $footerCenterHeaderLink_target .'"><b>'. $footerCenterHeader .'</b></a></li>'; 
              endif;
              while( have_rows('center_navigation', 'option') ) : the_row();

              $link = get_sub_field('link');
              $link_url = $link['url'];
              $link_title = $link['title'];
              $link_target = $link['target'] ? $link['target'] : '_self';

              echo '<li><a href="'. $link_url .'" class="footer-link" target="'. $link_target .'">'. $link_title .' </a></li>';
              endwhile; 

              echo '</ul>'; 
            endif; 
          ?>

        </div>
        <div class="col-md-4 px-5">
          <?php
            if( have_rows('right_navigation', 'option') ): 
              echo '<ul class="footer-navigation footer-navigation-right">';
              if ($footerRightHeader) : echo '<li><b>'. $footerRightHeader .'</b></li>'; endif;

              while( have_rows('right_navigation', 'option') ) : the_row();

              $link = get_sub_field('link');
              $link_url = $link['url'];
              $link_title = $link['title'];
              $link_target = $link['target'] ? $link['target'] : '_self';

              echo '<li><a href="'. $link_url .'" class="footer-link footer-link-right" target="'. $link_target .'">'. $link_title .' </a></li>';

              endwhile; 
              echo '</ul>';
            endif; 
          ?>
        </div>
      </div>
    </div>
    <div class="footer-bar"></div>
  </footer>

  <?php wp_footer(); ?>
  <?php echo $footerScripts; ?>

</body>
</html>
