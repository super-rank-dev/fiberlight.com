<div class="row">
    <? if ( get_sub_field('optional_title') ) : ?>
        <div class="small-12 columns title">
            <h2><? the_sub_field('optional_title'); ?></h2>
        </div>
    <? endif; ?>
    <div style="text-align:center;width:100%;margin-top:10px;float:left;">
        <? aor_button(); ?>
    </div>
    <? if ( get_sub_field('optional_description') ) : ?>
        <div class="small-12 columns description">
            <? the_sub_field('optional_description'); ?>
        </div>
    <? endif; ?>
    <?
    $totalEvents = get_sub_field('number_of_events');
    $loop = new WP_Query(
        array(
            'post_type' => 'event',
            'posts_per_page' => $totalEvents,
            'meta_query' => array(
                array(
                    'key'       => 'featured',
                    'value'     => '1',
                    'compare'   => '='
                )
            )
        )
    );
    ?>

    <? if ( $loop->have_posts() ) : ?>

        <? while ( $loop->have_posts() ) : $loop->the_post(); ?>

            <?
            if ( get_field('image') ) {
                $image = get_field('image')['sizes']['blog-post'];


            } else {
                $image = get_field('default_event_image', 'options')['sizes']['blog-post'];
            }
            ?>

            <div class="small-12 medium-<?= 12 / $totalEvents; ?> columns event">
                <div class="image" style="background-image:url('<?= $image; ?>'); ?>"></div>
                <h4><? the_title(); ?></h4>
                <p>
                    <i>
                        <? the_field('start_date'); ?> - <? the_field('end_date'); ?>
                    </i>
                </p>
                <a href="<? the_permalink(); ?>" class="button">
                    Read More
                </a>
            </div>


        <? endwhile; ?>

    <? endif; ?>

    <? wp_reset_postdata(); ?>

</div>
