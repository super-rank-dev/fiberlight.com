<?
if ( get_sub_field('title') ) :
?>
    <div class="row title">
        <div class="columns">
            <h3><? the_sub_field('title'); ?></h3>
        </div>
    </div>
<?
endif;

$randomInteger = rand(1000000,999999999);
$imageArray = array();
?>
<div class="row slider-<?= $randomInteger; ?> dual-slider">
<?php if (get_sub_field('slides')): ?> 
    <div class="small-12 medium-6 columns content-slides">
    <? $counter = 1; ?>
	<?php while(has_sub_field('slides')): ?>
        <? $detailArray = array(); ?>
        <div class="columns content-slide">
            <div class="content">
                <?
                if ( get_sub_field('title') ) : 
                ?>
                    <h4>
                        <? the_sub_field('title'); ?>
                    </h4>
                <?
                endif;
                ?>
                <? the_sub_field('content'); ?>
                
                <? $detailArray['image'] = get_sub_field('image')['sizes']['large']; ?>
                <? $detailArray['count'] = $counter; ?>
                <? $imageArray[] = $detailArray; ?>
            </div>

        </div>
        <? $counter++; ?>
	<?php endwhile; ?>
    </div>
<?php endif;
$imageArray = array_reverse($imageArray);
?>
<?php if ( is_array($imageArray) ): ?> 
    <div class="small-12 medium-6 columns image-slides">
    <? $counter = -1; ?>
	<? foreach ( $imageArray as $image) : ?>
        <? $counter++; ?>
        <div class="columns image-slide" style="background-image:url('<?= $image['image']; ?>');">
            <div class="count">
                <?
                echo sprintf("%02d", $image['count']);
                ?>
            </div>
        </div>
        
   
	<?php endforeach; ?>
    </div>
<?php endif; ?>
    <div class="nav">
        <span class="prev">
            Prev
        </span>
        <span class="next">
            Next
        </span>
    </div>
 </div>
 <script type="text/javascript">
    jQuery(document).ready(function($){

        $('.slider-<?= $randomInteger; ?> .content-slides').slick({
            arrows:false,
            autoplay:false,
            autoplaySpeed:3000,
            dots:false,
            vertical: true,
            swipe: false,
            //asNavFor: '.slider-<?= $randomInteger; ?> .image-slides',
        });
        $('.slider-<?= $randomInteger; ?> .image-slides').slick({
            arrows:false,
            autoplay:false,
            autoplaySpeed:3000,
            dots:false,
            vertical: true,
            swipe: false,
            //asNavFor: '.slider-<?= $randomInteger; ?> .content-slides',
        });
        
        $('.nav .next').click(function() {
           $('.slider-<?= $randomInteger; ?> .image-slides').slick('slickPrev'); 
           $('.slider-<?= $randomInteger; ?> .content-slides').slick('slickNext'); 
        });
        $('.nav .prev').click(function() {
           $('.slider-<?= $randomInteger; ?> .image-slides').slick('slickNext'); 
           $('.slider-<?= $randomInteger; ?> .content-slides').slick('slickPrev'); 
        });
        
        $('.slider-<?= $randomInteger; ?> .image-slides').slick('slickGoTo', <?= $counter; ?>);

    });
</script>