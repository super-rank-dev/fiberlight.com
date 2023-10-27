<?php get_template_part( 'includes/header' ); ?>

<section class="post-single">
    <div class="row">
        <div class="small-12 columns">
            <? if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

   
                <h6><?= get_The_date('l, F j, Y'); ?></h6>
                <? if ( get_field('author') ) : ?> 
                    <h6 style="font-size:12px;font-weight:bold;text-transform:none;letter-spacing:0px;">By
                        <a href="<?= get_the_permalink(get_field('author')); ?>">
                            <?= get_the_title(get_field('author')); ?>
                        </a>
                    </h6>
                <? endif; ?>
                <div class="content">
                    <? the_content(); ?>
                </div>
                
                
            <section class="related-posts" style="display:none;">
                <div class="row">
                    <div class="small-12 columns title">
                        <h2>
                            Related Blog Posts
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

                <a href="/resources/blog/" class="button back">
                    Back to Blog
                </a>
                
                <a href="/contact/" class="secondary button back">
                    For more information please contact us
                </a>
                
            <? endwhile; else : ?>

            <? endif; ?>

        </div>
    </div>
</section>

<section class="related-stories">
    <div class="row">
        <div class="small-12 columns title">
            <h2>
                Related Resources
            </h2>
        </div>
        <?php if (get_field('related_resources')): ?> 

        	<?php while(has_sub_field('related_resources')): ?>
        	    
        	    <div class="column" data-aos="fade-up">
        	        <? displayResource(get_sub_field('resource'), 'small'); ?>
                </div>
        
        
        	<?php endwhile; ?>
        
        <?php endif; ?>
    </div>
</section>


<?php get_template_part( 'includes/footer' ); ?>
