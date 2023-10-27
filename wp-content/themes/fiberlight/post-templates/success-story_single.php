<?php get_template_part( 'includes/header' ); ?>

<section class="success-story">
    <div class="row">
        <div class="small-12 columns large-8 content" data-aos="fade-right">
            
            
            <div class="row">
                <div class="small-12 columns challenge">
                    <h4>
                        Company Profile
                    </h4>
                    <? the_field('company_profile'); ?>
                </div>
            </div>
           
           
            <div class="row">
                <div class="small-12 columns challenge">
                    <h4>
                        Challenge
                    </h4>
                    <? the_field('challenge'); ?>
                </div>
            </div>
            
            
            <div class="row">
                <div class="small-12 columns solution">
                    <h4>
                        Solution
                    </h4>
                    <? the_field('solution'); ?>
                </div>
            </div>
            
            
            <div class="row">
                <div class="small-12 columns challenge">
                    <h4>
                        Benefit
                    </h4>
                    <? the_field('benefit'); ?>
                </div>
            </div>
            
            
        </div>
        <div class="small-12 columns large-4 sidebar" data-aos="fade-left">
            <div class="hold-me">
                <?php 
                $industries = wp_get_post_terms( get_the_ID(), 'Industry'); 
                $counter = 1;
                if ( !empty($industries) ) :
                ?>
                    <h6>
                        <b>Industries</b>
                    </h6>
                    <ul>
                        
                        <?
                        
                            foreach ( $industries as $industry ) : 
                                
                                $relatedPage = get_field('related_page', 'term_' . $industry->term_id);
                                
                               
                                
                                if ($relatedPage) :
                                echo "<li><a href='". $relatedPage . "'>" . $industry->name . "</a></li>";
                            else : 
                                 echo '<li>' . $industry->name . '</li>';
                            endif;
                           
                            endforeach;
                        
                        ?>
                    </ul>
                <? endif; ?>
                <?
                $solutions = wp_get_post_terms( get_the_ID(), 'Solution'); 
                $counter = 1;
                if ( !empty($solutions) ) :
                ?>
                    <h6>
                        <b>Solutions</b>
                    </h6>
                    <ul>
                        <?php 
                        
                        foreach ( $solutions as $solution ) : 
                            
                            $relatedPage = get_field('related_page', 'term_' . $solution->term_id);
                            
                            if ($relatedPage) :
                                echo "<li><a href='". $relatedPage . "'>" . $solution->name . "</a></li>";
                            else : 
                                 echo '<li>' . $solution->name . '</li>';
                            endif;
                         
                        endforeach;
                        ?>
                    </ul>
                <? endif; ?>
                <?
                $regions = wp_get_post_terms( get_the_ID(), 'Region'); 
                $counter = 1;
                if ( !empty($regions) ) :
                ?>
                    <h6>
                        <b>Region</b>
                    </h6>
                    <ul>
                        <?php 
                       
                        foreach ( $regions as $region ) : 
                            
                  
                           
                            echo "<li>" . $region->name . "</li>";
                         
                        endforeach;
                        ?>
                    </ul>
                <? endif; ?>
               <?php if( get_field('download_link') ): ?>
                    <a href="<?php echo the_field('download_link'); ?>" target="blank" class="button primary">Download Success Story</a>
                <?php endif; ?>
            </div>
            <div class="success-story-logo">
                <img src="<?= get_field('logo')['sizes']['medium']; ?>" alt="<?= get_field('logo')['caption']; ?>">
            </div>
        </div>
        
    </div>
</section>
<section class="am-testimonials light-gray-bg">
    <?php $randomIntegerTestimonial = rand(1000000,999999999); ?>
    <div class="row testimonials-holder testimonial-holders-<?php echo $randomIntegerTestimonial; ?>" data-aos="fade-up">
    <?php
        $posts = get_field('testimonial');
        if ($posts) :
            foreach( $posts as $post ):  ?>
                    <div class="column testimonial">
                        <?php if (get_field('photo') ) : ?><img src="<?= get_field('photo')['sizes']['small-square']; ?>"><?php endif; ?>
                        <p class="quote">
                            <? the_field('description'); ?>
                        </p>
                        <p class="credit">
                            <? the_field('tagline'); ?>
                        </p>
                    </div>
            <?php
            $testimonial_count = count($posts); 
            wp_reset_postdata();
            endforeach;
        endif;
    ?>
    </div>
    
<? if ( $testimonial_count >= 2 ) : ?>
    <script type="text/javascript">
        jQuery(document).ready(function($){
    
            $('.testimonial-holders-<?php echo $randomIntegerTestimonial; ?>').slick({
                arrows:false,
                autoplay:true,
                autoplaySpeed:5000,
                dots:true,
                slidesToShow: 1
            });
    
        });
    </script>
<? endif; ?>
</section>
<section class="pb-stats">
  
    <?php
    $randomInteger = rand(1000000,999999999);
    
    if (get_field('statistics')):
    $count = 0;
    ?> 
    <div class="row columns statistics" data-aos="fade-up">
    	<div class="stats stats-<?php echo $randomInteger; ?>">
    	<?php while(has_sub_field('statistics')):
    	//vars
    	$number = get_sub_field('number');
    	$title = get_sub_field('title');
    	
    	
    	?>
    	<div class="stat">
            <div class="stat-inner">
            	<p class="number"><?php echo $number; ?></p>
            	<p class="title"><?php echo $title; ?></p>
            </div>
        </div>
         <?php $count++; ?>
    	<?php endwhile; ?>
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
                autoplay:false,
                centerMode: false,
                slidesToShow: <?php echo $slide_count; ?>,
                fade: false,
                variableWidth: false,
                dots:false,
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
</section>
<section class="related-stories">
    <div class="row">
        <div class="small-12 columns title">
            <h2>
                Related Success Stories
            </h2>
        </div>
        <?php if (get_field('related_success_stories')): ?> 

        	<?php while(has_sub_field('related_success_stories')): ?>
        	    
        	    <div class="column" data-aos="fade-up">
        	        <? displayStory(get_sub_field('success_story'), 'small'); ?>
                </div>
        
        
        	<?php endwhile; ?>
        
        <?php endif; ?>
    </div>
</section>

<div class="row back-to-all">
    <div class="columns small-12">
        <a href="/resources/success-stories" class="button tertiary">Back to All Success Stories</a>
    </div>
</div>

<section class="pb-cta_bar dark-gray-bg">
    <?php
    $title = get_field('cta_title', 'options');
    $description = get_field('cta_description', 'options');
    $image = get_field('default_success_story_cta_banner', 'options');
    ?>
    
    <div class="row cta-wrap ">
        <div class="columns small-12 medium-6 image <?php echo $slider; ?>" style="background-image:url('<?= $image['url']; ?>">
        </div>
        <div class="columns small-12 medium-6 content">
            <div class="hold-me" data-aos="fade-left">
                <?php if ($title) : ?>
                    <h2><?php echo $title; ?></h2>
                <?php endif; ?>
                <?php if ($description) : ?>
                    <p><?php echo $description; ?></p>
                <?php endif; ?>
                <?php if (get_field('cta_button', 'options')): ?> 
                
                    <?php while(has_sub_field('cta_button', 'options')): ?>
                    
                        <? aor_button(); ?>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php get_template_part( 'includes/footer' ); ?>
