<?php if (get_sub_field('slides')): ?> 
    <div class="slides">
	<?php while(has_sub_field('slides')): ?>

        <div class="slide"
            style="background-image:url('<?= get_sub_field('background_image')['sizes']['mainstage-image']; ?>'); ?>"
            >
            <div class="row">
                <? if ( get_sub_field('sub_headline') ) : ?>
                    <h2><?= get_sub_field('sub_headline'); ?></h2>
                <? endif; ?>
                <? if ( get_sub_field('headline') ) : ?>
                    <h1><?= get_sub_field('headline'); ?></h1>
                <? endif; ?>
                <? the_sub_field('description'); ?>
                <?php if (get_sub_field('buttons')): ?> 
                	<?php while(has_sub_field('buttons')): ?>
                
                        <? aor_button(); ?>
                
                	<?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>

	<?php endwhile; ?>
    </div>
<?php endif; ?>

<? if ( count(get_sub_field('slides') ) > 1 ) : ?>
    <script type="text/javascript">
        jQuery(document).ready(function($){
    
            $('.slides').slick({
                arrows:true,
                autoplay:false,
                autoplaySpeed:3000,
                dots:false
            });
    
        });
    </script>
<? endif; ?>