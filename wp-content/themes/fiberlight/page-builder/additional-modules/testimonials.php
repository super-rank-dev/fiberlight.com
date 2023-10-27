<?php
function displayTestimonial($id) { ?>
    <div class="column testimonial" data-aos="fade-up">
        <?php if (get_field('photo') ) : ?><img src="<?= get_field('photo', $id)['sizes']['small-square']; ?>"><?php endif; ?>
        <p class="quote">
            <? the_field('description', $id); ?>
        </p>
        <p class="credit">
            <? the_field('tagline', $id); ?>
        </p>
    </div>
<?  
}



$slideshowMode = get_sub_field('slideshow_mode'); 
?>
<div class="row testimonials-holder">
    <? 
    if ( $slideshowMode ) :
        
        if ( get_sub_field('choose_testimonials') ) : 
            
            $posts = get_sub_field('choose_testimonials');

            foreach( $posts as $postID ): 
                displayTestimonial($postID);
            endforeach;
                
        else :
            $queryArray = array(
                'post_type' => 'testimonial',
                'posts_per_page' => 6,
                'orderby' => 'rand'
            );
            $loop = new WP_Query( $queryArray );
            if ( $loop->have_posts() ) :
                while ( $loop->have_posts() ) : $loop->the_post();
                
                    displayTestimonial(get_sub_field(get_the_ID()));
            
                endwhile;
            endif;
            wp_reset_postdata();
        endif;
    
    else :
        
        if ( get_sub_field('choose_testimonial') ) : 
            displayTestimonial(get_sub_field('choose_testimonial'));
            
        else :
            
            $queryArray = array(
                'post_type' => 'testimonial',
                'posts_per_page' => 1,
                'orderby' => 'rand'
            );
            $loop = new WP_Query( $queryArray );
            if ( $loop->have_posts() ) :
                while ( $loop->have_posts() ) : $loop->the_post();
                
                    displayTestimonial(get_sub_field(get_the_ID()));
            
                endwhile;
            endif;
            wp_reset_postdata();
        endif;
    
    endif; 
    ?>
        
    
</div>

<? if ( $slideshowMode ) : ?>
    <script type="text/javascript">
        jQuery(document).ready(function($){
    
            $('.testimonials-holder').slick({
                arrows:true,
                autoplay:true,
                autoplaySpeed:5000,
                dots:true,
                slidesToShow: 1,
                prevArrow:"<img class='slick-prev slick-arrow' src='<?php echo get_template_directory_uri(); ?>/img/icon-chevron-left-green.svg'>",
                nextArrow:"<img class='slick-next slick-arrow' src='<?php echo get_template_directory_uri(); ?>/img/icon-chevron-right-green.svg'>",
            });
    
        });
    </script>
<? endif; ?>