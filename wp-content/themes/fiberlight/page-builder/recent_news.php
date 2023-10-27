<div class="row intro">
    <div class="small-12 medium-8 columns title">
        <h2>
            <? the_sub_field('title'); ?>
        </h2>
        <? the_sub_field('content'); ?>
    </div>
    <div class="small-12 medium-4 columns link">
        <a href="<?= get_sub_field('link_url'); ?>" class="tertiary button small">
            <?= get_sub_field('link_text'); ?>
        </a>
    </div>
</div>
<div class="row articles">
    <?
    $types = get_sub_field('post_types');

    $queryArray = array(
        'post_type' => $types,
        'posts_per_page' => 4
    );



    //$queryArray['tax_query'] = $taxQuery;
    ?>
    
    <? $loop = new WP_Query( $queryArray ); ?>
    <? $counter = 1; ?>
    <? if ( $loop->have_posts() ) : ?>
        
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
       
    <? endif; ?>
    
    <? wp_reset_postdata(); ?>
    
</div>

<script type="text/javascript">
    jQuery(document).ready(function($){
      
        //Set link to entire project block, since wrapping in an <a> tag isn't accessible.
        $(".article").click(function() {
          window.location = $(this).find("a").attr("href"); 
          return false;
        });
    });
  
</script>