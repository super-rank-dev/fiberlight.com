<?php
$layout = get_sub_field('layout');
?>
<div class="row solutions-industries <?php echo $layout; ?>">
<?php if (get_sub_field('solutions')): ?>
    <div class="small-12 <?php if ($layout == 'full') : ?> large-12 <?php else: ?>large-8<?php endif; ?> columns solutions">
        <?php if (get_sub_field('solutions_title')) : ?><h2 class="title"><?php echo the_sub_field('solutions_title'); ?></h2><?php endif; ?>
        <div class="row" data-equalizer data-equalize-by-row="true">
    	<?php while(has_sub_field('solutions')):
    	    $icon = get_sub_field('icon');
    	    $title = get_sub_field('title');
    	    $description = get_sub_field('description');
    	    $link = get_sub_field('link');
    	?>
            <div class="small-12  <?php if ($layout == 'full') : ?> medium-6 large-4<?php else: ?>medium-6<?php endif; ?> columns solution" data-aos="fade-up">
                <?php if ($icon) : ?>
                    <img class="icon" src="<?php echo $icon['sizes']['medium']; ?>" alt="<?php echo $icon['alt']; ?>" />
                <?php endif; ?>
                <div class="content">
                    <div class="hold-me" data-equalizer-watch>
                        <?php if ($title) : ?>
                            <h3><?php echo $title; ?></h3>
                        <?php endif; ?>
                        <?php if ($description) : ?>
                            <p><?php echo $description; ?></p>
                        <?php endif; ?>
                    </div>
                    <?php if ($link) : ?>
                        <a class="button secondary" href="<?php echo $link; ?>">Learn More</a>
                    <?php endif; ?>
                </div>
            </div>
        
	<?php endwhile; ?>
	    </div>
    </div>
<?php endif; ?>

<?php if (get_sub_field('industries')): ?>
    <div class="small-12  <?php if ($layout == 'full') : ?> large-12 <?php else: ?>large-4<?php endif; ?> columns industries">
        <div class="row">
        <div class="small-12 columns">
            <?php if (get_sub_field('industries_title')) : ?>
                <h2 class="title"><?php echo the_sub_field('industries_title'); ?></h2>
            <?php endif; ?>
            <?php if (get_sub_field('industries_intro')) : ?>
                <?php echo the_sub_field('industries_intro'); ?>
            <?php endif; ?>
        </div>
        </div>
    <?php if ($layout == 'full') : ?>
    <div class="row" data-equalizer data-equalize-on="medium">
    <?php endif; ?>
	<?php while(has_sub_field('industries')):
	    $image = get_sub_field('image');
	    $title = get_sub_field('title');
	    $headline = get_sub_field('headline');
	    $link = get_sub_field('link');
	?>
	<?php if (!$layout == 'full') : ?>
        <div class="row align-middle" data-equalizer data-equalize-on="medium">
    <?php endif; ?>
            <div class="small-12 industry-col <?php if ($layout == 'full') : ?> medium-6 large-4 <?php else: ?>medium-12 no-pad<?php endif; ?> columns">
                <div class="industry" data-equalizer-watch data-aos="fade-up">
                    <?php if ($image) : ?>
                        <div class="image" style="background-image:url('<?php echo $image['sizes']['medium']; ?>');"></div>
                    <?php endif; ?>
                    <div class="content <?php if ($image) : ?>has-image<?php endif; ?>">
                    <?php if ($link) : ?>
                        <a href="<?php echo $link; ?>">
                    <?php endif; ?>
                        <?php if ($title) : ?>
                            <h4><?php echo $title; ?></h4>
                        <?php endif; ?>
                        <?php if ($headline) : ?>
                            <h3><?php echo $headline; ?></h3>
                        <?php endif; ?>
                    <?php if ($link) : ?>
                        </a>
                    <?php endif; ?>
                    <div>
                        <?php if ($link) : ?>
                        <a class="button secondary" href="<?php echo $link; ?>">Learn More</a>
                    <?php endif; ?>
                    </div>
                    </div>
                </div>
            </div>
        <?php if (!$layout == 'full') : ?>
        </div>
        <?php endif; ?>
        
	<?php endwhile; ?>
	<?php if ($layout == 'full') : ?>
	</div>
	<?php endif; ?>
    </div>
<?php endif; ?>



</div>

<script>
jQuery(document).ready(function($){
	   
	   //Set link to entire project block, since wrapping in an <a> tag isn't accessible.
        $(".industry").click(function() {
          window.location = $(this).find("a").attr("href"); 
          return false;
        });
});
</script>