<?php
$title = get_sub_field('title');
$description = get_sub_field('description');
$image = get_sub_field('background_image');
$video = get_sub_field('background_video');
?>

<div class="row cta-wrap">
    <div class="columns small-12 medium-6 image <?php if ($video) : ?>video-wrap<?php endif; ?> <?php echo $slider; ?>" <?php if (! $video) : ?>style="background-image:url('<?= $image['url']; ?>');"<?php endif; ?>>
     <?php if ($video) : ?>
     <div class="video-container">
         <video autoplay muted loop="loop" poster="<?php echo $image['sizes']['split-section']; ?>" class="video-bg">
          <source src="<?php echo $video; ?>" type="video/mp4">
        </video>
    </div>
    <?php endif; ?>
    </div>
    <div class="columns small-12 medium-6 content">
        <div class="hold-me"  data-aos="fade-left">
            <?php if ($title) : ?>
                <h2><?php echo $title; ?></h2>
            <?php endif; ?>
            <?php if ($description) : ?>
                <p><?php echo $description; ?></p>
            <?php endif; ?>
            <?php if (get_sub_field('buttons')): ?> 
                <?php while(has_sub_field('buttons')): ?>
                    <? aor_button(); ?>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>