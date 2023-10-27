<?
$randomNumber = rand(100,1000);
if ( get_sub_field('background_image') ) :
    $image = get_sub_field('background_image');
    ?>
    <style>
        .id-<?= $randomNumber; ?> {
            background-color: rgba(0,0,50,.5);
        }
        .id-<?= $randomNumber; ?>::after {
            background-image:url('<?= $image['sizes']['cta-banner']; ?>');

        }
    </style>
<? endif; ?>
<div class="bg-color-wrapper">
    <div class="id-<?= $randomNumber; ?> bg-image-wrapper">
        <div class="row align-middle ">
            <div class="columns align-center">
                <? if ( get_sub_field('title') ) : ?>
                    <h2><? the_sub_field('title'); ?></h2>
                <? endif; ?>
                <p><? the_sub_field('description'); ?></p>
                <?php if (get_sub_field('buttons')): ?> 
                
                	<?php while(has_sub_field('buttons')): ?>
                
                        <? aor_button(); ?>
                
                	<?php endwhile; ?>
                
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
