<?php
/*
Template Name: Success Stories
*/


get_template_part( 'includes/header' );


$termsSolution = get_terms( array( 'taxonomy' => 'Solution', 'hide_empty' => true, 'order' => 'ASC', 'orderby' => 'name' ));
$termsIndustry = get_terms( array( 'taxonomy' => 'Industry', 'hide_empty' => true, 'order' => 'ASC', 'orderby' => 'name' ));
$termsRegion = get_terms( array( 'taxonomy' => 'Region', 'hide_empty' => true, 'order' => 'ASC', 'orderby' => 'name' ));


?>


<section class="success-stories">
   <div class="row title-filter">
      <div class="column small-12 title">
         <h1>
            <?php if (get_field('page_title_override')) : echo the_field('page_title_override'); else: echo the_title(); endif; ?>
         </h1>
         <?php if (get_field('description')) : ?>
         <p class="intro-paragraph">
            <?php echo the_field('description'); ?>
         </p>
         <?php endif; ?>
      </div>
     
   </div>
   
   <div class="filter-wrap">
         <div class="row">
            <div class="small-12 large-7 columns filter-menu">
               <div class="filter-menu-item solution-type">
                   <div class="filter-menu-button">
                      Solution
                    </div>
                    <div class="filter-submenu">
                       <?php foreach ( $termsSolution as $term ) : ?>
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
                       <?php foreach ( $termsIndustry as $term ) : ?>
                          <div class="term">
                             <input id="<?= $term->slug ?>" type="checkbox" data-taxonomy="<?= $term->taxonomy ?>" data-taxonomy-terms="<?= $term->slug ?>" name="<?= $term->taxonomy ?>-group" value="<?= $term->slug ?>">
                             <label for="<?= $term->slug ?>"><?= $term->name ?></label>
                          </div>
                       <?php endforeach; ?>
                    </div>
               </div>
               <div class="filter-menu-item region">
                    <div class="filter-menu-button">
                      Region
                    </div>
                    <div class="filter-submenu">
                      <?php foreach ( $termsRegion as $term ) : ?>
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
   
   
   
   <?= do_shortcode('[ajax_load_more post_type="success-story" posts_per_page="12" taxonomy="Solution:Industry:Region" taxonomy_terms="" taxonomy_operator="IN:IN:IN" button_label="Load More"]'); ?>
   
   
   
</section>
<script>
$(document).ready(function(){
   
   $('.filter-menu-item').hover(function () {
        $(this).children(".filter-menu-button").toggleClass('active');
        $(this).children(".filter-submenu").toggleClass('show-filter-submenu');
    });


      $('.clear-filter-button').click(function() {
          $('.term input').prop('checked', false);
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


        // Loop each filter menu
        /*
        $('.advanced-filter-menu').each(function(e){
            var menu = $(this),
                type = menu.data('type'), // type of filter elements (checkbox/radio/select)
            tax = '',
                taxTerm = '',
                count = 0;


            // Loop each item in the menu
            if(type === 'checkbox' || type === 'radio'){ // Checkbox or Radio
                $('input:checked', menu).each(function(){
                    count++;
                    var el = $(this);


          // Build comma separated string of items
                    if(count > 1){
                        taxTerm += ','+ el.data('taxonomy-terms');
                    } else {
                        taxTerm += el.data('taxonomy-terms');
            tax += el.data('taxonomy');
                    }
                });
            }


      obj['taxonomy'] = tax; // add value(s) to obj
            obj['taxonomy-terms'] = taxTerm; // add value(s) to obj
      // obj['taxonomy-relation'] = "AND";
          obj['taxonomy-terms'] = taxTerm; // add value(s) to obj


        });


*/
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
      
      $('.region input[type=checkbox]:checked').each(function() {


         if ( count > 0 ) {
             terms += ', ';
         }
         terms += $(this).data('taxonomy-terms');
         count++;


      });


      console.log(terms);
      obj['taxonomy-terms'] = terms;
      obj['taxonomy'] = "Solution:Industry:Region";




        // console.log(obj);


        var data = obj;
        $.fn.almFilter('fade', '300', data); // Send data to Ajax Load More
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


<?php get_template_part( 'includes/footer' ); ?>