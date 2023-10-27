<? if ( get_sub_field('optional_title') || get_sub_field('optional_description') ) : ?>
    <div class="row title">
        <? if ( get_sub_field('optional_title') ) : ?>
            <div class="small-12 columns">
                <h2><? the_sub_field('optional_title'); ?></h2>
            </div>
        <? endif; ?>
        <? if ( get_sub_field('optional_description') ) : ?>
            <div class="small-12 columns description">
                <? the_sub_field('optional_description'); ?>
            </div>
        <? endif; ?>
    </div>
<? endif; ?>
<div class="row posts">
    <?
    unset($taxQuery, $queryArray, $specificPosts);
    
    $feedMode = get_sub_field('feed_mode');
    $numberOfPosts = get_sub_field('number_of_posts');
    $orderBy = "date";
    $categories = get_sub_field('select_category');

    if ( get_sub_field('custom_post_type') ) :
        $postType = get_sub_field('custom_post_type');
    else :
        $postType = "post";
    endif;
    
    if ( $feedMode == "recent" ) :
        

    elseif ( $feedMode == "hand_picked" ) :
        
        $numberOfPosts = count(get_sub_field('select_feed_content'));
        
        if (get_sub_field('select_feed_content')): 
            
        	while(has_sub_field('select_feed_content')):
        
                $specificPosts[] = get_sub_field('content');
        
        	endwhile;
        
        endif;

    elseif ( $feedMode == "random" ) :
        
        $randomInt = rand(0,10000000);
        $orderBy = "rand(" . $randomInt . ")";
        
    elseif ( $feedMode == "by_category" ) :

        $taxQuery = array(
            'relation' => 'OR',
            array(
                'taxonomy'         => 'category',
                'terms'            => $categories,
                'field'            => 'term_id',
                'operator'         => 'IN',
                'include_children' => false,
            ),
        );

    endif;
    
    
    
    $queryArray = array(
        'post_type' => $postType,
        'posts_per_page' => $numberOfPosts,
        'orderby' => $orderBy,
        'post__in' => $specificPosts
    );
    $queryArray['tax_query'] = $taxQuery;
    
    
    ?>
    
    <? $loop = new WP_Query( $queryArray ); ?>
    
    <? if ( $loop->have_posts() ) : ?>
        
        <? while ( $loop->have_posts() ) : $loop->the_post(); ?>
            <div class="columns">
                <a href="<? the_permalink(); ?>">
                    <h4><? the_title(); ?></h4>
                </a>
                <? the_excerpt(); ?>
                <a href="<? the_permalink(); ?>">
                    Read More
                </a>
            </div>
    
        <? endwhile; ?>
       
    <? endif; ?>
    
    <? wp_reset_postdata(); ?>

 
</div>
 <? if ( get_sub_field('view_all_url') ) : ?>
     <div class="row view-all">
        <div class="small-12 columns">
            <a href="<? the_sub_field('view_all_url'); ?>" class="button">
                View All
            </a>
        </div>
    </div>
<? endif; ?>

