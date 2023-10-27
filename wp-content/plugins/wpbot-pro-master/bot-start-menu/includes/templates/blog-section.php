<?php

$query_arg = array(
    'post_type'     => get_option( 'blog_post_type' ),
    'post_status'   => 'publish',
    'posts_per_page'=> get_option( 'blog_number_of_post' ),
    'paged'			=> 1,
    'orderby'		=> get_option( 'blog_post_display_orderby' ),
    'order'		=> get_option( 'blog_post_display_order' ),
);
$post_ids = get_option('blog_post_ids');
if( $post_ids && $post_ids!='' ){
    $ids = explode(',', $post_ids);
    $query_arg['post__in'] = array_map('trim', $ids);
}


$i = 0;
$my_query = new WP_Query( $query_arg );
if ( $my_query->have_posts() ) {
 
    while ( $my_query->have_posts() ) {
 
        $my_query->the_post();
        $i++;
        ?>

        <div class="wp-chatbot-start-content-single">
            <?php if( $i == 1 ): ?>
            <div class="start-single-header"><p><b>Latest Posts</b></p></div>
            <?php endif; ?>
            <div class="start-single-content">

            <?php if (has_post_thumbnail() ){ ?>
                <div class="post-thumb">
                <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
                </div>
            <?php }  ?>

            <div class="entry-header">           
                <p><b><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></b></p>
                <?php if ( 'post' == get_post_type() ) : ?>
                    <div class="postmeta">
                        <div class="post-date"><?php the_date(); ?></div><!-- post-date -->                                          
                    </div><!-- postmeta -->
                <?php endif; ?>
            </div><!-- .entry-header -->

            <div class="entry-summary">
                <?php the_excerpt(); ?> 
                <?php edit_post_link( __( 'Edit', 'pulsing-lite' ), '<span class="edit-link">', '</span>' ); ?>                         
            </div><!-- .entry-summary -->

            </div>
        </div>            

        <?php

    }
}
 

wp_reset_postdata();