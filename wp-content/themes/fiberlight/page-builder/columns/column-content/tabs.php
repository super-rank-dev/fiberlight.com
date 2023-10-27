<?php if (get_sub_field('tab')):
$randomInteger = rand(1000000,999999999);
?> 
    <ul class="tabs" data-tabs id="collapsing-tabs">
        <? $counter = 1; ?>
    	<?php while(has_sub_field('tab')): ?>
    
            <li class="tabs-title <? if ( $counter == 1 ) : echo "is-active"; endif; ?>">
                <a class="tab" href="#0panel<?= $counter; ?><?php echo $randomInteger; ?>">
                    <? the_sub_field('title'); ?>
                </a>
            </li>
            <? $counter++; ?>
    	<?php endwhile; ?>
    </ul>
<?php endif; ?>
<?php if (get_sub_field('tab')): ?> 
    <div class="tabs-content" data-tabs-content="collapsing-tabs">
        <? $counter = 1; ?>
    	<?php while(has_sub_field('tab')): ?>
    
            <div class="tabs-panel <? if ( $counter == 1 ) : echo "is-active"; endif; ?>" id="0panel<?= $counter; ?><?php echo $randomInteger; ?>">
                <? the_sub_field('content'); ?>
            </div>
            <? $counter++; ?>
    	<?php endwhile; ?>
    </div>
<?php endif; ?>