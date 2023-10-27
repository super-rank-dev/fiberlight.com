<?php
/**
 * Hero Full Page
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Load custom field values.
$backgroundImage = get_field('background_image');
$backgroundImageAlt = $backgroundImage['alt'];
$backgroundImageMobile = get_field('background_image_mobile');
$backgroundPattern = get_field('background_pattern');
$image = get_field('image');

// Create id attribute allowing for custom "anchor" value and section classes.
include(dirname(__DIR__).'/include/section-id.php');
$sectionClass = 'full-page-hero';
include(dirname(__DIR__).'/include/section-classes.php');

?>

<?php include(dirname(__DIR__).'/clone/background-pattern.php'); ?>
<?php include(dirname(__DIR__).'/clone/background-image.php'); ?>


	<div class="container">
		<div class="row justify-content-center align-items-start align-items-md-center h-100">
			<div class="col-8 col-md-5 ">
				<div style="position: relative; z-index: 5;">
					<InnerBlocks />
				</div>
			</div>
			<div class="col-4 col-md-6">
				<?php if ($image): ?>
					<div class="hero-image-wrap">
						<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"
							class="hero-image img-fluid" width="609" height="779" />
					</div>
				<?php endif; ?>
			</div>
		</div>

		</div>
		<?php 
			if( have_rows('bottom_buttons') ): 
				$solutionsNavTitle = get_field('bottom_buttons_title');
				echo '<div class="container container-solutions-nav">';
				echo '<div id="solutions-nav" class="solutions-nav d-md-flex flex-md-nowrap">';
				echo '<p class="align-self-center solutions-nav-title">'. $solutionsNavTitle .'</p>'; 
				while( have_rows('bottom_buttons') ) : the_row();
					$label = get_sub_field('label');
					$link = get_sub_field('link');
					$logoDesktop = get_sub_field('logo_desktop');
					$logoMobile = get_sub_field('logo_mobile');
					$link_url = $link['url'];
					$link_title = $link['title'];
					$link_target = $link['target'] ? $link['target'] : '_self';

					echo '<a class="solutions-nav-item align-self-center h-100" href="'. esc_url( $link_url ) .'" target="'. esc_attr( $link_target ) .'">';
					if ($logoDesktop && $logoMobile):
					echo '<img src="'. $logoDesktop['url'] .'" class="d-none d-md-block" target="_self" alt="'. $logoDesktop['alt'] .'">
					<img src="'. $logoMobile['url'] .'" class="d-block d-md-none" target="_self" alt="'. $logoMobile['alt'] .'" height="35" width="117" >';
					else : 
					echo $label;
					endif; 
					echo '</a>';

				endwhile;
				// echo '<div id="chat-bar" class="chat-bar qc_wpbot_chat_link d-block d-md-none"><img src="/wp-content/themes/fiberlight_theme/dist/images/icon_chat.svg" alt="chat icon" class="chat-icon"></div>';
				echo '</div>';
				echo '</div>';
			endif;
		?>

		


</section>