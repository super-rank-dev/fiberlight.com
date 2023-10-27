<?
// set the post type to use
$postType = "team-member";

// the wp query
$loop = new WP_Query( array( 'post_type' => $postType, 'posts_per_page' => '-1' ) );

?>

<div class="row">
    <div class="member-container">
        <?
        if ( $loop->have_posts() ) :
            $counter = 1;
            while ( $loop->have_posts() ) : $loop->the_post();

                ?>
                <div class="small-12 medium-12 large-6 columns member ">
                    <div class="member-border" data-aos="fade-up">
                        <? $image = get_field('headshot');
                            $image_placeholder = get_field('team_member_placeholder_image', 'options');
                        $link = get_the_permalink();
                        
                        ?>
                        <div class="row align-middle">
                        <div class="small-4 medium-5 large-4 columns image">
                            <a href="<?= $link; ?>" class="<?= $class; ?>">
                                <img src="<?php if ($image) : echo $image['sizes']['portrait-medium']; else: echo $image_placeholder['sizes']['portrait-medium']; endif; ?>">
                            </a>
                        </div>
                        <div class="small-8 medium-7 large-8 columns info">
                            <a href="<?= $link; ?>" class="<?= $class; ?>">
                                <h5><? the_title(); ?></h5>
                            </a>
                            <? if ( get_field('title') ) : ?>
                                <h6><? the_field('title'); ?></h6>
                            <? endif; ?>
                            <a href="<?= $link; ?>" class="button tertiary extra-small">Learn More</a>
                        </div>
                        </div>
                    </div>
                </div>
                <? $counter++; ?>
            <? endwhile; ?>
        <? endif; ?>
        <? wp_reset_postdata(); ?>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function($){
      
        //Set link to entire project block, since wrapping in an <a> tag isn't accessible.
        $(".member-border").click(function() {
          window.location = $(this).find("a").attr("href"); 
          return false;
        });
    });
    
</script>
