<?php
/**
 * savings-calculator
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

  // Load custom field values.

  $formID = get_field('form_id');
  include(dirname(__DIR__).'/include/section-padding.php');

 // Create id attribute allowing for custom "anchor" value and section classes.
 include(dirname(__DIR__).'/include/section-id.php');
 $sectionClass = 'savings-calculator ' . $sectionPadding;
 include(dirname(__DIR__).'/include/section-classes.php');

?>

	<div class="container">
		<div class="row">
			<div class="col-12">
          <?php 
            if ( is_admin() ) : 
              echo '<div class="alert alert-primary m-5" role="alert">Will display the savings calculator here.</div>';
            else:
              echo do_shortcode('[gravityform id="'. $formID .'" title="false" description="false" ajax="true"]');
            endif;


          ?> 

        </div>
			</div>
    </div>
</section>

