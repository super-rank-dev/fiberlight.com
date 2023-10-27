<?php get_template_part( 'includes/header' ); ?>

<section class="post-single">
    <div class="row">
        <div class="small-12 columns">
            <? if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

   
                <h6><?= get_The_date('l, F j, Y'); ?></h6>
                <div class="content">
                    <? the_content(); ?>
                </div>

                <a href="/resources/news/" class="button back">
                    Back to News
                </a>
            <? endwhile; else : ?>

            <? endif; ?>
        </div>
    </div>
</section>


<?php get_template_part( 'includes/footer' ); ?>
