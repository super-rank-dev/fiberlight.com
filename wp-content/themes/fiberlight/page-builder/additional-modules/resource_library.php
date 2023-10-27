<?php
$intro = get_sub_field('resource_intro');
//set terms
$solution_terms = get_terms( array( 'taxonomy' => 'Solution', 'hide_empty' => true, 'order' => 'ASC', 'orderby' => 'name' ));
$industry_terms = get_terms( array( 'taxonomy' => 'Industry', 'hide_empty' => true, 'order' => 'ASC', 'orderby' => 'name' ));
$content_terms = get_terms( array( 'taxonomy' => 'Type', 'hide_empty' => true, 'order' => 'ASC', 'orderby' => 'name' ));
?>
<section class="resource-archive">
    <?php if ($intro) : ?>
        <div class="resource-intro">
            <div class="row column">
                <?php echo $intro; ?>
            </div>
        </div>
        <?php endif; ?>
   <div class="filter-wrap">
         <div class="row">
            <div class="small-12 large-7 columns filter-menu">
               <div class="filter-menu-item solution-type">
                   <div class="filter-menu-button">
                      Solution
                    </div>
                    <div class="filter-submenu">
                       <?php foreach ( $solution_terms as $term ) : ?>
                          <div class="term">
                             <input id="<?= $term->slug ?>" type="checkbox" data-taxonomy="<?= $term->taxonomy ?>" data-taxonomy-terms="<?= $term->slug ?>" name="<?= $term->taxonomy ?>-group" value="<?= $term->slug ?>">
                             <label for="<?= $term->slug ?>"><?= $term->name ?></label>
                          </div>
                       <?php endforeach; ?>
                    </div>
               </div>
               <div class="filter-menu-item industry-type">
                   <div class="filter-menu-button">
                      Industry
                    </div>
                    <div class="filter-submenu">
                       <?php foreach ( $industry_terms as $term ) : ?>
                          <div class="term">
                             <input id="<?= $term->slug ?>" type="checkbox" data-taxonomy="<?= $term->taxonomy ?>" data-taxonomy-terms="<?= $term->slug ?>" name="<?= $term->taxonomy ?>-group" value="<?= $term->slug ?>">
                             <label for="<?= $term->slug ?>"><?= $term->name ?></label>
                          </div>
                       <?php endforeach; ?>
                    </div>
               </div>
               <div class="filter-menu-item post-type">
                    <div class="filter-menu-button">
                      Content Type
                    </div>
                    <div class="filter-submenu">
                      <?php foreach ( $content_terms as $term ) : ?>
                          <div class="term">
                             <input id="<?= $term->slug ?>" type="checkbox" data-taxonomy="<?= $term->taxonomy ?>" data-taxonomy-terms="<?= $term->slug ?>" name="<?= $term->taxonomy ?>-group" value="<?= $term->slug ?>" checked>
                             <label for="<?= $term->slug ?>"><?= $term->name ?></label>
                          </div>
                       <?php endforeach; ?>
                    </div>
               </div>
            </div>
            <div class="small-12 large-5 columns filter-buttons">
               <div class="button filter-button">Apply Filter</div>
               <div class="button secondary clear-filter-button">Clear Filters</div>
            </div>
         </div>
   </div>
   
   <div class="filter-results">
         <?= do_shortcode('[ajax_load_more theme_repeater="resources.php" posts_per_page="12" meta_key="order" order="ASC" orderby="meta_value_num" post_type="success-story, resource" taxonomy="solution:industry:type" taxonomy_terms=":" taxonomy_operator="IN:IN:IN" taxonomy_relation="AND"  button_label="View More Resources"]'); ?>
   </div>
   
</section>

<script>
$(document).ready(function(){
    
    $('.filter-menu-item').hover(function () {
        $(this).children(".filter-menu-button").toggleClass('active');
        $(this).children(".filter-submenu").toggleClass('show-filter-submenu');
    });

      $('.clear-filter-button').click(function() {
          $('.term input').prop('checked', false);
         $('.post-type .term input').prop('checked', true);
         alm_adv_filter();
         //window.location.href = "/research-library/search/";
         
      });

  /*
	* alm_adv_filter()
	* https://connekthq.com/plugins/ajax-load-more/examples/filtering/advanced-filtering/
	*
	*/

	function alm_adv_filter(){

		if(alm_is_animating){
			return false; // Exit if filtering is still active
		}

		var alm_is_animating = true;

		var obj= {},
			 count = 0,
             terms = '';
             posts = "";
      
      //solution type
      $('.solution-type input[type=checkbox]:checked').each(function() {
         if ( count > 0 ) {
            terms += ', ';
         }
         terms += $(this).data('taxonomy-terms');
         count++;

      });
      
      terms += ":";
      count = 0;

      //industry type
      $('.industry-type input[type=checkbox]:checked').each(function() {
         if ( count > 0 ) {
            terms += ', ';
         }
         terms += $(this).data('taxonomy-terms');
         count++;

      });
      
      terms += ":";
      count = 0;
      
      //content type
      $('.post-type input[type=checkbox]:checked').each(function() {
         if ( count > 0 ) {
            terms += ', ';
         }
         terms += $(this).data('taxonomy-terms');
         count++;

      });
      
      terms += ":";
      count = 0;
      
    //   //post type
    //   $('.post-type input[type=checkbox]:checked').each(function() {
    //      if ( count > 0 ) {
    //         posts += ', ';
    //      }
    //      posts += $(this).data('post-type');
    //      count++;

    //   });
      
    //   //posts += ", ";
    //   count = 0;
      

      console.log(terms);
      console.log(posts);
      obj['taxonomy-terms'] = terms;
      obj['taxonomy'] = "Solution:Industry:Type";
      //obj['post-type'] = posts;


		console.log(obj);

		var data = obj;
		ajaxloadmore.filter('fade', '300', data); // Send data to Ajax Load More
	}
	
	$('.filter-button').on('click', alm_adv_filter); // 'Filter' button click

	/*
	* almFilterComplete()
	* Callback function sent from core Ajax Load More
	*
	*/
	$.fn.almFilterComplete = function(){
		alm_is_animating = false; // clear animating flag
	};
	

});
</script>