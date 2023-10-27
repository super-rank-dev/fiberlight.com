<?php
/**
 * stat-list
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

  // Load custom field values.
  $stats = get_field('stats');
  $padding = get_field('padding');

  include(dirname(__DIR__).'/include/section-padding.php');

 // Create id attribute allowing for custom "anchor" value and section classes.
 include(dirname(__DIR__).'/include/section-id.php');
 $sectionClass = 'stat-list ' . $sectionPadding;
 include(dirname(__DIR__).'/include/section-classes.php');

?>

	<div class="container">
		<div class="row">
			
      <?php 
          foreach( $stats as $stat ): 
            $number = get_field( 'number', $stat->ID );
            $description = get_field( 'description', $stat->ID );
        ?>
          <div class="col text-center">
            <div class="stat-wrap">
								<div class="stat-item mb-3">
									<div class="number"><?php echo esc_html( $number ); ?></div>
									<div class="description"><?php echo esc_html( $description ); ?></div>
								</div>
						</div>
            </div>
          <?php endforeach; ?>

        

    </div>
</section>
