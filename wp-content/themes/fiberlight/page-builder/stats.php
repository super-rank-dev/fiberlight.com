<?php if (get_sub_field('title') || get_sub_field('content')) : ?>
<div class="row title">
    <div class="small-12 columns">
        <?php if (get_sub_field('title')) : ?>
            <h2><?php echo the_sub_field('title'); ?></h2>
        <?php endif; ?>
        <?php if (get_sub_field('content')) : ?>
            <?php echo the_sub_field('content'); ?>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

<?php
$randomInteger = rand(1000000,999999999);
$rows = get_sub_field('stat');
if($rows) :
$count = 0;
?> 
<div class="row columns statistics" data-aos="fade-up">
	<div class="stats stats-<?php echo $randomInteger; ?>">
	<?php
	shuffle( $rows );
	foreach($rows as $row):
	//vars
	$number = $row['number'];
	$title = $row['title'];
	?>
	<div class="stat">
        <div class="stat-inner">
        	<p class="number"><?php echo $number; ?></p>
        	<p class="title"><?php echo $title; ?></p>
        </div>
    </div>
     <?php $count++; ?>
	<?php endforeach; ?>
	</div>
</div>
<?php endif; ?>

<?php
if ($count < 4) :
    $slide_count = $count;
else:
    $slide_count = '4';
endif; ?>

    
<script type="text/javascript">
    jQuery(document).ready(function($){

        $('.stats-<?php echo $randomInteger; ?>').slick({
            arrows:true,
            autoplay:true,
            centerMode: false,
            slidesToShow: <?php echo $slide_count; ?>,
            fade: false,
            variableWidth: false,
            dots:false,
            infinite: true,
            prevArrow:"<img class='slick-prev slick-arrow' src='<?php echo get_template_directory_uri(); ?>/img/icon-chevron-left-green.svg'>",
            nextArrow:"<img class='slick-next slick-arrow' src='<?php echo get_template_directory_uri(); ?>/img/icon-chevron-right-green.svg'>",
            responsive: [
                {
                  breakpoint: 800,
                  settings: {
                    slidesToShow: 2,
                  }
                },
                {
                  breakpoint: 480,
                  settings: {
                    slidesToShow: 1,
                  }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
              ]
            
        });

    //equal height slides
    var stHeight = $('.stats-<?php echo $randomInteger; ?>').height();
    $('.stat-inner').css('height',stHeight + 'px' );
    
    });
</script>