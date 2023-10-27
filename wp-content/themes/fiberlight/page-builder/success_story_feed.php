<div class="row intro">
    <div class="small-12 medium-8 columns title">
        <h2>
            <? the_sub_field('title'); ?>
        </h2>
        <? the_sub_field('content'); ?>
    </div>
    <div class="small-12 medium-4 columns link">
        <a href="<?= get_sub_field('link_url'); ?>" class="tertiary button small">
            <?= get_sub_field('link_text'); ?>
        </a>
    </div>
</div>

<div class="related-stories" data-aos="fade-up">
    <div class="row">
        <?php if (get_sub_field('success_stories')): ?> 

        	<?php while(has_sub_field('success_stories')): ?>
        	    
        	    <div class="column">
        	        <? displayStory(get_sub_field('success_story'), 'small'); ?>
                </div>
        
        
        	<?php endwhile; ?>
        
        <?php endif; ?>
    </div>
</div>


    
