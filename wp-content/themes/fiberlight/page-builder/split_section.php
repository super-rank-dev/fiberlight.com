<?
$image = get_sub_field('background_image');
if ( get_sub_field('layout') == "image_right_content_left" ) :

    $class = "content-first";

endif;

if ( get_sub_field('split_section_type') == "testimonials" ) : 
    $slider = "testimonial";
endif;
?>

<div class="row <?= $class; ?> <?php if (get_sub_field('split_section_type') != "content" ) : ?>expanded <?php else: ?>logo-row<?php endif; ?>"data-equalizer data-equalize-on="medium">

    <?php if ( get_sub_field('split_section_type') == "content" ) : ?>
    <div class="columns small-12 medium-6 content content-2" data-aos="fade-right">
        <div class="hold-me">
            <?php if (get_sub_field('logo_2')) : ?>
                <div class="logo" data-equalizer-watch><img src="<?php echo get_sub_field('logo_2')['sizes']['resource-thumbnail']; ?>" /></div>
            <?php endif; ?>
            <? if ( get_sub_field('title_2') ) : ?>
                <h2><? the_sub_field('title_2'); ?></h2>
            <? endif; ?>
            <div class="text"><? the_sub_field('content_2'); ?></div>
            <?php if (get_sub_field('buttons_2')): ?> 
            
            	<?php while(has_sub_field('buttons_2')): ?>
            
                    <? aor_button(); ?>
            
            	<?php endwhile; ?>
            
            <?php endif; ?>
        </div>
    </div>
    <?php else: ?>
    <div class="columns small-12 medium-6 image <?php echo $slider; ?>" style="background-image:url('<?= $image['sizes']['split-section']; ?>');" <?php if ( get_sub_field('layout') == "image_right_content_left" ) : ?> data-aos="fade-left" <?php else : ?> data-aos="fade-right"<?php endif; ?>>
        <?php if ( get_sub_field('split_section_type') == "testimonials" ) : 
            
            $post_objects = get_sub_field('testimonials');

            if( $post_objects ): ?>
                <div class="testimonial-slider">
                <?php foreach( $post_objects as $post_object):
                $content = get_field('description', $post_object->ID);
                $tagline = get_field('tagline', $post_object->ID);
                ?>
                    <div class="slide">
                        <div class="inner">
                            <p class="quote"><?php echo $content; ?></p>
                            <p class="credit"><?php echo $tagline; ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
                </div>
            <?php endif;
         endif; ?>
    </div>
    <?php endif; ?>
    <div class="columns small-12 medium-6 content" <?php if ( get_sub_field('layout') == "image_right_content_left" ) : ?> data-aos="fade-right" <?php else : ?> data-aos="fade-left"<?php endif; ?>>
        <div class="hold-me">
            <?php if (get_sub_field('logo')) : ?>
                <div class="logo" data-equalizer-watch><img src="<?php echo get_sub_field('logo')['sizes']['resource-thumbnail']; ?>" /></div>
            <?php endif; ?>
            <? if ( get_sub_field('title') ) : ?>
                <h2><? the_sub_field('title'); ?></h2>
            <? endif; ?>
            <div class="text"><? the_sub_field('content'); ?></div>
            <?php if (get_sub_field('buttons')): ?> 
            
            	<?php while(has_sub_field('buttons')): ?>
            
                    <? aor_button(); ?>
            
            	<?php endwhile; ?>
            
            <?php endif; ?>
        </div>
    </div>
</div>

<?php if ( get_sub_field('split_section_type') == "testimonials" ) : ?>
<script type="text/javascript">
    jQuery(document).ready(function($){

        $('.testimonial-slider').not('.slick-initialized').slick({
            arrows:true,
            autoplay:false,
            centerMode: false,
            slidesToShow: 1,
            fade: true,
            variableWidth: false,
            dots:true,
            prevArrow:"<img class='slick-prev slick-arrow' src='<?php echo get_template_directory_uri(); ?>/img/icon-chevron-left-green.svg'>",
            nextArrow:"<img class='slick-next slick-arrow' src='<?php echo get_template_directory_uri(); ?>/img/icon-chevron-right-green.svg'>",
        });

    });
</script>
<?php endif; ?>