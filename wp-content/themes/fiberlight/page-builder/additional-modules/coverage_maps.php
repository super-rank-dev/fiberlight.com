<?php
$termsState = get_terms( array( 'taxonomy' => 'State', 'hide_empty' => true, 'order' => 'ASC', 'orderby' => 'name' ));
?>
<div class="row">
    <div class="small-12 columns title" data-aos="fade-right">
        <?php if (get_sub_field('title')) : ?>
            <h2><?php echo the_sub_field('title'); ?></h2>
        <?php endif; ?>
    </div>
    <div class="small-12 medium-5 large-3 columns description" data-aos="fade-right">
        <?php
        if (get_sub_field('description')) : ?>
            <p><?php echo the_sub_field('description'); ?></p>
        <?php endif; ?>
    </div>
    
    
    
    <div class="small-12 medium-7 large-9 columns state-accordion" data-aos="fade-left">
        <div class="accordion" data-accordion data-allow-all-closed="true">
        
        <?php foreach ( $termsState as $term ) : ?>
        
                       
  
            
                    <div class="accordion-item" data-accordion-item>
                        <a href="#" class="accordion-title">
                            <?php echo $term->name; ?>
                        </a>
                
                        <div class="accordion-content" data-tab-content>
                            <?php
                            // WP_Query arguments
                            $args = array(
                            	'post_type'              => array( 'coverage-map' ),
                            	'post_status'            => array( 'publish' ),
                            	'nopaging'               => true,
                            	'posts_per_page'         => '-1',
                            	'order'                  => 'ASC',
                            	'orderby'                => 'title',
                            	'tax_query' => array(
                                    array(
                                        'taxonomy' => 'State',
                                        'field' => 'slug',
                                        'terms' => $term->slug,
                                    ),
                                ),
                            );
                            
                            // The Query
                            $query = new WP_Query( $args );
                            ?>
                            
                            <?php if ( $query->have_posts() )  : ?>
                            	<ul>
                            	<?php while ( $query->have_posts() ) :
                            		$query->the_post(); ?>
                            		<li>
                            		    <a href="<?php echo the_permalink(); ?>"><?php echo the_title(); ?></a>
                            		</li>
                            	<?php endwhile; ?>
                            	</ul>
                            <?php endif;
                            
                            // Restore original Post Data
                            wp_reset_postdata();
                            ?>
                        </div>
                    </div>
        <?php endforeach; ?>
        </div>
    </div>
    
    
    
    
</div>
    
