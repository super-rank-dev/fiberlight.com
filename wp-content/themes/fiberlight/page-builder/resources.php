<?php if (get_sub_field('resource')):
$count =$count = count(get_sub_field('resource'));
?>
<div class="row resources align-center">
	<?php while(has_sub_field('resource')): 
	//vars
	$style = get_sub_field('resource_style');
	$type = get_sub_field('resource_type');
	$image = get_sub_field('image');
	$title = get_sub_field('title');
	$file = get_sub_field('file');
	$link = get_sub_field('link');
	$link_title = get_sub_field('link_title');
	
	if ($count == 1) :
	    $col = 'medium-6 shrink';
	elseif ($count == 2) :
	    $col = 'medium-6';
	elseif ($count == 3) :
	    $col = 'medium-6 large-4';
	elseif ($count == 4) :
	    $col = 'medium-6';
	else:
	    $col = 'medium-6 large-4';
	endif;
	?>
	<div class="small-12 <?php echo $col; ?> columns">
    	<div class="resource row align-middle <?php echo $style; ?>" data-aos="fade-up">
    	    <?php if ($image) : ?>
    	    <div class="shrink columns image">
    	        <?php if ($type = 'file') : ?>
    	        	<a href="<?php echo $file['url']; ?>" target="_blank">
    	        <?php else: ?>
    	        	<a href="<?php echo $link; ?>">
    	        <?php endif; ?>
    	        <img src="<?php echo $image['sizes']['resource-thumbnail']; ?>" alt="<?php echo $image['alt']; ?>" />
    	        <?php if ($type == 'file' || $type == 'link') : ?></a><?php endif; ?>
    	    </div>
    	    <?php endif; ?>
    	    <?php if ($file || $title) : ?>
    	    <div class="columns content">
    	           <h5><?php echo $title; ?></h5>
    	          <?php if ($type == 'file') : ?>
    	        	<a href="<?php echo $file['url']; ?>" target="_blank" class="button tertiary">Download PDF</a>
    	        <?php else: ?>
    	        	<a href="<?php echo $link; ?>" class="button tertiary"><?php echo $link_title; ?></a>
    	        <?php endif; ?>
    	    </div>
    	   <?php endif; ?>
    	</div>
    </div>
	<?php endwhile; ?>
</div>
<?php endif; ?>