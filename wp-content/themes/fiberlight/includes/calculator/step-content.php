<?php
//vars
$heading = get_field($step . '_heading', 'options');
$subheading = get_field($step . '_subheading', 'options');
$intro  = get_field($step . '_intro', 'options');
?>

<div class="savings-calculator-intro">
    <div class="intro">
        <?php
        //heading
        if($heading) : ?>
            <h1><?php echo $heading; ?></h1>
        <?php
        else: ?>
            <h1>The Fiberlight Savings Calculator</h1>
        <?php
        endif;
        
        //subheading
        if($subheading) : ?>
            <h2><?php echo $subheading; ?></h2>
        <?php
        endif;
        
        //intro
        if($intro) : ?>
            <?php echo $intro; ?>
        <?php
        endif;
        ?>
    </div>
    
    <div class="row calc-stats" data-equalizer>
        <?php if (get_field($step . '_stats', 'options')): ?> 
        	<?php while (has_sub_field($step . '_stats', 'options')):
        	//vars
        	$stat = get_sub_field('stat', 'options');
        	$source = get_sub_field('source', 'options');
        	?>
        	<div class="small-12 medium-6 columns">
        	    <div class="stat-item" data-equalizer-watch>
            	    <?php if ($stat) : ?>
            	        <div class="stat">
            	            <?php echo $stat; ?>
            	        </div>
            	    <?php endif; ?>
            	    <?php if ($source) : ?>
            	        <span class="source">
            	            <?php echo $source; ?>
            	        </span>
            	    <?php endif; ?>
                </div>
        	</div>
        	<?php endwhile; ?>
        <?php endif; ?>
    </div>
</div>