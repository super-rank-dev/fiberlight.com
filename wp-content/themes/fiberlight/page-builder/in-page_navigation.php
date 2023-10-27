<div class="row">
    <?php if (get_sub_field('navigation_items')): ?> 

    	<?php while(has_sub_field('navigation_items')): ?>
    
            <div class="item column">
                <a href="#<? the_sub_field('element_id'); ?>">
                    <? the_sub_field('display_text'); ?>
                </a>
            </div>
    
    	<?php endwhile; ?>
    
    <?php endif; ?>
</div>