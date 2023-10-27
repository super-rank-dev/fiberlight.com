<?php get_template_part( 'includes/header' );

$map = get_field('map');
$content = get_field('content');
$termsState = get_terms( array( 'taxonomy' => 'State', 'hide_empty' => true, 'order' => 'ASC', 'orderby' => 'name' ));
?>

<section class="coverage-map">
    <div class="row">
        <div class="small-12 medium-7 large-8 columns">
            <div class="main" data-aos="fade-right">
                <?php if ($content) : ?>
                <div class="content">
                    <?php echo $content; ?>
                </div>
                <?php endif; ?>
                <img src="<?php echo $map['url']; ?>" alt="<?php echo $map['url']; ?>" />
                <a href="<?php echo $map['url']; ?>" target="_blank" class="button">Download Map</a>
            </div>
        </div>
        <div class="small-12 medium-5 large-4 columns">
            <div class="sidebar" data-aos="fade-left">
                <h3>Coverage Maps</h3>
                <?php foreach ( $termsState as $term ) : ?>
                <div class="accordion" data-accordion data-allow-all-closed="true">
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
                </div>
            <?php endforeach; ?>
        
        </div>
    </div>
</section>

<?php get_template_part( 'includes/footer' ); ?>
