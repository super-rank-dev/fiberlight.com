<div class="row">
    <div class="small-12 columns title">
        <?php if (get_sub_field('title')) : ?>
            <h2><?php echo the_sub_field('title'); ?></h2>
        <?php endif; ?>
    </div>
    <div class="small-12 medium-5 large-3 columns description">
        <?php
        if (get_sub_field('description')) : ?>
            <p><?php echo the_sub_field('description'); ?></p>
        <?php endif; ?>
    </div>
    <div class="small-12 medium-7 large-9 columns state-accordion">
        <?php if (get_sub_field('state')): ?>
            <div class="accordion" data-accordion data-allow-all-closed="true">
                <? $counter = 1; ?>
            	<?php while(has_sub_field('state')): ?>
            
                    <div class="accordion-item" data-accordion-item>
                        <a href="#" class="accordion-title">
                            <? the_sub_field('title'); ?>
                        </a>
                
                        <div class="accordion-content" data-tab-content>
                            <? the_sub_field('content'); ?>
                        </div>
                    </div>
                    <? $counter++;  ?>
            	<?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
    
