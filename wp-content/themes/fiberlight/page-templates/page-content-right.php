<?php
/*
Template Name: Content Right
*/


get_template_part( 'includes/header' );

?>
<div class="pb-content_section">
    <div class="row" >
    		<div class="appt-quote small-12 medium-6 column" style="order:2">
            <? the_content(); ?>
        </div>
        <div class="small-12 medium-6 column">
            <?= do_shortcode(get_field('shortcode')); ?>
        </div>

        
    </div>

</div>


<?php get_template_part( 'includes/footer' ); ?>