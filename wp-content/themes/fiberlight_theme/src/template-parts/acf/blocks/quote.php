<?php
/**
 * Quote
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

 // Load custom field values.
$quoteLayout = get_field('quote_layout');
$backgroundImage = get_field('background_image');
$backgroundImageMobile = get_field('background_image_mobile');
$backgroundPattern = get_field('background_pattern');
$quote = get_field('quote');
$author = get_field( 'author', $quote->ID );
$title = get_field( 'title', $quote->ID );
$theQuote = get_field( 'testimonial', $quote->ID );

include(dirname(__DIR__).'/include/section-padding.php');
include(dirname(__DIR__).'/include/background-image.php');

// Create id attribute allowing for custom "anchor" value and section classes.
include(dirname(__DIR__).'/include/section-id.php');
$sectionClass = 'quote ' . $sectionPadding;
include(dirname(__DIR__).'/include/section-classes.php');
?>

<?php include(dirname(__DIR__).'/clone/background-pattern.php'); ?>
<?php include(dirname(__DIR__).'/clone/background-image.php'); ?>

	<div class="container h-100">
		<div class="row align-items-center justify-content-center h-100">

    <?php if ($quoteLayout === 'layout1') : ?>
      <div class="col-12 col-md-auto order-last order-md-first h-100">
        <div class="author-content has-background has-fl-dark-blue-background-color has-fl-dark-blue-background">
          <div class="bar bar-green"></div>
          <?php if ($author) : ?><p class="author-text"><?php echo esc_html( $author ); ?></p><?php endif; ?>
          <?php if ($title) : ?><p class="title-text"><?php echo esc_html( $title ); ?></p><?php endif; ?>
        </div>
      </div>
      <div class="col-12 col-md-6 order-first order-md-last h-100">
        <div class="quote-content has-background has-fl-light-blue-background-color has-fl-light-blue-background">
          <div class="icon_quote"></div>
          <p class="quote-text"><?php echo esc_html( $theQuote ); ?></p>
        </div>
			</div>

    <?php else : ?>

      <div class="col-11 col-md-10 col-lg-9 text-center h-100">
        <div class="layout-2">
          <div class="icon_quote"></div>
          <p class="quote-text"><?php echo esc_html( $theQuote ); ?></p>
          <?php if ($author) : ?><p class="author-text"><?php echo esc_html( $author ); ?></p><?php endif; ?>
            <?php if ($title) : ?><p class="title-text"><?php echo esc_html( $title ); ?></p><?php endif; ?>
          <div class="bar bar-green"></div>
        </div>
      </div>

    <?php endif; ?>


      </div>

    </div>
</section>