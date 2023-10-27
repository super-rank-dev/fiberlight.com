<?php get_template_part( 'includes/header' ); 
?>

<section class="search-results">
    <div class="row" data-equalizer data-equalize-on="medium" data-equalize-by-row="true">

        <?
        if ( have_posts() ) : while ( have_posts() ) : the_post();
            //vars
            $custom_excerpt = get_field('custom_excerpt');
            $excerpt = get_the_excerpt();
            $description = get_field('description');
            $company_profile = get_field('company_profile');
            $team_member = get_field('bio');
            
            $hero = get_field('background_image');
            $headshot = get_field('headshot');
            $post_image = get_field('image');
            $testimonial_image = get_field('photo');
            $ss_tile = get_field('tile_image');
        ?>
            <div class="small-12 medium-6 columns">
                <div class="search-tile">
                    <div class="search-inner" data-equalizer-watch>
                        <span class="search-tag">
                            <?php echo get_post_type(); ?>
                        </span>
                        <h3>
                            <a href="<? the_permalink(); ?>">
                                <? the_title(); ?>
                            </a>
                        </h3>
                        <p>
                        <?php
                            if($custom_excerpt):
                                echo $custom_excerpt;
                            elseif ($excerpt):
                                echo $excerpt;
                            elseif($description):
                                echo $description;
                            elseif($company_profile):
                                 $profile = substr($company_profile, 0, 300);
                                echo $profile;
                            elseif($team_member):
                                 $team = substr($team_member, 0, 300);
                                echo $team;
                            endif;
                        ?>
                        </p>
                        <?php 
                        if ($hero) :
                            $image = $hero;
                        elseif ($headshot) :
                            $image = $headshot;
                        elseif ($post_image) :
                            $image = $post_image;
                        elseif ($testimonial_image) :
                            $image = $testimonial_image;
                        elseif ($ss_tile) :
                            $image = $ss_tile;
                        endif;
                        
                        if ($image) : ?>
                        <img src="<?php echo $image['sizes']['thumbnail']; ?>" />
                        <?php
                        endif;
                        ?>
                    </div>
                    <a href="<? the_permalink(); ?>" class="button tertiary small">
                        Read More
                    </a>
                </div>
            </div>

        <? endwhile; ?>
        <div class="row pagination">
            <div class="small-12 columns">
                <? aor_archive_pagination(); ?>
            </div>
        </div>
        
        <?php else : ?>

        <? endif; ?>

    </div>
</section>
  <script type="text/javascript">
	jQuery(document).ready(function($){
	
	//Set link to entire project block, since wrapping in an <a> tag isn't accessible.
        $(".search-tile").click(function() {
          window.location = $(this).find("a").attr("href"); 
          return false;
        });
	
		
	});
	</script>

<?php get_template_part( 'includes/footer' ); ?>
