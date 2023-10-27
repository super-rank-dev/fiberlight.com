<div class="row">
    <div class="small-12 columns title">
        <h2>
            <? the_sub_field('title'); ?>
        </h2>
        <? the_sub_field('content'); ?>
    </div>
</div>

<div class="row columns" data-aos="fade-up">
<?php if (get_sub_field('milestone')): ?>
<div class="timeline-nav">
	<?php while(has_sub_field('milestone')):
	//vars
	$year = get_sub_field('year');
	?>
    <span class="year"><?php echo $year; ?></span>


	<?php endwhile; ?>
</div>
<?php endif; ?>

<?php if (get_sub_field('milestone')): ?>
<div class="timeline">
	<?php while(has_sub_field('milestone')):
	//vars
	$content = get_sub_field('content');
	$image = get_sub_field('image');
	?>
	<div class="timeline-inner">
	    <div class="row align-middle">
        	<div class="small-12 medium-8 large-9 columns">
            <?php if ($content) : ?>
                <?php echo $content; ?>
            <?php endif; ?>
            </div>
            <?php if ($image) : ?>
            <div class="small-12 medium-4 large-3 columns">
                <img src="<?php echo $image['sizes']['gallery-thumbnail']; ?>" alt="<?php echo $image['alt']; ?>" />
            </div>
            <?php endif; ?>
        </div>
	</div>
    <?php endwhile; ?>
    </div>
<?php endif; ?>
</div>

<script>
jQuery(document).ready(function($){
	 $('.timeline').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      fade: true,
      variableHeight: true,
      asNavFor: '.timeline-nav'
    });
    $('.timeline-nav').slick({
      slidesToShow: 5,
      slidesToScroll: 1,
      asNavFor: '.timeline',
      dots: false,
      arrows: true,
      centerMode: false,
      infinite: true,
      focusOnSelect: true,
      prevArrow:"<img class='slick-prev slick-arrow' src='<?php echo get_template_directory_uri(); ?>/img/icon-chevron-left-green.svg'>",
      nextArrow:"<img class='slick-next slick-arrow' src='<?php echo get_template_directory_uri(); ?>/img/icon-chevron-right-green.svg'>",
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 3
           
          }
        },
        {
          breakpoint: 640,
          settings: {
            slidesToShow: 2
          }
        },
        {
          breakpoint: 420,
          settings: {
            slidesToShow: 2
          }
        },
       
    
       ] 
    });


});
</script>

