<?php



$foundTags = array();

$loop = new WP_Query( array( 'post_type' => 'event', 'posts_per_page' => '-1' ) );

if ( $loop->have_posts() ) :
    while ( $loop->have_posts() ) : $loop->the_post();

        $tags = get_field('tags');

        if ( is_array($tags) ) {
            foreach ( $tags as $tag ) {
                if ( !in_array($tag, $foundTags) ) {
                    $foundTags[] = $tag;
                }
            }
        }

    endwhile;

endif;
wp_reset_postdata();


function displayEvent($eventID) { ?>
    <?
        unset($cssClasses);

        $tags = get_field('tags');

        $moreThanOneClass = 0;

        if ( is_array($tags) ) {
            foreach ($tags as $tag) {

                $cleanTag = str_replace(' ', '', $tag);
                $cleanTag = str_replace('/', '', $cleanTag);

                if ( $moreThanOneClass ) {
                    $cssClasses .= " ";
                }

                $cssClasses .= $cleanTag;

                $moreThanOneClass++;

            }
        }

        if ( get_field('image', $eventID )) {
            $image = get_field('image', $eventID)['sizes']['split-section'];
        } else {
            $image = get_field('default_event_post_image', $eventID, 'options')['sizes']['split-section'];
        }
    ?>

   <div class="row event <?= $cssClasses; ?>">

       <?php if ( get_field('image', $eventID )) { ?>
        <div class="small-12 medium-4 columns image" style="background-image:url('<?= $image; ?>')";>
            <?php if ( get_field('featured', $eventID) ) { ?>
                <div class="featured">
                    Featured
                </div>
            <?php } ?>
            &nbsp;
        </div>
        <?php } ?>
        <div class="small-12 medium-<?php if ( get_field('image', $eventID )) { echo '8'; } else { echo '12'; } ?> columns info">
            <div class="hold-me">
                <h6><?= get_field('start_date', $eventID); ?>
                    <?php if ( get_field('end_date') ) { ?>
                        - <?= get_field('end_date', $eventID); ?>
                    <?php } ?>
                </h6>
                <h4><?= get_the_title($eventID); ?></h4>
                <p><?php the_field('short_description'); ?></p>
                <br /><a href="<?= get_the_permalink($eventID); ?>" class="button primary" >The Details</a>
            </div>
        </div>
   </div>
<?php } ?>


    <div class="section-container bg-light-gray">
        <div class="row">
            <div class="sort columns small-12">
               <h5 class="filter">Filter by:</h5>
                <?

                if ( is_array($foundTags) ) {
                    foreach ( $foundTags as $tag ) {
                        $cleanTag = str_replace(' ', '', $tag);
                        $cleanTag = str_replace('/', '', $cleanTag);
                        ?>
                <div class="filter-cats small-12 medium-4 columns">
                    <input type="checkbox" name="tag" value=".<?= $cleanTag; ?>" id="<?= $cleanTag; ?>" />
                    <label for="<?= $cleanTag; ?>"><?= $tag; ?></label>
                </div>
                        <?
                    }
                }
                ?>
            </div>



<!--
            <div class="small-12 columns content-row">
                <p>Check back often for upcoming event information.</p>
            </div>
-->
        </div>
        <div class="event-container row">
            <?
            $loop = new WP_Query(
                array(
                    'post_type'         => 'event',
                    'posts_per_page'    => '10',
                    'meta_query'        => array(
                        array(
                            'key'           => 'featured',
                            'compare'       => '=',
                            'value'         => '1',
                        )
                    )
                )
            );
            ?>

            <?php if ( $loop->have_posts() ) : ?>

                <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

                    <?php displayEvent(get_the_ID()); ?>

                <?php endwhile; ?>

            <?php endif; ?>

            <?php wp_reset_postdata(); ?>

            <?php
            $today = date('Y-m-d H:i:s');
            $loop = new WP_Query(array(
            'post_type'         => 'event',
            'posts_per_page'    => '-1',
            'order'             => 'ASC',
            'orderby'           => 'meta_value',
            'meta_key'          => 'start_date',
            'meta_type'         => 'DATE',
            'meta_query' => array(
                'relation'      => 'AND',
                array(
                    'key'       => 'start_date',
                    'compare'   => '>=',
                    'value'     => $today,
                    'type'      => 'DATETIME'
                ),
                array(
                    'relation'  => 'OR',
                    array(
                        'key'       => 'featured',
                        'compare'   => '!=',
                        'value'     => '1'
                    ),
                    array(
                        'key'       => 'featured',
                        'compare'   => 'NOT EXISTS'
                    )
                )
            ),
            ));
            //aor_print_r($loop->posts);
            $pastEvents = new WP_Query(array(
            'post_type'         => 'event',
            'posts_per_page'    => '-1',
            'meta_query' => array(
                'relation'      => 'AND',
                array(
                    'key'       => 'start_date',
                    'compare'   => '<',
                    'value'     => $today,
                    'type'      => 'DATETIME'
                ),
                array(
                    'relation'  => 'OR',
                    array(
                        'key'       => 'featured',
                        'compare'   => '!=',
                        'value'     => '1'
                    ),
                    array(
                        'key'       => 'featured',
                        'compare'   => 'NOT EXISTS'
                    )
                )
            ),
            'order'             => 'DESC',
            'orderby'           => 'meta_value',
            'meta_key'          => 'start_date',
            'meta_type'         => 'DATETIME'
            ));
            //aor_print_r($pastEvents->posts);
            $pastEvents->posts = array_reverse($pastEvents->posts);
            $loop->post_count += $pastEvents->post_count;
            $totalPosts = $loop->post_count;
            $loop->posts = array_merge($loop->posts, $pastEvents->posts);

            ?>
            <?php if ( $loop->have_posts() ) : ?>

                <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

                    <?php displayEvent(get_the_ID()); ?>

                <?php endwhile; ?>

            <?php endif; ?>

            <?php wp_reset_postdata(); ?>
        </div>




    </div>



<script type="text/javascript">
    jQuery(document).ready(function($){

        // quick search regex
        var qsRegex;
        var checkFilter;
        var $checkboxes = $('.sort input');

        // init Isotope
        var $container = $('.event-container').isotope({
            itemSelector: '.event',
            layoutMode: 'fitRows',
            filter: function() {
                var $this = $(this);
                var checkResult = checkFilter ? $this.is(checkFilter) : true;
                return checkResult;
            }
        });
        /*
        $('#filters').on('click', 'button', function() {
            buttonFilter = $(this).attr('data-filter');
            $container.isotope();
        });
        */

        $checkboxes.click(function() {
            wasChecked = $(this).prop('checked');

            $(this).parent().parent().find('input').prop('checked', false);

            if ( wasChecked ) {
                $(this).prop('checked', true);
            }
            else {
                $(this).prop('checked', false);
            }

            var filters = [];
            // get checked checkboxes values
            $checkboxes.filter(':checked').each(function() {
                filters.push(this.value);
            });
            // ['.red', '.blue'] -> '.red, .blue'
            checkFilter = filters.join('');
            $container.isotope();
        });


    });
</script>
