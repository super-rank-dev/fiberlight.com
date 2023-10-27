<?php
	//vars
	$style = get_sub_field('resource_style');
	$type = get_sub_field('resource_type');
	$image = get_sub_field('image');
	$title = get_sub_field('title');
	$file = get_sub_field('file');
	$link = get_sub_field('link');
	$link_title = get_sub_field('link_title');
	?>
    	<div class="resource <?= $type; ?> row align-middle <?php echo $style; ?>">
    	    <?php if ($image) : ?>
    	    <div class="shrink columns image">
    	        <?php if ($type == 'file') : ?>
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
    	          <?php if (get_sub_field('resource_type') == 'file') : ?>
    	        	<a href="<?php echo $file['url']; ?>" target="_blank" class="button tertiary">Download PDF</a>
    	        <?php else: ?>
    	        	<a href="<?php echo $link; ?>" class="button tertiary"><?php echo $link_title; ?></a>
    	        <?php endif; ?>
    	    </div>
    	   <?php endif; ?>
    	</div>
    	
      
  <script type="text/javascript">
	jQuery(document).ready(function($){
	
	//Set link to entire project block, since wrapping in an <a> tag isn't accessible.
        $(".resource.file").click(function() {
          var url = $(this).find("a").attr("href"); 
          window.open(url, '_blank');
          return false;
        });
	
		
	});
	</script>