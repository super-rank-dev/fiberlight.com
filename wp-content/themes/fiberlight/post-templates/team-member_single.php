<?php get_template_part( 'includes/header' ); ?>

<section class="team-member-single">
    <div class="row">
        <div class="small-12 medium-4 columns">
            <? if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <? $image = get_field('headshot'); ?>
                <div class="image">
                    <img src="<?= $image['sizes']['portrait-medium']; ?>">
                </div>
             

            <? endwhile; endif; ?>
        </div>
        <div class="small-12 medium-8 columns">
                <h6><? the_field('title'); ?></h6>
                <? the_field('bio'); ?>
                
             
                
                <a href="<?= get_the_permalink(get_field('leadership_page','options')); ?>" class="button secondary">
                    All Team Members
                </a>
        </div>

    </div>
    
</section>
<?
$queryArray = array(
    'post_type' => 'post',
    'posts_per_page' => -1
);

$metaQuery = array(
    'relation' => 'AND',
    array(
        'key'     => 'author',
        'value'   => get_the_ID(),
        'compare' => '=',
    ),
);

$queryArray['meta_query'] = $metaQuery;

?>

<? $loop = new WP_Query( $queryArray ); ?>
            
<? $counter = 1; ?>
<? if ( $loop->have_posts() ) : ?>
    <section class="pb-recent_news background-pattern ">
        <div class="row intro">
            <div class="small-12 medium-8 columns title">
                <h2>
                    Blogs by <? the_title(); ?>
                </h2>
         
            </div>
            <div class="small-12 medium-4 columns link">
                <a href="/resources/blog/" class="tertiary button small">
                    Read All Recent Blogs
                </a>
            </div>
        </div>
        <div class="row articles">
            
            
            <? while ( $loop->have_posts() ) : $loop->the_post();
            if (get_field('image')) :
                $image = get_field('image');
            else:
                $image = get_field('default_blog_post_image' ,'options');
            endif;
            ?>
                
                <div class="small-12 medium-3 columns article <? if ( $counter == 3 || $counter == 2 ) : echo "middle"; endif; ?>"  data-aos="fade-up">
                    <div class="hold-me">
                        <div class="image" style="background-image:url('<?= $image['sizes']['blog-post']; ?>');">
                            
                        </div>
                        <div class="content">
                            <a href="<?= get_the_permalink(); ?>">
                                <h6>
                                    <?= get_the_date('l, F j, Y'); ?>
                                </h6>
                            </a>
                            <h5>
                                <? the_title(); ?>
                            </h5>
                            <? the_excerpt(); ?>
                            <a href="<?= get_the_permalink(); ?>" class="button tertiary extra-small">
                                Read More
                            </a>
                            
                        </div>
                    </div>
                    
                </div>
                <? $counter++; ?>
            <? endwhile; ?>
           
       
        
            </div>
        </section>
        
    <? endif; ?>
        
<? wp_reset_postdata(); ?>

<?php get_template_part( 'includes/footer' ); ?>
